<?php
require_once '../DB/credentials.php';

if (!function_exists('make_comment')){
    function make_comment($text, $photoId, $nickname) {
        $conn = new mysqli(SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $comment_date = date("Y-m-d h:i:sa");
            $sql = "INSERT INTO comments (text, photo_id, nickname, upload_date)
VALUES ('$text', '$photoId', '$nickname', '$comment_date')";

            if ($conn->query($sql) === FALSE) {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

        }
    }
}

if (!function_exists('show_comments')){
    function show_comments(array $comments) {

        if (count($comments)>0) {
            foreach ($comments as $comment){
                echo $comment->nickname . "<br>" . $comment->date . "<br>" . $comment->text . "<br><hr>";
            }
        } else {
            echo "<br>0 comments";
        }
    }
}

if (!function_exists('get_comments')){
    function get_comments($photoId) {
        $conn = new mysqli(SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $sql = "SELECT id, text, photo_id, nickname, reg_date FROM comments WHERE photo_id = $photoId";

        try {
            $result = $conn->query($sql);
        }
        catch (Exception $e) {
            echo $e; exit;
        }
        $conn->close();

        $comments=[];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $comment = new stdClass();
                $comment->text = $row['text'];
                $comment->nickname = $row['nickname'];
                $comment->date = $row['reg_date'];
                $comments[]=$comment;
            }
        }
        return $comments;
    }
}

?>