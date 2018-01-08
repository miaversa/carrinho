<?php
use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', Miaversa\CartController::class . ':index');
$app->post('/{pid}', Miaversa\CartController::class . ':add');
