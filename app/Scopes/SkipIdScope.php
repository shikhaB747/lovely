<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\{Builder,Model,Scope};

class SkipIdScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Apply a condition to skip ID 1
        $builder->where('id', '!=', 1);
    }
}
