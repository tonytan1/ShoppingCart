<?php
/**
 * Created by PhpStorm.
 * User: tonytan
 * Date: 28/11/2015
 * Time: 1:42 PM
 */

function check_admin_user()
{
    if (isset($_SESSION['admin_user'])){
        return true;
    }
    else{
        return false;
    }
}


function login($username, $password) {
// check username and password with db
// if yes, return true
// else return false
    // connect to db
    $conn = db_connect();
    if (!$conn) {
        return 0;
    }
    // check if username is unique
    $sql = "select username from admin where username='$username' and "
        . "password=sha1('$password')";
    $result = $conn->query($sql);
    if (!$result) {
        return 0;
    }
    if ($result->num_rows>0) {
        return 1;
    } else {
        return 0;
    }
}


function change_password($username, $old_password, $new_password) {
// change password for username/old_password to new_password
// return true or false
    // if the old password is right
    // change their password to new_password and return true
    // else return false
    if (login($username, $old_password)) {
        if (!($conn = db_connect())) {
            return false;
        }
        $result = $conn->query("update admin
                            set password = sha1('".$new_password."')
                            where username = '".$username."'");
        if (!$result) {
            return false;  // not changed
        } else {
            return true;  // changed successfully
        }
    } else {
        return false; // old password was wrong
    }
}

function insert_category($catname)
{
    $conn = db_connect();
    $sql = "select catname from categories where catname='$catname'";
    $result = $conn->query($sql);
    if (!$result || $result->num_rows!=0)
        return false;
    $sql = "insert into categories values ('', '$catname')";
    $result = $conn->query($sql);
    if (!$result)
        return false;
    return true;
}
function update_category ($catid, $catname)
{
    $conn = db_connect();
    $sql = "update categories set catname='$catname' where catid='$catid'";
    $result = @$conn->query($sql);
    if (!$result)
        return false;
    return true;
}
function delete_category ($catid)
{
    $conn = db_connect();
    $sql = "select isbn from books where catid='$catid'";
    $result = @$conn->query($sql);
    if (!$result || $result->num_rows>0)
        return false;

    $sql = "delete from categories where catid='$catid'";
    $result = @$conn->query($sql);
    if (!$result)
        return false;
    return true;
}

function insert_book($isbn, $title, $author, $catid, $price, $description){
    $conn = db_connect();
    $sql = "select isbn from books where isbn='$isbn'";
    $result = $conn->query($sql);
    if (!$result || $result->num_rows!=0)
        return false;
    $sql = "insert into books values ('$isbn', '$title', '$author',"
        . "'$catid', '$price', '$description')";
    $result = $conn->query($sql);
    if (!$result)
        return false;
    return true;
}

function update_book ($oldisbn, $isbn, $title, $author, $catid, $price,
                      $description)
{
    $conn = db_connect();
    $sql = "update books set isbn='$isbn', title='$title', author='$author',"
        . "catid='$catid',price='$price',description='$description' "
        . "where isbn='$oldisbn'";
    $result = @$conn->query($sql);
    if (!$result)
        return false;
    return true;
}

function delete_book ($isbn)
{
    $conn = db_connect();
    $sql = "delete from books where isbn='$isbn'";
    $result = @$conn->query($sql);
    if (!$result)
        return false;

    return true;
}

