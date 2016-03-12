use book_sc;
drop table order_items;

CREATE TABLE order_items(
  orderid INT UNSIGNED NOT NULL REFERENCES orders(orderid),
  isbn CHAR(13) NOT NULL REFERENCES books(isbn),
  item_price FLOAT(4,2) NOT NULL ,
  quantity tinyint UNSIGNED NOT NULL,
  PRIMARY KEY (orderid, isbn)
);