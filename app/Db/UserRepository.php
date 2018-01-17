<?php 

namespace Tuiter\Db;

use Tuiter\Models\User;
use Tuiter\Core\Auth\AuthRepositoryInterface as AuthRepository;

class UserRepository extends BaseRepository implements AuthRepository
{
    public function getById($id)
    {
        $query = "SELECT * FROM users WHERE id = :id";

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
    }

    public function has(User $user)
    {
        return ! is_null($this->getById($user->getId()));
    }

    private function mapRowToObject(array $row)
    {
        return (new User)
            ->setId($row['id'])
            ->setEmail($row['email'])
            ->setPassword($row['password'])
            ->setUsername($row['username']);
    }
}