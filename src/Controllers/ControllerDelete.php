<?php

namespace Natanael\Blog\Controllers;

use League\Plates\Engine;
use Natanael\Blog\Entity\Post;
use Natanael\Blog\Helper\FlashMessage;
use Natanael\Blog\Repository\PostsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerDelete implements RequestHandlerInterface
{
    use FlashMessage;

    public function __construct(private Engine $template, private PostsRepository $repository) 
    {

    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $id = filter_var($queryParams['id']);
        if ($id === false || $id === null) {
            $this->flashMessage('post inexistente');    
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $post = $this->repository->searchPost($id);
        $oldImage = $post->getImage();

        unlink(__DIR__ . '/../../public/img/' . $oldImage);
    
        if ($this->repository->deletePost($id)) {
            return new Response(302, [
                'Location' => '/'
            ]);
        } else {
            $this->flashMessage('erro ao excluir o post');
            return new Response(302, [
                'Location' => '/'
            ]);
        }
    }
}