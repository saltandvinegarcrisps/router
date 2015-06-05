<?php

namespace Routing;

class UriMatcher {

	protected $routes;

	protected $params;

	public function __construct(array $routes) {
		$this->routes = $routes;
		$this->params = [];
	}

	public function getParams() {
		return $this->params;
	}

	public function match($path) {
		if(array_key_exists($path, $this->routes)) {
			return $this->routes[$path];
		}

		foreach($this->routes as $pattern => $route) {
			$tokens = [];

			if(preg_match_all('#:([a-z]+)#', $pattern, $matches)) {
				$tokens = $matches[1];
				$pattern = str_replace($matches[0], '([^/]+)', $pattern);
			}

			if(preg_match('#^'.$pattern.'$#', $path, $matches)) {
				$values = array_slice($matches, 1);

				$this->params = count($tokens) == count($values) ? array_combine($tokens, $values) : $values;

				return $route;
			}
		}

		return false;
	}

}
