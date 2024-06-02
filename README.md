# vivara

vivara is E-com Project based on zoho books api its integrated with use of zoho books system !

## Description

You might have heard about zoho books so this project is E-comm project having frontend-backend feature and carousel, categories and diffrent sections can be added dynamically using backend cms module and its connected with zoho books and local database system using webhooks and diffrent api calls..

## Getting Started

### Dependencies

* Zoho Books

### Installing
* Clone the repository: git clone https://github.com/Shady-shaikh/vivara.git
* Navigate to the project directory: cd vivara

### Site Details

* Home page
  ![Home Page](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(1).png)
* Product List Page
  ![Product List](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(2).png)
* View Product
  ![View Product](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(3).png)
* Cart Page Example
  ![Cart Page](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(4).png)
* Backend Carousel Exmaple
  ![Backend Carousel](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(5).png)
* Inventory Report
  ![Inventory Report](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(6).png)
* Invoice Page
  ![Invoice Page](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(7).png)


### Executing program

* You should have php installed before moving further
* make sure to clone this repo inside www/ht docs depeding on wamp/xamp
* make sure your server is running
* you need to create database named as eureka then import this file there https://github.com/Shady-shaikh/vivara/blob/main/public/vivara_db.sql
* after installing open this project in vs code and change your database file credentials which you can find in config/database.php
* then search on any browser http://localhost/vivara/

## Usage

* You need to create an account in zoho books first 
* You can use some domain or NGROK to create temporary url of your project http://localhost/vivara/
* once your project is have https or live then you can put same url in webhooks along with functions like add/edit and delete
* Your url in webhook should be like https:/somestring/vivara/handleZohoBooksWebhook and make sure to use trigger when added or edited for add/edit and add type parametere in url  as module_manage  and for delete use module_delete with deleted triggers (any field)
* Once all required webhooks are created then you can create items using item group module and make sure to add 3 attributes named as category,color and size
* Now go to login page of our project after items are added and if you are a first time user then click on register and enter details
* Once you create a customer you can see its reflected in zoho books customer module also
* Now you can login and see itsms and you can use add to cart button and update quantities then after proceeding your invoice would be generated
* You can now see orders and payment details in those modules present in my account tab
* Invoice will be emailed to customer automatically and all data like stocks, inventory, invoice and payments would get reflected at the same time in zoho books also
* Make sure to enter proper details according to zoho books and enjoy...


## Authors

* Abu Osama Shaikh
* [LinkedIn](https://www.linkedin.com/in/usama-shaikh-81294a306/)
* usashaikh86@gmail.com

Feel free to contribute or add more data to enhance the project.


