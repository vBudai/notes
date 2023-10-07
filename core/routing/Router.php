<?php

namespace routing;

use controllers\MainController;
use controllers\SearchController;
use Exception;
use ReflectionException;
use ReflectionMethod;

class Router
{

    private static array $routes = [];
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws ReflectionException
     */
    public function getContent(): string
    {
        $execRoute = null;
        foreach (self::$routes as $route)
            if($route->getRequestMethod() == $this->request->getRequestMethod() && preg_match($route->getMask(), $this->request->getPath()) ){
                $execRoute = $route;
                break;
            }

        if($execRoute){
            if ($execRoute->getControllerName() && $execRoute->getControllerAction()){
                // Получение названия контроллера и его метода
                $controllerName = $execRoute->getControllerName();
                $controllerAction = $execRoute->getControllerAction();
                $controller = new $controllerName;

                //Параметры для контроллера из url
                $params = [];
                $paramsToController = [];
                preg_match_all($execRoute->getMask(), $this->request->getPath(),$params);
                foreach ($execRoute->getParams() as $key => $param){
                    $paramsToController[$param] = $params[$key+1][0];
                }

                if(method_exists($controller, $controllerAction))
                    return $controller->$controllerAction($this->request, $paramsToController);

                return "Метод ".$controllerAction." не найден";
            }
            else return "Контроллер не найден";
        }

        return "Маршрут не найден";
    }

    public static function addRoute(Route $route): void
    {
        self::$routes[] = $route;
    }

}