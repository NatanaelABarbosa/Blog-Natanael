<?php

namespace Natanael\Blog\Helper;

trait FlashMessage 
{
    public function flashMessage(string $message): void
    {
        $_SESSION['flash_message'] = "Erro: " . strtolower(trim($message));
    }
}