<?php
namespace App\Filters\EntityFilters;
use App\Filters\QueryFilter;

class AppsFilters extends QueryFilter
{
    public function created_at($order = 'desc')
    {
        return $this->builder->orderBy('created_at', $order);
    }

    public function name($value = '')
    {
        if($value != '')
            return $this->builder->where('name', $value);
    }
    public function status($level = '')
    {
        if($level != '')
            return $this->builder->where('status', $level);
    }

}