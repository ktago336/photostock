<?php
require '../DB/credentials.php';

$id = $_GET['id'];

$conn = new mysqli(SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, nickname, upload_date, photo FROM posts WHERE id = $id";
try {
    $result=$conn->query($sql);
}
catch (Exception $e){
    echo $e; exit;
}
$conn->close();
$row = $result->fetch_assoc();
$photo = $row['photo'];
$name = $row['name'];
$nickname = $row['nickname'];
$date = $row['upload_date'];
?>

<html>
    <body>
    <h1 style = 'margin-bottom: 50px;' align="center">Hello! This is the image you've searched for</h1>
    <h2 align="center">
        <?php echo $nickname; ?>
    </h2>
    <div align="center"><img style='width:70%' src= '<?php echo $photo; ?>' ><br>
    <?php echo $name. "<br>" . $date ?>
    </div>




    </body>



</html>




