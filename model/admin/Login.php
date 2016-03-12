<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 30/11/2015
 * Time: 12:18 AM
 */

include_once('../../function/book_sc_fns.php');

session_start();

if (check_admin_user()) {
    require('admin.php');
    echo '<br/>You have been logged in.<br />';
    exit;
}

do_html_header('Administration');
display_login_form();
do_html_footer();