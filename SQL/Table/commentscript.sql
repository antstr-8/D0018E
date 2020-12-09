CREATE TABLE COMMENT(
  custid int NOT NULL,
  prodid int NOT NULL,
  comment varchar(255),
  rating int,
  FOREIGN KEY(custid) REFERENCES CUSTOMER(id),
  FOREIGN KEY(prodid) REFERENCES PRODINFO(id)
);
