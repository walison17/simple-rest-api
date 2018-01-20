<?php

$app->group('/api', function () {
    $this->post('/signin', 'AuthController:signIn');
    $this->get('/user', 'AuthController:getUserDetails');

    $this->post('/users', 'UsersController:new');
    $this->get('/users', 'UsersController:index');
    $this->get('/users/{user}', 'UsersController:show');
    $this->delete('/users/{user}', 'UsersController:destroy');

    // $this->get('/statuses', 'StatusController:index');
    // $this->post('/statuses', 'StatusController:new');
    // $this->get('/statuses/{status}', 'StatusController:show');
    // $this->delete('/statuses/{status}', 'StatusController:destroy');
});
