CREATE OR ALTER TABLE CUSTOMER (
  id int NOT NULL AUTO_INCREMENT,
  uname varchar(15) DEFAULT NULL,
  password varchar,
  fname varchar(15),
  sname varchar(15)
  phone int,
  email varchar,
  admin bit DEFAULT 0,
  sex varchar(5),
  birthdate date,
  PRIMARY KEY(id)
);
