<?php
declare(strict_types=1);

namespace Miaversa;

use Interop\Container\ContainerInterface;

final class CartController
{
	private $db;
	private $renderer;

	public function __construct(ContainerInterface $container)
	{
		$this->renderer = $container->get('renderer');
	}

	public function index($request, $response, $args)
	{
		$_SESSION['h'] = rand();
		$_SESSION['han'] = 1;
		$this->renderer->render($response, 'cart.index.php', []);
	}

	public function add($request, $response, $args)
	{
	}
}