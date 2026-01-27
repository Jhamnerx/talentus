<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Models\TicketEvent;
use App\Enums\TicketEventType;
use App\Models\TicketAttachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AddAttachmentAction
{
    /**
     * Add attachment to ticket.
     *
     * @param Ticket $ticket
     * @param UploadedFile $file
     * @param int $uploadedBy
     * @param int|null $messageId
     * @return TicketAttachment
     */
    public function execute(Ticket $ticket, UploadedFile $file, int $uploadedBy, ?int $messageId = null): TicketAttachment
    {
        return DB::transaction(function () use ($ticket, $file, $uploadedBy, $messageId) {
            // Guardar archivo en storage/app/tickets/{ticket_id}/
            $path = $file->store("tickets/{$ticket->id}", 'local');

            // Crear registro de attachment
            $attachment = TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'message_id' => $messageId,
                'uploaded_by' => $uploadedBy,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);

            // Actualizar last_activity_at
            $ticket->update(['last_activity_at' => now()]);

            // Registrar evento
            TicketEvent::create([
                'ticket_id' => $ticket->id,
                'actor_id' => $uploadedBy,
                'type' => TicketEventType::ATTACHMENT_ADDED->value,
                'payload' => [
                    'attachment_id' => $attachment->id,
                    'original_name' => $attachment->original_name,
                    'size' => $attachment->size,
                ],
                'created_at' => now(),
            ]);

            return $attachment->fresh('uploadedBy');
        });
    }

    /**
     * Delete attachment and its file.
     *
     * @param TicketAttachment $attachment
     * @return bool
     */
    public function delete(TicketAttachment $attachment): bool
    {
        // Eliminar archivo físico
        if (Storage::disk('local')->exists($attachment->path)) {
            Storage::disk('local')->delete($attachment->path);
        }

        // Eliminar registro
        return $attachment->delete();
    }
}
