<?php

namespace App\Models;

class Ticket extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'title',
        'body',
        'department_id',
        'user_id',
        'latest_status'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'department_id' => 'integer',
        'user_id' => 'string',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'user_id',
        'id',
        'department_id'
    ];

    protected $appends = [
        'status',
        'department_name'
    ];


    //Relations
    public function latestStatus()
    {
        return $this->belongsTo(Status::class,'latest_status','id');
    }
    public function statuses()
    {
        return $this->belongsToMany(Status::class,'status_ticket');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function updateLatestStatus($status)
    {
        $this->update([
            'latest_status' => $status
        ]);
    }

    //Mutators
    public function getStatusAttribute()
    {
        return $this->latestStatus()->pluck('title')['0'];
    }

    public function getDepartmentNameAttribute()
    {
        return $this->department()->pluck('title')->first();
    }
}
