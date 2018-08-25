<?php

namespace App\Modules\News\Models;

use App\Models\AppModel;

class News extends AppModel
{
    protected $table = 'news';

    protected $primaryKey = 'news_id';
    public $perPage = 5;
    public $orderBy = 'news_date';
    public $order = 'desc';

    protected $attributes = [
    'news_id',
    'news_title',
    'news_description',
    'news_content',
    'news_date',
    'news_author',
    'news_language'
  ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->attributes['news_date'] = time();
            return true;
        });
    }
}
