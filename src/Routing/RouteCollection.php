<?php

namespace Routing;

class RouteCollection implements CollectionInterface {

	protected $routes;

	public function __construct(array $routes = []) {
		$this->set($routes);
	}

	public function getIterator() {
		return new \ArrayIterator($this->routes);
	}

	public function get() {
		return $this->routes;
	}

	public function set(array $routes) {
		$this->routes = $routes;

		return $this;
	}

	public function merge(array $routes) {
		$this->set(array_merge($this->routes, $routes));

		return $this;
	}

	public function has($path) {
		return array_key_exists($path, $this->routes);
	}

	public function route($path) {
		return $this->routes[$path];
	}

}
