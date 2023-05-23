<?php

namespace App\Http\Livewire\Admin\Reviews;

use App\Exports\ReviewsExport;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Cliente\Review;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public $search;


    public function render()
    {
        $reviews = Review::where(function ($query) {
            $query->where('empresa', 'like', '%' . $this->search . '%')
                ->orwhere('cargo', 'like', '%' . $this->search . '%')
                ->orwhere('name', 'like', '%' . $this->search . '%')
                ->orwhere('telefono', 'like', '%' . $this->search . '%');
        })->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.reviews.index', compact('reviews'));
    }

    public function ExportReviews()
    {
        return Excel::download(new ReviewsExport, 'revisiones_clientes.xls');
    }
}
