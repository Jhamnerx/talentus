<?php

namespace App\Http\Livewire\Admin\Payments;

use App\Http\Livewire\Admin\Cobros\Payment;
use App\Models\Payments;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManagerStatic as Image;

class PaymentsPanel extends Component
{
    use WithFileUploads;
    public Payments $payment;

    public $file, $nota;


    protected $listeners = [
        'PaymentPanel',
    ];

    public function mount()
    {
        $this->payment = Payments::find('1');
    }

    public function render()
    {
        return view('livewire.admin.payments.payments-panel');
    }

    public function PaymentPanel(Payments $payment)
    {
        $this->payment = $payment;
        $this->reset('file');
    }


    public function save()
    {

        $this->validate([
            'file' => 'image|max:1024', // 1MB Max
        ]);

        $image = $this->file;

        $img = Image::make($image->getRealPath())->encode('jpg', 65)->fit(760, null, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        Storage::disk('local')->put('public/payments' . '/' . $this->payment->numero . '.png', $img, 'public');

        $this->payment->nota = $this->nota;
        $this->payment->save();

        $this->payment->image()->create([
            'url' => 'payments/' . $this->payment->numero . '.png',
        ]);

        //$img->storeAs('payments', $this->payment->numero . '.png');
        # code...
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'image|max:1024', // 1MB Max
        ]);
    }
}
