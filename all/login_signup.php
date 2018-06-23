<?php
$_SESSION['user'] = '';
site_top();
?>
    <div id="shade"></div>
    <div id="entering">

        <a id="log_in" href="/login" onmouseover="lighter_log();" onmouseout="darker_log();">
            <p>Log in</p>
        </a>
        <a id="sign_up" href="/signup" onmouseover="lighter_sign();" onmouseout="darker_sign();">
            <p>Sign up</p>
            <a href="/home"><img id="close" src="../img/page/close.png"></a>
        </a>

    </div>
<?php
site_bottom();
?>