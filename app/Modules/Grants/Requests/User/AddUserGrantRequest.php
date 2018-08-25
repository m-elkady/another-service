<?php

namespace App\Modules\Grants\Requests\User;

use App\Base\Request;
use App\Modules\Grants\Models\Grant;
use App\Modules\Users\Models\User;
use Illuminate\Support\Facades\DB;
use Hoa\Math\Combinatorics\Combination\CartesianProduct;

/**
 * Class AddUserGrantRequest
 * @package App\Modules\Grants\Requests\User
 * @author Mohammed Elkady <m.elkady365@gmail.com>
 */
class AddUserGrantRequest extends Request
{
    public function __construct()
    {
        $this->rules = [
            'grant_id' => ['required', 'min:1', 'max:30'],
            'user_id' => ['required', 'min:1', 'max:30'],
          ];
        $this->sanitize = [
            'grant_id' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}'],
            'user_id' => ['preg_split:/\s*(,|;|\s)\s*/:{{ VALUE }}']
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
            'grant_id' => ['grant_name', 'grant', 'grant_id', 'kid', 'grant_names', 'grants', 'grant_ids', 'kids'],
            'user_id' => ['user_name', 'username', 'login', 'user', 'user_names', 'usernames', 'logins', 'users', 'user_id', 'uid', 'user_ids', 'uids'],
          ];
    }

    /**
     * Create Grant User Item
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function process()
    {
        $this->setAttributes($this->sanitize($this->getAttributes()));
        $grant = new Group();
        $user = new User();
        $user = $user->select('user_id');
        $grant = $grant->select('grant_id');
        if ($this->grant_id) {
            $grantNames = is_array($this->grant_id) ? $this->grant_id : [$this->grant_id];
            $grant = $grant->where(function ($query) use ($grantNames) {
                foreach ($grantNames as $name) {
                    if (is_numeric($name)) {
                        $query = $query->orWhere('grant_id', $name);
                    } else {
                        $query = $query->orWhere('grant_name', 'LIKE', "%$name%");
                    }
                }
            });
        }
        $grant = $grant->get()->toArray();
        if ($this->user_id) {
            $userNames = is_array($this->user_id) ? $this->user_id : [$this->user_id];
            $user = $user->where(function ($query) use ($userNames) {
                foreach ($userNames as $name) {
                    if (is_numeric($name)) {
                        $query = $query->orWhere('user_id', $name);
                    } else {
                        $query = $query->orWhere('user_name', 'LIKE', "%$name%");
                    }
                }
            });
        }

        $user = $user->get()->toArray();
        $userGrant = DB::table('user_grant');
        $product = new CartesianProduct(collect($user)->flatten()->all(), collect($grant)->flatten()->all());
        $inserts = [];
        foreach ($product as $i => $tuple) {
            $inserts[] = ['user_id' => $tuple[0], 'grant_id' => $tuple[1]];
        }

        if (!$userGrant->insert($inserts)) {
            $this->errorInternal();
        }

        return ['response' => 'OK'];
    }
}
