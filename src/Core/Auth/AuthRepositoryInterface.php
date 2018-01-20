<?php

namespace Tuiter\Core\Auth;

interface AuthRepositoryInterface
{
    /**
     * Busca um usuário a partir de seu identificador
     *
     * @param mixed $id
     * @return \Tuiter\Core\Auth\Authenticatable|null
     */
    public function getById($id);

    /**
     * Busca um usuário pelo email  
     *
     * @param string $email
     * @return \Tuiter\Core\Auth\Authenticatable|null
     */
    public function getByEmail(string $email);
}