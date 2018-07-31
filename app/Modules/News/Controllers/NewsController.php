<?php

namespace App\Modules\News\Controllers;

use App\Modules\News\Requests\DeleteNewsRequest;
use App\Modules\News\Requests\EditNewsRequest;
use App\Modules\News\Requests\ViewNewsRequest;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\Request;
use App\Modules\News\Requests\AddNewsRequest;


class NewsController extends Controller
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
    $request = new ViewNewsRequest();
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
    $request = new AddNewsRequest();
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
    $request = new EditNewsRequest();
    return $request->load($data)->validate()->process();
  }

  /**
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function view()
  {
    $data = $this->request->all();
    $request = new ViewNewsRequest();
    return $request->load($data)->process();
  }

  /**
   * @return array
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function delete()
  {
    $data = $this->request->all();
    $request = new DeleteNewsRequest();
    $response = $request->load($data)->validate()->process();
    return response(['response' => $response]);
  }


}