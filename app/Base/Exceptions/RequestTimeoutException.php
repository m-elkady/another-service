<?php

namespace App\Base\Exceptions;

/**
 * Class RequestTimeoutException
 *
 * @package App\Exceptions
 *
 */
class RequestTimeoutException extends BaseException
{
    /**
     * @var string
     */
    protected $status = '408';
    protected $title = 'Request timed out';
    protected $detail = '';

    /**
     * BadRequestException constructor.
     *
     * @param string $detail
     * @param string $title
     */
    public function __construct($detail, $title = '')
    {
        $this->detail = $detail ?: $this->detail;
        $this->title = $title ?: $this->title;

        parent::__construct($this->detail);
    }
}
