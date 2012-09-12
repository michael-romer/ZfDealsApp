CREATE TABLE product(
  id varchar(255) NOT NULL,
  name varchar(255) NOT NULL,
  stock int(10) NOT NULL,
  PRIMARY KEY (id)
)

CREATE TABLE deal(
  id int(10) NOT NULL AUTO_INCREMENT,
  price float NOT NULL,
  startDate date NOT NULL,
  endDate date NOT NULL,
  product varchar(255) NOT NULL,
  PRIMARY KEY (id)
)