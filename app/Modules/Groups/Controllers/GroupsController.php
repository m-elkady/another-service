<?php

namespace App\Modules\Groups\Controllers;

use App\Modules\Groups\Requests\DeleteGroupRequest;
use App\Modules\Groups\Requests\EditGroupRequest;
use App\Modules\Groups\Requests\ViewGroupRequest;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Modules\Groups\Requests\AddGroupRequest;


class GroupsController extends Controller
{

  /** @var Request $request */
  protected $request;

  /**
   * GroupsController constructor.
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
    $request = new ViewGroupRequest();
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
    $request = new AddGroupRequest();
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
    $request = new EditGroupRequest();
    return $request->load($data)->validate()->process();
  }

  /**
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function view()
  {
    $data = $this->request->all();
    $request = new ViewGroupRequest();
    return $request->load($data)->process();
  }

  /**
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function delete()
  {
    $data = $this->request->all();
    $request = new DeleteGroupRequest();
    $response = $request->load($data)->validate()->process();
    return response(['response' => $response]);
  }


}