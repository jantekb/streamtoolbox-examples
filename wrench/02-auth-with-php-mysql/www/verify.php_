<?php 
if(isset($_POST['submit'])){ 

	include 'database.inc';
     
    //Lets search the databse for the user name and password 
    //Choose some sort of password encryption, I choose sha256 
    //Password function (Not In all versions of MySQL). 
    $usr = mysql_real_escape_string($_POST['username']); 
    $pas = hash('sha256', mysql_real_escape_string($_POST['password']));
	
	// you can use http://www.xorbin.com/tools/sha256-hash-calculator to generate test sha256 hashes
	
    $sql = mysql_query("SELECT * FROM wtb_user WHERE username='$usr' AND password='$pas' LIMIT 1");

    if(mysql_num_rows($sql) == 1){ 
	    error_log('login ok');
        $row = mysql_fetch_array($sql); 
        session_start(); 
        $_SESSION['username'] = $row['username']; 
        $_SESSION['fname'] = $row['first_name']; 
        $_SESSION['lname'] = $row['last_name'];
        $_SESSION['logged'] = TRUE; 
        header("Location: video.php");
        exit; 
    } else { 
        header("Location: login.php?error=1"); 
        exit; 
    } 
} else {    // If the form button wasn't submitted go to the index page, or login page 
    header("Location: login.php");     
    exit; 
} 
?>