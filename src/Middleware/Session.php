<?php
declare(strict_types=1);

namespace Miaversa\Middleware;

final class Session
{
	private $settings;

	public function __construct()
	{
		$this->settings = array(
			'expires' => '20 minutes',
			'path' => '/',
			'domain' => null,
			'secure' => false,
			'httponly' => false,
			'name' => 'slim_session',
		);

		ini_set('session.use_cookies', '0');
		session_cache_limiter('nocache');
		session_set_save_handler(
			array($this, 'open'),
			array($this, 'close'),
			array($this, 'read'),
			array($this, 'write'),
			array($this, 'destroy'),
			array($this, 'gc')
		);
	}

	public function __invoke($request, $response, $next)
	{
		$this->loadSession($request);
		$response = $next($request, $response);
		$response = $this->saveSession($response);
		return $response;
	}

	protected function loadSession($request)
	{
		if (session_id() === '') {
			session_start();
		}

		$default = json_encode([]);
		$cookie = \Dflydev\FigCookies\FigRequestCookies::get($request, $this->settings['name'], $default);

		$value = json_decode($cookie->getValue(), true);
		$_SESSION = is_array($value) ? $value : array();
	}

	protected function saveSession($response)
	{
		$value = json_encode($_SESSION);
		$response = \Dflydev\FigCookies\FigResponseCookies::set($response, \Dflydev\FigCookies\SetCookie::create($this->settings['name'])->withValue($value));
		return $response;
	}

	public function open($savePath, $sessionName) {
		return true;
	}

	public function close() {
		return true;
	}

	public function read($id) {
		return '';
	}

	public function write($id, $data) {
		return true;
	}

	public function destroy($id) {
		return true;
	}

	public function gc($maxlifetime) {
		return true;
	}
}
