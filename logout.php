<?php 

require_once '_inc/config.php';

// you are not logged in

if (! logged_in()) {
    redirect('/');
}

// log out

do_logout();

//flash it and go home
flash()->warning('Bye bye!');
redirect('/');
