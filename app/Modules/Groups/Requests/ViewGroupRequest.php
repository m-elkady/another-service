<?php

namespace App\Modules\Groups\Requests;

use App\Base\Request;
use App\Modules\Groups\Models\Group;

/**
 * Class ViewGroupRequest
 * @package App\Modules\Groups\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class ViewGroupRequest extends Request
{
    public function __construct()
    {
        $this->rules = [];
        $this->sanitize = [
      'group_name' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}']
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
      'group_name' => ['group', 'name', 'group_name', 'groups', 'names', 'group_names', 'id', 'group_id', 'gid', 'ids', 'group_ids', 'gids'],
    ];
    }

    /**
     * Get G Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $group = new Group();
        $this->setAttributes($this->sanitize($this->getAttributes()));
        $perPage = $this->perPage ? intval($this->perPage) : 20;
        $orderBy = $this->orderBy ? $this->orderBy : 'group_name';
        $order = $this->order ? $this->order : 'ASC';

        $group->setPerPage($perPage);
        if ($this->group_name) {
            $groupNames = is_array($this->group_name) ? $this->group_name : [$this->group_name];

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
        $group = $group->groupBy('group_id');
        $group->orderBy($orderBy, $order);

        return $group->paginate()->appends($this->getAttributes());
    }
}
