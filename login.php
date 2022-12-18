<?php 
    include_once "_partials/header.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ) 
    {
        $username = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $remember = intval($_POST['rememberMe']);

        $login = $auth->login( $username, $password, $remember);

        if ($login['error']) {
            //Something went wrong, display error message
            flash()->error( $login['message'] );
        } 
        else {
            flash()->success($login['message']);
            redirect('/');            
        }
    }
?>
    <div class="container">
        <form method="post" action="" class="box box-auth">
            <h2 class="box-auth-heading">
                Login
            </h2>

            <input type="text" value="<?= $_POST['username'] ?: '' ?>" class="form-control my-3" name="email" placeholder="Email Address" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <label class="checkbox">
                <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe" checked>
                Remember me!
            </label>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>

            <p class="alt-action text-center">
                or <a href="<?= BASE_URL ?>/register">create account</a>
            </p>
        </form>
    </div>

<?php include_once "_partials/footer.php" ?>
