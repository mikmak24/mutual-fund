<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeContributionHistory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'employee_contribution_history';

    protected $fillable = [
        'employee_contribution_id', 'username', 'employee_contribution', 'employer_contribution', 'employee_gained',
        'employee_contribution_change', 'employer_contribution_change', 'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'updated_at',
    ];

    
}
