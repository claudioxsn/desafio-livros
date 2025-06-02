<?php

namespace App\Exceptions;

use Exception;

class DatabaseException extends Exception
{
    public function __construct($message = "Erro no banco de dados")
    {
        parent::__construct($message);
    }
}
