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
* ![Home Page](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(1).png)
* Product List Page
* ![Product List](shady-shaikh.github.io/portfolio_usama/projects/vivara%20(2).png)
* View Product
* ![View Product](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(3).png)
* Cart Page Example
* ![Cart Page](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(4).png)
* Backend Carousel Exmaple
* ![Backend Carousel](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(5).png)
* Inventory Report
* ![Inventory Report](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(6).png)
* Invoice Page
* ![Invoice Page](https://shady-shaikh.github.io/portfolio_usama/projects/vivara%20(7).png)


### Executing program

* You should have php installed before moving further
* make sure to clone this repo inside www/ht docs depeding on wamp/xamp
* make sure your server is running
* you need to create database named as eureka then import this file there https://github.com/Shady-shaikh/eureka/blob/main/public/eureka_db.sql
* after installing open this project in vs code and change your database file credentials which you can find in config/database.php
* then search on any browser http://localhost/eureka/

## Usage

* login with creds superadmin@gmail.com and Pass@123
* You need create beats first (area-route-beat) in order to assign beat to any customers or salesman for app
* you can create business partners , products , warehouse/bins and much more in master
* You can create more user in internal users module (user management tab)
* You can create mulitple companies from localhost/eureka/admin/company and login with that company email and default password (Pass@123)
* After master you need to create purchase pricing in purchase pricing module found in pricing tab (export sheet then add data then import)
* You can create sales price list also but it will take pricing data automatcially from pricing ladder (margin & scheme)
* You need to create margin,scheme and then pricing ladder  (sub-d margin optional) . Once ladder is generated you can now use sales and purchase modules
* In order to purchase orders or sales order its better to login with your company creds (created in company module localhost/eureka/admin/company)
* in order to add items in inventory you need to create po then forward that po to gr using + (clone) button once its done you can see items getting reflected in inventory
* You can rectify your inventory using inventory rectification module found in inventory tab
* You can transfer your data from bin-bin and warehouse-warehouse
* You can return your items using sales return and credit note can be also added
* You can see multiple type of reports (sales, purchase) and per day reports (inventory) and you can use filters also
* You can see logs and histroy for debug some transaction issues or analysis of transaction and history
* Beat calendar, Focus pack and incentives module are being used in eureka-app which you can download and integrate from https://github.com/Shady-shaikh/eureka-app
* A Distributor and Sub-Distributor role user can raise claim and it will be verified according to the flow like (Distributor->Channel (channel wise)->Head->Finance)
* A claim can be approve/reject or revise by any of superior role users which is ther in flow
* Make sure to enter proper details according to hul and enjoy...


## Authors

* Abu Osama Shaikh
* [LinkedIn](https://www.linkedin.com/in/usama-shaikh-81294a306/)
* usashaikh86@gmail.com

Feel free to contribute or add more data to enhance the project.


