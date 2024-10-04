<?php

namespace Natanael\Blog\Controllers;

use League\Plates\Engine;
use Natanael\Blog\Repository\PostsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerPost implements RequestHandlerInterface
{
    public function __construct(private Engine $template, private PostsRepository $repository) 
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $postList = $this->repository->allPosts();

        return new Response(body: $this->template->render('post', [
            'postList' => $postList
        ]));
    }
}