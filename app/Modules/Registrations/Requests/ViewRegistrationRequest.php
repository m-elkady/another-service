<?php

namespace App\Modules\Registrations\Requests;

use App\Base\Request;
use App\Modules\Registrations\Models\Registration;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class ViewRegistrationRequest extends Request
{
    public function __construct()
    {
        $this->rules = [];
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
      'register_email' => ['mail', 'email', 'address', 'user_email', 'user_mail', 'user_address'],
      'register_code'  => ['code', 'validation'],
    ];
    }

    /**
     * Get News Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        return Registration::pagination($this)->toArray();
    }
}
