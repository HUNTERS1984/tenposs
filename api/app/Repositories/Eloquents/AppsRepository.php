<?php

namespace App\Repositories\Eloquents;

use App\Models\App;
use App\Models\User;
use App\Repositories\Contracts\AppsRepositoryInterface;
use App\Filters\EntityFilters\AppsFilters;

class AppsRepository implements AppsRepositoryInterface
{


    public function all()
    {
        return App::all();
    }

    public function storeApp($user, $arrayApp)
    {
        $app = new App($arrayApp);
        return $user->apps()->save($app);
    }


    public function fetchAppsByUser(AppsFilters $filters, $user_id, $limit = 20)
    {

        $app = App::where('user_id', $user_id)->filter($filters)->paginate($limit);
        return $app;
    }

    public function remove($user_id, $app_id)
    {
        $app = App::where('id', $app_id)->where('user_id', $user_id)->first();
        return $app->delete();
    }
}