<?php

namespace App\Modules\Groups\Requests;

use App\Base\Request;
use App\Modules\Groups\Models\Group;

/**
 * Class AddGroupRequest
 * @package App\Modules\Group\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class AddGroupRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
      'group_name' => ['unique:groups', 'required', 'min:3', 'max:30'],
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
      'group_name' => ['group', 'name', 'group_name'],
    ];
    }

    /**
     * Create Group Item
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $group = new Group();
        $group->setRawAttributes($this->getAttributes());
        if (!$group->save()) {
            $this->errorInternal();
        }

        return $group->toArray();
    }
}
