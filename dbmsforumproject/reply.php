<?php
//create_cat.php
include 'connect.php';
include 'header.php';
session_start();
$id = number_format(mysqli_real_escape_string($conn,$_GET['id']));
if($_SESSION['signed_in']== false)
    {
         //check for sign in status
        echo 'You must be signed in to post .';
    }

else if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //someone is calling the file directly, which we don't want
   // echo 'This file cannot be called directly.';
    echo    '<form method="post" action="">
    <textarea name="reply-content" required></textarea></br>
    <input type="submit" value="POST" /></br></br></br>
    </form>';
} 

else
{
        //a real user posted a real reply
    
        $id =  number_format(mysqli_real_escape_string($conn,$_GET['id']));
        $post = $_POST['reply-content'];
        $uid = $_SESSION['user_id'];
        $name = $_SESSION['user_name'];
        $sql = "INSERT INTO 
                    posts(Upvote_Downvote,
                          User_ID,
                          Content,
                          belongs_to) 
                VALUES (0,'$uid', '$post','$id')";
        $sql1 = "INSERT INTO  post_date(date_post) VALUES(now())";
        $result = mysqli_query($conn,$sql);
        $result1 = mysqli_query($conn,$sql1);
        if(!$result)
        {
            echo 'Your reply has not been saved, please try again later.';
        }
        else
        {
            echo "</br></br>Your reply has been saved, check out the<a href='topic1.php?id={$id}'>Thread</a>.";
        }
}

 
include 'footer.php';
?>