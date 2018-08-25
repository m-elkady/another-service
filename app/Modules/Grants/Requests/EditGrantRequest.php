<?php

namespace App\Modules\Grants\Requests;

use App\Base\Request;
use App\Modules\Grants\Models\Grant;

/**
 * Class EditGrantRequest
 * @package App\Modules\Grants\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class EditGrantRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
      'grant_id' => ['required', 'numeric'],
      'grant_name' => ['max:30'],
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
        'grant_id' => ['id', 'grant_id', 'gid'],
        'grant_name' => ['grant', 'name', 'grant_name'],
      ];
    }

    /**
     * Edit Grant Item
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $grant = Grant::findOrFail($this->grant_id);
        $attributes = $this->getAttributes();
        unset($attributes['grant_id']);

        foreach ($attributes as $attribute => $value) {
            if (isset($value)) {
                $grant->{$attribute} = $value;
            }
        }
        if (!$grant->update()) {
            $this->errorInternal();
        }

        return $grant->toArray();
    }
}
