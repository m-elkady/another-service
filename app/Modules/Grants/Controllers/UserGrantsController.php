<?php

namespace App\Modules\Grants\Controllers;

use App\Modules\Grants\Requests\User\DeleteUserGrantRequest;
use App\Modules\Grants\Requests\User\ViewUserGrantRequest;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Modules\Grants\Requests\User\AddUserGrantRequest;

class UserGrantsController extends Controller
{

  /** @var Request $request */
    protected $request;

    /**
     * UserGrantsController constructor.
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
        $request = new ViewUserGrantRequest();
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
        $request = new AddUserGrantRequest();
        return $request->load($data)->validate()->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function view()
    {
        $data = $this->request->all();
        $request = new ViewUserGrantRequest();
        return $request->load($data)->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function delete()
    {
        $data = $this->request->all();
        $request = new DeleteUserGrantRequest();
        $response = $request->load($data)->validate()->process();
        return response(['response' => $response]);
    }
}
