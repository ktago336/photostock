<?php
require '../DB/credentials.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD']=='GET'):
?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Enter password:<br><input type="password" name="pass">    
<button type="submit">DELETE!!!</button>
</form>

<?php
endif;
?>


<?php
if ($_SERVER['REQUEST_METHOD']=='POST') {
    $valid_pass = $env->DB_DEL_PASS;

    $conn = new mysqli(SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
    }
    
    $pass = $_POST['pass'];
    
    if ($pass != $valid_pass) {
	die("Wrong password!");
    }

    $sql = "SELECT * FROM posts";
    if($result = mysqli_query($conn, $sql)) {
	foreach($result as $row) {
	    $ids[] = $row['id'];
	    if (file_exists($row['photo'])) {
		unlink($row['photo']);
	    }
	}

	foreach($ids as $row) {
	    mysqli_query($conn,  "DELETE FROM posts WHERE id = '$row'");
	}

	if (mysqli_query($conn, $sql)) {
	    header("Location: index.php");
	}
    } else {
	echo "ERROR: " . mysqli_error($conn);
    }

    $conn->close();
}
?>