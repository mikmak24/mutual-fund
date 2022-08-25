<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeContribution extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'employee_contribution', 'employer_contribution', 'employee_gained', 'date_of_contribution', 'uploaded_by'
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
