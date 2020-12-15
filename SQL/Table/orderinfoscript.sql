CREATE TABLE ORDERINFO(
  id int NOT NULL,
  prodid int NOT NULL,
  quantity int,
  oldprice int(11) NOT NULL,
  FOREIGN KEY(id) REFERENCES ORDERS(id),
  FOREIGN KEY(prodid) REFERENCES PRODINFO(id)
);
