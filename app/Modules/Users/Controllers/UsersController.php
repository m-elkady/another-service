<?php

namespace App\Modules\Users\Controllers;

use App\Modules\Users\Requests\DeleteUserRequest;
use App\Modules\Users\Requests\EditUserRequest;
use App\Modules\Users\Requests\ViewUserRequest;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Modules\Users\Requests\AddUserRequest;
use App\Modules\Users\Requests\BcomputeUserRequest;

class UsersController extends Controller
{

  /** @var Request $request */
    protected $request;

    /**
     * UsersController constructor.
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
        $request = new ViewUserRequest();
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
        $request = new AddUserRequest();
        return $request->load($data)->validate()->process();
    }

    /**
     * @return array
     * @throws \App\Base\Exceptions\InternalErrorException
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function edit()
    {
        $data = $this->request->all();
        $request = new EditUserRequest();
        return $request->load($data)->validate()->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function view()
    {
        $data = $this->request->all();
        $request = new ViewUserRequest();
        return $request->load($data)->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function delete()
    {
        $data = $this->request->all();
        $request = new DeleteUserRequest();
        $response = $request->load($data)->validate()->process();
        return response(['response' => $response]);
    }

    /**
     * @return void
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function bcompute()
    {
        $data = $this->request->all();
        $request = new BcomputeUserRequest();
        return $request->load($data)->validate()->process();
    }
}
