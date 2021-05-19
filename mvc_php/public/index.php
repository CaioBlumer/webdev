<html>
<title>Framework MVC- PHP 7.4 - 2020/2</title>
<body>

<?php

/**
 * Front Controller
 * PHP version 7.4
 *
 * author: Daveh.io
 * Modified: Vinicius Ramos
 */


/**
 * Composer
 */
require_once dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 *  Session Start
 */
session_start();


/**
 * Routing
 */
$roteador = new Core\Rotear();

// Adicionando as rotas
$roteador->add('', [
    'controller' => 'Home',
    'action' => 'index'
]);
$roteador->add('login', [
    'controller' => 'Login',
    'action' => 'index'
]);
$roteador->add('logout', [
    'controller' => 'Login',
    'action' => 'sair'
]);
$roteador->add('agenda', [
    'controller' => 'Agenda',
    'action' => 'index'
]);
$roteador->add('{controller}/{action}');
$roteador->add('{controller}/{id:\d+}/{action}');
$roteador->add('admin/{controller}/{action}', [
    'namespace' => 'Admin'
]);

$roteador->dispatch($_SERVER['QUERY_STRING']);


?>


</body>
</html>
