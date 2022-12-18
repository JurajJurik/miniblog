<?php require_once "_inc/config.php";

$routes = [

    //HOMEPAGE
    '/' => [
        'GET'   => 'home.php'
    ],

    //USER
    '/user' => [
        'GET'   => 'user.php'
    ],

    //LOGIN
    '/login' => [
        'GET'   =>  'login.php',
        'POST'  =>  'login.php',
    ],

    //REGISTER
    '/register' => [
        'GET'   =>  'register.php',
        'POST'  =>  'register.php',
    ],

    //LOGOUT
    '/logout' => [
        'GET'   =>  'logout.php',

    ],

    //POST
    '/post' => [
        'GET'   =>  'post.php',
        'POST'  =>  '_inc/post-add.php',
    ],

    //TAG
    '/tag' => [
        'GET'   => 'tag.php'
    ],

    //EDIT
    '/edit' => [
        'GET'   =>  'edit.php',
        'POST'  =>  '_inc/post-edit.php',
    ],

    //DELETE
    '/delete' => [
        'GET'   =>  'delete.php',
        'POST'  =>  '_inc/post-delete.php',
    ],
];

$page = segment(1);
$method = $_SERVER['REQUEST_METHOD'];

$public = [
    'login', 'register'
];

if ( ! logged_in() && !in_array( $page, $public)) {
    redirect('/login');
}

if (! isset($routes["/$page"][$method])) {
    show_404();
}

require $routes["/$page"][$method];

