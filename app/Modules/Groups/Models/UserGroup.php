<?php

namespace App\Modules\Groups\Models;

use App\Models\AppModel;
use Illuminate\Database\Eloquent\Builder;

class UserGroup extends AppModel
{
  protected $table = 'user_group';

  protected $primaryKey = ['group_id', 'user_id'];
  public $increamenting = false;
  
  // public $perPage = 5;
  // public $orderBy = 'group_name';
  // public $order = 'asc';

  // protected $attributes = [
  //   'group_id',
  //   'group_name',
  // ];

  public function groups()
  {
    return $this->belongsTo('App\Modules\Groups\Models\Group', 'group_id');
  }

  public function users()
  {
    return $this->belongsTo('App\Modules\Users\Models\User', 'user_id');
  }
  // protected function setKeysForSaveQuery(Builder $query)
  //   {
  //       $query
  //           ->where('group_id', '=', $this->getAttribute('group_id'))
  //           ->where('user_id', '=', $this->getAttribute('user_id'));
  //       return $query;
  //   }

  /**
   * Set the keys for a save update query.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  protected function setKeysForSaveQuery(Builder $query)
  {
    $keys = $this->getKeyName();
    if (!is_array($keys)) {
      return parent::setKeysForSaveQuery($query);
    }

    foreach ($keys as $keyName) {
      $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
    }

    return $query;
  }

  /**
   * Get the primary key value for a save query.
   *
   * @param mixed $keyName
   * @return mixed
   */
  protected function getKeyForSaveQuery($keyName = null)
  {
    if (is_null($keyName)) {
      $keyName = $this->getKeyName();
    }

    if (isset($this->original[$keyName])) {
      return $this->original[$keyName];
    }

    return $this->getAttribute($keyName);
  }
}