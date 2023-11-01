 CREATE DATABASE sneakerhive;
 USE sneakerhive;

 CREATE TABLE site_user (
 id INT AUTO_INCREMENT,
 email_address VARCHAR(500),
 password VARCHAR(500),
 CONSTRAINT pk_user PRIMARY KEY (id)
 );

 CREATE TABLE user_info (
  id INT AUTO_INCREMENT,
   user_id INT,
   first_name VARCHAR(200),
   last_name VARCHAR(200),
   mobile_number VARCHAR(20),
   gender VARCHAR(10),
   date_of_birth DATE,
 delivery_address VARCHAR(500),
 CONSTRAINT pk_userinfo PRIMARY KEY (id),
 CONSTRAINT fk_userinfo_user FOREIGN KEY (user_id) REFERENCES
 site_user (id)
 );

  CREATE TABLE newsletter (
 id INT AUTO_INCREMENT,
 email_address VARCHAR(500),
 CONSTRAINT pk_user PRIMARY KEY (id)
 );

 CREATE TABLE product_info (
 id INT AUTO_INCREMENT,
 category VARCHAR(200),
 name VARCHAR(500),
 price FLOAT,
 description VARCHAR(4000),
 gender VARCHAR(10),
 qty_in_stock INT,
 product_image VARCHAR(1000),
 CONSTRAINT pk_product PRIMARY KEY (id)
 );

  CREATE TABLE shopping_cart_item (
 id INT AUTO_INCREMENT,
 user_id INT,
 product_item_id INT,
 qty INT,
 CONSTRAINT pk_shopcartitem PRIMARY KEY (id),
 CONSTRAINT fk_shopcartitem_user FOREIGN KEY (user_id) REFERENCES
 site_user (id),
 CONSTRAINT fk_shopcartitem_proditem FOREIGN KEY (product_item_id)
 REFERENCES product_info (id)
 );

   CREATE TABLE products_liked (
 id INT AUTO_INCREMENT,
 user_id INT,
 product_item_id INT,
 qty INT,
 CONSTRAINT pk_productsliked PRIMARY KEY (id),
 CONSTRAINT fk_productsliked_user FOREIGN KEY (user_id) REFERENCES
 site_user (id),
 CONSTRAINT fk_productsliked_proditem FOREIGN KEY (product_item_id)
 REFERENCES product_info (id)
 );

 CREATE TABLE shop_order (
 id INT AUTO_INCREMENT,
 user_id INT,
 order_date DATETIME,
 shipping_address INT,
 order_total FLOAT,
 CONSTRAINT pk_shoporder PRIMARY KEY (id),
 CONSTRAINT fk_shoporder_user FOREIGN KEY (user_id) REFERENCES
 site_user (id),
 CONSTRAINT fk_shoporder_shipaddress FOREIGN KEY (shipping_address)
 REFERENCES user_info (id)
 );

 CREATE TABLE order_line (
 id INT AUTO_INCREMENT,
 product_item_id INT,
 order_id INT,
 qty INT,
 price INT,
 CONSTRAINT pk_orderline PRIMARY KEY (id),
 CONSTRAINT fk_orderline_proditem FOREIGN KEY (product_item_id)
 REFERENCES product_info (id),
 CONSTRAINT fk_orderline_order FOREIGN KEY (order_id) REFERENCES
 shop_order (id)
 );