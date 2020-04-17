<?php



if (isset($_GET['id'])) {
                    $id = $_GET['id'];

        mysqli_query($conn, "DELETE FROM posts WHERE post_id=$id");
        header('location: topicm1.php');
    }

?>