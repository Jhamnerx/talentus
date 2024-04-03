<?php

namespace App\Livewire\Admin\Facturacion\Utiles;

use Livewire\Component;
use App\Models\plantilla;
use Greenter\Model\Response\StatusCdrResult;
use App\Http\Controllers\Admin\Facturacion\Api\ApiFacturacion;

class ConsultaCdr extends Component
{

    public $openModal = true;
    public $plantilla;
    public $resultado;
    public $filename;

    public $ruc, $tipo = '01', $serie = 'F001', $correlativo = 1;

    protected function rules()
    {

        return [
            'ruc' => 'required|numeric|digits:11',
            'tipo' => 'required',
            'serie' => 'required|alpha_num|size:4',
            'correlativo' => 'required|numeric',
        ];
    }

    public function mount()
    {
        $this->plantilla = plantilla::first();
        $this->ruc = $this->plantilla->ruc;
    }

    public function render()
    {
        return view('livewire.admin.facturacion.utiles.consulta-cdr');
    }

    public function consultar()
    {
        $this->serie = strtoupper($this->serie); // Convert serie to uppercase

        $datos = $this->validate();

        $api = new ApiFacturacion();
        // Assign the result to a variable
        $res = $api->getStatusCdr($datos);

        $this->resultado = [
            'is_success' => $res->isSuccess(),
            'codigo' => $res->getCode(),
            'mensaje' => $res->getMessage(),
            'cdr' => $res->getCdrResponse(),
            'cdr_status' => $res->getCdrResponse() ? $res->getCdrResponse()->getDescription() : null,
            'cdr_notes' => $res->getCdrResponse() ? $res->getCdrResponse()->getNotes() : null,
            'error_mensaje' => $res->getError() ? $res->getError()->getMessage() : null,

        ];

        $this->filename = $api->filename;
    }

    public function closeModal()
    {
        $this->openModal = false;
    }

    public function updated($propertyName)
    {
        $this->reset('resultado');
    }
}
