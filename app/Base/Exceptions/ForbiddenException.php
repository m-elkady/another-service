<?php

namespace App\Base\Exceptions;

/**
 * Class ForbiddenException
 *
 * @package App\Exceptions
 *
 */
class ForbiddenException extends BaseException
{
    /**
     * @var string
     */
    protected $status = '403';
    protected $title = 'Forbidden Exception';
    protected $detail = '';

    /**
     * ForbiddenException constructor.
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
