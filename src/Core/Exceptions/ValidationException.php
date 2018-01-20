<?php

namespace Tuiter\Core\Exceptions;

use Tuiter\Core\Validation\ErrorMessages;

class ValidationException extends \Exception
{
    /**
     * Mensagens de erro geradas pelo validator
     *
     * @var ErrorMessages
     */
    private $errors;

    protected $code = 400;

    public function __construct(ErrorMessages $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation exception', $this->code);
    }

    /**
     * Retorna os erros da validação
     *
     * @return \Tuiter\Core\Validation\ErrorMessages
     */
    public function getMessages()
    {
        return $this->errors;
    }
}