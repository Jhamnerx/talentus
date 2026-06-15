<?php

namespace App\Http\Controllers\Api\WhatsFleep;

use App\Enums\WhatsFleep\MessageStatus;
use App\Events\WhatsFleep\ConversationUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\WhatsFleep\StoreIncomingWhatsappRequest;
use App\Http\Requests\WhatsFleep\UpdateWhatsappStatusRequest;
use App\Jobs\WhatsFleep\ProcessIncomingWhatsappMessage;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WhatsappMessage;
use Illuminate\Http\JsonResponse;

class IncomingWhatsappController extends Controller
{
    public function store(StoreIncomingWhatsappRequest $request): JsonResponse
    {
        ProcessIncomingWhatsappMessage::dispatch($request->validated());

        return response()->json(['accepted' => true], 202);
    }

    public function status(UpdateWhatsappStatusRequest $request): JsonResponse
    {
        $device = Device::where('body', $request->input('device'))->first();

        if (! $device) {
            return response()->json(['message' => 'Device not found'], 404);
        }

        $message = WhatsappMessage::with('conversation')
            ->where('device_id', $device->id)
            ->where('wa_message_id', $request->input('wa_message_id'))
            ->first();

        if (! $message) {
            return response()->json(['message' => 'Message not found'], 404);
        }

        $status = MessageStatus::from($request->input('status'));

        $message->status = $status;

        if ($status === MessageStatus::Delivered && $message->delivered_at === null) {
            $message->delivered_at = now();
        }

        if ($status === MessageStatus::Read) {
            $message->read_at = $message->read_at ?? now();
            $message->is_read = true;
        }

        $message->save();

        broadcast(new ConversationUpdated($message->conversation));

        return response()->json(['updated' => true]);
    }
}
