<?php

namespace App\Models;

class News extends AppModel
{
  protected $table = 'news';

  protected $primaryKey = 'news_id';

  public function setNewsDateAttribute()
  {
    $this->attributes['news_date'] = time();
  }

  protected $attributes = ['news_id', 'news_language'];

}