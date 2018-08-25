<?php

namespace App\Modules\News\Requests;

use App\Base\Request;
use App\Modules\News\Models\News;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class ViewNewsRequest extends Request
{
    public function __construct()
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
      'news_id'          => ['news_id', 'id'],
      'news_title'       => ['max:200'],
      'news_description' => ['max:500'],
      'news_content'     => ['max:5000'],
      'news_author'      => ['max:200'],
      'news_language'    => ['language', 'news_language', 'lang'],
    ];
    }

    /**
     * Get News Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        return News::pagination($this)->toArray();
    }
}
