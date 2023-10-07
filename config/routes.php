<?php


use controllers\NoteController;
use routing\Route;
use routing\Router;

// Вывод страницы
Router::addRoute(new Route(
    'GET',
    '/',
    NoteController::class,
    'index',
));


// Получение заметок
Router::addRoute(new Route(
    'GET',
    'api/v1/notes',
    NoteController::class,
    'getNotes',
));


// Создание заметки
Router::addRoute(new Route(
    'POST',
    'api/v1/note',
    NoteController::class,
    'createNote',
));

// Редактирование заметки
Router::addRoute(new Route(
    'PUT',
    'api/v1/note/{noteId}',
    NoteController::class,
    'editNote',
));

// Удаление заметки
Router::addRoute(new Route(
    'DELETE',
    'api/v1/note/{noteId}',
    NoteController::class,
    'deleteNote',
));

// Добавление фото
/*Router::addRoute(new Route(
    'POST',
    'api/v1/note/image',
    NoteController::class,
    'loadImage',
));*/

// Удаление фото
/*Router::addRoute(new Route(
    'DELETE',
    'api/v1/note/image/imageId',
    NoteController::class,
    'deleteImage',
));*/