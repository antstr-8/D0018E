DELIMITER $$
DROP TRIGGER IF EXISTS orderinsert;
CREATE TRIGGER orderinsert
	AFTER INSERT
    ON ORDERS FOR EACH ROW
    BEGIN
		INSERT INTO ORDERINFO (id, prodid, quantity, oldprice, oldcolor, oldurl)
        SELECT NEW.id, CART.prodid, quantity, PRODINFO.price, PRODINFO.color, PRODINFO.url
				FROM CART LEFT OUTER JOIN PRODINFO ON CART.prodid = PRODINFO.id
                WHERE NEW.custid = CART.custid;

        UPDATE PRODINFO LEFT JOIN CART ON PRODINFO.id = CART.prodid
        SET PRODINFO.stock = (PRODINFO.stock - CART.quantity)
        WHERE CART.custid = NEW.custid;

        DELETE FROM CART WHERE NEW.custid = CART.custid;
    END$$

DELIMITER ;
