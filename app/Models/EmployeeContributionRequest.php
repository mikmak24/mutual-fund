<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeContributionRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'employee_contribution_request';

    protected $fillable = [
        'username', 'requested_amount', 'status', 'date_of_request', 'approved_by'
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
