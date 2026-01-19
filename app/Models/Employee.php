<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'qualification_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'hire_date',
    ];

    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payrollSheets()
    {
        return $this->hasMany(PayrollSheet::class);
    }

}
