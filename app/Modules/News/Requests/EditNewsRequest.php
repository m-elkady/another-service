<?php

namespace App\Modules\News\Requests;

use App\Base\Request;
use App\Modules\News\Models\News;
use App\Rules\Uppercase;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class EditNewsRequest extends Request
{

  function __construct()
  {
    $this->rules = [
      'news_id' => ['required', 'numeric'],
      'news_title' => ['max:200'],
      'news_description' => ['max:500'],
      'news_content' => ['max:5000'],
      'news_author' => ['max:200'],
      'news_language' => ['min:2', 'max:2', new Uppercase()],
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
      'news_id' => ['news_id', 'id'],
      'news_title' => ['title', 'news_title'],
      'news_description' => ['description', 'news_description'],
      'news_content' => ['content', 'news_content'],
      'news_author' => ['author', 'news_author'],
      'news_language' => ['language', 'news_language', 'lang'],
    ];
  }

  /**
   * Create News Item
   * @return array
   * @throws \App\Base\Exceptions\InternalErrorException
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function process()
  {
    $news = News::findOrFail($this->news_id);
    $attributes = $this->getAttributes();
    unset($attributes['news_id']);

    foreach ($attributes as $attribute => $value) {
      if(isset($value)){
        $news->{$attribute} = $value;
      }
    }
    if (!$news->update()) {
      $this->errorInternal();
    }

    return $news->toArray();
  }


}