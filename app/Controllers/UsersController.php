<?php 

namespace Tuiter\Controllers;

class UsersController extends BaseController
{
    public function index()
    {
        return json($this->container['user.repository']->getAll());
    }
}