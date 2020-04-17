<?php
//signup.php
include ('connect.php');
include ('header.php');

echo '<h3>Sign up</h3>';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    echo '<div class = "slogin-box" >
        <img src="avatar.png" alt="login_img" class="avatar">
        <h1>SignUp Here</h1>
        <form  method="post" action="">
        User_Id :<input type="text" name="user_id" placeholder="Enter Username...." required></br>
        Password :<input type="password" name="user_pass" placeholder="Enter Password...." required></br>
        Password again: <input type="password" name="user_pass_check" required></br>
        Email :<input type="Email" name="user_email" placeholder="Enter Email...." required></br>
        User_name:<input type="text" name="user_name" placeholder="Enter name...." ></br>
        Designation :<select name="designation">
            <option value="student">Student</option>
            <option value="staff">Staff</option>
            <option value="moderator">Moderator</option>
            </select></br>
        About me :<input type= "text" name = "about" placeholder = "About me...."></br> 
            <input type="submit" name="submit" value="SignUp">
        </form></div>';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data 
    */
    $errors = array(); /* declare the array for later use */
     
    if(isset($_POST['user_name']))
    {
        //the user name exists
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }
     
     
    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }
     
    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
    {
        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
        echo '<ul>';
        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
        {
            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
        }
        echo '</ul>';
    }
    else
    {
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
        $user_id = $_POST['user_id'];
        $password = $_POST['user_pass'];
        $email=$_POST['user_email'];
        $username=$_POST['user_name'];
        $designation=$_POST['designation'];
        $about=$_POST['about'];
        $sql = "INSERT INTO account VALUES (NOW(),'$password','$user_id','$email','$about','$username','$designation')";
        $result = mysqli_query($conn,$sql);
         
        if(!$result)
        {
            //something went wrong, display the error
            echo 'Something went wrong while registering. Please try again later.';
            //echo mysql_error(); //debugging purposes, uncomment when needed
        }
        else
        {
            echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
        }
    }
}
 
include ('footer.php');
?>