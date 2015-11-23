Simple url matcher.

	$routes = new Routing\RouteCollection([
		'/' => function() {
			echo 'Hi';
		},
	]);

	$routes->merge([
		'/:id' => function($params) {
			echo $params['id'];
		},
	]);

	$router = new Routing\UriMatcher($routes);

	$uri = $_SERVER['REQUEST_URI'];
	$route = $router->match($uri);

	$route($router->getParams());
