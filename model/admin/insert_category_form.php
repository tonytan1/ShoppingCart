<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 30/11/2015
 * Time: 8:32 PM
 */

require_once('../../function/book_sc_fns.php');

session_start();

do_html_header('Add a category');

if (check_admin_user()){
    display_category_form();
    do_html_url('admin.php', 'Back to administration menu');
} else {
    echo '<p>You are not authorized to enter the administration area.</p>';
}