<?php
//create_cat.php
include 'connect.php';
include 'header.php';
session_start();
$id = number_format(mysqli_real_escape_string($conn,$_GET['id']));
//first select the category based on $_GET['cat_id']
$sql = "SELECT
            cat_id,
            Name_subject,
            cat_disc
        FROM
            categories
        WHERE
            cat_id ='$id'";
 
$result = mysqli_query($conn,$sql);
 
if(!$result)
{
    echo 'The category could not be displayed, please try again later.' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'This category does not exist.';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2>Threads in ′' . $row['Name_subject'] . '′ category</h2>';
        }
        $id = number_format(mysqli_real_escape_string($conn,$_GET['id']));
        
        //do a query for the topics
        $sql = "SELECT  Thread_id ,
TName , 
Subject, 
Date_Created, 
Rating , 
cat_name 
                    
                FROM
                    Threads
                WHERE
                    cat_name = (SELECT Name_subject from categories where cat_id= '$id')";
         
        $result = mysqli_query($conn,$sql);
         
        if(!$result)
        {
            echo 'The topics could not be displayed, please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'There are no topics in this category yet.';
            }
            else
            {
                //prepare the table
                echo '<table class = "tab" border="1">
                      <tr>
                        <th>Thread</th>
                        <th>Tags</th>
                        <th>Subject</th>
                        <th>Created at</th>
                      </tr>'; 
                $user_id = $_SESSION['user_id'];
                        $query1 = "SELECT * FROM account WHERE User_ID = '$user_id'  AND designation = 'moderator'";
                        $res= mysqli_query($conn,$query1);                        
                while($row = mysqli_fetch_assoc($result))
                {               
                    echo '<tr>';
                        echo '<td class="leftpart">';
                        $tid =  $row['Thread_id'];

                        if(mysqli_num_rows($res) == 0)
                        {
                            echo "<h3><a href='topic1.php?id={$tid}'>"  . $row['TName']. '</a><h3>';  
                        }
                    else{
                            echo "<h3><a href='topicm1.php?id={$tid}'>"  . $row['TName']. '</a><h3>';
                        }
                        
                        echo '</td>';
                        $tnm = $row['TName'];
                        $que = "SELECT * FROM tag where tname = '$tnm'";
                        $res = mysqli_query($conn, $que);
                        echo '<td class = "lmiddle">';
                        while ($row1 = mysqli_fetch_assoc($res)) {
                            echo "<h6>#" . $row1['tag_name'] . "</h6>";
                        }
                        echo '</td>';

                        echo '<td class ="rmiddle"><h3>' . $row['Subject'] . "</h3></td>";
                        echo '<td class="rightpart">';
                            echo date('Y-m-d', strtotime($row['Date_Created']));
                        echo '</td>';
                    echo '</tr>';
                }
            }
        }
    }
}
 
include 'footer.php';
?>