<?php

namespace App\Modules\Grants\Controllers;

use App\Modules\Grants\Requests\DeleteGrantRequest;
use App\Modules\Grants\Requests\EditGrantRequest;
use App\Modules\Grants\Requests\ViewGrantRequest;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Modules\Grants\Requests\AddGrantRequest;

class GrantsController extends Controller
{

  /** @var Request $request */
    protected $request;

    /**
     * GrantsController constructor.
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
        $request = new ViewGrantRequest();
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
        $request = new AddGrantRequest();
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
        $request = new EditGrantRequest();
        return $request->load($data)->validate()->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function view()
    {
        $data = $this->request->all();
        $request = new ViewGrantRequest();
        return $request->load($data)->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function delete()
    {
        $data = $this->request->all();
        $request = new DeleteGrantRequest();
        $response = $request->load($data)->validate()->process();
        return response(['response' => $response]);
    }
}
