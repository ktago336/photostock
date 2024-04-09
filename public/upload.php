<?php
if ($_SERVER['REQUEST_METHOD']=='GET'):
?>
<h1 align="center">UPLOAD YOUR PHOTO HERE!!!!!!!</h1>
<form method="POST" enctype="multipart/form-data" action="/upload.php">
    WRITE YOUR PHOTO NAME HERE!!!!!!!<br><input type="text" name="name">
    WRITE YOUR NICKNAME HERE!!!!!!!<br><input type="text" name="nickname">
    SELECT IMAGE HERE<br><input type="file" name="photo">
<button type="submit">SUBMIT!!!</button>
</form>

<?php
endif;
?>



<?php
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $env = json_decode(file_get_contents(__DIR__.'/../.env.json'));

    $servername = "localhost";
    $username = $env->DB_USERNAME;
    $password = $env->DB_PASSWORD;
    $dbname = $env->DB_NAME;

// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $info = pathinfo($_FILES['photo']['name']);
    $ext = $info['extension']; // get the extension of the file
    $newname = "image_".microtime().".$ext";
    $check = getimagesize($_FILES['photo']['tmp_name']);
    var_dump($check["mime"]);
//    exit;
    if (!strstr($check["mime"], "image/")) {
	die("File is not an image");
    }
    $target = '/images/'.$_FILES["photo"]['name'];


    move_uploaded_file( $_FILES['photo']['tmp_name'], __DIR__.'/images/'.$_FILES["photo"]['name']);
    $nickname=$_POST['nickname'];
    $photoname=$_POST['name'];
    $current_date = date("Y-m-d h:i:sa");

    $sql = "INSERT INTO posts (name, nickname, photo, upload_date)
VALUES ('$photoname', '$nickname', '$target', '$current_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully watch <a href='/'>HERE</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
