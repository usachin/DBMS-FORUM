<?php
//create_cat.php
include 'connect.php';
include 'header.php';
session_start(); 
echo '<h2>Create a Thread</h2>';
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo 'Sorry, you have to be <a class = "item" href="signin.php">signed in</a> to create a Thread.';
}
else if($_SERVER['REQUEST_METHOD'] != 'POST')
    {   //the user is signed in
        //the form hasn't been posted yet, display it
        //retrieve the categories from the database for use in the dropdown
        $sql = "SELECT
                    cat_id,
                    Name_subject,
                    cat_disc
                FROM
                    categories";
         
        $result = mysqli_query($conn,$sql);
         
        if(!$result)
        {
            //the query failed, uh-oh :-(
            echo 'Error while selecting from database. Please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                //there are no categories, so a topic can't be posted
                
                    echo 'You have not created categories yet.';
                    echo "</br></br>";

                    echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                    echo "you can create Category  <a href='create_cat.php'>  Here </a>";
                
            }
            else
            {
         
                echo '<form method="post" action="">
                    Thread: <input type="text" name="topic_subject" required/></br></br>
                    Subject : <input type= "text" name = "subject" required/></br></br>
                    Tag : <input type = "text" name = "tag"/></br></br> ';
                 echo  'Category: '; 
                 
                echo '<select name="topic_cat">';
                    while($row = mysqli_fetch_assoc($result))
                    {   $cat =$row['Name_subject'];
                        echo "<option value='"  . $row['Name_subject'] . "'>" . $row['Name_subject'] . '</option>';
                    }
                echo '</select></br></br>'; 
                echo  '<input type="submit" value="Create Thread" /></form>';
            }
        }
    }    
                
else
    {
        
                 $tname =$_POST['topic_subject'];
            $subject=$_POST['subject'];
            $by = $_SESSION['user_id'];
            $cat = $_POST['topic_cat'];
            $tag = $_POST['tag'];              
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO 
                        Threads(TName,Subject, Started_By,Date_Created,TNumber_of_Posts,Viewcount,Rating,cat_name) 
                        VALUES('$tname','$subject','$by',NOW(),0,0,0,'$cat')";
            $tsql = "INSERT INTO tag VALUES('$tname','$tag')";
            $result1 = mysqli_query($conn,$tsql);
                      
            $result = mysqli_query($conn,$sql);
            $query= "SELECT cat_id from categories where Name_subject = '$cat'";
            $res = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($res);
            $cid = $row['cat_id']; 
        if(!$result)
        {
            echo 'Your Thread has not been saved, please try again later.';
        }
        else
        {
            echo "</br></br>Your reply has been saved, check out the<a href='category.php?id={$cid}'>Thread</a>.";
        }
           
                
}

 
include 'footer.php';
?>