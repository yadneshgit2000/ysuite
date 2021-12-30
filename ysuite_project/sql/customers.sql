create database DB;
use DB;
CREATE TABLE customers (
Cust_ID INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
Name VARCHAR(30) NOT NULL,
Address VARCHAR(80) NOT NULL,
Email VARCHAR(30) NOT NULL,
ISD INT NOT NULL,
Mobile DECIMAL(10) NOT NULL,
Notes VARCHAR(50) NOT NULL);
Alter table customers auto_increment = 10;
