<?php
$_SESSION['user'] = '';
site_top();
?>
<div id="shade"></div>
<div id="error"><button onclick="clear_error_add_picture();">Get it</button></div>
<div id="entering">

    <form id="recover" method="post">
        <a href="/login"><img class="close_form" src="../img/page/close.png"></a>

        <input type="text" name="r-login" placeholder="Enter your login" required>
        <input type="email" name="r-email" placeholder="Enter your e-mail" required>

        <input type="submit" name="recover" value="Recover" style="width: 15%;">
    </form>
</div>
<?php
site_bottom();
if (isset($_POST['recover'])) {
    $login = $_POST['r-login'];
    $email = $_POST['r-email'];
    $connect = new Db;
    $sql = $connect->row( "SELECT * FROM users WHERE user_name='$login'");
    if ($sql != NULL) {
        foreach ($sql as $data) {
            if ($data['email'] == $email && $data['activate'] == '1') {
                $new_password = time();
                $message = "<p>Hello, $login!</p><p>Your new password on Camagru is <b>".$new_password."</b>.</p>";
                $pass = hash('whirlpool', $new_password);
                $connect->query( "UPDATE users SET `password` = '$pass' WHERE `user_name` = '$login'");
                $subject = "Camagru";
                $subject_preferences = array(
                    "input-charset" => "utf-8",
                    "output-charset" => "utf-8",
                    "line-length" => 76,
                    "line-break-chars" => "\r\n"
                );
                $header = "Content-type: text/html; charset='utf-8'. \r\n";
                $header .= "From: Camagru <camagru@unit.ua> \r\n";
                $header .= "MIME-Version: 1.0 \r\n";
                $header .= "Content-Transfer-Encoding: 8bit \r\n";
                $header .= "Date: ".date("r (T)")." \r\n";
                $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);
                mail("$email", "$subject", "$message", $header);
                header("Location: /login");
            }
            else {
                echo "<script>open_error('The incorrect email or non activated acc.'); </script>";
            }

        }
    } else {
        echo "<script> open_error('The incorrect login.'); </script>";
    }
}
