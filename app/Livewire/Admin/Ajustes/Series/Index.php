<?php

namespace App\Livewire\Admin\Ajustes\Series;

use App\Models\Series;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\WithPagination;

use function PHPSTORM_META\map;
use App\Models\TipoComprobantes;

class Index extends Component
{
    use WithPagination;
    public $tipo_comprobante_id, $serie, $correlativo = 0;


    public function render()
    {
        $series = Series::orderby('tipo_comprobante_id', 'asc')->paginate(10);
        return view('livewire.admin.ajustes.series.index', compact('series'));
    }


    public function addSerie()
    {

        $datos = $this->validate(
            [
                'tipo_comprobante_id' => 'required|exists:tipo_comprobantes,codigo',
                'serie' => 'required|unique:series,serie',
                'correlativo' => 'numeric|min:0|required',
            ],
            [
                'tipo_comprobante_id.exists' => 'el tipo de comprobante no existe',
                'serie.unique' => 'La serie ya existe',
                'correlativo.numeric' => 'El correlativo debe ser un número',
                'correlativo.min' => 'el valor minimo aceptado es: 0',
                'correlativo.required' => 'el valor minimo es obligatorio',
            ]
        );


        $comprobante = TipoComprobantes::find($this->tipo_comprobante_id);

        $comprobante->series()->create([
            'serie' => $datos['serie'],
            'correlativo' => Str::upper($datos['correlativo']),
        ]);

        $this->afterSave($datos['serie'], $comprobante->descripcion);

        $this->reset('serie', 'correlativo');
    }
    #[On('update-table')]
    public function updateTable()
    {
        $this->render();
    }

    public function deleteSerie(Series $serie)
    {

        $this->dispatch('delete-serie', serie: $serie);
    }
}
