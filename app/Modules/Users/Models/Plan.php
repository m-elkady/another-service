<?php

namespace App\Modules\Users\Models;

use App\Models\AppModel;

class Plan extends AppModel
{
    protected $table         = 'plans';
    protected $primaryKey    = 'plan_id';
    // public $perPage          = 5;
    // public $orderBy          = 'user_date';
    // public $order            = 'desc';

    public function userPlans()
    {
        return $this->hasMany('App\Modules\Users\Models\UserPlan', 'plan_id');
    }

    // public function users() {
  //   return $this->belongsTo('App\Modules\Users\Models\User', 'user_id');
  // }
}
