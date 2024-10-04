<?php

use Natanael\Blog\Controllers\ControllerContent;
use Natanael\Blog\Controllers\ControllerCreate;
use Natanael\Blog\Controllers\ControllerDelete;
use Natanael\Blog\Controllers\ControllerEdit;
use Natanael\Blog\Controllers\ControllerEditForm;
use Natanael\Blog\Controllers\ControllerLogin;
use Natanael\Blog\Controllers\ControllerLoginForm;
use Natanael\Blog\Controllers\ControllerLogout;
use Natanael\Blog\Controllers\ControllerPost;

return [
    'GET|/' => ControllerPost::class,
    'POST|/' => ControllerCreate::class,
    'GET|/editar' => ControllerEditForm::class,
    'POST|/editar' => ControllerEdit::class,
    'GET|/content' => ControllerContent::class,
    'GET|/excluir' => ControllerDelete::class,
    'GET|/login' => ControllerLoginForm::class,
    'POST|/login' => ControllerLogin::class,
    'GET|/logout' => ControllerLogout::class,
];