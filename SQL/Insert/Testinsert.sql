//Inserts a customer named Anton Sven
INSERT INTO CUSTOMER (uname,psword,fname,sname,phone,email,sex,birthdate)
VALUES ("customer1","firstcustomer","Anton","Sven",0761234567,"customer1@mail.new","Man", "1900-01-01");


//Inserts a order at a Lars our only customer.
INSERT INTO ORDERS(custid,orderdate,cost)
VALUES((SELECT id FROM CUSTOMER WHERE fname = "Lars"),"2020-01-01",241421);


//Test insertion of a product into the product catalog
INSERT INTO PRODCAT(name,description)
VALUES("art1","The first piece of art created on this earth worth its weight in gold");

//Test insertion of a productinformation based on the art1 on the above item
INSERT INTO PRODINFO(prodid,color,stock,url,price)
VALUES((SELECT id FROM prodcat WHERE name="art1"),"red",100,"/../pictures/art1.png",250);


INSERT INTO PRODINFO(prodid,color,stock,url,price)
VALUES((SELECT id FROM prodcat WHERE name="art2"),"blue",120,"/../pictures/art2.png",300);
