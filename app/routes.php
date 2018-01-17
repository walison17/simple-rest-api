<?php

$app->group('/api', function () {
    $this->group('/users', function () {
        $this->post('', 'registration.controller:register');
        $this->get('', 'users.controller:index');
    });
});
