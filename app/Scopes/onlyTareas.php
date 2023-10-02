<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class OnlyTareas implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // $builder->where('empresa_id', 1);

        if (auth()->user()->hasRole('tecnico')) {

            $builder->where('tecnico_id', auth()->user()->id);
        }
    }
}
