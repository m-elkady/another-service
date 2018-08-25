<?php

namespace App\Modules\Registrations\Requests;

use App\Base\Request;
use App\Modules\Registrations\Models\Registration;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class DeleteRegistrationRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
      'register_code' => ['required'],
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
      'register_code' => ['id', 'code'],
    ];
    }

    /**
     * Delete News Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $registration = Registration::findOrFail($this->register_code);

        return $registration->delete();
    }
}
