<?php

namespace App\Modules\Grants\Requests;

use App\Base\Request;
use App\Modules\Grants\Models\Grant;

/**
 * Class AddGrantRequest
 * @package App\Modules\Grants\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class AddGrantRequest extends Request
{
    /**
     * Class Constructor
     *
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function __construct()
    {
        $this->rules = [
          'grant_name'    => ['unique:grants','required', 'max:30'],
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
          'grant_name'       => ['grant', 'name', 'grant_name'],
        ];
    }

    /**
     * Create Grant Item
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $grant = new Grant();
        $grant->setRawAttributes($this->getAttributes());
        if (!$grant->save()) {
            $this->errorInternal();
        }

        return $grant->toArray();
    }
}
