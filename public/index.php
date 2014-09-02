<?php

$environment = strtolower(getenv('APPLICATION_ENV'));

// Check app_env setting.
if (!$environment) {
    throw new \Exception('APPLICATION_ENV : empty');
}

/**
 * @var \MiniFrame\Di\Di $diImpl
 */
$diImpl = include(realpath(__DIR__ . '/../') . '/configs/bootstrap.php');
$diImpl->get('error_catcher')->register();
$diImpl->get('dispatcher')->dispatch(
    $diImpl->get('configs')->web_application->default_controller,
    $diImpl->get('configs')->web_application->routes->toArray()
);
