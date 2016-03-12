<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 22/11/2015
 * Time: 5:17 PM
 */
include('../function/book_sc_fns.php');

//the shopping cart needs a session
session_start();

$catid = $_GET['catid'];
$name = get_category_name($catid);

do_html_header($name);

//get the book info out from db
$book_array = get_books($catid);

display_books($book_array);

//if logged in as admin, show add, delete book links
if(isset($_SESSION['admin_user'])){
    display_button("index.php", "continue", "Continue Shopping");
    display_button("admin/admin.php", "admin-menu", "Admin Menu");
    display_button("admin/edit_category_form.php?catid=".$catid,
        "edit-category", "Edit Category");
}else{
    display_button("index.php", "continue-shopping", "Continue Shopping");
}

do_html_footer();