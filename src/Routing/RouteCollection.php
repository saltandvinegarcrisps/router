<?php

namespace Routing;

class RouteCollection implements CollectionInterface {

	protected $keys = [];

	protected $values = [];

	public function __construct(array $routes = []) {
		$this->set($routes);
	}

	public function getIterator() {
		return new \ArrayIterator($this->get());
	}

	public function append($path, $route) {
		array_push($this->keys, $path);
		array_push($this->values, $route);

		return $this;
	}

	public function appends(array $routes) {
		foreach($routes as $key => $value) {
			$this->append($key, $value);
		}

		return $this;
	}

	public function prepend($path, $route) {
		array_unshift($this->keys, $path);
		array_unshift($this->values, $route);

		return $this;
	}

	public function prepends(array $routes) {
		foreach($routes as $key => $value) {
			$this->prepend($key, $value);
		}

		return $this;
	}

	public function get() {
		return array_combine($this->keys, $this->values);
	}

	public function set(array $routes) {
		$this->keys = array_keys($routes);
		$this->values = array_values($routes);

		return $this;
	}

	public function merge(array $routes) {
		return $this->appends($routes);
	}

	public function has($path) {
		return in_array($path, $this->keys, true);
	}

	public function route($path) {
		$index = array_search($path, $this->keys, true);

		return $this->values[$index];
	}

}
