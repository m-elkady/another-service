<?php

namespace App\Base;

use App\Base\Exceptions\BadRequestException;
use App\Base\Exceptions\ForbiddenException;
use App\Base\Exceptions\HttpException;
use App\Base\Exceptions\InternalErrorException;
use App\Base\Exceptions\NoContentException;
use App\Base\Exceptions\NotFoundException;
use App\Base\Exceptions\PaymentRequiredException;
use App\Base\Exceptions\PreconditionFailedException;
use App\Base\Exceptions\RequestTimeoutException;
use App\Base\Exceptions\UnauthorizedException;
use App\Base\Exceptions\UnprocessableEntityException;


/**
 * Class Failable
 *
 * Trait to be used on any class through which you want to throw exceptions. All you have to
 * do is use this trait and call the exception functions on that class.
 *
 */
trait Failable
{
  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param $title
   * @param $statusCode
   * @param $detail
   *
   * @throws \App\Base\Exceptions\HttpException
   */
  public function error($title = '', $statusCode = 500, $detail = null)
  {
    throw new HttpException($title, $statusCode, $detail);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param string $detail
   * @param        $title
   *
   * @throws \App\Base\Exceptions\NotFoundException
   */
  public function errorNotFound($detail = '', $title = '')
  {
    throw new NotFoundException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param        $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\BadRequestException
   */
  public function errorBadRequest($detail = '', $title = '')
  {
    throw new BadRequestException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param        $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\ForbiddenException
   */
  public function errorForbidden($detail = '', $title = '')
  {
    throw new ForbiddenException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param        $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\UnauthorizedException
   */
  public function errorUnauthorized($detail = '', $title = '')
  {
    throw new UnauthorizedException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param        $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\InternalErrorException
   */
  public function errorInternal($detail = '', $title = '')
  {
    throw new InternalErrorException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param string $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\NoContentException
   */
  public function errorNoContent($detail = '', $title = '')
  {
    throw new NoContentException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param string $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\BadRequestException
   */
  public function errorInvalidParameters($detail = '', $title = '')
  {
    throw new BadRequestException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param string $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\UnprocessableEntityException
   */
  public function errorUnprocessableEntity($detail = '', $title = '')
  {
    throw new UnprocessableEntityException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param string $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\BadRequestException
   */
  public function errorEmptyParameters($detail = '', $title = '')
  {
    throw new BadRequestException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param string $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\RequestTimeoutException
   */
  public function errorTimeout($detail = '', $title = '')
  {
    throw new RequestTimeoutException($detail, $title);
  }

  /**
   * The exception is automatically catched by the handler and JSON is returned
   *
   * @param string $detail
   * @param string $title
   *
   * @throws \App\Base\Exceptions\PaymentRequiredException
   */
  public function errorPaymentRequired($detail = '', $title = '')
  {
    throw new PaymentRequiredException($detail, $title);
  }

  public function errorPreConditionFailed($detail = '', $title = '')
  {
    throw new PreconditionFailedException($detail, $title);
  }
}
