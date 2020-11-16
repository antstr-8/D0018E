CREATE TABLE PRODINFO(
  id int NOT NULL,
  prodid int NOT NULL AUTO_INCREMENT,
  color varchar(20),
  stock int,
  url varchar(255),
  price int,
  PRIMARY KEY(id),
  FOREIGN KEY(prodid) REFERENCES PRODCAT(id)
);
