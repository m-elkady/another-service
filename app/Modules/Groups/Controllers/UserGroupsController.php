<?php

namespace App\Modules\Groups\Controllers;

use App\Modules\Groups\Requests\User\DeleteUserGroupRequest;
use App\Modules\Groups\Requests\User\ViewUserGroupRequest;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Modules\Groups\Requests\User\AddUserGroupRequest;

class UserGroupsController extends Controller
{

  /** @var Request $request */
    protected $request;

    /**
     * UserGroupsController constructor.
     * @param Request $request
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function index()
    {
        $data = $this->request->all();
        $request = new ViewUserGroupRequest();
        return $request->load($data)->process();
    }

    /**
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function add()
    {
        $data = $this->request->all();
        $request = new AddUserGroupRequest();
        return $request->load($data)->validate()->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function view()
    {
        $data = $this->request->all();
        $request = new ViewUserGroupRequest();
        return $request->load($data)->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function delete()
    {
        $data = $this->request->all();
        $request = new DeleteUserGroupRequest();
        $response = $request->load($data)->validate()->process();
        return response(['response' => $response]);
    }
}
