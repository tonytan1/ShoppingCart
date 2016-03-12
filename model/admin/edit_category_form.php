<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 30/11/2015
 * Time: 12:11 AM
 */

require_once('../../function/book_sc_fns.php');

session_start();
do_html_header('Edit category');

if (check_admin_user()) {
    if (true) {
        $s = get_category_name($_GET['catid']);
        echo "$s";
        $catid = $_GET['catid'];
        $cat = compact('catname', 'catid');
        display_category_form($cat);
    }else {
        echo '<p>Could not retrieve category details.</p>';
    }

    do_html_url('admin.php', 'Back to administration menu');
} else {
    echo '<p>You are not authorized to enter the administration area.</p>';
}
do_html_footer();