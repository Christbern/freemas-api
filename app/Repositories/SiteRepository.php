<?php 

namespace App\Repositories;

use App\Models\Site;

class SiteRepository extends ResourceRepository {

    public function __construct(Site $site)
    {
        $this->model = $site;
    }

    public function getAll() {
        return $this->model->with('client')->get();
    }
}