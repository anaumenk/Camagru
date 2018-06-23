<?php
$connect = new Db;
site_top();
?>
<div id="shade"></div>
<div id="error"><button onclick="clear_error_add_picture();">Get it</button></div>

<div id="entering">
    <form method="post" id="signup_form">
        <a href="/login_signup"><img class="close_form" src="../img/page/close.png" ></a>
            <input id="user_name" type="text" name="login" placeholder="Enter your login" title="Only letters and/or numbers with a maximum 15 characters" required>
            <input id="email" type="email" name="email" placeholder="Enter your email" required>
            <input id="password" type="password" name="password" pattern="[A-Za-z0-9]{8,}" placeholder="Enter your password" title="Your password may contain 8 letters and/or numbers" required>
            <input id="rep_pass" type="password" name="rep_pass" placeholder="Repeat your password" required>

        <input type="submit" value="Register" name="submit" style="width: 15%;" >
    </form>

</div>
<?php
site_bottom();

if (isset($_POST['submit']))
{
    $login = $_POST['login'];
    $email = $_POST['email'];
    $pass = hash('whirlpool', $_POST['password']);
    $rep_pass = hash('whirlpool', $_POST['rep_pass']);
    $activation_code = hash('whirlpool', $email.time());
    if (preg_match('/[a-z0-9]{1,15}/', strtolower($login))) {
        $sql = $connect->row("SELECT * FROM users WHERE user_name='$login'");
        if (!$sql) {
            if (preg_match('/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/', strtolower($email) ))
            {
                if (preg_match('/[a-z0-9]{8,}/', strtolower($_POST['password']))) {
                    if ($pass == $rep_pass)
                    {
                        $connect->query( "INSERT INTO users (`user_name`, `email`, `password`, `activation_code`, `activate`, `comments`, `user_image`) VALUES ('$login', '$email', '$pass', '$activation_code', 0, 1, 'img/page/user_image.png')");
                        $message = "<p>Hello, $login!</p><p>You need to confirm your email address to complete your Camagru account.</p><p>It's easy — just click <a href='http://localhost:8080/?activation_code=$activation_code'>HERE</a>.</p>";
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
                        header("Location: /");
                    }
                    else {
                        echo "<script>open_error('The passwords not match')</script>";
                    }
                }
                else {
                    echo "<script>open_error('Your password may contain minimum 8 letters and/or numbers')</script>";
                }
            }
            else {
                echo "<script>open_error('Email field must be in email format');</script>";
            }
        }
        else {
            echo "<script>open_error('Such login already exists.');</script>";
        }
    }
    else {
        echo "<script>open_error('Only letters and/or numbers with a maximum 15 characters');</script>";
    }

}