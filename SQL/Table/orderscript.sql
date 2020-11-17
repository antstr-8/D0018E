CREATE TABLE ORDERS(
  id int NOT NULL AUTO_INCREMENT,
  custid int NOT NULL,
  orderdate date,
  cost int,
  PRIMARY KEY(id),
  FOREIGN KEY(custid) REFERENCES CUSTOMER(id)
);
