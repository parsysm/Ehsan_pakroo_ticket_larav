<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens,Notifiable;

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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'is_customer'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'id',
        'is_customer',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'is_customer' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    //Relations
    public function tickets()
    {
        return $this->hasMany(Ticket::class,'user_id','id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class,'user_id','id');
    }

    public function isCustomer()
    {
        if($this->attributes['is_customer'])
            return true;

        return false;
    }
}
