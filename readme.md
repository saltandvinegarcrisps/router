Simple url matcher.

	$routes = new Routing\RouteCollection([
		'/' => function() {
			echo 'Hi';
		},
	]);

	$routes->merge([
		'/:id' => function() use($router) {
			echo $router->getParams()['id'];
		},
	]);

	$router = new Routing\UriMatcher;

	$uri = $_SERVER['REQUEST_URI'];
	$route = $router->match($uri);

	$route($router->getParams());
