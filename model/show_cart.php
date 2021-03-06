<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 22/11/2015
 * Time: 8:51 PM
 */

include('../function/book_sc_fns.php');

// The shopping cart needs sessions
session_start();

@$new = $_GET['new'];

if($new) {
    // new item selected
    if(!isset($_SESSION['cart'])){
        $_SESSION['cart'] = array();
        $_SESSION['items'] = 0;
        $_SESSION['total_price'] = '0.00';
    }

    if(isset($_SESSION['cart'][$new])){
        $_SESSION['cart'][$new]++;
    }else{
        $_SESSION['cart'][$new] = 1;
    }

    $_SESSION['total_price'] =calculate_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);
}

if(isset($_POST['save'])){
    foreach($_SESSION['cart'] as $isbn => $qty){
        if($_SESSION['cart'][$isbn] == 0){
            unset($_SESSION['cart'][$isbn]);
        }else{
            $_SESSION['cart'][$isbn] = $_POST[$isbn];
        }
    }

    $_SESSION['total_price'] = calculate_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);
}

do_html_header("Your shopping cart");

if((isset($_SESSION['cart'])) && (array_count_values($_SESSION['cart']))) {
    display_cart($_SESSION['cart']);
}else{
    echo "<P>There are no items in your cart</P><hr/>";
}

$target = "index.php";

//if we have just added an item to the cart, continue shopping in the category.
if($new) {
    $details = get_book_details($new);
    if($details['catid']){
        $target = "show_cat.php?catid=".$details['catid'];
    }
}

display_button($target, "continue-shopping", "Continue Shopping");

//use this if ssl is set up
//$path = $_SERVER['PHP_SELF'];
//$server = $_SERVER['SERVER_NAME'];
//$path =str_replace('show_cart.php', '', $path);
//display_button("https://".$server.$path."checout.php",
 //   "go-to-checkout", "Go To Checkout");

//if no SSL use below code
display_button("checkout.php", "go-to-checkout", "Go To Checkout");

do_html_footer();
