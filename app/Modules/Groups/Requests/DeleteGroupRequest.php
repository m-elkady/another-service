<?php

namespace App\Modules\Groups\Requests;

use App\Base\Request;
use App\Modules\Groups\Models\Group;

/**
 * Class AddGroupRequest
 * @package App\Modules\Group\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class DeleteGroupRequest extends Request
{

  function __construct()
  {
    $this->rules = [
      'group_id' => ['required'],
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
      'group_id' => ['group', 'name', 'group_name', 'id', 'group_id', 'gid'],
    ];
  }

  /**
   * Delete Group Item
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {
    $group = Group::where('group_id', $this->group_id)
      ->orWhere('group_name', $this->group_id)->get();

    return $group->delete();
  }


}