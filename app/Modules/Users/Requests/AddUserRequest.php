<?php

namespace App\Modules\Users\Requests;

use App\Base\Request;
use App\Modules\Users\Models\User;
use App\Rules\Uppercase;
use App\Services\LdapService;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class AddUserRequest extends Request {

  public $modelAttributes = [
    'user_id',
    'user_name',
    'user_ldap',
    'user_date',
  ];

  function __construct() {

    $this->rules = [
      'user_name'     => ['required', 'min:3', 'max:50'],
      'user_password' => ['required', 'min:3', 'max:50'],
      'firstname'     => 'nullable|max:50',
      'lastname'      => 'nullable|max:50',
      'user_email'    => 'nullable|email',
      'language'      => [new Uppercase()],
      'ip'            => ['max:50'],
      'plan'          => 'nullable|numeric|max:50',
    ];
  }

  /**
   *
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function attributes() {
    return [
      'user_name'     => ['name', 'user_name', 'username', 'login', 'user'],
      'user_password' => ['pass', 'password', 'user_password', 'user_pass'],
      'firstname'     => ['firstname', 'givenname', 'first_name', 'user_firstname', 'user_givenname', 'user_first_name', 'user_given_name'],
      'lastname'      => ['lastname', 'sn', 'user_lastname', 'user_sn', 'user_last_name'],
      'user_email'    => ['mail', 'email', 'user_email', 'user_mail'],
      'language'      => ['language', 'lang'],
      'ip'
    ];
  }

  /**
   * Create User Item
   * @return array
   * @throws \App\Base\Exceptions\InternalErrorException
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process() {
    $user = new User();

//    (new LdapService())->buildUserEntry($this);
    $attributes = $this->modelAttributes;

    foreach ($attributes as $attribute) {
      if ($this->{$attribute}) {
        $user->{$attribute} = $this->{$attribute};
      }
    }

    if (!$user->save()) {
      $this->errorInternal();
    }

    return $user->toArray();
  }

}
