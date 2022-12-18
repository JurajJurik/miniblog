<?php

// require stuff
require_once 'vendor/autoload.php';

// /*show all errors, nastavenie zobrazenia chyb, na programatorske ucely, pri nasadeni na zivy server sa to zmaze alebo prepne do off/0*/
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
//error_reporting(-1);
error_reporting(E_ALL &~E_NOTICE);

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// constants & settings

define ('BASE_URL', 'http://localhost/miniblog');
define ('APP_PATH', realpath(__DIR__ . '/../'));


//-------GLOBAL CONFIG
$config = [
    'db' => [
        'type' =>       'mysql',
        'server' =>     'localhost',
        'name' =>       'miniblog',
        'username' =>   'root',
        'password' =>   'root',
        'charset' =>    'utf8'
    ]
];

$db = new PDO("{$config['db']['type']}:host={$config['db']['server']};dbname={$config['db']['name']};charset={$config['db']['charset']}", $config['db']['username'], $config['db']['password']);

$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );


try {
    $query = $db -> query("select * from tags");
} 
catch ( PDOException $e) {
    $error  = date('j M Y, G:i ') . PHP_EOL;
    $error .= '----------------------------' . PHP_EOL;
    $error .= $e->getMessage() . ' in ['. __FILE__ .' : '. __LINE__ .']' . PHP_EOL . PHP_EOL;

    file_put_contents(APP_PATH . '/_inc/error.log', $error.PHP_EOL, FILE_APPEND);
}

// require functions
require_once 'functions-general.php';
require_once 'functions-string.php';
require_once 'functions-post.php';
require_once 'functions-auth.php';

// sessions start + flash messages

if( !session_id()) @session_start();

//@ pred funkciou v php znamená, že aj keď nasledujúci príkaz vypíše error, tak ho nezobrazí.

use \Tamtamchik\SimpleFlash\Flash;

//napojenie PHPAuth

require_once ("vendor/phpauth/phpauth/Config.php");
require_once ("vendor/phpauth/phpauth/Auth.php");

$auth_config = new PHPAuth\Config($db);
$auth   = new PHPAuth\Auth($db, $auth_config);