<?php 

namespace Tuiter\Db;

use Tuiter\Models\User;

interface UserRepositoryInterface
{
    /**
     * Busca um usuário por id 
     *
     * @param mixed $id
     * @return \Tuiter\Models\User
     */
    public function getById($id);

     /**
      * Busca um usuário por email
      *
      * @param string $email
      * @return \Tuiter\Models\User
      */
    public function getByEmail(string $email);

    /**
     * Cria ou atualiza um usuário
     *
     * @param \Tuiter\Models\User $user
     * @return void
     */
    public function save(User $user);

    /**
     * Busca um usuário pelo usarname
     *
     * @param string $username
     * @return \Tuiter\Models\User
     */
    public function getByUsername(string $username);

    /**
     * Deleta um usuário
     *
     * @param User $user
     * @return void
     */
    public function delete(User $user);

    /**
     * Busca todos os usuários
     *
     * @return \Tuiter\Models\User[]]
     */
    public function getAll();
}
