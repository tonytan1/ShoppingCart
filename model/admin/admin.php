<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 28/11/2015
 * Time: 12:41 PM
 */

include_once "../../function/book_sc_fns.php";
session_start();

if(isset($_GET['username']) && isset($_GET['password'])){
    $username = $_GET['username'];
    $password = $_GET['password'];

    if(login($username, $password)){
        $_SESSION['admin_user'] = $username;
        //echo $_SESSION['admin_user'];
       // echo $username;
    }else{
        do_html_header("Problem");
        echo"<p>You could not be logged in.</p>";
        do_html_url('Login.php', 'Login');
        do_html_footer();
        exit;
    }
}

do_html_header("Administration");
if(check_admin_user()){
    display_admin_menu();
    echo "";
    echo "<strong><a href=logout.php>Log Out</a></strong>";

}else{
    echo "<p>Your are not authorized to enter the administration area.</p>";
}

do_html_footer();