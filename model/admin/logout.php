<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 30/11/2015
 * Time: 12:21 AM
 */

include('../../function/book_sc_fns.php');

session_start();
$old_user = $_SESSION['admin_user'];

unset($_SESSION['admin_user']);
do_html_header('Loggin out');

if (!empty($old_user)) {
    echo '<p>Logged out.</p>';
    do_html_url('Login.php', 'Login');
} else {
    echo "<p>You were not logged in, and so have not been logged out.</p>";
    do_html_url("Login.php", "Login");
}
do_html_footer();