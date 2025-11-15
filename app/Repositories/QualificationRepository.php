<?php 

namespace App\Repositories;

use App\Models\Qualification;

class QualificationRepository extends ResourceRepository {

    public function __construct(Qualification $qualification)
    {
        $this->model = $qualification;
    }

    public function getAll() {
        return $this->model->with('employees');
    }
    
}