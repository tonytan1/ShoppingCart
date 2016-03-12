<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 24/11/2015
 * Time: 8:34 PM
 */

function process_card($card_details){
    //connect to payment gateway
    // use gpg to encrypt and email it
    // or store in db
    return true;
}

function insert_order($order_details)
{
    // extract order_details out as variables
    extract($order_details);


    if (!isset($name) && !isset($address) && !isset($city) && !isset($state) &&
        !isset($zip) && !isset($country)
    ) {
        return "";

    } else {
        $ship_name = $name;
        $ship_address = $address;
        $ship_city = $city;
        $ship_state = $state;
        $ship_zip = $zip;
        $ship_country = $country;

        $conn = db_connect();

        $conn->autocommit(false);
        // we want to insert the order as a transaction start one
        // by turning off autocommit.

        //insert customer address
        $sql = "select customerid from customers where name='$name' and "
            . "address='$address' and city='$city' and state='$state' and "
            . "zip='$zip' and country='$country'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $customer = $result->fetch_object();
            $customerid = $customer->customerid;
        } else {
            $sql = "insert into customers values ('','$name','$address',"
                . "'$city','$state','$zip','$country')";
            $result = $conn->query($sql);
            if (!$result)
                return false;
            $customerid = $conn->insert_id;
        }
        date_default_timezone_set('UTC');
        $date = date('Y-m-d', time());
        $sql = "insert into orders values ('','$customerid','"
            . $_SESSION['total_price'] . "','$date','NOT_PAID','$ship_name',"
            . "'$ship_address','$ship_city','$ship_state','$ship_zip',"
            . "'$ship_country')";

        $result = $conn->query($sql);

        if (!$result)
            return false;

        $cost = $_SESSION['total_price'];
        $sql = "select orderid from orders where customerid='$customerid' and "
            . "amount between " . ($cost - 0.001) . " and " . ($cost + 0.001)
            . " and date='$date' and "
            . "order_status='NOT_PAID' and ship_name='$ship_name' and "
            . "ship_address='$ship_address' and ship_city='$ship_city' and "
            . "ship_state='$ship_state' and ship_zip='$ship_zip' and "
            . "ship_country='$ship_country'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $order = $result->fetch_object();
            $orderid = $order->orderid;
        } else {
            return false;
        }
        foreach ($_SESSION['cart'] as $isbn => $qty) {
            $details = get_book_details($isbn);
            $price = $details['price'];
            $sql = "insert into order_items values ('$orderid','$isbn','$price',"
                . "'$qty')";
            $result = $conn->query($sql);
            if (!$result)
                return false;
        }
        $conn->commit();
        $conn->autocommit(true);

        return $orderid;
    }

}

function calculate_shipping_cost(){
    return 20;
}
