<?php

namespace Tuiter\Models;

use JsonSerializable;
use Tuiter\Core\Auth\Authenticatable;

class User extends BaseModel implements Authenticatable, JsonSerializable
{
    private $username;
    private $email;
    private $password;

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

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'emai' => $this->email, 
            'username' => $this->username,
        ];
    }
}