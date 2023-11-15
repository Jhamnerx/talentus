<?php

namespace App\Livewire\Cliente\Formularios;

use App\Models\Cliente\Review as ClienteReview;
use Livewire\Component;

class Review extends Component
{

    public $empresa, $cargo, $name, $telefono, $birthday;
    public $q1, $q2, $q3, $q3_res, $q4, $q5, $q5_why;

    protected function rules()
    {

        return [
            'empresa' => 'required',
            'cargo' => 'required',
            'name' => 'required',
            'telefono' => 'required',
            'birthday' => 'required',

            'q1' => 'required',
            'q2' => 'required',
            'q3' => 'required',
            'q3_res' => 'required_if:q3,SI|nullable',
            'q4' => 'required',
            'q5' => 'required',
            'q5_why' => 'required_if:q5,NO'
        ];
    }

    public function messages()
    {

        return [
            'empresa.required' => 'Ingresa el nombre de tu empresa',
            'cargo.required' => 'Describe tu cargo en tu empresa',
            'name.required' => 'Escribe tu nombre',
            'telefono.required' => 'Escribe tu telefono',
            'birthday.required' => 'Escribe tu fecha de nacimiento',

            'q1.required' => 'Especifica una de las alternativas',
            'q2.required' => 'Escribe una recomendación',
            'q3.required' => 'Especifica una de las alternativas',
            'q3_res.required_if' => 'Si tu respuesta es SI, especifica',
            'q4.required' => 'Especifica una de las alternativas',
            'q5.required' => 'Especifica una de las alternativas',
            'q5_why.required_if' => 'Si tu respuesta es NO, especifica'
        ];
    }
    public function render()
    {
        return view('livewire.cliente.formularios.review');
    }

    public function sendForm()
    {

        $this->validate();


        $review =  ClienteReview::create(
            [
                'empresa' => $this->empresa,
                'cargo' => $this->cargo,
                'name' => $this->name,
                'telefono' => $this->telefono,
                'birthday' => $this->birthday,

                'question' => [
                    'q1' => $this->q1,
                    'q2' => $this->q2,
                    'q3' => $this->q3,
                    'q3_res' => $this->q3_res,
                    'q4' => $this->q4,
                    'q5' => $this->q5,
                    'q5_why' => $this->q5_why
                ]
            ]
        );

        $this->reset();
        $this->dispatch('save-review');
    }

    public function updated($attr)
    {

        $this->validateOnly($attr);
    }
}
