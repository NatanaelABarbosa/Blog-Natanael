<?php

namespace Natanael\Blog\Controllers;

use League\Plates\Engine;
use Natanael\Blog\Repository\PostsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerLoginForm implements RequestHandlerInterface
{
    public function __construct(private Engine $template) 
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (array_key_exists('logado', $_SESSION) && $_SESSION['logado'] === true) {
            return new Response(200, [
                'Location' => '/'
            ]);
        }
        
        return new Response(body: $this->template->render('login'));
    }
}