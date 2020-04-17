<?php
//create_cat.php
include 'connect.php';
include 'header.php';
session_start(); 

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    echo "<form action='' method='post'>
           <input type='text' name ='search' placeholder = 'search'/>
           In:<select name='searchin'>
              <option value='categories'>categories</option>
              <option value='threads'>Threads</option>
              </select>
           <input type='submit' value='>>'/>
           </form>";
}
else{
    if(isset($_POST['search'])){
      $search = $_POST['search'];
      if(isset($_POST['searchin'])){
      $in = $_POST['searchin'];
      }
      $search = preg_replace("#[^0-9a-z]#i", "", $search);
      if(strcmp($in,'threads'))
      {
       $query = "SELECT * FROM categories WHERE Name_subject LIKE '%$search%'";  
        $result =  mysqli_query($conn ,$query);
        if(mysqli_num_rows($result) == 0)
        {
          echo "No result found of search";
        }
        else{
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
      else{
          $query = "SELECT * FROM threads WHERE TName LIKE '%$search%'";
          $result = mysqli_query($conn,$query);
          if(mysqli_num_rows($result) == 0){
            echo  "No result in threads of '$search'";
          } 

          else{
            
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
?>