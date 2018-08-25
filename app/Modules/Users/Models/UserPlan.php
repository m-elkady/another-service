<?php

namespace App\Modules\Users\Models;

use App\Models\AppModel;

class UserPlan extends AppModel
{
    protected $table         = 'user_plan';
    protected $primaryKey    = 'plan_id';
    // public $perPage          = 5;
    // public $orderBy          = 'user_date';
    // public $order            = 'desc';

    public function plans()
    {
        return $this->belongsTo('App\Modules\Users\Models\Plan', 'plan_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Modules\Users\Models\User', 'user_id');
    }
}
