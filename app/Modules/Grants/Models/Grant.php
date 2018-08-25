<?php

namespace App\Modules\Grants\Models;

use App\Models\AppModel;

class Grant extends AppModel
{
    protected $table = 'grants';

    protected $primaryKey = 'grant_id';
    public $perPage = 5;
    public $orderBy = 'grant_id';
    public $order = 'asc';
   
    protected $attributes = [
    'grant_id',
    'grant_name',
  ];
}
