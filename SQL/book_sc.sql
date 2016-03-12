drop DATABASE book_sc;
CREATE DATABASE book_sc;

use book_sc;

CREATE TABLE customers (
  customerid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  name CHAR(60) NOT NULL ,
  address CHAR(80) NOT NULL ,
  city CHAR(30) NOT NULL ,
  state CHAR(20),
  zip CHAR(10),
  country CHAR(20) NOT NULL
);

CREATE TABLE orders(
  orderid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  customerid INT UNSIGNED NOT NULL REFERENCES customers(customerid),
  amount FLOAT(6,2),
  DATE date NOT NULL ,
  order_status CHAR(10),
  ship_name CHAR(60) NOT NULL ,
  ship_address CHAR(80) NOT NULL ,
  ship_city CHAR(30) NOT NULL ,
  ship_state CHAR(20),
  ship_zip CHAR(10),
  ship_country CHAR(20) NOT NULL
);

CREATE TABLE books(
  isbn CHAR(13) NOT NULL PRIMARY KEY ,
  author CHAR(100),
  title CHAR(100),
  catid int UNSIGNED,
  price FLOAT(4,2) NOT NULL ,
  description VARCHAR(255)
);

CREATE TABLE categories(
  catid int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
  catname CHAR(60) NOT NULL
);

CREATE TABLE order_items(
  orderid INT UNSIGNED NOT NULL REFERENCES orders(orderid),
  isbn CHAR(13) NOT NULL REFERENCES books(isbn),
  item_price FLOAT(4,2) NOT NULL ,
  PRIMARY KEY (orderid, isbn)
);

CREATE TABLE admin(
  username CHAR(16) NOT NULL PRIMARY KEY ,
  password CHAR(40) NOT NULL
);

GRANT SELECT, insert, update, delete
on book_sc.*
to tonytan@localhost IDENTIFIED BY 'p@55w0rd';
