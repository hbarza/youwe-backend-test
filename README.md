<p align="center">
    <h1 align="center">CODNITIVE</h1>
    <h2 align="center">Youwe Backend Test</h2>
    <br>
</p>

The project includes Youwe "Poker Chance" and "Phrase Analyzer" tests.

You can find a live version of test application on this address:
[http://youwe.be.cooode.run/](http://youwe.be.cooode.run/)

### Test 1. Poker chance calculator
Web application should calculate chance of getting desired card based on the amount of cards left.
Use string notation to designate cards.

Example:
* H2-H10 - cards 2-10 of hearts
* HJ - jack of hearts
* HA - ace of hearts
* SJ - jack of spades
* DJ - jack of diamonds
* CJ - jack of clubs
  [suit][value]

1. User should select a suit and a card rank.
2. User starts drafting cards, one by one.
3. Website should display a chance of getting customer selected card on the next Draft.

If customer selected card is drafted website should display popup with a message "Got it, the chance was (current chance of getting the card)%" and reset to step 1.

### Test 2: Phrase analyser
Create a web application that will analyse customer input and provide some statistics.

Runflow:
1. Customer is asked to insert a string (not longer then 255 chars)
2. Customer submits the data and receives a grid overview with character statistics.
    - character symbol
    - how many times character encountered.
    - sibling character info: character was seen standing before [list of chars], after [list of chars], longest distance between chars is 10 (in case of 2 or more characters).



DIRECTORY STRUCTURE
-------------------

      modules/            contains related modules and codes
      tests/              contains tests for the poker and graph 

Please note codes related to 'Assessment Development' placed in below directory:

`modules/Codnitive`

you can find 'Poker Chance Calculator' under `Poker` module:

`modules/Codnitive/Poker`

and find 'Phrase Analyzer' under `Graph` module:

`modules/Codintive/Graph`



REQUIREMENTS
------------

The minimum requirement by this project:
* PHP 7.2.X
* Nginx 1.10 or higher


INSTALLATION
------------

### Install via Composer

If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer create-project --prefer-dist codnitive/youwe-backend-test youwe
~~~



CONFIGURATION
-------------

### Web Server
You should make a copy from `nginx-local.conf-SMPL` to `nginx-local.conf` and config `server_name`, `root` and `fastcgi_pass` options as you need, if you are using nginx web server.

### Database
Also you should make a copy from `config/db.php-SMPL` to `config/db.php`


**NOTES:**
- Currently for latest version you don't need to connect application to a database and creating a copy from file is enough.


TESTING
-------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).

Unit tests are located under `test\unit` directory:

- `PokerTest.php`
- `GraphTest.php`

Tests can be executed by running

```
php vendor/bin/codecept run unit
```


The command above will execute all unit tests. If you need to run only specific test you can run this command:
```
php vendor/bin/codecept run unit PokerTest 
``` 
or bellow command to run Graph test:
```
php vendor/bin/codecept run unit GraphTest
```
