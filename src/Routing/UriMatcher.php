<?php

namespace Routing;

class UriMatcher {

	protected $routes;

	protected $params;

	public function __construct(array $routes = [], array $params = []) {
		$this->routes = $routes;
		$this->params = $params;
	}

	public function getParams() {
		return $this->params;
	}

	public function setParams(array $values, array $keys = []) {
		// if keys match values set combined array
		$this->params = count($keys) == count($values) ? array_combine($keys, $values) : $values;
	}

	protected function replaceTokens(& $pattern) {
		$tokens = [];

		if(preg_match_all('#:([a-z0-9]+)#', $pattern, $matches)) {
			$tokens = $matches[1];
			$pattern = str_replace($matches[0], '([^/]+)', $pattern);
		}

		return $tokens;
	}

	public function matchString($path) {
		if(array_key_exists($path, $this->routes)) {
			return $this->routes[$path];
		}

		return false;
	}

	public function matchPattern($path) {
		foreach($this->routes as $pattern => $route) {
			$tokens = $this->replaceTokens($pattern);

			if(preg_match('#^'.$pattern.'$#', $path, $matches)) {
				$this->setParams(array_slice($matches, 1), $tokens);

				return $route;
			}
		}

		return false;
	}

	public function match($path) {
		if($route = $this->matchString($path)) {
			return $route;
		}

		if($route = $this->matchPattern($path)) {
			return $route;
		}

		return false;
	}

}
