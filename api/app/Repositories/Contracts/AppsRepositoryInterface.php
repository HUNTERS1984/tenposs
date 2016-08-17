<?php
    namespace App\Repositories\Contracts;
    interface AppsRepositoryInterface
    {
        public function all();
        public function storeApp($user, $arrayAppData);
        public function fetchAppsByUser(\App\Filters\EntityFilters\AppsFilters $filters, $user_id);
        public function show($user, $app_id);
        public function updateApp($user,$app_id, $arrayApp);
    }