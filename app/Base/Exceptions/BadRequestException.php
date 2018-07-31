<?php

namespace App\Base\Exceptions;

/**
 * Class BadRequestException
 *
 * @package App\Exceptions
 *
 */
class BadRequestException extends BaseException
{
    /**
     * @var string
     */
    protected $status = '400';
    protected $title = 'Bad Request';
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
