<?php
//create_cat.php
include 'connect.php';
include 'header.php';
 
 
if($_SESSION['signed_in'] == false)
{
    //the user is not signed in
    echo 'Sorry, you have to be <a class = "item" href="signin.php">signed in</a> to create a Category.';
} 
else if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo "<form method='post' action=''>
        Category name: <input type='text' name='cat_name' required/></br></br>
        Category description: <textarea name='cat_description' /></textarea></br></br>
        <input type='submit' value='Add category' />
     </form>";
}
else
{
    //the form has been posted, so save it
    $cat_n = $_POST['cat_name'];
    $cat_d = $_POST['cat_description'];
    $sql = "INSERT INTO categories(Name_subject, cat_disc)
       VALUES('$cat_n','$cat_d')";
    $result = mysqli_query($conn,$sql);
    if(!$result)
    {
        //something went wrong, display the error
        echo 'Error' . mysqli_error($conn);
        echo "</br></br></br></br>";
        echo "<a href='create_cat.php'>Go Back</a>";
    }
    else
    {
        echo 'New category successfully added.';
    }
}
?>