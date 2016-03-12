<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 28/11/2015
 * Time: 11:16 AM
 */
include ('order_fns.php');

session_start();

do_html_header('Checkout');

$card_type = $_POST['card_type'];
$card_number = $_POST['card_number'];
$card_month = $_POST['card_month'];
$card_year = $_POST['card_year'];
$card_name = $_POST['card_name'];

if($_SESSION['cart'] && ($card_type) && ($card_number) && ($card_month) && ($card_year) && ($card_name)){
    // display cart, not allowing changes and without pictures
    display_cart($_SESSION['cart'], false, 0);

    display_shipping(calculate_shipping_cost());

    if(process_card($_POST)){
        // empty shopping cart
        session_destroy();
        echo "<p>Thank you for shopping with us. Your order has been placed.</p>";
        display_button("index.php", "continue-shopping", "Continue Shopping");
    }else{
        echo "<p>Could not process your card. please contact the card issuer or try again.</p>";
        display_button("purchase.php", "back", "Back");
    }
}else{
    echo "<p> you didn't fill in all the fields. please try again</p><hr/>";
    display_button("purchase.php", "back", "Back");
}

do_html_footer();
