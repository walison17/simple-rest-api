<?php 

namespace Tuiter\Db;

use Tuiter\Models\User;

class StatusRepository extends BaseRepository
{
    public function getAll()
    {  
    }

    public function getByUserId(int $userId, $eagerLoad = false)
    {
    }   
}