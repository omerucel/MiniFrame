<?php

$classLoader = include(realpath(__DIR__ . '/../') . '/vendor/autoload.php');
$diImpl = new \MiniFrame\Di\DiImpl();
$diImpl->set('class_loader', $classLoader);

/**
 * Configs
 */
$diImpl->set('configs', function () use ($environment) {
    return new \Zend\Config\Config(include(realpath(__DIR__) . '/env/' . $environment . '.php'), true);
}, true);

/**
 * Logger
 */
$diImpl->set('logger', function () use ($diImpl) {
    $configs = $diImpl->get('configs');
    $logFile = $configs->logger->path . '/' . $configs->logger->name . '-' . date('Y-m-d') . '.log';
    $monolog = new \Monolog\Logger($configs->logger->name);
    $fileStream = new \Monolog\Handler\StreamHandler($logFile, $configs->logger->level, true, 0666);
    $lineFormatter = new \MiniFrame\Logger\MonologLineFormatter(
        $configs->logger->line_format,
        $configs->logger->datetime_format
    );
    $lineFormatter->setReqId($configs->req_id);
    $fileStream->setFormatter($lineFormatter);
    $monolog->pushHandler($fileStream);
    return $monolog;
}, true);

/**
 * ErrorCatcher
 */
$diImpl->set('error_catcher', function () use ($diImpl) {
    $errorCatcher = new \MiniFrame\ErrorCatcher();
    $exceptionHandler = new \MiniFrame\ExceptionCallbackHandler($diImpl->get('logger'));
    $fatalErrorHandler = new \MiniFrame\FatalErrorCallbackHandler($diImpl->get('logger'));
    $errorCatcher->setExceptionCallback([$exceptionHandler, 'handle']);
    $errorCatcher->setFatalCallback([$fatalErrorHandler, 'handle']);
    return $errorCatcher;
}, true);

/**
 * Http Dispatcher, Request & Response
 */
$diImpl->set('dispatcher', function () use ($diImpl) {
    return new \MiniFrame\WebApplication\Dispatcher($diImpl);
}, true);

$diImpl->set('http_request', function () {
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
}, true);

$diImpl->set('http_response', function () {
    return new \Symfony\Component\HttpFoundation\Response();
}, true);

/**
 * Twig
 */
$diImpl->set('twig', function () use ($diImpl) {
    $configs = $diImpl->get('configs');
    $loader = new Twig_Loader_Filesystem($configs->twig->templates_path);
    return new Twig_Environment($loader, $configs->twig->toArray());
}, true);

/**
 * Swift Mailer
 */
$diImpl->set('swiftmailer', function () use ($diImpl) {
    $configs = $diImpl->get('configs')->swiftmailer;
    $transport = Swift_SmtpTransport::newInstance($configs->host, $configs->port)
        ->setUsername($configs->username)
        ->setPassword($configs->password);
    return Swift_Mailer::newInstance($transport);
});

/**
 * PDO
 */
$diImpl->set('pdo', function () use ($diImpl) {
    $config = $diImpl->get('configs');
    $pdo = new PDO($config->pdo->dsn, $config->pdo->username, $config->pdo->password);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $pdo;
}, true);

return $diImpl;