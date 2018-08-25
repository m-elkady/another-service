<?php

namespace App\Modules\Grants\Requests\User;

use App\Base\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ViewUserGrantRequest
 * @package App\Modules\Grants\Requests\User
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class ViewUserGrantRequest extends Request
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
            'grant_name' => ['grant', 'grant_name', 'grant_id', 'kid'],
            'user_name' => ['user_name', 'username', 'login', 'user', 'user_id', 'uid'],
          ];
    }

    /**
     * Get UserGrant Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        if (!$this->user_name && !$this->grant_name) {
            $this->errorPreConditionFailed('Missing conditional parameter');
        }

        $userGrant = DB::table('user_grant');
        
        $userName = $this->user_name;

        $userGrant
      ->join('users', 'users.user_id', '=', 'user_grant.user_id')
      ->join('grants', 'grants.grant_id', '=', 'user_grant.grant_id');
        if ($this->user_name) {
            $userGrant = $userGrant->select('grants.grant_id', 'grants.grant_name');
            $userNames = is_array($this->user_name) ? $this->user_name : [$this->user_name];

            $userGrant = $userGrant->where(function ($query) use ($userNames) {
                foreach ($userNames as $name) {
                    if (is_numeric($name)) {
                        $query = $query->orWhere('users.user_id', $name);
                    } else {
                        $query = $query->orWhere('users.user_name', 'LIKE', "%$name%");
                    }
                }
            });
        }

        if ($this->grant_name) {
            $userGrant = $userGrant->select('users.user_id', 'users.user_name');
            $grantNames = is_array($this->grant_name) ? $this->grant_name : [$this->grant_name];

            $userGrant = $userGrant->where(function ($query) use ($grantNames) {
                foreach ($grantNames as $name) {
                    if (is_numeric($name)) {
                        $query = $query->orWhere('grants.grant_id', $name);
                    } else {
                        $query = $query->orWhere('grants.grant_name', 'LIKE', "%$name%");
                    }
                }
            });
        }

        return $userGrant->get();
    }
}
