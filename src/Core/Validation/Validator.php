<?php 

namespace Tuiter\Core\Validation;

use Tuiter\Core\Validation\ErrorMessages;
use Respect\Validation\Exceptions\NestedValidationException;

class Validator
{
    private $errors = []; 

    /**
     * {@inheritDoc}
     *
     * @return void
     */
    public function validate(array $input, array $rules, array $customMessages = [])
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($input[$field] ?? null);
            } catch(NestedValidationException $e) {
                $e->findMessages($this->loadTranslations());
                $this->errors[$field] = $e->getMessages();
            }
        }

        return ! empty($this->errors);
    }

    /**
     * {@inheritDoc}
     *
     * @return bool 
     */
    public function fail()
    {
        return count($this->errors) > 0;
    }

    /**
     * {@inheritDoc}
     *
     * @return \Tuiter\Core\Validation\ErrorMessages
     */
    public function getMessages()
    {
        return new ErrorMessages($this->errors);
    }

    /**
     * Carrega as mensagens traduzidas 
     *
     * @return string[]
     */
    private function loadTranslations()
    {
        $translatedMessages = require __DIR__ . '/messages.php';

        return $translatedMessages;
    }   
}