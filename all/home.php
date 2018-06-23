<?php
    site_top();
    $login  = $_SESSION['user'];

    $login_sql = $connect->row("SELECT * FROM `users` WHERE `user_name` = '$login'");
    foreach ($login_sql as $login_data) {
        $login_id = $login_data['user_id'];
    }

    $page = strstr($_SERVER['REQUEST_URI'], '?');
    $page = substr($page, 1);
    if ($page > 1) {
        $page = ($page  - 1) * 6;
    }
    else {
        $page = 0;
    }
    $sql = $connect->row("SELECT * FROM images ORDER BY id_img DESC LIMIT 6 OFFSET $page");
    if ($sql != NULL) {
        $i = 1;
        echo "<div id='pictures'><div style='display: flex; justify-content: center;'>";
        foreach ($sql as $data) {
            $user_id = $data['user_id'];
            $image = $data['img_src'];
            $likes = $data['likes'];
            $comments = $data['comments'];
            $img_id = $data['id_img'];
            echo "<div class='home_img' onclick='open_image(".$i.");'><img  src=" . $image . "></div>";
            $sql_new = $connect->row( "SELECT * FROM users WHERE user_id='$user_id'");
            foreach ($sql_new as $data_new) {
                    $user_img = $data_new['user_image'];
                    $user_name = $data_new['user_name'];
                    $user_comments = $data_new['comments'];
                    $user_email = $data_new['email'];
            }
            echo "<div class='image_view' id = ". $i." style='display: none;'>
                      <div id='header_user'>
                          <div>
                              <img src='". $user_img ."'>
                              <p>" . $user_name . "</p>
                          </div>
                          <i onclick='close_image(".$i.");' class='far fa-times-circle'></i>
                      </div>
                      <div id='img_div'><center><img src='". $image." '></center></div>
                      <form id='likes_comments' method='post'>
                           <div id='likes'>";
                           $if = 1;
                           if ($_SESSION['user'] != '') {
                               $likes_sql = $connect->row( "SELECT * FROM likes WHERE image_id='$img_id'");
                               foreach ($likes_sql as $likes_data) {
                                   if ($likes_data['user_id'] == $login_id) {
                                        $if = 0;
                                        echo "<i class='fas fa-heart'></i>";
                                   }
                               }
                           }
                           if ($if == 1) {
                               echo "<i class='far fa-heart'></i>";
                           }
                           $button = array('login' => $login, 'img_id' => $img_id, 'login_id' => $login_id, 'if' => $if);
                           echo "
                                <button name='set_like' value='". json_encode($button)."'></button>
                                <p>".$likes."</p>
                           </div>
                           <div id='comments'>
                                <i class='far fa-comment'></i>
                                <p>".$comments."</p>
                           </div>
                      </form>
                      <div id='comments_form'>";
                      if ($_SESSION['user'] != '') {
                           echo "<form id='new_comment' method='post'><textarea name='comment_text'></textarea>
                                <button name='send_comment' type='submit'
                                value='".json_encode(array(
                                   'img_id' => $img_id,
                                   'login_id' => $login_id,
                                   'user_comments' => $user_comments,
                                   'user_name' => $user_name,
                                   'user_email' => $user_email)) ."'>Comment</button></form>";
                      }
                      $comments = $connect->row("SELECT * FROM comments WHERE `img_id`=$img_id ORDER BY id DESC");
                      foreach ($comments as $comm_data) {
                          $user_id = $comm_data['user_id'];
                          $comment = $comm_data['comment'];
                          $comment_id = $comm_data['id'];
                          $user_info = $connect->row("SELECT * FROM users WHERE `user_id`=$user_id");
                          foreach ($user_info as $user_data) {
                              $img_for_comm = $user_data['user_image'];
                              $user = $user_data['user_name'];
                          }
                          echo "<div class='comm'>
                                    <div style='display: flex;'><img src='".$img_for_comm."'><p>$user</p></div>
                                    <div style='position: relative;'>
                                        <p>$comment</p>";
                          if ($user_id == $login_id) {
                              echo "<form id='del_comment' method='post'>
                                         <input hidden name='comm' value='".json_encode(array(
                                      'img_id' => $img_id,
                                      'comment_id' => $comment_id)) ."'>  
                                         <input type='submit' value='Delete comment' name='del_comm'>
                                    </form>";
                          }
                          echo "
                                    </div>
                                </div>";
                      }
                      echo "

                      </div>
                  </div>";
                  if (!($i % 3)) {
                       echo "
                  </div><div style='display: flex; justify-content: center;'>";
                  }
                  $i++;
        }
        echo "</div></div></div>";
    }
    else {
        echo "<p id='no_photos'>No photos yet.</p>";
    }
    $count_sql = $connect->row("SELECT COUNT(*) AS `count` FROM images");
    $num = $count_sql[0]['count'];
    $j = 1;
    if ($num > 6) {
        echo "<div id='numeration'><center>";
        while ($num - 6 > 0) {
            echo "<a href='?". $j ."'>" . $j . "</a>";
            $j++;
            $num = $num - 6;
        }
        echo "<a href='?". $j ."'>" . $j . "</a></center></div>";
    }

    if (isset($_POST['set_like'])) {
        $button = json_decode($_POST['set_like'], true);
        $login = $button['login'];
        $img_id = $button['img_id'];
        $login_id = $button['login_id'];
        $if = $button['if'];
        if ($login != '') {
            if ($if == 0) {
                $connect->query("UPDATE `images` SET `likes` = `likes` - 1 WHERE `id_img` = '$img_id'");
                $connect->query("DELETE FROM `likes` WHERE `user_id` = '$login_id' AND `image_id` = '$img_id'");
                echo "<meta http-equiv='refresh' content='0'>";
            }
            if($if == 1) {

                $connect->query("UPDATE `images` SET `likes` = `likes` + 1 WHERE `id_img` = '$img_id'");
                $connect->query( "INSERT INTO `likes` (`user_id`, `image_id`) VALUES ('$login_id', '$img_id')");
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
        else {
            header("Location: /login_signup");
        }
    }

    if (isset($_POST['send_comment'])) {
        $button = json_decode($_POST['send_comment'], true);
        $img_id = $button['img_id'];
        $comment = $_POST['comment_text'];
        $comment = htmlspecialchars($comment);
        $login_id = $button['login_id'];
        $user_comments = $button['user_comments'];
        $user_name = $button['user_name'];
        $email = $button['user_email'];
        if ($comment != '') {
            $connect->query("INSERT INTO `comments` (`img_id`, `user_id`, `comment`) VALUES ('$img_id', '$login_id', '$comment')");
            $connect->query("UPDATE `images` SET `comments` = `comments` + 1 WHERE `id_img` = '$img_id'");

            if ($user_comments == '1') {
                $message = "<p>Hello, $user_name!</p><p>You have new comment.</p>";
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

        }
        echo "<meta http-equiv='refresh' content='0'>";
    }

    if (isset($_POST['del_comm'])) {
        $button = json_decode($_POST['comm'], true);
        $img_id = $button['img_id'];
        $comm_id = $button['comment_id'];

        $connect->query("DELETE FROM `comments` WHERE `id` = '$comm_id'");
        $connect->query("UPDATE `images` SET `comments` = `comments` - 1 WHERE `id_img` = '$img_id'");
        echo "<meta http-equiv='refresh' content='0'>";
    }
    site_bottom();