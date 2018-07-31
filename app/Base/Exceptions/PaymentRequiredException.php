<?php

namespace App\Base\Exceptions;

/**
 * Class RequestTimeoutException
 *
 * @package App\Exceptions
 *
 */
class PaymentRequiredException extends BaseException
{
    /**
     * @var string
     */
    protected $status = '402';
    protected $title = 'Payment required';
    protected $detail = 'Payment is required to perform this action';

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
