<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A short description." />
    <meta name="keywords" content="put, keywords, here" />
    <title>Forum</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="style.css" >
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<body>
<h1>FORUM</h1>
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="homepage.html"><i class="fas fa-home" style="font-size:20px;"></i>Home</a> -
        <a class="item" href="create_threads.php">Create a thread</a> -
        <a class="item" href="create_cat.php">Create a category</a> -
        <a class="item" href="search.php">Search</a>
         
        <div id="userbar">
       <?php
        session_start();
        error_reporting(0);
        echo "<div id='userbar'>";
        if($_SESSION['signed_in'])
        {
        echo 'Hello' . $_SESSION['user_name'] . '. Not you?<a class = "item" href="signout.php"> Sign out </a>';
        }
        else
        {
        echo '<a class="item" href="signin.php">Sign in</a> or <a class="item" href="signup.php">create an account</a>.';
        }
        echo "</div>";
    ?>
    </div>
        <div id="content">
        