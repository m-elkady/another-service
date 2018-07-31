<?php

namespace App\Base\Exceptions;

/**
 * Class NoContentException
 *
 * @package App\Exceptions
 *
 */
class NoContentException extends BaseException
{
    /**
     * @var string
     */
    protected $status = '204';
    protected $title = 'No content available';
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
