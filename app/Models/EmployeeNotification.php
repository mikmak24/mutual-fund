<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeNotification extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from', 'to', 'message', 'is_read'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at', 'created_at',
    ];

    
}
