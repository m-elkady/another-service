<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BooleanRule implements Rule {

  /**
   * @param string $attribute
   * @param mixed $value
   * @return bool
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function passes($attribute, $value) {
    return in_array($value, ['1', '0', 'yes', 'no', 'true', 'false']);
  }

  /**
   * @return \Illuminate\Contracts\Translation\Translator|string
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function message() {
    return 'The :attribute must be one of these values: ' . implode(',', ['1', '0', 'yes', 'no', 'true', 'false']);
  }

}
