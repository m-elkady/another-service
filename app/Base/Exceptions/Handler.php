<?php

namespace App\Base\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as LumenExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//use App\Base\Loggers\AppLogger;

/**
 * Class Handler
 *
 * The handler which overrides the lumen's exception handler in order to
 * integrate the Restful exceptions
 *
 * @package App\Core\Base\Exceptions
 *
 */
class Handler extends LumenExceptionHandler
{
  // Exceptions that will not be logged
  protected $dontReport = [
    NotFoundException::class,
    UnprocessableEntityException::class,
    BadRequestException::class,
  ];

  /**
   * Convert the Exception into a JSON HTTP Response
   *
   * @param Request $request
   * @param Exception $e
   *
   * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
   */
  public function render($request, Exception $e)
  {
    if (env('APP_DEBUG')) {
      return parent::render($request, $e);
    }
    $appName = config('app.app_id', 'app');
    $debugMode = env('APP_DEBUG', false);

    // If debug is enabled, we are okay with sending back the views
    if ($debugMode && (php_sapi_name() !== 'cli')) {
      return $this->renderExceptionWithWhoops($e);
    }

    return $this->handle($request, $e);
  }

  /**
   * Render an exception using Whoops.
   *
   * @param  \Exception $e
   *
   * @return Response
   */
  protected function renderExceptionWithWhoops(Exception $e)
  {
    $statusCode = 500;
    if (method_exists($e, 'getStatusCode')) {
      $statusCode = $e->getStatusCode();
    }

    $headers = [];
    if (method_exists($e, 'getHeaders')) {
      $headers = $e->getHeaders();
    }

    $whoops = new Run;
    $whoops->pushHandler(new PrettyPageHandler());

    return new Response(
      $whoops->handleException($e),
      $statusCode,
      $headers
    );
  }

  /**
   * Handles the exceptions thrown in the system, checks if the exception
   * is one of the app exception (BaseException's Child) then return
   * the array with status and render if there is any other e.g. fatal or anythin
   *
   * @param            $request
   * @param \Exception $e
   *
   * @return Response|\Symfony\Component\HttpFoundation\Response
   */
  public function handle($request, Exception $e)
  {
    $data = [];
    $status = 500;

    if ($e instanceOf BaseException) {
      $data = $e->toArray();
      $status = $e->getStatus();
    } else if (method_exists($e, 'toArray') && method_exists($e, 'getStatus')) {
      $data = $e->toArray();
      $status = $e->getStatus();

      if (!isset($data['status']) || !isset($data['title']) || !isset($data['detail'])) {
        $data = [];
        $status = 500;
      }
    }

    // Handling any default HTTP exceptions
    if ($e instanceOf NotFoundHttpException) {
      $exception = new NotFoundException("Resource not found");
      $data = $exception->toArray();
      $status = $data['status'];
    }

    // Handling any default HTTP exceptions
    if ($e instanceOf MethodNotAllowedHttpException) {
      $requestedUrl = $request->method() . ' ' . $request->url();
      $exception = new HttpException('Method not allowed', 405, sprintf('Invalid request method. "%s"', $requestedUrl));
      $data = $exception->toArray();
      $status = $data['status'];
    }

    if ($e instanceof ValidationException) {
      parent::render($request, $e);
    }

    if (empty($data)) {
      $data = [
        'status' => 500,
        'title' => 'Uncaught Error',
        'detail' => $e->getMessage(),
        'type' => 'https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html',
      ];
    }

    // Include the trace in response iff
    //    - Environment allows it `APP.INCLUDE_EXCEPTION_TRACE`
    //    - It is an internal error
    //    - Exception has a trace string method

    $appName = config('app.app_id', 'app');
    if (
      env($appName . '.INCLUDE_EXCEPTION_TRACE', true) &&
      $data['status'] === 500 &&
      method_exists($e, 'getTraceAsString') &&
      empty($data['trace'])
    ) {
      $data['trace'] = $e->getTraceAsString();
    }

    /** @var \Laravel\Lumen\Http\ResponseFactory */
    return response()->json($data, $status, [
      'Content-Type' => 'application/problem+json',
    ]);
  }

  /**
   * @param Exception $e
   * @throws Exception
   * @author Mohammed Elkady <m.elkady365@gmail.com>
   */
  public function report(Exception $e)
  {
//        $request = app(Request::class);
//
//        $logger = new AppLogger($request);
//        $logger->logException($e);

    parent::report($e);
  }
}
