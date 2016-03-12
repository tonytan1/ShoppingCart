<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 29/11/2015
 * Time: 6:35 PM
 */
require_once('../../function/book_sc_fns.php');
session_start();

do_html_header("Adding a book");
if(check_admin_user()){
    if(filled_out($_POST)){
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $catid = $_POST['catid'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        if(insert_book($isbn, $title, $author, $catid, $price, $description)){
            echo "<p>Book<em>".stripslashes($title)."</em> was added to the database.";
        }else{
            echo "<p>Book<em>".stripslashes($title)."</em> could not be added to database.";
        }

    }else{
        echo "<p>You have not filled out the form. Please try again.";
    }

    do_html_url("admin.php", "Back to administration menu");
}else{
    echo "<p>You are not authrised to view this page.</p>";
}