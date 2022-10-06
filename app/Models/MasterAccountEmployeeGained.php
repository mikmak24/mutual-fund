<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAccountEmployeeGained extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'master_account_employee_gained';

    protected $fillable = [
        'username', 'amount', 'percentage', 'date_of_change', 'status', 'amount_total'
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
