Simple url matcher.

	$routes = [
		'/' => function() {
			echo 'Hi';
		},
		'/:id' => function($params) {
			echo $params['id'];
		},
	];

	$router = new Routing\UriMatcher($routes);

	$uri = $\_SERVER['REQUEST_URI'];
	$route = $router->match($uri);

	$route($router->getParams());
