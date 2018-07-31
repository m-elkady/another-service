<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Uppercase implements Rule
{
  /**
   * @param string $attribute
   * @param mixed $value
   * @return bool
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function passes($attribute, $value)
  {
    return !empty($value) ? strtoupper($value) === $value : true;
  }

  /**
   * @return \Illuminate\Contracts\Translation\Translator|string
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function message()
  {
    return 'The :attribute must be uppercase.';
  }

}