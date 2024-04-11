<?php
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

$sql = "SELECT id, name, nickname, upload_date, photo FROM posts";
$result = $conn->query($sql);
$conn->close();



?>

<DOCTYPE html>
    <html>
        <head>

        </head>
        <body>
            <h1 align="center">Welcome to world's first free photostock со шлюхами и блэкджеком</h1>
            <h1 align="center"><a href="/upload.php">UPLOAD PHOTO HERE</a></h1>
	    <h3 align="center"><a href="/delete_photos.php">DELETE PHOTOS HERE</a></h3>
            <?php
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()){
                    $photo = $row['photo'];
                    $photo_id = $row['id'];

                    echo "<a href='/image.php?id=$photo_id'>";

                    echo "#".$row['id'] . "<br>";
                    echo "<img style='height: 300px' src= '$photo' ><br>";
                    echo $row["name"]. " " . $row["nickname"]. " " . $row["upload_date"] . "<br><hr>";

                    echo "</a>";
                }
		// delete photos
            } else {
                echo "0 results";
            }
            ?>




        </body>

    </html>


</DOCTYPE>


<?php




?>