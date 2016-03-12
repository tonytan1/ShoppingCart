<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 22/11/2015
 * Time: 3:50 PM
 */
include('../function/book_sc_fns.php');

session_start();
do_html_header("Welcome to Book ShoppingCart");

echo '<p>Please choose a category:</p>';

$cat_array = get_categories();

display_categories($cat_array);

//if logged in as admin, show add, delete, edit cat links
if(isset($_SESSION['admin_user'])){
    display_button('admin/admin.php', 'admin-menu', 'Admin Menu');
}

do_html_footer();