<?php

namespace App\Modules\Grants\Requests;

use App\Base\Request;
use App\Modules\Grants\Models\Grant;

/**
 * Class DeleteGrantRequest
 * @package App\Modules\Grants\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class DeleteGrantRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
        'grant_id' => ['required'],
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
            'grant_id' => ['grant', 'name', 'grant_name', 'id', 'grant_id', 'gid'],
          ];
    }

    /**
     * Delete Grant Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $grant = Grant::where('grant_id', $this->grant_id)->orWhere('grant_name', $this->grant_id)->first();

        return $grant->delete();
    }
}
