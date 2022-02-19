<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if(in_array('uuid', $model->fillable)) {
                $uuid = generateUuid4();
                while(Self::whereUuid($uuid)->first()){
                    $uuid = generateUuid4();
                }
                $model->uuid = $uuid;
            }
        });
    }
}
