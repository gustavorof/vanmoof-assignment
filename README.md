# VANMOOF

## Magento development assignment

Magento 2 project implemented for VanMoof. The proposal of this application is to implement a custom dropdown product attribute to represent the shipment date of the product. The information must have the following requirements:

* Product attribute should contain the next values 7 days, 14 days, 30 days
* Product attribute should be available in the next REST API endpoints:
  * /V1/products-render-info
  * /V1/products
  * /V1/products/{sku}
* A product attribute should be exposed in date format. For example, if today is the 28th of June 2021 and the product has a value of 7 days we should show 04-07-2021, same for 14 and 30 days.

## Built With

* Magento 2.4.3 version
* PHP 7.4
* Composer
* Mysql
* Docker


## Getting Started


### Requirements


```
PHP 7.4
Magento 2.4.3
```


### Installing 

Clone this repository. use master branch.

```
git clone git@github.com:gustavorof/vanmoof-assignment.git or git clone https://github.com/gustavorof/vanmoof-assignment.git
git checkout master
```

After cloning the repository, install the packages from composer

```
composer install
```

Then, create an empty database in Mysql. 

```
create database <your-database-name>
```

### Installing Magento

Run the following command to install the Magento application:

```
bin/magento setup:install --backend-frontname=<admin-afrontname> --db-host=<your-db-host> --db-name=<your-db-name> --db-user=<your-db-user> --db-password=<your-db-password> --base-url=<your-local-url> --language=<language-code> --currency=<currency> --admin-user=<your-admin-user> --admin-password=<your-admin-password> --admin-firstname=<your-firstname> --admin-lastname=<your-lastname> --admin-email=<your-email> --elasticsearch-host=<your-local-elasticsearch-host> --elasticsearch-port=<your-local-elasticsearch-port>
``` 
  
  
## Running PHP Unit tests

  It's possible to run php unit tests by running command in the root project directory:
```
vendor/bin/phpunit
```
  
## Author
  
* **Gustavo Francisco** - *PHP / Magento developer* - [Profile on Github](https://github.com/gustavorof)
* Email: gustavor.francisco@gmail.com
* [Profile on Linkedin](https://www.linkedin.com/in/gustavo-francisco/)
  
## Magento concepts

* EAV Attributes
* Plugins
* Data Patch
* Dependency Injection
  
## Acknowledgments

* PHP
* PHP unit
* Composer
* SOLID principles
* Database
* Docker
* GIT
  
  
## Additional Information

This Magento project was implement exclusevely for this assignment.

* Composer.lock was versioned to make sure the same version you have were properly implemented.
* A custom module called ProductDelivery was created under app/code/VanMoof directory to meet the requirements.
* A custom phpunit.xml file was versioned in the project to keep the compatibility of what was tested.

  
