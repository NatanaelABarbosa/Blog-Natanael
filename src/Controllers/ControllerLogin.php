<?php

namespace Natanael\Blog\Controllers;

use League\Plates\Engine;
use Natanael\Blog\Helper\FlashMessage;
use Natanael\Blog\Repository\UsersRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerLogin implements RequestHandlerInterface
{
    use FlashMessage;

    public function __construct(private Engine $template, private UsersRepository $repository) 
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();

        $email = filter_var($body['email']);
        $password = filter_var($body['password']);

        $user = $this->repository->searchUser($email);

        $correctPassword = password_verify($password, $user['password']);

        if (!$correctPassword) {
            $this->flashMessage('e-mail ou senha incorretos');
            return new Response(302, [
                'Location' => '/login'
            ]);
        }

        if (password_needs_rehash($user['password'], PASSWORD_ARGON2ID)) {
            $this->repository->updatePassword($user['email'], $user['password']);
        } 

        $_SESSION['logado'] = true;
        return new Response(302, [
            'Location' => '/'
        ]);
    }
}