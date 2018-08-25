<?php

namespace App\Modules\Users\Requests;

use App\Base\Request;
use App\Modules\Users\Models\User;

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
      'user_name' => ['required'],
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
      'user_name' => ['user', 'name', 'user_name', 'username', 'login', 'id', 'user_id', 'uid'],
    ];
    }

    /**
     * Delete News Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $news = User::where('user_name', $this->user_name)->orWhere('user_id', $this->user_name)->first();

        return $news->delete();
    }
}
