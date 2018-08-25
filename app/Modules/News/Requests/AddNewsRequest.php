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
class AddNewsRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
      'news_title'       => ['required', 'max:200'],
      'news_description' => ['required', 'max:500'],
      'news_content'     => ['required', 'max:5000'],
      'news_author'      => ['required', 'max:200'],
      'news_language'    => ['required', 'min:2', 'max:2', new Uppercase()],
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
      'news_title'       => ['title', 'news_title'],
      'news_description' => ['description', 'news_description'],
      'news_content'     => ['content', 'news_content'],
      'news_author'      => ['author', 'news_author'],
      'news_language'    => ['language', 'news_language', 'lang'],
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
        $news = new News();
        $news->setRawAttributes($this->getAttributes());
        if (!$news->save()) {
            $this->errorInternal();
        }

        return $news->toArray();
    }
}
