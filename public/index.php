<?php

if (PHP_SAPI == 'cli-server') {
	$url  = parse_url($_SERVER['REQUEST_URI']);
	$file = __DIR__ . $url['path'];
	if (is_file($file)) {
		return false;
	}
}

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../config/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __DIR__ . '/../config/dependencies.php';

// Register middleware
require __DIR__ . '/../config/middleware.php';

// Register routes
require __DIR__ . '/../config/routes.php';

// Run app
$app->run();
