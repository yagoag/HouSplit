# HouSplit [![Stories in Ready](https://badge.waffle.io/yagoag/HouSplit.png?label=ready&title=Ready)](https://waffle.io/yagoag/HouSplit) [![Stories in progress](https://badge.waffle.io/yagoag/HouSplit.png?label=in+progress&title=In Progress)](https://waffle.io/yagoag/HouSplit)

![HouSplit](screenshot.png)

HouSplit is a bill management system based in PHP and MySQL for people dividing houses and bills, especially university students. It was originally meant to be used by "Repúblicas" - often shorted down to "Rep(s)" - which are houses divided by university students in Brazil, usually in a large number of people. It can also be applied to many other situation in which people share bills and/or borrow money to each other. Some other places you could use HouSplit are your Fraternity house or even your University Housing unit.

## Requirements
* PHP 5.5+ <sup>†</sup>
* MySQL 5.0+

<sub>† it is possible to adapt the system to work with older versions of PHP, but at least 5.5 is necessary to run the system as-is</sub>

## Installation
* Run the SQL query on the folder "sql/"
* Copy the files in "src/" to your server
* Edit "config.php" to fit your needs
  * $crypt_iterations should only be set once the server is being set up. Changing the value of this configuration after server setup will result in older accounts of the database not working and needing manual fix.
  * All of the other settings can be changed anytime according to your needs.
* Run "install.php" to create the first account of the server. Be sure to delete the file from the server once the first account is created, otherwise strangers will be able to create accounts in your system uninvited.
