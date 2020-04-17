<?php
include 'connect.php';
include 'header.php';
echo '<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>';
session_start();

$query="SELECT Thread_id , TName FROM  Threads WHERE Thread_id = " . mysqli_real_escape_string($conn,$_GET['id']);
$result = mysqli_query($conn,$query);
if(!$result)
{
    echo 'The Thread could not be displayed, please try again later.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No Thread defined yet.';
    }
    else{$row = mysqli_fetch_assoc($result);
        $id = number_format(mysqli_real_escape_string($conn,$_GET['id']));
        $_SESSION["th_id"] = $id;
    	echo "<h1>-: POSTS :-</h1>";
     
  echo '<table class= "tab" >
              <tr>
                <th colspan = 3>'. $row['TName'] .'</th>
                
              </tr>
              <tr>
              <th>User</th>
              <th>vote</th>
              <th>post</th>
              </tr>';
   
    $que = " SELECT posts.Content,
    posts.Upvote_Downvote,
    posts.User_ID,
    posts.post_Id,
    Account.User_ID,
    Account.Name
FROM
    posts
LEFT JOIN
    Account
ON
     posts.User_ID = Account.User_ID
WHERE
    posts.belongs_to = '$id' ORDER BY  posts.Upvote_Downvote DESC";

$que1 = " SELECT post_date.date_post
FROM
    post_date
LEFT JOIN
    posts
ON
     posts.post_Id = post_date.post_id
WHERE
    posts.belongs_to = '$id' " ;

    $result=mysqli_query($conn,$que);
    $result1=mysqli_query($conn,$que1);
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No posts defined yet.';
    }
    else{

   		 while($row = mysqli_fetch_assoc($result))
        	{  $row1 = mysqli_fetch_assoc($result1);            
            	echo '<tr>';
                echo '<td class="leftpart">';
                echo "<h3>". $row['Name'] . "</h3></br>" ;
                echo date('Y-m-d', strtotime($row1['date_post']));
                echo '</td>';
                $num = number_format( $row['Upvote_Downvote']);
                echo '<pre><td class="middle"><span id = "thisid">' . $num . '</span>    ';
                 $pid = $row['post_Id'];
                
                 echo "<a href = 'like.php?id={$pid}'><i class='fas fa-heart'  style='font-size:15px; color:red;'></i></a>Upvote</td></pre>";
                echo '<td class="rightpart">';
                echo $row['Content'];
                echo '</td>';
            	echo '</tr>';
            }
        }
	}
}

$id = number_format(mysqli_real_escape_string($conn,$_GET['id']));
echo "<div class='menu' align='right'><a  class='item' href='index.php'>Go Back</a> -- <a class='item' id = 'post' href='reply.php?id={$id}'>Post</a> ";

include "footer.php";
?>

