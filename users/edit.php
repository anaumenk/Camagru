<?php
site_top();
$connect = new Db;
$login = $_SESSION['user'];
$login_sql = $connect->row( "SELECT * FROM users WHERE user_name='$login'");
foreach ($login_sql as $login_data) {
    $email = $login_data['email'];
    $user_img = "../$login_data[user_image]";
}
?>
<div id="shade"></div>
<div id="error"><button onclick="clear_error();">Get it</button></div>
<div id="entering">
    <form id="edit_profile" method="post">

        <a href="/"><img class="close_form" src="../img/page/close.png"></a>

        <div class="bigger">
            <div style="display: flex; align-items: center; width: 50%;">
                <div style="width: 50px; height: 50px; position: relative;">
                    <input type="file" id="new_user_image" name="new_user_image" style="position: absolute; top:0; bottom: 0; height: 100%; width: 100%; border-radius: 0; opacity: 0;">
                    <img id='user_image' src='<?php echo $user_img?>' style='border-radius: 50%; width: 100%; height: 100%;'>
                    <script>change_user_image_prev();</script>
                </div>
                <p style="margin-left: 10px;"><?php echo $login ?></p>
            </div>
            <div style="width: 50%; display: flex; justify-content: flex-end;">
                <button onclick="change_user_image(); return false;">Change user image</button>
            </div>
        </div>
        <div class="bigger">
            <div style="width: 50%;">
                <input class="log" type="text" name="login" placeholder="new login" title="Only letters and/or numbers with a maximum 15 characters">
            </div>
            <div style="width: 50%; display: flex; justify-content: flex-end;">
                <button name="change_login">Change login</button>
            </div>

        </div>

        <div class="bigger" style="flex-direction: column; align-items: flex-start;">
            <input class="log" type="password" placeholder="old password" name="old_pass" style="max-width: 250px;">
            <input class="log" type="password" placeholder="new password" name="new_pass" title="Your password may contain 8 letters and/or numbers" style="max-width: 250px;">
            <div style="width: 100%; display: flex;">
                <div style="width: 50%;">
                    <input class="log" type="password" placeholder="repeat new password" name="rep_pass">
                </div>
                <div style="width: 50%; display: flex; justify-content: flex-end;">
                    <button name="change_password">Change password</button>
                </div>
            </div>
        </div>

        <div class="bigger">
            <div style="width: 50%;">
                <input class="log" type="email" placeholder="new e-mail" name="email">
            </div>
            <div style="width: 50%; display: flex; justify-content: flex-end;">
                <button name="change_email">Change email</button>
            </div>

        </div>
        <div class="bigger">
            <div style="width: 50%; display: flex;">
                <label>Send me email when there is new comment.</label>
                <input class="log" type='checkbox' name="checkbox" style="width: auto; margin-left: 5px;"
                    <?php
                        $sql = $connect->row("SELECT comments FROM users WHERE user_name='$login'");
                        foreach ($sql as $data)
                        {
                            if ($data['comments'] == '1') {
                                echo "checked";
                            }
                        }
                    ?>
                >
            </div>
            <div style="width: 50%; display: flex; justify-content: flex-end;">
                <button name="change_checkbox">Change</button>
            </div>

        </div>
    </form>

</div>

<?php
if (isset($_POST['change_login'])) {
    if ($_POST['login'])
    {
        if (preg_match('/[a-z0-9]{1,15}/', strtolower($_POST['login']))) {
            $new_log = $_POST['login'];
            $sql = $connect->row("SELECT user_name FROM users WHERE user_name='$new_log'");
            if (!$sql) {

                $connect->query("UPDATE users SET `user_name` = '$new_log' WHERE `user_name` = '$login'");
                $message = "<p>Hello!</p><p>Your old login was <b>".$login."</b>.</p><p>Your new login is <b>".$new_log."</b>.</p>";
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
                $_SESSION['user'] = $new_log;
                echo "<meta http-equiv='refresh' content='0'>";
            }
            else {
                echo "<script>open_error('Such login already exists.');</script>";
            }
        }
        else {
            echo "<script>open_error('Only letters and/or numbers with a maximum 15 characters');</script>";
        }
    }
    else {
        echo "<script>open_error('Enter the new login to change it.');</script>";
    }
}
if (isset($_POST['change_password'])) {
    $new_pass = hash('whirlpool', $_POST['new_pass']);
    if ($_POST['new_pass'] && $_POST['rep_pass'] && $_POST['rep_pass']) {
        $sql = $connect->row("SELECT * FROM users WHERE user_name='$login'");
        if ($sql != NULL) {
            foreach ($sql as $data) {
                if ($data['password'] == hash("whirlpool", $_POST['old_pass'])) {
                    if (preg_match('/[a-z0-9]{8,}/', strtolower($_POST['new_pass']))) {
                        if ($_POST['new_pass'] == $_POST['rep_pass']) {
                            $connect->query("UPDATE users SET `password` = '$new_pass' WHERE `user_name` = '$login'");
                            $message = "<p>Hello, $login!</p><p>You have changed your password.</p>";
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
                        }
                        else {
                            echo "<script>open_error('The new and repeated new passwords do not match.');</script>";
                        }
                    }
                    else {
                        echo "<script>open_error('Your password may contain minimum 8 letters and/or numbers');</script>";
                    }
                }
                else {
                    echo "<script>open_error('The incorrect old password.');</script>";
                }
            }
        }
    }
    else {
        echo "<script>open_error('Enter the old password, the new password and repeat the new password to change it.');</script>";
    }
}
if (isset($_POST['change_email'])) {
    $new_email = $_POST['email'];
    if ($new_email){
        if (preg_match('/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$/', strtolower($new_email) ))
        {
            $connect->query("UPDATE users SET `email` = '$new_email' WHERE `user_name` = '$login'");
            $message = "<p>Hello, $login!</p><p>You have changed your email address.</p><p>The new one is <b>".$new_email."</b></p>";
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
            $email = $new_email;
            $message = "<p>Hello, $login!</p><p>You have changed your email address.</p>";
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
        }
        else {
            echo "<script>open_error('Email field must be in email format');</script>";
        }

    }
    else {
        echo "<script>open_error('Enter the new email to change it.');</script>";
    }
}
if (isset($_POST['change_checkbox'])) {
    if (isset($_POST['checkbox']) == '1') {
        $connect->query("UPDATE users SET `comments` = '1' WHERE `user_name` = '$login'");
    }
    if (isset($_POST['checkbox']) == '0') {
        $connect->query("UPDATE users SET `comments` = '0' WHERE `user_name` = '$login'");
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

site_bottom();
