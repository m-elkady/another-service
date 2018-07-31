<?php

namespace App\Base;


abstract class Request
{
  use Failable;
  public $thisAttributes = [];
  public $rules = [];
  public $messages = [];

  abstract public function attributes();

  /**
   * @param array $data
   *
   * @return $this
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function load(array $data)
  {
    $attributes = (array)$this->attributes();

    foreach ($attributes as $attribute => $body) {
      if (isset($data[$attribute])) {
        $this->thisAttributes[$attribute] = $data[$attribute];
      } elseif (is_array($body) && !empty($body)) {
        $this->thisAttributes[$attribute] = null;
        foreach ($body as $field) {
          if (isset($data[$field])) {
            $this->thisAttributes[$attribute] = $data[$field];
            break;
          }
        }
      } elseif (is_numeric($attribute)) {
        if (isset($data[$body]))
          $this->thisAttributes[$body] = $data[$body];
        else
          $this->thisAttributes[$body] = null;
      } else {
        $this->thisAttributes[$attribute] = null;
      }
    }

    return $this;
  }

  /**
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function getAttributes()
  {
    return (array)$this->thisAttributes;
  }

  /**
   * @param array $attributes
   * @return $this
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function setAttributes(array $attributes)
  {
    foreach ($attributes as $attribute => $value) {
      $this->setAttribute($attribute, $value);
    }

    return $this;
  }

  /**
   * @param string $attribute
   * @param $value
   * @return $this
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function setAttribute(string $attribute, $value)
  {
    if (in_array($attribute, $this->attributes())) {
      $this->thisAttributes[$attribute] = $value;
    }

    return $this;
  }

  /**
   * @param string $attribute
   * @return mixed|null
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function getAttribute(string $attribute)
  {
    $value = $this->thisAttributes[$attribute] ? $this->thisAttributes[$attribute] : null;

    return $value;
  }

  /**
   * @return array
   */
  public function messages()
  {
    return $this->messages;
  }

  /**
   * @param string $property
   * @return mixed
   * @throws \ReflectionException
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function __get($property)
  {
    $method = 'get' . ucfirst($property);
    if (method_exists($this, $method)) {
      $reflection = new \ReflectionMethod($this, $method);
      if (!$reflection->isPublic()) {
        throw new \RuntimeException("The called method is not public");
      }
    }

    if (in_array($property, $this->getAttributes())) {
      return $this->thisAttributes[$property];
    } elseif (in_array($property, array_keys($this->getAttributes()))) {
      return $this->thisAttributes[$property];
    }
  }

  /**
   * @param $property
   * @param $value
   * @return $this
   * @throws \ReflectionException
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function __set($property, $value)
  {
    $method = 'set' . ucfirst($property);
    if (method_exists($this, $method)) {
      $reflection = new \ReflectionMethod($this, $method);
      if (!$reflection->isPublic()) {
        throw new \RuntimeException("The called method is not public");
      }
    }

    if (in_array($property, $this->attributes())) {
      $this->thisAttributes[$property] = $value;
    }

    return $this;
  }

  public function validate()
  {
    //skip validation if rules are empty
    if (empty($this->rules)) {
      return $this;
    }

    $data = $this->getAttributes();
    // Make a new validator object
    $validator = validator($data, $this->rules, $this->messages());
    // Check for failure
    if ($validator->fails()) {
      $this->errorPreConditionFailed($validator->errors());
    }

    return $this;
  }


}