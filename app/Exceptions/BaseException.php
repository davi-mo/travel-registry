<?php

namespace App\Exceptions;

use Illuminate\Http\Response;
use Throwable;

class BaseException extends \DomainException
{
    /** @var int */
    protected int $httpStatusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

    /** @var string */
    protected string $title = 'Something went wrong';

    /** @var string */
    private $detail;

    /**
     * BaseException constructor.
     *
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = "",
        Throwable $previous = null
    ) {
        parent::__construct($message, $this->httpStatusCode, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @param int $httpStatusCode
     */
    public function setHttpStatusCode(int $httpStatusCode): void
    {
        $this->httpStatusCode = $httpStatusCode;
    }

    /**
     * @return string
     */
    public function getDetail(): string
    {
        return $this->detail;
    }

    /**
     * @param string $detail
     */
    public function setDetail(string $detail): void
    {
        $this->detail = $detail;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
