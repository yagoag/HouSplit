CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `payer` int NOT NULL,
  `date` date NOT NULL,
  `type` ENUM('Payment', 'Bill', 'CredTransf') NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1 AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `balance` float NOT NULL,
  `password` text NOT NULL,
  `salt` text NOT NULL,
  `active` bool NOT NULL DEFAULT TRUE,
  `admin` bool NOT NULL DEFAULT FALSE,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1 AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `portions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `memberID` int(10) unsigned NOT NULL,
  `transactionID` int(10) unsigned NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=latin1 AUTO_INCREMENT;