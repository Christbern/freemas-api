<?php 

namespace App\Repositories;

use App\Models\Attendance;

class AttendanceRepository extends ResourceRepository {

    public function __construct(Attendance $attendance)
    {
        $this->model = $attendance;
    }

    public function getAll() {
        return $this->model->with('employee', 'site')->latest()->get();
    }
}