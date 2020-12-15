DELIMITER $$
DROP TABLE IF EXISTS PRODINFO;
CREATE TABLE PRODINFO(
  id int NOT NULL AUTO_INCREMENT,
  prodid int NOT NULL,
  color varchar(20),
  stock int,
  url varchar(255),
  price int,
  PRIMARY KEY(id),
  FOREIGN KEY(prodid) REFERENCES PRODCAT(id)
);
DELIMITER ;
