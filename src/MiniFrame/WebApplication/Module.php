<?php

namespace MiniFrame\WebApplication;

use MiniFrame\Di\IDi;
use Symfony\Component\HttpFoundation\Response;

abstract class Module
{
    /**
     * @var IDi
     */
    protected $dependencyInjection;

    /**
     * @param IDi $dependencyInjection
     */
    public function __construct(IDi $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    /**
     * Modül, Application sınıfında ilk yüklenirken çağrılır.
     */
    public function init()
    {
    }

    /**
     * @return IDi
     */
    public function getDi()
    {
        return $this->dependencyInjection;
    }

    /**
     * @param $controllerClass
     * @param string $requestMethod
     * @param array $params
     * @return mixed|void
     */
    public function dispatch($controllerClass, $requestMethod = 'get', array $params = array())
    {
        /**
         * @var Controller $controller
         */
        $controller = new $controllerClass($this->getDi());

        /**
         * @var Response $response
         */
        $response = $controller->preDispatch();
        if (!$response instanceof Response) {
            $response = call_user_func_array(array($controller, $requestMethod), $params);

            $postDispatchResponse = $controller->postDispatch();
            if ($postDispatchResponse instanceof Response) {
                $response = $postDispatchResponse;
            }

            if (!$response instanceof Response) {
                $response = $this->getDi()->getHttpResponse();
            }
        }

        $response->send();
    }


    public function registerErrorHandlers()
    {
        set_error_handler(array($this, 'errorHandler'));
        set_exception_handler(array($this, 'handleException'));
        register_shutdown_function(array($this, 'fatalErrorHandler'));
    }

    /**
     * Bir hata oluştuğunda bu metod tetiklenir.
     *
     * @param $errNo
     * @param $errStr
     * @param $errFile
     * @param $errLine
     * @throws \ErrorException
     */
    public function errorHandler($errNo, $errStr, $errFile, $errLine)
    {
        throw new \ErrorException($errStr, $errNo, 0, $errFile, $errLine);
    }

    /**
     * Ölümcül bir hata oluştuğunda bu metod tetiklenir.
     *
     * @return mixed
     */
    public function fatalErrorHandler()
    {
        $error = error_get_last();

        if ($error !== null) {
            $errNo = $error["type"];
            $errFile = $error["file"];
            $errLine = $error["line"];
            $errStr = $error["message"];

            $this->handleFatalError($errStr, $errNo, $errFile, $errLine);
        }
    }

    /**
     * @param \Exception $exception
     * @return mixed
     */
    abstract public function handleException(\Exception $exception);

    /**
     * @param $errStr
     * @param $errNo
     * @param $errFile
     * @param $errLine
     * @return mixed
     */
    abstract public function handleFatalError($errStr, $errNo, $errFile, $errLine);
}
