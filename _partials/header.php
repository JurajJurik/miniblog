<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= isset($page_title) ? "$page_title /" : '' ?>This is a Miniblog</title>
    <link rel="stylesheet" href="<?= asset('/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('/css/main.css') ?>">
    <link rel="icon" href="data:,">

    <script>
        var baseURL = '<?php BASE_URL ?>';
    </script>

</head>
<body class="<?= segment(1) ? segment(1) : 'home' ?>">
    
    <header class="container">
        <?= flash()->display() ?>

        <?php if ( logged_in() ) : $logged_in = get_user() ?>
            <div class="navigation btn-group btn-group-xs">
                <a href="<?= BASE_URL ?>" class="btn btn-default"> all posts </a>
                <a href="<?= BASE_URL ?>/user/<?= $logged_in->uid ?>" class="btn btn-default"> my posts </a>
                <a href="<?= BASE_URL ?>/post/new" class="btn btn-default"> add new </a>
            </div>
            <div class="navigation btn-group btn-group-xs">
                <span class="username small"> <?= plain( $logged_in->email ) ?> </span>
                <a href="<?= BASE_URL ?>/logout" class="btn btn-default logout"> logout </a>
            </div>
        <?php endif ?>
        


    
       <?php if(isset($_SESSION['message']) && !empty($_SESSION['message'])) : ?>

            <div class="alert alert-warning container" role="alert">
                <p><?php echo $_SESSION['message']; ?>
                </p>
            </div>

        <?php unset($_SESSION['message']); endif ?>
        

    </header>

