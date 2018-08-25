<?php

namespace App\Modules\Groups\Models;

use App\Models\AppModel;

class Group extends AppModel
{
    protected $table = 'groups';

    protected $primaryKey = 'group_id';
    public $perPage = 5;
    public $orderBy = 'group_name';
    public $order = 'asc';

    protected $attributes = [
    'group_id',
    'group_name',
  ];
}
