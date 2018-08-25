<?php

namespace App\Modules\News\Requests;

use App\Base\Request;
use App\Modules\News\Models\News;

/**
 * Class AddNewsRequest
 * @package App\Modules\News\Requests
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class DeleteNewsRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
      'news_id' => ['required', 'numeric'],
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
      'news_id' => ['id', 'news_id'],
    ];
    }

    /**
     * Delete News Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $news = News::findOrFail($this->news_id);

        return $news->delete();
    }
}
