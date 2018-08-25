<?php

namespace App\Modules\Users\Models;

use App\Models\AppModel;

class User extends AppModel
{
    protected $table         = 'users';
    protected $primaryKey    = 'user_id';
    public $perPage          = 5;
    public $orderBy          = 'user_date';
    public $order            = 'desc';
    public $filterAttributes = [
    'user_name' => 'like',
  ];

    public function userPlans()
    {
        return $this->hasMany('App\Modules\Users\Models\UserPlan', 'user_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->attributes['user_date'] = time();
            return true;
        });
    }
}
