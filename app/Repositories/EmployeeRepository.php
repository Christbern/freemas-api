<?php 

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository extends ResourceRepository {

    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    public function getAll() {
        return $this->model->with('qualification', 'attendances', 'payrollSheets');
    }
    
}