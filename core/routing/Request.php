<?php

namespace routing;


class Request
{

    private string $path;
    private array $data = [];
    private array $files;
    private string $requestMethod;


    public function __construct()
    {
        $url = $_SERVER['REQUEST_URI'];
        $this->files = $_FILES ?? [];

        $this->path = parse_url($url)['path'];
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];

        switch ($this->requestMethod){
            case 'GET':
                $this->data = $_GET;
                break;
            case 'POST':
                $this->data = $_POST;
                break;
            case ('PUT' && $_SERVER['CONTENT_TYPE'] === 'application/x-www-form-urlencoded'):
                $serverData = file_get_contents('php://input');
                parse_str($serverData, $this->data);
                break;
            case 'DELETE':
                $this->data = [];
                break;
            default:
                die('Wrong request method');
        }
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

}