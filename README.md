# List customers phone numbers

## Introduction

this project uses PHP 7.3 and Symfony 4.

In this document we'll describe how did I think while coding.

### steps to start the project
#### using sample.db you sent in the exercise with extra data
 - install sqlite 3 `sudo apt install sqlite3`
 - Run `composer install`
 - Run `symfony server:start`
 - go to http://localhost:8000/phonenumbers

#### using main sample.db in the exercise and not updated
if you need to use the sample.db that you set in the exercise, please copy it and paste it inside `/var` directory
then after run steps in above make these steps:
 - Run `php bin/console doctrine:schema:update --force` to update database structure
 - go to http://localhost:8000/phone/validator/
 - start adding the data of each country with its country name, code, and regex, but please make sure you put a right regex value
 - Run `bin/console customer:set-phone-state` this will update all customers with phone number state with valid or not valid depend on country regex
 - go to http://localhost:8000/phonenumbers

### MY Thoughts
- I decided to create a crud of all countries and called it `phoneNumberValidator` to be able to scale it without writing code, by just go to http://localhost:8000/phone/validator/ and add any new country data we need
- I supposed that the customer should have right phone number value, so it is better to prevent adding wrong phone structure to database from the begining
- I create a command to update all current customers (may be old data) to detect which one is valid or not depend on the country that this customer belong
- then created a query the join `customer` table with `phoneValidator` table to get all customers that their phone numbers prefix match country code
- i added a pagination using `knp-paginator-bundle`
- this is a video for that show you how the list of phone numbers are shown https://monosnap.com/file/mlkv8Ho15verio6cUk9qKJeQAoSnVZ

### MY Trials
- I tried some other solutions but didn't complete them
one of these solutions is to create one query that get all customers each one with its country code and validate regex inside the query using `REGEXP` function
but found at doctrine `REGEXP` is not supported for sqlite, and I tried to create custom doctrine function for `REGEXp` but didn't work,
so i didn't complete in that solution to prevent spend much time searching for different solutions


- I tried to create REST API, thet return the list of phone numbers, and i already created it and it is working at `PhoneNumberApiController` but I didn't use it to not spend much time at design, so at end i used the normal get action that render html and send some variables to that html