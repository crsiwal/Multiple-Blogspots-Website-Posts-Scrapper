<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('/', function ($routes) {
	$routes->get('', 'Blogs::index');
	$routes->get('login', 'Auth::login');
	$routes->get('logout', 'Auth::logout');
});

$routes->group('redirect', function ($routes) {
	$routes->get('google', 'Auth::google');
});

$routes->group('blogs', function ($routes) {
	$routes->get('', 'Blogs::index');
	$routes->get('new', 'Blogs::preview');
	$routes->post('new', 'Blogs::preview');
	$routes->post('add', 'Blogs::addBlog');
});

$routes->group('posts', function ($routes) {
	$routes->get('blog/(:num)', 'Posts::blogPost/$1');
	$routes->get('draft', 'Posts::statusPosts/2');
	$routes->get('rejected', 'Posts::statusPosts/3');
	$routes->get('scheduled', 'Posts::statusPosts/4');
	$routes->get('created', 'Posts::statusPosts/5');
	$routes->get('single/(:num)', 'Posts::singlePost/$1');
	$routes->get('reject/(:num)', 'Posts::rejectPost/$1');
	$routes->get('edit/(:num)', 'Posts::editPost/$1');
	$routes->post('schedule', 'Posts::schedulePost');
});

$routes->group('blogspot', function ($routes) {
	$routes->get('', 'Blogspot::index');
});

$routes->cli('tools/crawler', 'BlogsTool::crawler');
