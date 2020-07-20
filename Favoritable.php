<?php

namespace App\Traits;

use App\User;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function($model) { // before delete() method call this
            $model->userFavorites()->delete();
        });
    }

    public function userFavorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'model_id', 'user_id');
    }
}
