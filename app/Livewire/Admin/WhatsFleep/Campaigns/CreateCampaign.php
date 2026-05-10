<?php

namespace App\Livewire\Admin\WhatsFleep\Campaigns;

use App\Jobs\WhatsFleep\SendCampaignJob;
use App\Models\WhatsFleep\Campaign;
use App\Models\WhatsFleep\Device;
use App\Models\WhatsFleep\WaTag;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\WireUiActions;

class CreateCampaign extends Component
{
    use WireUiActions, WithFileUploads;

    public int    $currentStep    = 1;
    public string $name           = '';
    public ?int   $device_id      = null;
    public string $sender         = '';
    public ?int   $tag_id         = null;
    public string $message_type   = 'text';
    public string $message        = '';
    public string $caption        = '';
    public string $footer         = '';
    public string $image_url      = '';
    public array  $buttons        = [''];
    public string $list_title     = '';
    public string $list_button_text = 'Ver opciones';
    public array  $list_sections  = [['title' => 'Sección 1', 'rows' => ['']]];
    public int    $delay          = 10;
    public string $schedule_type  = 'immediate';
    public string $schedule_time  = '';

    protected function rules(): array
    {
        $rules = [
            'name'          => 'required|string|max:255',
            'device_id'     => 'required|exists:devices,id',
            'tag_id'        => 'required|exists:tags,id',
            'message_type'  => 'required|in:text,image,video,audio,document,button,template,list',
            'delay'         => 'required|integer|min:1|max:60',
            'schedule_type' => 'required|in:immediate,scheduled',
        ];

        switch ($this->message_type) {
            case 'text':
                $rules['message'] = 'required|string';
                break;
            case 'image':
            case 'video':
            case 'audio':
            case 'document':
                $rules['image_url'] = 'required|url';
                break;
            case 'button':
                $rules['message'] = 'required|string';
                $rules['buttons'] = 'required|array|min:1|max:3';
                break;
            case 'list':
                $rules['message']          = 'required|string';
                $rules['list_button_text'] = 'required|string';
                break;
        }

        if ($this->schedule_type === 'scheduled') {
            $rules['schedule_time'] = 'required|date|after:now';
        }

        return $rules;
    }

    public function mount(): void
    {
        $device = Auth::user()->waDevices()->where('status', 'Connected')->first();
        if ($device) {
            $this->device_id = $device->id;
            $this->sender    = $device->body;
        }
    }

    public function updatedDeviceId(): void
    {
        $device = Auth::user()->waDevices()->find($this->device_id);
        $this->sender = $device?->body ?? '';
    }

    public function nextStep(): void
    {
        if ($this->currentStep === 1) {
            $this->validateOnly('name,device_id');
        }
        $this->currentStep++;
    }

    public function prevStep(): void
    {
        $this->currentStep--;
    }

    public function create(): void
    {
        $this->validate();

        $campaign = Campaign::create([
            'user_id'      => Auth::id(),
            'name'         => $this->name,
            'sender'       => $this->sender,
            'phonebook_id' => $this->tag_id,
            'type'         => $this->message_type,
            'message'      => json_encode($this->buildMessageData()),
            'delay'        => $this->delay,
            'schedule'     => $this->schedule_type === 'scheduled' ? $this->schedule_time : null,
            'status'       => 'waiting',
        ]);

        $tag = WaTag::findOrFail($this->tag_id);
        foreach ($tag->contacts as $contact) {
            $campaign->blasts()->create([
                'user_id'  => Auth::id(),
                'sender'   => $this->sender,
                'receiver' => $contact->number,
                'message'  => $campaign->message,
                'type'     => $this->message_type,
                'status'   => 'pending',
            ]);
        }

        if ($this->schedule_type === 'immediate') {
            SendCampaignJob::dispatch($campaign, $this->buildMessageData());
        }

        $this->notification()->success('Campaña creada', 'La campaña ha sido programada exitosamente.');
        $this->redirect(route('admin.whats-fleep.campaigns'));
    }

    private function buildMessageData(): array
    {
        return [
            'sender'      => $this->sender,
            'type'        => $this->message_type,
            'message'     => $this->message,
            'url'         => $this->image_url,
            'caption'     => $this->caption,
            'footer'      => $this->footer,
            'buttons'     => $this->buttons,
            'title'       => $this->list_title,
            'buttonText'  => $this->list_button_text,
            'sections'    => $this->list_sections,
        ];
    }

    public function render()
    {
        $devices   = Auth::user()->waDevices()->where('status', 'Connected')->get();
        $phonebooks = Auth::user()->waTags()->withCount('contacts')->get();

        return view('livewire.admin.whats-fleep.campaigns.create-campaign', compact('devices', 'phonebooks'));
    }
}
