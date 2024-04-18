<?php
require_once '../DB/credentials.php';
require '../functions/comments.php'
?>

<?php
make_comment($_POST['comment'], $_GET['id'], $_POST['nickname']);

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
$photo_id = $row['id'];
$name = $row['name'];
$nickname = $row['nickname'];
$date = $row['upload_date'];
?>

<?php

?>


<html>
    <body>
    <h1 style = 'margin-bottom: 50px;' align="center">Hello! This is the image you've searched for</h1>
    <h2 align="center">
        <?php echo $nickname; ?>
    </h2>
    <div align="center"><img style='width:70%' src= '<?php echo $photo; ?>' ><br>
    <?php echo $name. "<br>" . $date . "<br><hr>"
    ?>
    <form method='POST' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?' . http_build_query($_GET); ?>">
	Write a comment: <textarea name='comment' rows='3' cols = '40'></textarea> 
	Write your nickname: <input type='text' name='nickname'>
    <button type='submit'>Submit</button>
    </form>
    <?php
    $comments = get_comments($photo_id);
    show_comments($comments);
    ?>
    </div>



    </body>



</html>




