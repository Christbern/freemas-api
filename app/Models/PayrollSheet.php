<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'site_id',
        'month',
        'days_worked',
        'total_amount',
    ];

    protected $casts = [
        'month' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
