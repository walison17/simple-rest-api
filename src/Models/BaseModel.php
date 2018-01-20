<?php 

namespace Tuiter\Models;

class BaseModel
{
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }
    
    public function equals(BaseModel $other)
    {
        return $this->id === $other->getId();
    }
}