<?php

namespace App\Modules\Groups\Requests;

use App\Base\Request;
use App\Modules\Groups\Models\UserGroup;
use App\Modules\Groups\Models\Group;
use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\DB;
use Hoa\Math\Combinatorics\Combination\CartesianProduct;
use App\Helpers\Cartesian;

/**
 * Class AddGroupRequest
 * @package App\Modules\Group\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class AddUserGroupRequest extends Request
{

  function __construct()
  {
    $this->rules = [
      'group_id' => ['required', 'min:1', 'max:30'],
      'user_id' => ['required', 'min:1', 'max:30'],
    ];
    $this->sanitize = [
      'group_id' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}'],
      'user_id' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}']
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
      'group_id' => ['group', 'group_name', 'groups', 'group_names', 'group_id', 'group_ids', 'gid', 'gids'],
      'user_id' => ['user_name', 'username', 'login', 'user', 'user_id', 'uid', 'user_names', 'usernames', 'logins', 'users', 'user_ids', 'uids'],
    ];
  }

  /**
   * Create Group User Item
   * @return array
   * @throws \App\Base\Exceptions\InternalErrorException
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {
    $this->setAttributes($this->sanitize($this->getAttributes()));
    $userGroup = new UserGroup();
    $group = new Group();
    $user = new User();
    $user = $user->select('user_id');
    $group = $group->select('group_id');
    if ($this->group_id) {
      $groupNames = is_array($this->group_id) ? $this->group_id : [$this->group_id];
      $group = $group->where(function ($query) use ($groupNames) {
        foreach ($groupNames as $name) {
          if (is_numeric($name)) {
            $query = $query->orWhere('group_id', $name);
          } else {
            $query = $query->orWhere('group_name', 'LIKE', "%$name%");
          }
        }
      });
    }
    $group = $group->get()->toArray();
    if ($this->user_id) {
      $userNames = is_array($this->user_id) ? $this->user_id : [$this->user_id];
      $user = $user->where(function ($query) use ($userNames) {
        foreach ($userNames as $name) {
          if (is_numeric($name)) {
            $query = $query->orWhere('user_id', $name);
          } else {
            $query = $query->orWhere('user_name', 'LIKE', "%$name%");
          }
        }
      });
    }

    $user = $user->get()->toArray();

    $smaller = count($user) >= count($group) ? $group : $user;
    $userGroup = DB::table('user_group');

    $product = new CartesianProduct(collect($user)->flatten()->all(), collect($group)->flatten()->all());
    $inserts = [];
    foreach ($product as $i => $tuple) {
      $inserts[] = ['user_id' => $tuple[0], 'group_id' => $tuple[1]];
    }


    if (!$userGroup->insert($inserts)) {
      $this->errorInternal();
    }

    return ['response' => 'OK'];
  }


}