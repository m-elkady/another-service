<?php

namespace App\Modules\News\Requests;

use App\Base\Request;
use App\Models\News;
use App\Rules\Uppercase;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class ViewNewsRequest extends Request
{
  function __construct()
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
      'news_id' => ['news_id', 'id'],
      'news_language' => ['language', 'news_language', 'lang'],
    ];
  }

  /**
   * Get News Item
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {

    $perPage = $this->perPage ? intval($this->perPage) : 20;
    $orderBy = $this->orderBy ? $this->orderBy : 'news_date';
    $order = $this->order ? $this->order : 'desc';
    $news = new News();
    $news->setPerPage($perPage);

    $attributes = $news->getAttributes();
    foreach ($attributes as $attribute) {
      if ($this->{$attribute}) {
        $news = $news->where($attribute, $this->{$attribute});
      }
    }
    $news = $news->orderBy($orderBy, $order);
    $result = $news->paginate()->appends($this->getAttributes());
    return $result->toArray();
  }


}