DELIMITER $$
DROP TABLE IF EXISTS ORDERINFO;
CREATE TABLE ORDERINFO(
  id int NOT NULL,
  prodid int NOT NULL,
  quantity int,
  oldprice int(11) NOT NULL,
  oldcolor varchar(20),
  oldurl varchar(255),
  FOREIGN KEY(id) REFERENCES ORDERS(id),
  FOREIGN KEY(prodid) REFERENCES PRODINFO(id)
);
DELIMITER ;
