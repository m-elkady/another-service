<?php

namespace App\Modules\Groups\Requests;

use App\Base\Request;
use App\Modules\Groups\Models\UserGroup;
use Illuminate\Support\Facades\DB;

/**
 * Class ViewGroupRequest
 * @package App\Modules\Groups\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class DeleteUserGroupRequest extends Request
{
  function __construct()
  {
    $this->rules = [
      'group_name' => 'required',
      'user_name' => 'required',
    ];
    $this->sanitize = [
      'group_name' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}'],
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
      'perPage',
      'orderBy',
      'order',
      'group_name' => ['group', 'group_name', 'group_id', 'gid'],
      'user_name' => ['user_name', 'username', 'login', 'user', 'user_id', 'uid'],
    ];
  }

  /**
   * Get G Item
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {
    $this->setAttributes($this->sanitize($this->getAttributes()));

    $userGroup = DB::table('user_group');
    $groupName = $this->group_name;
    $userName = $this->user_name;

    $userGroup
      ->join('users', 'users.user_id', '=', 'user_group.user_id')
      ->join('groups', 'groups.group_id', '=', 'user_group.group_id');

    if ($userName) {
      $userGroupNames = is_array($userName) ? $userName : [$userName];

      $userGroup = $userGroup->where(function ($query) use ($userGroupNames) {
        foreach ($userGroupNames as $name) {
          if (is_numeric($name)) {
            $query = $query->orWhere('users.user_id', $name);
          } else {
            $query = $query->orWhere('users.user_name', 'LIKE', "%$name%");
          }
        }
      });
    }

    if ($groupName) {
      $userGroupNames = is_array($groupName) ? $groupName : [$groupName];

      $userGroup = $userGroup->where(function ($query) use ($userGroupNames) {
        foreach ($userGroupNames as $name) {
          if (is_numeric($name)) {
            $query = $query->orWhere('groups.group_id', $name);
          } else {
            $query = $query->orWhere('groups.group_name', 'LIKE', "%$name%");
          }
        }
      });
    }

    return $userGroup->delete();
  }


}