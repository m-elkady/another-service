<?php

namespace App\Modules\Registrations\Controllers;

use App\Modules\Registrations\Requests\DeleteRegistrationRequest;
use App\Modules\Registrations\Requests\ViewRegistrationRequest;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Modules\Registrations\Requests\AddRegistrationRequest;

class RegistrationsController extends Controller
{

  /** @var Request $request */
    protected $request;

    /**
     * NewsController constructor.
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
        $request = new ViewRegistrationRequest();
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
        $request = new AddRegistrationRequest();
        return $request->load($data)->validate()->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function view()
    {
        $data = $this->request->all();
        $request = new ViewRegistrationRequest();
        return $request->load($data)->process();
    }

    /**
     * @return array
     * @author Mohammed Elkady <m.elkady365@gmail.com>
     */
    public function delete()
    {
        $data = $this->request->all();
        $request = new DeleteRegistrationRequest();
        $response = $request->load($data)->validate()->process();
        return response(['response' => $response]);
    }
}
