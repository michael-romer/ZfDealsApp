CREATE TABLE product(
  productId varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  stock int(10) NOT NULL,
  PRIMARY KEY (id)
)

CREATE TABLE deal(
  dealId int(10) NOT NULL AUTO_INCREMENT,
  price float NOT NULL,
  startDate date NOT NULL,
  endDate date NOT NULL,
  product varchar(255) NOT NULL,
  PRIMARY KEY (id)
)

CREATE TABLE ordering(
  orderId int(10) NOT NULL AUTO_INCREMENT,
  firstname varchar(255) NOT NULL,
  lastname varchar(255) NOT NULL,
  street varchar(255) NOT NULL,
  zip varchar(10) NOT NULL,
  city varchar(255) NOT NULL,
  deal int(10) NOT NULL,
  PRIMARY KEY (id)
)