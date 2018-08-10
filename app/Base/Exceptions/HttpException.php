<?php

namespace App\Base\Exceptions;

/**
 * Class HttpException
 *
 * @package App\Exceptions
 *
 */
class HttpException extends BaseException
{
    /**
     * @var string
     */
    protected $status = 500;
    protected $title = 'Problem Occurred';
    protected $detail = null;
    protected $trace = null;

    /**
     * BadRequestException constructor.
     *
     * @param string  $title
     * @param integer $status
     * @param string  $detail
     * @param string  $trace
     */
    public function __construct($title = null, $status = 500, $detail = null, $trace = null)
    {
        $this->title = $title ?: $this->title;
        $this->status = $status;
        $this->detail = $detail ?: $this->detail;
        $this->trace = $trace ?: $trace;

        parent::__construct($this->detail);
    }
}
