# ysuite
## Instructions about Main Application configuration

### Step 1: To configure MySQL database
- In folder sql there is a file named costomers.sql
- Open that file copy the contents and paste it in MySQL workbench or phpMyAdmin. This is a core start of making database.
- It is recommended to maintain the same name as for database, table as db, customers respectively.
- Make changes in connection.php according to the requirements (password, user only).

### Step 2: To Place a folder structure in right location preferebaly xampp
```
ysuite
    |---connection.php
    |---index.php
    |---add_customer.php
    |---index.js
    |---js   
        |---jquery.js
        |---jquery.min.js
    |---sql               --> Not Necessary now onwards
        |---customers.sql
```

- Place the whole folder named ysuite under htdocs
### Very Very Important (Its not possible to send zip file which includes .js files)
- Rename the file named "index.txt" --> "index.js" 
- Open Xampp Control Panel and start apache and mysql server
- Make sure connecting with intenet just in the start in order to load bootstrap links and scripts, cdn links until gets stored in the cache. 
- Run the application on browser at http://localhost/ysuite
