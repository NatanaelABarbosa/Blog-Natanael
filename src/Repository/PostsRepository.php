<?php

namespace Natanael\Blog\Repository;

use Natanael\Blog\Entity\Post;
use PDO;
use PDOException;

class PostsRepository 
{
    public function __construct(private PDO $pdo) {}

    public function allPosts(): array
    {
        $sqlQr = "SELECT * FROM posts";
        $stmt = $this->pdo->query($sqlQr);

        $fetch = $stmt->fetchAll();
        $list = [];

        foreach ($fetch as $data) {
            $list[] = $this->hydrate($data);
        }

        return $list;
    }

    public function searchPost(int $id): Post
    {
        $sqlQr = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->pdo->prepare($sqlQr);

        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        $stmt->execute();

        $postData = $stmt->fetch();

        return $this->hydrate($postData); 
    }
    
    private function hydrate(array $postData): Post
    {
        $post = new Post(
            $postData['id'],
            $postData['title'],
            $postData['summary'],
            $postData['content'],
        );

        if ($postData['image'] !== null) {
            $post->setImage($postData['image']);
        }

        return $post;
    }

    public function createPost(Post $post): bool 
    {
        $sqlQrImage1 = '';
        $sqlQrImage2 = '';

        if ($post->getImage() !== "") {
            $sqlQrImage1 = ', image';
            $sqlQrImage2 = ', :image';
        }

        $sqlQr = "INSERT INTO posts (title, summary, content$sqlQrImage1) 
                  VALUES (:title, :summary, :content$sqlQrImage2)";

        $this->pdo->beginTransaction();
            
        try {
            $stmt = $this->pdo->prepare($sqlQr);

            $stmt->bindValue(':title', $post->getTitle());
            $stmt->bindValue(':summary', $post->getSummary());
            $stmt->bindValue(':content', $post->getContent());

            if ($post->getImage() !== '') {
                $stmt->bindValue(':image', $post->getImage());
            }
            
            $stmt->execute();

            $this->pdo->commit();
            return true;
        }catch (PDOException $e) {
            echo $e->getMessage();
            $this->pdo->rollBack();
            return false;
        }
    }

    public function editPost(Post $post): bool
    {
        $sqlQrImage = '';

        if ($post->getImage() !== '') {
            $sqlQrImage = ", image = :image";
        }

        $sqlQr = "UPDATE posts
                  SET title = :title, summary = :summary, content = :content$sqlQrImage
                  WHERE id = :id";

        $this->pdo->beginTransaction();
            
        try {
            $stmt = $this->pdo->prepare($sqlQr);

            $stmt->bindValue(':title', $post->getTitle());
            $stmt->bindValue(':summary', $post->getSummary());
            $stmt->bindValue(':content', $post->getContent());

            if ($post->getImage() !== '') {
                $stmt->bindValue(':image', $post->getImage());
            }

            $stmt->bindValue(':id', $post->id);

            $stmt->execute();

            $this->pdo->commit();
            return true;
        }catch (PDOException $e) {
            echo $e->getMessage();
            $this->pdo->rollBack();
            return false;
        }
    }

    public function deletePost(int $id): bool
    {
        $sqlQr = "DELETE FROM posts WHERE id = :id";

        $this->pdo->beginTransaction();
            
        try {
            $stmt = $this->pdo->prepare($sqlQr);

            $stmt->bindValue(1, $id);

            $stmt->execute();

            $this->pdo->commit();
            return true;
        }catch (PDOException $e) {
            echo $e->getMessage();
            $this->pdo->rollBack();
            return false;
        }
    }
}