<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 22/11/2015
 * Time: 4:03 PM
 */

include_once('output_fns.php');
include_once('admin_fns.php');
include_once('order_fns.php');
include "data_valid_fns.php";

function db_connect()
{
    $db_host = 'localhost';
    $db_name = 'book_sc';
    $db_user = 'tonytan';
    $db_pass = 'p@55w0rd';

    $result = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if (!$result) {
        throw new Exception('Could not connect to database server');
    } else {
        return $result;
    }
}

function db_result_to_array(mysqli_result $result){
    $result_array = array();

    for ($count=0; $row = $result->fetch_assoc(); $count++) {
        $result_array[$count] = $row;
    }

    return $result_array;
}

function get_categories(){
    $conn = db_connect();
    $query = "SELECT catid, catname From categories";
    $result = mysqli_query($conn, $query);

   /* if(!$result){
        return false;
    }

    $num_cats = @$result->num_rows;
    if($num_cats == 0){
        return false;
    }*/

    $result = db_result_to_array($result);
    return $result;
}

function display_categories($cat_array){
    //if(!is_array($cat_array)){
   //     echo "<p> No categories currently available</p>";
   //     return;
  //  }

    echo "<ul>";
    foreach ($cat_array as $row) {
        $url = "show_cat.php?catid=".($row['catid']);
        $title = $row['catname'];
        echo "<li>";
        do_html_url($url, $title);
        echo "</li>";
    }
    echo "</ul>";
    echo "<hr />";
}

function get_category_name($catid){
    //query database for the name for a category id
    $conn = db_connect();
    $query = "SELECT catname FORM categories WHERE catid = '".$catid."'";
    $result = @$conn->query($query);

    if(!$result){
        return false;
    }
    $num_cats = @$result->num_rows;
    if($num_cats == 0){
        return false;
    }

    $row =$result->fetch_object();
    return $row->catname;
}

function get_books($catid){
    $conn = db_connect();
    $query = "SELECT isbn, title From books WHERE catid='".$catid."'";
    $result = @$conn->query($query);

    if(!$result){
        return false;
    }

    $num_books = @$result->num_rows;
    if($num_books == 0){
        return false;
    }

    $result = db_result_to_array($result);
    return $result;
}

function display_books($book_array){
    if(!is_array($book_array)){
        echo "<p> No books currently available</p>";
        return;
    }

    echo "<ul>";
    foreach ($book_array as $row) {
        $url = "show_book.php?isbn=".($row['isbn']);
        $title = $row['title'];
        echo "<li>";
        do_html_url($url, $title);
        echo "</li>";
    }
    echo "</ul>";
    echo "<hr />";
}

function get_book_details($isbn){
    $conn = db_connect();
    $query = "SELECT * FROM books WHERE isbn='".$isbn."'";

    $Results = $conn->query($query)  or die('couldn\'t retrieve from database');
    $bookDetails = $Results->fetch_assoc();

    return $bookDetails;

}

function display_book_details($bookDetails){
    ?>
Title: <?php echo $bookDetails['title']?> <br />
ISBN Number: <?php echo $bookDetails['isbn']?> <br />
Book author: <?php echo $bookDetails['author']?> <br />
Category: <?php echo $bookDetails['catid']?> <br />
Subject of the book: <?php echo $bookDetails['catid']?> <br />
Price: <?php echo $bookDetails['price']?> <br />
Description: <?php echo $bookDetails['description']?> <br />
Book image: <br />
    <img src="/myPHP/ShoppingCart/images/books/<?php echo $bookDetails['isbn'] ?>.jpg" alt="<? echo $bookDetails['title']?>" />


<? /*
<?php if($_SESSION['user'] == $bookDetails['owner_username']): ?>
    <br /><a href="../delete_book/process_delete.php?bookId=<?php echo $bookDetails['id'];?>">Delete this book from store</a>
<?php endif; ?>
    */ ?>

<?
}

function calculate_price($cart)
{
    $price = 0.0;
    if (is_array($cart)) {
        $conn = db_connect();
        foreach ($cart as $isbn => $qty) {
            $query = "SELECT * FROM books WHERE isbn='" . $isbn . "'";
            $result = $conn->query($query);
            if ($result) {
                $item = $result->fetch_object();
                $item_price = $item->price;
                $price += $item_price * $qty;
            }
        }
    }
    return $price;
}

function calculate_items($cart) {
    // sum total items in shopping cart
    $items =0;
    if(is_array($cart)){
        foreach($cart as $isbn=>$qty){
            $items += $qty;
        }
    }

    return $items;
}

