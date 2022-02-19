<?php

namespace App\Models;


class Reply extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'body',
        'ticket_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => 'string',
        'ticket_id' => 'string',
        'customer_id' => 'string',
        'employee_id' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'ticket_id',
        'id'
    ];

    protected $with = [
      'user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id','id');
    }

}
