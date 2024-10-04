<?php

namespace Natanael\Blog\Entity;

class Post
{
    public function __construct(
        public readonly ?int $id, 
        private string $title,
        private string $summary,
        private string $content,
        private string $image = ""
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSummary(): string 
    {
        return $this->summary;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getFormatedImage(): string
    {
        return 'img/' . $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }
}