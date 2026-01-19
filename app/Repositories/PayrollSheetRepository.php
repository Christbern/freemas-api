<?php

namespace App\Repositories;

use App\Models\PayrollSheet;

class PayrollSheetRepository extends ResourceRepository
{

    public function __construct(PayrollSheet $payrollSheet)
    {
        $this->model = $payrollSheet;
    }

    public function getLatest() {
        return $this->model->with(['employee.qualification', 'site.client'])->latest()->get();
    }
    
    public function getByEmployeeAndSite($month)
    {
        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();
        return $this->model::with('employee.qualification')
            ->whereBetween('work_date', [$startOfMonth, $endOfMonth])
            ->where('present', true)
            ->get()
            ->groupBy(fn($a) => $a->employee_id . '-' . $a->site_id);
    }
}
