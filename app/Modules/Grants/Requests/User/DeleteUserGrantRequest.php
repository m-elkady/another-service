<?php

namespace App\Modules\Grants\Requests\User;

use App\Base\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DeleteUserGrantRequest
 * @package App\Modules\Grants\Requests\User
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class DeleteUserGrantRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
            'grant_name' => 'required',
            'user_name' => 'required',
          ];
        $this->sanitize = [
            'grant_name' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}'],
            'user_name' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}']
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
            'perPage',
            'orderBy',
            'order',
            'grant_name' => ['grant_name', 'grant', 'grant_id', 'kid', 'grant_names', 'grants', 'grant_ids', 'kids'],
            'user_name' => ['user_name', 'username', 'login', 'user', 'user_names', 'usernames', 'logins', 'users', 'user_id', 'uid', 'user_ids', 'uids'],
          ];
    }

    /**
     * Get G Item
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $this->setAttributes($this->sanitize($this->getAttributes()));

        $userGrant = DB::table('user_grant');
        $userGrant
        ->join('users', 'users.user_id', '=', 'user_grant.user_id')
        ->join('grants', 'grants.grant_id', '=', 'user_grant.grant_id');

        if ($this->user_name) {
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

        return $userGrant->delete();
    }
}
