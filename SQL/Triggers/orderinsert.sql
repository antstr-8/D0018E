DELIMITER $$
CREATE TRIGGER orderinsert
	AFTER INSERT
    ON ORDERS FOR EACH ROW
    BEGIN
		INSERT INTO ORDERINFO (id, prodid, quantity)
        SELECT NEW.id, prodid, quantity FROM CART WHERE NEW.custid = CART.custid;

        UPDATE PRODINFO LEFT JOIN CART ON PRODINFO.id = CART.prodid
        SET PRODINFO.stock = (PRODINFO.stock - CART.quantity)
        WHERE CART.custid = NEW.custid;

        DELETE FROM CART WHERE NEW.custid = CART.custid;
    END$$

DELIMITER ;
