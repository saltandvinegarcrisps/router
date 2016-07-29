<?php

namespace Routing;

class UriMatcher
{
    protected $routes;

    protected $params;

    public function __construct(CollectionInterface $routes = null, array $params = [])
    {
        $this->routes = null === $routes ? new RouteCollection : $routes;
        $this->setParams($params);
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams(array $values, array $keys = [])
    {
        // if keys match values set combined array
        $this->params = count($keys) == count($values) ? array_combine($keys, $values) : $values;
    }

    protected function replaceTokens(& $pattern)
    {
        $tokens = [];

        if (preg_match_all('#:([a-z0-9]+)#', $pattern, $matches)) {
            $tokens = $matches[1];
            $pattern = str_replace($matches[0], '([^/]+)', $pattern);
        }

        return $tokens;
    }

    protected function testPath($path)
    {
        if (false === $this->routes->has($path)) {
            return false;
        }

        $route = $this->routes->route($path);

        if (false === is_string($route)) {
            return false;
        }

        return strpos($route, '/') === 0;
    }

    protected function resolveAliases($path)
    {
        while ($this->testPath($path)) {
            $path = $this->routes->route($path);
        }

        return $path;
    }

    public function matchString($path)
    {
        return $this->routes->has($path) ? $this->routes->route($path) : false;
    }

    public function matchPattern($path)
    {
        foreach ($this->routes as $pattern => $route) {
            $tokens = $this->replaceTokens($pattern);

            if (preg_match('#^'.$pattern.'$#', $path, $matches)) {
                $this->setParams(array_slice($matches, 1), $tokens);

                return $route;
            }
        }

        return false;
    }

    public function match($path)
    {
        $path = $this->resolveAliases($path);

        if ($route = $this->matchString($path)) {
            return $route;
        }

        if ($route = $this->matchPattern($path)) {
            return $route;
        }

        return false;
    }
}
