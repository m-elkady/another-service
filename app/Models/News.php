<?php

namespace App\Models;

class News extends AppModel
{
  protected $table = 'news';

  protected $primaryKey = 'news_id';
  public $perPage = 5;
  public $orderBy = 'news_date';
  public $order = 'desc';

  /**
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function setNewsDateAttribute()
  {
    $this->attributes['news_date'] = time();
  }

  protected $attributes = [
    'news_id',
    'news_title',
    'news_description',
    'news_content',
    'news_author',
    'news_date',
    'news_language'
  ];

}