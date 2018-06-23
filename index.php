<?php
    Include 'config/database.php';
    session_start();

    try{
        $DB_DSN = "mysql:host=localhost; dbname=camagru";
        $DB_USER = "root";
        $DB_PASSWORD = "fktrcfylhf";
        $mdb = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    }catch (PDOException $e){
        header('Location: config/setup.php');
    }

    $connect = new Db;

    if ($_GET['logout'] == 'true'){
        $_SESSION['user'] = "";
        header("Location: /");
    }
    if (preg_match("/\?activation_code=/", $_SERVER['REQUEST_URI'])) {
        $page = 'home';
        $activation_code = $_GET['activation_code'];
        $sql = $connect->row("SELECT * FROM users WHERE activation_code='$activation_code'");
        if ($sql != NULL) {
            foreach ($sql as $data) {
                if ($data['activate'] == '0') {
                    $connect->query("UPDATE users SET `activate` = 1 WHERE `activation_code` = '$activation_code'");
                    echo "<script> alert('Your registration was confirmed successful.'); </script>";
                    $_SESSION['user'] = $data['user_name'];
                    header("Location: /");
                }
                else {
                    echo "<script>alert('The registration was already confirmed.');</script>";
                }

            }
        } else {
            echo "<script> alert('The incorrect activation code.'); </script>";
        }
    }
    else if ($_SERVER['REQUEST_URI'] == '/') {
        $page = 'home';
    }
    else if (preg_match("/profile/", $_SERVER['REQUEST_URI']) || preg_match("/profile\?[0-9]+/", $_SERVER['REQUEST_URI'])) {
        $page = 'profile';
    }
    else {
        $page = substr($_SERVER['REQUEST_URI'], 1);
    }

    if (file_exists('all/' . $page . '.php')) {
        Include 'all/' . $page . '.php';
    }
    else if ($_SESSION['user'] != '' && file_exists('users/' . $page . '.php')) {
        Include 'users/' . $page . '.php';
    }
    else if (($_SESSION['user'] == '' && file_exists('users/' . $page . '.php')) || preg_match("/\?[0-9]{1,}/", $_SERVER['REQUEST_URI'])) {
        Include 'all/home.php';
    }
    else {
        echo "<html>
    <head>
        <title>Cat-o-gram</title>
        <meta charset='utf-8'></script>
    </head>
    <body>
         <div style='display:flex; justify-content:center;'>
                <p>Wrong page</p>
         </div>";
    }

    function site_top (){
        echo '
    <html>
    <head>
        <title>Cat-o-gram</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <link href="style.css" rel="stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <header>
        <p><a href="/">Cat-o-gram</a></p>
        <a onclick="open_nav();">
            <ul class="nav"> 
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </a>
        <a onclick="hide_nav()">
            <img id="close_nav" src="img/page/close.png">
        </a>
        <ul class="menu">
            <a class="log_in" href="/"><li>Home</li></a>
            <a class="log_in" href="/profile"><li>Profile</li></a>
            <a class="log_in" href="/add_picture"><li>Add picture</li></a>
            <a class="log_in" href="/edit"><li>Edit profile</li></a>
            <a id="log_out" href="/login_signup"><li>Log in / Sign up</li></a>
            <a id="all" href="?logout=true"><li>Log out</li></a>
         </ul>

    </header>
    <main>
        ';
    }
    if ($_SESSION['user'] != '') {

        echo "
        <script>
            var elements_menu = document.getElementsByClassName('log_in');
            for(var j = 0, length = elements_menu.length; j < length; j++) {
                    elements_menu[j].style.display = 'block';
            }
            document.getElementById('all').style.display = 'block';
            document.getElementById('log_out').style.display = 'none';
        </script>";
    }

    function site_bottom (){
        echo '
    </main>
    <footer>
            <p>anaumenk</p>
        </footer>
    </body>
    </html>';
    }



