<?php 

namespace App\Repositories;

use App\Models\User;

class UserRepository extends ResourceRepository{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getByEmail($email) {
        return $this->model->where('email', $email)->first();
    }

    public function getByPhoneNumber($phone) {
        return $this->model->where('phone', $phone)->first();
    }
}