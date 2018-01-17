<?php

namespace Tuiter\Core\Validation;

interface ValidatorInterface
{
    /**
     * Executa a validação
     *
     * @param array $input
     * @param array $rules
     * @param array $messages
     * @return void
     */
    public function validate(array $input, array $rules, array $messages = []);

    /**
     * Retorna todas as mensagens de erros
     *
     * @return \Tuiter\Core\Validation\ErrorMessages
     */
    public function getMessages();

    /**
     * Verifica se a validação falhou
     *
     * @return bool
     */
    public function fail();
}