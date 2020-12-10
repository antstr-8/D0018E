CREATE TABLE CUSTOMER (
  id int NOT NULL AUTO_INCREMENT,
  uname varchar(15) DEFAULT NULL,
  psword varchar(255),
  fname varchar(15),
  sname varchar(15),
  phone varchar(15),
  email varchar(255),
  admin bit DEFAULT 0,
  sex varchar(5),
  birthdate date,
  PRIMARY KEY(id)
);
