<?php

namespace App\Repositories\Eloquents;

use App\Models\Apps;
use App\Models\Users;
use App\Repositories\Contracts\AppsRepositoryInterface;
use App\Filters\EntityFilters\AppsFilters;

class AppsRepository implements AppsRepositoryInterface
{


    public function all()
    {
        return Apps::all();
    }

    public function storeApp($user, $arrayApp)
    {
        $app = new Apps($arrayApp);
        return $user->apps()->save($app);
    }


    public function fetchAppsByUser(AppsFilters $filters, $user_id, $limit = 20)
    {

        $app = Apps::where('user_id', $user_id)->filter($filters)->paginate($limit);
        return $app;
    }

    public function remove($user_id, $app_id)
    {
        return Apps::where('id', $app_id)->where('user_id', $user_id)->delete();
    }
}