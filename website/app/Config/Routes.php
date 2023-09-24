<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Blogs::index');
$routes->group('blogs', function ($routes) {
	$routes->get('', 'Blogs::index');
	$routes->get('new', 'Blogs::preview');
	$routes->post('new', 'Blogs::preview');
});
