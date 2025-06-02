<?php

namespace App\Exceptions;

use Exception;

class ModelNotFoundException extends Exception
{
    public function __construct($message = "Modelo não encontrado")
    {
        parent::__construct($message);
    }
}
