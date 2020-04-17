<?php
//create_cat.php
include 'connect.php';
include 'header.php';
session_start();
$sql = "SELECT *  FROM categories ";


 
$result = mysqli_query($conn,$sql);

if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<table class= "tab" >
              <tr>
                <th>Category</th>
                <th>Last topic</th>
              </tr>'; 
             
        while($row = mysqli_fetch_assoc($result))
        {               
            echo '<tr>';
                echo '<td class="leftpart">';
                $id = $row['cat_id'];
                echo "<h3><a href='category.php?id={$id}' >" . $row['Name_subject'] . "</a></h3>" . $row['cat_disc'];
                echo '</td>';
                echo '<td class="rightpart">';
                $cname = $row['Name_subject'];
                $sql1 = "SELECT TName,Thread_id from Threads where cat_name='$cname' order by  Date_Created DESC ";
                $result1 = mysqli_query($conn,$sql1); 
                $row1 = mysqli_fetch_assoc($result1);
                $tid  = $row1['Thread_id'];
                echo "<a href='topic1.php?id={$tid}'>" . $row1['TName'] . "</a>";
                echo '</td>';
            echo '</tr>';
        }
    }
}
 
include 'footer.php';
?>