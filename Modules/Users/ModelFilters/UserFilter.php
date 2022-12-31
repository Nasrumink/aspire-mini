<?php

namespace Modules\Users\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{

    # _id is dropped from the end of the input key to define the method so filtering user_id would use the user() method
    protected $drop_id = false;
    protected $camel_cased_methods = false;
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function setup()
    {
        return;
    }

    public function id($filter)
    {
        return $this->where('id', $filter);
    }

    public function role($filter)
    {
        return $this->where('role', $filter);
    }

}
