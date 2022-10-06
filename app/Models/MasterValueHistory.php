<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterValueHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'master_value_history';

    protected $fillable = [
        'amount', 'date_of_change', 'changed_by', 'percentage', 'difference', 'status'
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
