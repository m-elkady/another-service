<?php

namespace App\Modules\Registrations\Requests;

use App\Base\Request;
use App\Modules\Registrations\Models\Registration;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class AddRegistrationRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
      'register_email' => ['required', 'email', 'max:150'],
    ];
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function attributes()
    {
        return [
      'register_email' => ['mail', 'email', 'address', 'user_email', 'user_mail', 'user_address'],
    ];
    }

    /**
     * Create News Item
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @throws \App\Base\Exceptions\HttpException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $registration = new Registration();

        // Delete old registrations
        $registration->where('register_date', '<', (time() - 864000))->delete();
        // search for pending requests
        if ($registration->where('register_email', $this->register_email)->first()) {
            $this->error('Pending request already exists', 412);
        }
        $registration->setRawAttributes($this->getAttributes());
        if (!$registration->save()) {
            $this->errorInternal();
        }

        return $registration->toArray();
    }
}
