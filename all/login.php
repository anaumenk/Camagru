<?php
$_SESSION['user'] = '';
site_top();
?>
    <div id="shade"></div>
    <div id="error"><button onclick="clear_error_add_picture();">Get it</button></div>
    <div id="entering">

    <form id="login_form" method="post">
        <a href="/login_signup"><img class="close_form" src="../img/page/close.png"></a>
        <input id="log_login" type="text" name="log_login" placeholder="Enter your login" required>
        <input id="log_password" type="password" name="log_password" placeholder="Enter your password" required>
        <a href="/recover">Forget your password?</a>
        <input type="submit" name="log_submit" value="OK" style="width: 15%;">
    </form>
    </div>
<?php
site_bottom();

if (isset($_POST['log_submit'])) {
    $login = $_POST['log_login'];
    $password = $_POST['log_password'];
    $connect = new Db;
    $sql = $connect->row( "SELECT * FROM users WHERE user_name='$login'");
    if ($sql != NULL) {
        foreach ($sql as $data) {
            if ($data['password'] == hash("whirlpool", $password) && $data['activate'] == '1') {
                $_SESSION['user'] = $login;
                header("Location: /profile");
            }
            else {
                echo "<script> open_error('The incorrect password or non activated acc.'); </script>";
            }

        }
    } else {
        echo "<script> open_error('The incorrect login.'); </script>";
    }
}

