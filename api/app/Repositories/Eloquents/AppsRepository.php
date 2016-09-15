<?php

namespace App\Repositories\Eloquents;

use App\Models\App;
use App\Models\User;
use App\Repositories\Contracts\AppsRepositoryInterface;
use App\Filters\EntityFilters\AppsFilters;
use DB;

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

    public function updateApp($user,$app_id, $arrayApp)
    {
        return $user->apps()->findOrFail($app_id)->update($arrayApp);
    }

    public function fetchAppsByUser(AppsFilters $filters, $user_id, $limit = 20)
    {

        $app = App::where('user_id', $user_id)->filter($filters)->paginate($limit);
        return $app;
    }

    public function show($user, $app_id){
        return $user->apps()->findOrFail($app_id);
    }

    public function remove($user_id, $app_id)
    {
        $app = App::where('id', $app_id)->where('user_id', $user_id)->first();
        return $app->delete();
    }

    public function updateNotifyInfo($app_id, $arrayInfo)
    {
       return App::where('id',$app_id)->update($arrayInfo);
    }

    public function getAppInfoById($app_id)
    {
        return App::where('id',$app_id)->get()->toArray();
    }
}