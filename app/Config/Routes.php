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

	$routes->group('draft', function ($routes) {
		$routes->get('', 'Posts::statusPosts/2');
		$routes->get('(:any)', 'Posts::statusPosts/2/$1');
	});

	$routes->group('rejected', function ($routes) {
		$routes->get('', 'Posts::statusPosts/3');
		$routes->get('(:any)', 'Posts::statusPosts/3/$1');
	});

	$routes->group('scheduled', function ($routes) {
		$routes->get('', 'Posts::statusPosts/4');
		$routes->get('(:any)', 'Posts::statusPosts/4/$1');
	});

	$routes->group('created', function ($routes) {
		$routes->get('', 'Posts::statusPosts/5');
		$routes->get('(:any)', 'Posts::statusPosts/5/$1');
	});

	$routes->get('single/(:num)', 'Posts::singlePost/$1');
	$routes->get('reject/(:num)', 'Posts::rejectPost/$1');
	$routes->get('edit/(:num)', 'Posts::editPost/$1');
	$routes->post('schedule', 'Posts::schedulePost');
});

$routes->group('bloggers', function ($routes) {
	$routes->get('', 'Bloggers::index');
	$routes->get('labels/json', 'Bloggers::labels');
});

$routes->group('tools', function ($routes) {
	$routes->cli('scrapblogs', 'BlogsTool::crawler');
	$routes->cli('batchpost', 'PostingTool::post');
});

/* Create Routes only for development */
$routes->environment('development', static function ($routes) {
	$routes->get('builder', 'Tools\Builder::index');
});
