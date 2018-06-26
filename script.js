function open_nav() {
    var nav = document.getElementsByClassName('nav');
    for(var i = 0, length = nav.length; i < length; i++) {
        nav[i].style.display = 'none';
    }
    document.getElementById("close_nav").style.display = "unset";



    var menu = document.getElementsByClassName('menu');
    for(var j = 0, length_m = menu.length; j < length_m; j++) {
        menu[j].style.display = 'block';
    }
}

function hide_nav() {
    document.getElementById("close_nav").style.display = "none";

    var nav = document.getElementsByClassName('nav');
    for(var i = 0, length = nav.length; i < length; i++) {
        nav[i].style.display = 'unset';
    }

    var menu = document.getElementsByClassName('menu');
    for(var j = 0, length_m = menu.length; j < length_m; j++) {
        menu[j].style.display = 'none';
    }
}

function lighter_log() {
    document.getElementById('log_in').style.backgroundColor = "#6f535e";
}

function darker_log() {
    document.getElementById('log_in').style.backgroundColor = "#937782";
}

function lighter_sign() {
    document.getElementById('sign_up').style.backgroundColor = "#6f535e";
}

function darker_sign() {
    document.getElementById('sign_up').style.backgroundColor = "#937782";
}

function close_img() {
    document.getElementById("shade").style.display = "none";
    document.getElementById("entering").style.display = "none";
}

function camera() {
    var player = document.getElementById('camera');

    navigator.getMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    navigator.getMedia(
        {
            video: true,
            audio: false
        },
        function(stream) {
            player.srcObject = stream;
            player.play();
            is_video = true;
        },
        function(err) {
            is_video = false;
            captureButton.disabled = true;
        }
    );
}

function prev_picture() {
    const overlay = document.querySelector('#new_pattern');

    var inpElem = document.getElementById('upload'),
        divElem = document.getElementById('pic');

    inpElem.addEventListener('change', function(e) {
        preview(this.files[0]);
    });

    function preview(file) {
        if ( file.type.match(/image.*/) ) {
            var reader = new FileReader(), img;

            reader.addEventListener('load', function(event) {
                img = document.createElement('img');
                img.id = 'new_img';
                img.src = event.target.result;
                divElem.appendChild(img);

            });

            reader.readAsDataURL(file);
        }
    }
}

function create_img() {
    const overlay = document.querySelector('#new_pattern');

    if (overlay) {
        var divElem = document.getElementById('pic');
        var elem = document.getElementById('new_img');

        if (elem){
            elem.remove();
        }
        var newElem = document.createElement('img');
        newElem.id = 'new_img';
        divElem.appendChild(newElem);


        const video = document.querySelector('#camera');
        const img = document.querySelector('#new_img');

        const canvas = document.createElement('canvas');


        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0);
        img.src = canvas.toDataURL('image/png');

        var xmlhttp = new XMLHttpRequest();
        var response = xmlhttp.responseText;
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                var response = xmlhttp.responseText;
                img.src = response;
            }
        };
        xmlhttp.open("POST", "compare.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("overlay=" + overlay.src + "&photo=" + img.src);
    }
}

function save_img() {
    var xmlhttp = new XMLHttpRequest();
    const img = document.querySelector('#new_img');

    if (img) {
        if (img.src.indexOf("data:image/png") >= 0) {
            xmlhttp.open("POST", "save.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("photo=" + img.src);
        }
        else {
            document.getElementById('shade').style.display = 'unset';
            var elem = document.getElementById('error');
            elem.style.display = 'inline-flex';
            var newElem = document.createElement('p');
            newElem.id = 'p_in_error';
            newElem.textContent = 'Select PNG image format';
            elem.insertBefore(newElem, elem.firstChild);
        }
    }
}

function choose_pattern() {
    var pattern = document.querySelector('#patterns').children;
    for (var i=0, child; child=pattern[i]; i++) {
        child.onclick = function () {
            var parElem = document.getElementById('cam_div');

            var elem = document.getElementById('new_pattern');
            if (elem) {
                elem.remove();
            }
            var newElem = document.createElement('img');
            newElem.id = 'new_pattern';
            newElem.style.display = 'none';
            newElem.src = this.src;
            parElem.appendChild(newElem);
        };
        child.ondblclick = function () {
            var elem = document.getElementById('new_pattern');
            if (elem) {
                if (elem.src = this.src) {
                    elem.remove();
                }
            }
        };
    }
}

function open_image(i) {
    document.getElementById(i).style.display = 'flex';
}

function close_image(i) {
    document.getElementById(i).style.display = 'none';
}

function change_user_image_prev() {
    var inpElem = document.getElementById('new_user_image');

        inpElem.addEventListener('change', function(e) {
            preview(this.files[0]);
        });

        function preview(file) {
            if ( file.type.match(/image.*/) ) {
                var reader = new FileReader(), img;

                reader.addEventListener('load', function(event) {
                    img = document.getElementById('user_image')
                    img.src = event.target.result;
                });

                reader.readAsDataURL(file);
            }
        }
}

function change_user_image() {
    var xmlhttp = new XMLHttpRequest();
    const img = document.querySelector('#user_image');

    if (img)
    {
        if (img.src.indexOf("data:image/png") >= 0)
        {
            xmlhttp.open("POST", "save_user_image.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("photo=" + img.src);
        }
        else {
            var elem = document.getElementById('error');
            elem.style.display = 'inline-flex';
            var newElem = document.createElement('p');
            newElem.id = 'p_in_error';
            newElem.textContent = 'Select PNG image format';
            elem.insertBefore(newElem, elem.firstChild);
        }
    }
}

function open_error(text) {
    var elem = document.getElementById('error');

    elem.style.display = 'inline-flex';
    var newElem = document.createElement('p');
    newElem.id = 'p_in_error';
    newElem.textContent = text;
    elem.insertBefore(newElem, elem.firstChild);
}

function clear_error_add_picture() {
    document.getElementById('p_in_error').remove();
    document.getElementById('shade').style.display = 'none';
    document.getElementById('error').style.display = 'none'
}

function clear_error() {
    document.getElementById('p_in_error').remove();
    document.getElementById('error').style.display = 'none'
}