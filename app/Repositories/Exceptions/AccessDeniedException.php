<?php
namespace App\Repositories\Exceptions;

use Exception;

class AccessDeniedException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message, 0, null);
    }
}