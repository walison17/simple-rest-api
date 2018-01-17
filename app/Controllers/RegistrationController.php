<?php 

namespace Tuiter\Controllers;

use Tuiter\Models\User;
use Tuiter\Core\Validation\Validator;
use Psr\Http\Message\RequestInterface;
use Respect\Validation\Validator as v;
use Psr\Http\Message\ResponseInterface;

class RegistrationController extends BaseController
{
    public function register(RequestInterface $request, ResponseInterface $response)
    {
        $validator = new Validator;

        $validator->validate($request->getParams(), [
            'email' => v::notOptional()->email(),
            'username' => v::notOptional()->noWhitespace(),
            'password' => v::notOptional()
        ]);

        if ($validator->fail()) {
            return json($validator->getMessages(), 400);
        }

        $user = new User;
        $user->setEmail(request('email'))
            ->setUsername(request('username'))
            ->setPassword(password_hash(request('password'), PASSWORD_BCRYPT));

        $this->container['user.repository']->save($user);
    }
}