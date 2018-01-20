<?php 

namespace Tuiter\Db;

use Tuiter\Models\User;
use UserRepositoryAuthRepository;
use Tuiter\Db\UserRepositoryInterface;
use Tuiter\Core\Auth\AuthRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface, AuthRepositoryInterface
{
    public function getById($id)
    {
        $query = "SELECT * FROM users u WHERE u.id = :id";

        try {
            $sttm = $this->connection->prepare($query);
            $sttm->bindValue(':id', $id);
            $sttm->execute();
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        $row = $sttm->fetch(\PDO::FETCH_ASSOC);

        return $row ? $this->mapRowToObject($row) : null;
    }   
    
    public function getByEmail(string $email)
    {
        $query = 'SELECT * FROM users u WHERE u.email = :email';

        try {
            $sttm = $this->connection->prepare($query);
            $sttm->bindValue(':email', $email);
            $sttm->execute();

            $row = $sttm->fetch(\PDO::FETCH_ASSOC);
            return $row ? $this->mapRowToObject($row) : null;
        } catch (PDOException $ex) {
            throw new \Exception($ex->getMessage());
        }
    }

    public function getAll()
    {
        $query = 'SELECT * FROM users';

        try {
            $sttm = $this->connection->prepare($query);
            $sttm->execute();
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return array_map(function ($row) {
            return $this->mapRowToObject($row);
        }, $sttm->fetchAll());
    }

    public function save(User $user)
    {
        $this->has($user) ? $this->update($user) : $this->insert($user);
    }

    public function insert(User $user)
    {
        $query = "INSERT INTO users(id, email, username, password) 
            VALUES(:id, :email, :username, :password)";

        try {
            $sttm = $this->connection->prepare($query);
            $sttm->bindValue(':id', $user->getId());
            $sttm->bindValue(':email', $user->getEmail());
            $sttm->bindValue(':username', $user->getUsername());
            $sttm->bindValue(':password', $user->getPassword());

            $sttm->execute();
        } catch (PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        $user->setId($this->connection->lastInsertId());
    }

    public function has(User $user)
    {
        return ! is_null($this->getById($user->getId()));
    }

    public function getByUsername(string $username)
    {
        $query = 'SELECT * FROM users WHERE username = :username';

        try {
            $sttm = $this->connection->prepare($query);
            $sttm->bindValue(':username', $username);
            $sttm->execute();

            $row = $sttm->fetch(\PDO::FETCH_ASSOC);
            return $row ? $this->mapRowToObject($row) : null; 
        } catch (PDOException $ex) {
            throw new \Exception($ex->getMessage());
        }   
    }

    /**
     * Deleta um usuário
     *
     * @param User $user
     * @return \Tuiter\Models\User
     */
    public function delete(User $user)
    {
        $query = 'DELETE FROM users WHERE username = :username';

        try {
            $sttm = $this->connection->prepare($query);
            $sttm->bindValue(':username', $user->getUsername());
            $sttm->execute();
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    private function mapRowToObject(array $row)
    {
        return (new User)
            ->setId($row['id'])
            ->setEmail($row['email'])
            ->setUsername($row['username'])
            ->setPassword($row['password']);
    }
}