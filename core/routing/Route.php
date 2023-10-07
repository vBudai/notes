<?php

namespace routing;

final class Route
{

    private string $requestMethod;
    private string $route;
    private string $controllerName;
    private string $controllerAction;


    public function __construct(string $requestMethod, string $route, string $controllerName, string $controllerAction)
    {
        $this->requestMethod = $requestMethod;
        $this->route = $route;
        $this->controllerName = $controllerName;
        $this->controllerAction = $controllerAction;
    }

    public function getParams(): array
    {
        $params = [];
        preg_match_all('/{([a-z]\w*)}/',$this->route,$params);
        return $params[1];
    }

    public function getMask(): string
    {
        $params = $this->getParams();
        $route = preg_replace("/{[a-z]\w*}/","(\w*)", $this->route);

        return '~' . $route . '/?$~';
    }

    public function getRequestMethod(): string
    {
        return $this->requestMethod;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    public function getControllerAction(): string
    {
        return $this->controllerAction;
    }

}