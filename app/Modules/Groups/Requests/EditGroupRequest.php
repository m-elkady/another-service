<?php

namespace App\Modules\Groups\Requests;

use App\Base\Request;
use App\Modules\Group\Models\Group;

/**
 * Class AddGroupRequest
 * @package App\Modules\Groups\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class EditGroupRequest extends Request
{

  function __construct()
  {
    $this->rules = [
      'group_id' => ['required', 'numeric'],
      'group_name' => ['required', 'min:3', 'max:30'],
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
      'group_id' => ['group_id', 'id', 'gid'],
      'group_name' => ['group', 'name', 'group_name']
    ];
  }

  /**
   * Edit Group Item
   * @return array
   * @throws \App\Base\Exceptions\InternalErrorException
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {
    $group = Group::findOrFail($this->group_id);
    $attributes = $this->getAttributes();
    unset($attributes['group_id']);

    foreach ($attributes as $attribute => $value) {
      if (isset($value)) {
        $group->{$attribute} = $value;
      }
    }
    if (!$group->update()) {
      $this->errorInternal();
    }

    return $group->toArray();
  }


}