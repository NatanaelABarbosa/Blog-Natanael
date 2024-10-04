<?php 

namespace Natanael\Blog\Controllers;

use finfo;
use League\Plates\Engine;
use Natanael\Blog\Entity\Post;
use Natanael\Blog\Helper\FlashMessage;
use Natanael\Blog\Repository\PostsRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ControllerCreate implements RequestHandlerInterface
{
    use FlashMessage;

    public function __construct(private Engine $template, private PostsRepository $repository) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();
        
        $title = filter_var($body['title']);
        if ($title === false || $title === null || $title === "") {
            $this->flashMessage('o post necessita de um título');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $summary = filter_var($body['summary']);
        if ($summary === false || $summary === null || $summary === "") {
            $this->flashMessage('o post necessita de um resumo');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $content = filter_var($body['content']);
        if ($content === false || $content === null || $content === "") {    
            $this->flashMessage('o post necessita de um conteúdo');
            return new Response(302, [
                'Location' => '/'
            ]);
        }

        $post = new Post(
           null,
           $title,
           $summary,
           $content 
        );

        $files = $request->getUploadedFiles();
        /** @var UploadedFileInterface $uploadedImage */
        $uploadedImage = $files['image'];

        if ($uploadedImage->getError() === UPLOAD_ERR_OK) {
            $tmpName = $uploadedImage->getStream()->getMetadata('uri');
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($tmpName);

            if (str_starts_with($mimeType, 'image/')) {
                $safeFileName = uniqid('upload_') . '_' . basename($uploadedImage->getClientFilename());
                $uploadedImage->moveTo(__DIR__ . '/../../public/img/' . $safeFileName);
                $post->setImage($safeFileName);
            }
        }

        if ($this->repository->createPost($post)) {
            return new Response(302, [
                'location' => '/'
            ]);
        } else {
            $this->flashMessage('não foi possível postar');
            return new Response(302, [
                'location' => '/'
            ]);
        }
    }
}