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
else
{
    //the user is signed in
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {   
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
                    Thread: <input type="text" name="topic_subject" /></br></br>
                    Subject : <input type= "text" name = "subject" /></br></br>';
                 echo  'Category: '; 
                 
                echo '<select name="topic_cat">';
                    while($row = mysqli_fetch_assoc($result))
                    {   $cat =$row['Name_subject'];
                        echo "<option value='cricket'>" . $row['Name_subject'] . '</option>';
                    }
                echo '</select></br></br>'; 
                     
                echo 'Post: <textarea name="post_content" /></textarea></br></br>
                    <input type="submit" value="Create Thread" />
                 </form>';
                 $tname =$_POST['topic_subject'];
            $subject=$_POST['subject'];
            $by = $_SESSION['user_id'];
            $cat = $_POST['topic_cat'];              
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO 
                        Threads(TName,Subject, Started_By,Date_Created,TNumber_of_Posts,Viewcount,Rating,cat_name) 
                        VALUES('$tname','$subject','$by',NOW(),0,0,0,'$cat')";
                      
            $result = mysqli_query($conn,$sql);
           echo $result;
            }
        }
    }
    else
    {
        //start the transaction
        $query  = "BEGIN WORK;";
        $result = mysqli_query($conn,$query);
         
        if(!$result)
        {
            //Damn! the query failed, quit
            echo 'An error occured while creating your topic. Please try again later.';
        }
        else
        {
            $tname =$_POST['TName'];
            $subject=$_POST['Subject'];
            $by = $_SESSION['Started_By'];
            $cat = $_POST['cat_name'];              
            //the form has been posted, so save it
            //insert the topic into the topics table first, then we'll save the post into the posts table
            $sql = "INSERT INTO 
                        Threads(TName,Subject, Started_By,Date_Created,Viewcount,Rating,cat_name) 
                        VALUES('$tname','$subject','$by',NOW(),0,0,'$cat')";
                      
            $result = mysqli_query($conn,$sql);
            if(!$result)
            {
                //something went wrong, display the error
                echo 'An error occured while inserting your data. Please try again later.' . mysqli_error($conn);
                $sql = "ROLLBACK;";
                $result = mysqli_query($conn,$sql);
            }
            else
            {
                //the first query worked, now start the second, posts query
                //retrieve the id of the freshly created topic for usage in the posts query
                $topicid = mysqli_insert_id();
                 $content = $_POST['post_content'];
                 $user = $_SESSION['user_id'];
                $sql = "INSERT INTO
                            posts(Upvote_Downvote,User_ID , Date_Post ,Content ,belongs_to )
                        VALUES
                            (0,'$user', NOW(),'$content'," . $topicid . ")";
                $result = mysqli_query($conn,$sql);
                 
                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'An error occured while inserting your post. Please try again later.' . mysql_error($conn);
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($conn,$sql);
                }
                else
                {
                    $sql = "COMMIT;";
                    $result = mysqli_query($conn,$sql);
                     
                    //after a lot of work, the query succeeded!
                    echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
                }
            }
        }
    }
}
 
include 'footer.php';
?>