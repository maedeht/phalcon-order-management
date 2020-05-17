# Phalcon Simple Order Management

- First of all, follow the instructions for phalcon [installation](https://docs.phalcon.io/4.0/en/installation) and [web server setup](https://docs.phalcon.io/4.0/en/webserver-setup)
- Database and tables schema are stored in `database/v1.0.0` folder, use them to create the database.
- Change service container file (`public/index.php`) and add your database name and its username and password.
- Now the project can be launched in localhost or any other hosts

----------

### Comments on the project
- User can be created in `Register` page and be logged in using `Signin` link on the menu**
- Some permission policies have been added to protect pages from guests and to manage users to visit pages they need*
- A signed in user can create orders in `Orders` page and retrieve list of his/her orders**
- A signed in user also can create order items in `OrderItems` page and access list of items of an order**
