<?php

namespace App\Modules\Users\Requests;

use App\Base\Request;
use App\Modules\Users\Models\User;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class ViewUserRequest extends Request
{

  function __construct()
  {
    $this->rules = [];
    $this->sanitize = [
      'user_name' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}']
    ];
  }

  /**
   *
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function attributes()
  {
    return [
      'perPage' => ['count'],
      'orderBy' => ['order'],
      'order' => ['order_type'],
      'user_name' => ['name', 'user_name', 'username', 'login', 'user', 'names', 'user_names', 'usernames', 'logins', 'users', 'id', 'user_id', 'uid', 'ids', 'user_ids', 'uids'],
      'from',
      'to',
      'group'
    ];
  }

  /**
   * Get User Item
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {
    $this->setAttributes($this->sanitize($this->getAttributes()));
    $user = new User();
    $perPage = $this->perPage ? intval($this->perPage) : 5;
    $orderBy = $this->orderBy ? $this->orderBy : 'user_date';
    $order = $this->order ? $this->order : 'DESC';
    $from = $this->from;
    $to = $this->to;
    $user->setPerPage($perPage);

    $usernames = is_array($this->user_name) ? $this->user_name : [$this->username];

    $user = $user->where(function ($query) use ($usernames) {
      foreach ($usernames as $name) {
        if (is_numeric($name)) {
          $query = $query->orWhere('user_id', $name);
        } else {
          $query = $query->orWhere('user_name', 'LIKE', "%$name%");
        }
      }
    });

    if ($from) {
      $user = $user->where('user_date', '>=', $from);
    }
    if ($to) {
      $user = $user->where('user_date', '<=', $value);
    }

    if ($this->group) {
      $user = $user->groupBy($this->group);
    }


    $user->orderBy($orderBy, $order);
    return $user->paginate()->appends($this->getAttributes());
  }

}
