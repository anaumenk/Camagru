<?php
site_top();
?>
<div style="display: flex;">
    <div id="shade" style="display: none;"></div>
    <div id="error"><button onclick="clear_error_add_picture();">Get it</button></div>

    <div id="photos_form">
        <div id="cam_div" style="width: 100%; height: 40%; display: flex; position: relative; justify-content: center;">
            <video id="camera" autoplay></video>
            <script>camera();</script>
        </div>
        <div id='pic'></div>

        <div id="buttons">
                   <form id="add_picture_form" method="post" enctype="multipart/form-data" style="background-color: white; flex-direction: row;">

                       <button id="take" onclick="create_img(); return false;">Take picture</button>

                       <button name="save" onclick="
                       save_img();
                       if (document.querySelector('#new_img') == null) {
                           open_error('You may download or take photo with some sticker to save it');
                           return false;
                       }
                       else if (document.getElementById('p_in_error') != null) {
                           return false;
                       }
                       else {
                           location.reload();
                       }
                        ">Save picture</button>
                       <div style="position: relative;">
                           <button id="download">Download from file</button>
                           <input type="file" name="upload" id="upload" onmouseenter="
                           var button = document.getElementById('download').style;
                           button.backgroundColor = 'white';
                           button.transition = '1s';
                           button.color = '#70545f';" onmouseleave="
                           var button = document.getElementById('download').style;
                           button.backgroundColor = '#70545f';
                           button.transition = '1s';
                           button.color = 'white';" onclick="
                           var elem = document.getElementById('new_img');

                           if (elem) {elem.remove();}">
                   <script>prev_picture();</script>
                       </div>
                   </form>

        </div>
    </div>
           <div id="patterns">
                   <img src="../img/page/0111.png">
                   <img src="../img/page/0222.png">
                   <img src="../img/page/0333.png">
                   <img src="../img/page/0555.png">
                   <img src="../img/page/0666.png">
                   <img src="../img/page/0777.png">
           </div>
    <script>choose_pattern();</script>

</div>
<?php
$login = $_SESSION['user'];
$login_sql = $connect->row("SELECT * FROM `users` WHERE `user_name` = '$login'");
foreach ($login_sql as $login_data) {
    $login_id = $login_data['user_id'];
}
$sql = $connect->row("SELECT * FROM images WHERE user_id='$login_id' ORDER BY id_img DESC");
$i = 1;
if ($sql) {
    echo "<div id='helpful_div'><div class='prev_photos'>";
    foreach ($sql as $data) {
        $img_url = $data['img_src'];
        echo "<div class='prev_img'><img src='". $img_url ."'></div>";
        if (!($i % 5)) {
            echo "</div><div class='prev_photos'>";
        }
        $i++;
    }
    echo "</div></div>";
}

site_bottom();
