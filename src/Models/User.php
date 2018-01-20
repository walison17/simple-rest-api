<?php

namespace Tuiter\Models;

use Tuiter\Core\Auth\Authenticatable;

class User extends BaseModel implements Authenticatable
{
    private $username;
    private $email;
    private $password;
    private $statuses;

    public function getPassword()
    {
        return $this->password;
    }    

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return self
     */ 
    public function setUsername(string $username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Set the value of password
     *
     * @return self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of statuses
     */ 
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Set the value of statuses
     *
     * @return self
     */ 
    public function setStatuses(array $statuses)
    {
        $this->statuses = $statuses;

        return $this;
    }
}