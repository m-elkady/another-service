<?php

namespace App\Modules\Registrations\Models;

use App\Models\AppModel;

class Registration extends AppModel
{
  protected $table = 'register';

  protected $primaryKey = 'register_id';
  public $perPage = 5;
  public $orderBy = 'register_date';
  public $order = 'desc';

  protected $attributes = [
    'register_id',
    'register_email',
    'register_code',
    'register_date'
  ];

  public $filterAttributes = [
    'register_email' => 'like',
  ];

  protected static function boot()
  {
    parent::boot();
    static::creating(function ($model) {
      $model->attributes['register_date'] = time();
      $model->attributes['register_code'] = md5($model->attributes['register_email'] . time());
      return true;
    });
  }
}