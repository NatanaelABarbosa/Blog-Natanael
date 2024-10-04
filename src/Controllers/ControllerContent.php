<?php

namespace Natanael\Blog\Controllers;

use League\Plates\Engine;
use Natanael\Blog\Helper\FlashMessage;
use Natanael\Blog\Repository\PostsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerContent implements RequestHandlerInterface
{
    use FlashMessage;
    public function __construct(private Engine $template, private PostsRepository $repository) 
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $id = filter_var($queryParams['id'], FILTER_VALIDATE_INT);
        if ($id === null || $id === false) {
            $this->flashMessage('Post inexistente');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $post = $this->repository->searchPost($id);

        return new Response(body: $this->template->render('content', [
            'post' => $post
        ]));
    }
}