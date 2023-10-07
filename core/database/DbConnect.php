<?php

namespace database;

use PDO;
use PDOException;
use Symfony\Component\Dotenv\Dotenv;
use Exception;

class DbConnect
{
    protected readonly PDO $conn;

    public function __construct()
    {
        $dotenv = new Dotenv();

        // Считывание данных для подключения
        try{
            $dotenv->load($_SERVER['DOCUMENT_ROOT'] . '/.env');
        }
        catch (Exception $e){
            echo ".env loading error: " . $e->getMessage();
        }

        // Подключение к БД
        try{
            $this->conn = new PDO(
                "$_ENV[dbtype]:host=$_ENV[dbhost];
                dbname=$_ENV[dbname]",
                $_ENV['dbuser'],
                $_ENV['dbpassword']);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e){
            echo 'Database connecting error: ' . $e->getMessage();
        }
    }

    public function getConn(): PDO
    {
        return $this->conn;
    }
}