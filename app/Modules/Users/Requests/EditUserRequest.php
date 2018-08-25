<?php

namespace App\Modules\Users\Requests;

use App\Base\Request;
use App\Modules\Users\Models\User;
use App\Rules\Uppercase;
use App\Rules\BooleanRule;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class EditUserRequest extends Request
{
    public $modelAttributes = [
    'user_id',
    'user_name',
    'user_ldap',
    'user_date',
    'user_iban',
    'user_bic',
    'user_status',
    'user_last',
    'user_zabbix',
    'report',
    'billing',
    'user_vat',
  ];

    public function __construct()
    {
        $this->rules = [
      'user_name'     => ['required', 'min:3', 'max:50'],
      'user_password' => ['required', 'min:3', 'max:50'],
      'firstname'     => 'nullable|max:50',
      'lastname'      => 'nullable|max:50',
      'user_email'    => 'nullable|email',
      'language'      => [new Uppercase()],
      'ip'            => ['max:50'],
      'plan'          => 'nullable|numeric|max:50',
      'user_status'        => ['nullable', new BooleanRule()],
      'report'        => ['nullable', new BooleanRule()],
      'user_vat'      => 'nullable|numeric',
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
      'user_name'     => ['name', 'user_name', 'username', 'login', 'user', 'id', 'user_id', 'uid'],
      'user_password' => ['pass', 'password', 'user_password', 'user_pass'],
      'firstname'     => ['firstname', 'givenname', 'first_name', 'user_firstname', 'user_givenname', 'user_first_name', 'user_given_name'],
      'lastname'      => ['lastname', 'sn', 'user_lastname', 'user_sn', 'user_last_name'],
      'user_email'    => ['mail', 'email', 'user_email', 'user_mail'],
      'language'      => ['language', 'lang'],
      'ip',
      'plan',
      'plan_type',
      'user_iban',
      'user_bic',
      'user_address'  => ['postal_address', 'address', 'user_address'],
      'postal_code'   => ['postal_code', 'code'],
      'postal_code'   => ['postal_code', 'code'],
      'postal_code'   => ['postal_code', 'code'],
      'organisation'  => ['organisation', 'o'],
      'city'          => ['locality', 'l', 'city'],
      'user_status'        => ['status', 'user_status'],
      'organisation'  => ['organisation', 'o'],
      'report',
      'user_zabbix',
      'ssh'           => ['key', 'ssh'],
      'mode',
      'billing',
      'user_vat'
    ];
    }

    /**
     * Edit User Item
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $user       = User::where('user_id', $this->user_name)->orWhere('user_name', $this->user_name)->first();
        $attributes = $this->modelAttributes;
        unset($attributes['user_name']);

        foreach ($attributes as $attribute) {
            if ($this->{$attribute}) {
                $user->{$attribute} = $this->{$attribute};
            }
        }

        $user->user_last = time();
        if ($this->status) {
            $user->user_status = in_array($this->status, ['0', 'no', 'false']) ? 0 : 1;
        }
        if ($this->report) {
            $user->user_status = in_array($this->status, ['0', 'no', 'false']) ? 0 : 1;
        }

        if (!$this->plan_type) {
            $user->plan_type = 'memory';
        }

        if (!$user->update()) {
            $this->errorInternal();
        }

        return $user->toArray();
    }
}
