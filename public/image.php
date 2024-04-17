<?php
require '../DB/credentials.php';
?>

<?php
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

<?php
function make_comment() {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$nickname = $_POST['nickname'];
	$comment_date = date("Y-m-d h:i:sa");
	$comment = $_POST['comment'];

	$sql = "INSERT INTO comments (text, photo_id, nickname, reg_date)
VALUES ('$comment', '$id', '$nickname', '$comment_date')";

        if ($conn->query($sql) === FALSE) {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}

    }
}
?>

<?php
function show_comments() {
    $sql = "SELECT id, text, photo_id, nickname, reg_date FROM comments WHERE photo_id = $id";

    try {
	    $result = $conn->query($sql);
    }
    catch (Exception $e) {
	echo $e; exit;
    }
    $conn->close();

    if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
	    $comment = $row['text'];
	    $nickname = $row['nickname'];
	    $comment_date = $row['reg_date'];
	    echo $nickname . "<br>" . $comment_date . "<br>" . $comment . "<br><hr>";
	}
    } else {
	echo "<br>0 comments";
    }
}
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
    make_comment();
    show_comments();
    ?>
    </div>



    </body>



</html>




