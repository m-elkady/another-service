<?php

namespace App\Modules\Grants\Requests;

use App\Base\Request;
use App\Modules\Grants\Models\Grant;

/**
 * Class ViewGrantRequest
 * @package App\Modules\Grants\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class ViewGrantRequest extends Request
{
    public function __construct()
    {
        $this->rules = [];
        $this->sanitize = [
            'grant_name' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}']
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
            'grant_name' => ['grant', 'name', 'grant_name', 'grants', 'names', 'grant_names', 'id', 'grant_id', 'gid', 'ids', 'grant_ids', 'gids'],
          ];
    }

    /**
     * Get Grants Items
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $this->setAttributes($this->sanitize($this->getAttributes()));
        $grant = new Grant();
        $perPage = $this->perPage ? intval($this->perPage) : 20;
        $orderBy = $this->orderBy ? $this->orderBy : 'grant_name';
        $order = $this->order ? $this->order : 'ASC';
        $grant->setPerPage($perPage);

        $grantNames = is_array($this->grant_name) ? $this->grant_name : [$this->grant_name];

        $grant = $grant->where(function ($query) use ($grantNames) {
            foreach ($grantNames as $name) {
                if (is_numeric($name)) {
                    $query = $query->orWhere('grant_id', $name);
                } else {
                    $query = $query->orWhere('grant_name', 'LIKE', "%$name%");
                }
            }
        });

        $grant->orderBy($orderBy, $order);
        return $grant->paginate()->appends($this->getAttributes());
    }
}
