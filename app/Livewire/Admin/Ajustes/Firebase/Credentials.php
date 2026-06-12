<?php

namespace App\Livewire\Admin\Ajustes\Firebase;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as FirebaseNotification;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class Credentials extends Component
{
    use WithFileUploads, WireUiActions;

    public const RUTA = 'firebase/firebase-credentials.json';

    public const REQUIRED_KEYS = ['type', 'project_id', 'private_key', 'client_email'];

    public $file;

    public ?string $projectId = null;
    public ?string $clientEmail = null;
    public ?string $actualizadoEn = null;
    public bool $existe = false;

    public ?int $usuarioPruebaId = null;

    /** @var Collection<int, User> */
    public Collection $usuariosConToken;

    public function mount(): void
    {
        $this->cargarEstado();
    }

    public function cargarEstado(): void
    {
        $this->existe = Storage::disk('local')->exists(self::RUTA);

        if (!$this->existe) {
            $this->projectId = $this->clientEmail = $this->actualizadoEn = null;
        } else {
            $contenido = json_decode(Storage::disk('local')->get(self::RUTA), true);
            $this->projectId   = $contenido['project_id'] ?? null;
            $this->clientEmail = $contenido['client_email'] ?? null;
            $this->actualizadoEn = date('d/m/Y H:i', Storage::disk('local')->lastModified(self::RUTA));
        }

        $this->usuariosConToken = User::whereNotNull('fcm_token')
            ->orderBy('name')
            ->get(['id', 'name', 'email']);
    }

    public function save(): void
    {
        $this->validate([
            'file' => ['required', 'file', 'max:2048'],
        ], [
            'file.required' => 'Selecciona el archivo JSON de la cuenta de servicio.',
            'file.max'      => 'El archivo no debe superar 2 MB.',
        ]);

        $contenido = $this->file->get();
        $json = json_decode($contenido, true);

        if (!is_array($json)) {
            $this->addError('file', 'El archivo no es un JSON válido.');
            return;
        }

        $faltantes = array_diff(self::REQUIRED_KEYS, array_keys($json));
        if (!empty($faltantes)) {
            $this->addError('file', 'No parece una cuenta de servicio de Firebase. Faltan campos: ' . implode(', ', $faltantes));
            return;
        }

        if (($json['type'] ?? null) !== 'service_account') {
            $this->addError('file', 'El JSON debe ser de tipo "service_account".');
            return;
        }

        Storage::disk('local')->put(self::RUTA, $contenido);

        $this->reset('file');
        $this->cargarEstado();

        $this->notification()->success(
            title: 'CREDENCIALES GUARDADAS',
            description: 'Firebase quedó configurado para el proyecto ' . ($this->projectId ?? '—') . '.'
        );
    }

    public function enviarPrueba(): void
    {
        $this->validate([
            'usuarioPruebaId' => ['required', 'integer', 'exists:users,id'],
        ], [
            'usuarioPruebaId.required' => 'Selecciona un usuario para enviar la prueba.',
            'usuarioPruebaId.exists'   => 'El usuario seleccionado no existe.',
        ]);

        $usuario = User::find($this->usuarioPruebaId);

        if (!$usuario?->fcm_token) {
            $this->notification()->error(
                title: 'SIN TOKEN FCM',
                description: 'El usuario seleccionado no tiene token FCM registrado.'
            );
            return;
        }

        try {
            $messaging = app(Messaging::class);

            $mensaje = CloudMessage::new()
                ->toToken($usuario->fcm_token)
                ->withNotification(FirebaseNotification::create(
                    '🔔 Prueba de Notificación',
                    'Esta es una notificación de prueba desde Talentus.'
                ))
                ->withData([
                    'action' => 'test',
                    'enviado_por' => auth()->user()?->name ?? 'Admin',
                ])
                ->withAndroidConfig([
                    'priority' => 'high',
                    'notification' => [
                        'sound'      => 'default',
                        'channel_id' => 'general',
                    ],
                ])
                ->withApnsConfig([
                    'payload' => ['aps' => ['sound' => 'default', 'badge' => 1]],
                ]);

            $messaging->send($mensaje);

            $this->notification()->success(
                title: 'PUSH ENVIADO',
                description: 'Notificación de prueba enviada a ' . $usuario->name . '.'
            );
        } catch (\Throwable $e) {
            $this->notification()->error(
                title: 'ERROR AL ENVIAR',
                description: $e->getMessage()
            );
        }
    }

    public function render()
    {
        return view('livewire.admin.ajustes.firebase.credentials');
    }
}
