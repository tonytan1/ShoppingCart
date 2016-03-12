<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 23/11/2015
 * Time: 11:30 PM
 */

include ('../function/book_sc_fns.php');

// the shopping cart needs sessions, so start one
session_start();

do_html_header("Checkout");

//create short variable names
$name =isset($_POST['name']);
$address = isset($_POST['address']);
$city = isset($_POST['city']);
$zip = isset($_POST['zip']);
$country=isset($_POST['country']);

//if filled out
if(isset($_SESSION['cart'])&&($name)&&($address)&&($city)&&($zip)&&($country)){
    //able to insert into database
    if(insert_order($_POST)!=false){
        // display cart, not allowing changes and without pics
        display_cart($_SESSION['cart'], false, 0);

        display_shipping(calculate_shipping_cost());

        //display credit card details
        display_card_form($name);

        display_button("show_cart.php", "continue-shopping", "Continue Shopping");
    }else{
        echo "<p>Could not store data, please try again.</p>";
        display_button("checkout.php", 'back', 'Back');
    }
}else{
    echo "<p>You didn't fill in all the field, please try again.</p><hr/>";
    display_button('Checkout.php', 'back', 'Back');
}