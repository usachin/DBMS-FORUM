<?php
include ("connect.php");
session_start();
$id=(mysqli_real_escape_string($conn,$_GET['id']));
$que = "UPDATE posts set Upvote_Downvote = Upvote_Downvote + 1 where post_Id = '$id'  ";
$result = mysqli_query($conn , $que);
$tid = $_SESSION['th_id'];
echo $tid;
/*echo "You Liked the post <a href =thread1.php?id='$tid' "*/
header("location: topic1.php?id=$tid ");
/*$que = "UPDATE posts set Upvote_Downvote = Upvote_Downvote + 1 where post_id = 12345";
/*$result = mysqli_query($conn,$que);*/
?>