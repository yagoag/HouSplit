CREATE TABLE IF NOT EXISTS `bills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `date` date NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `salt` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `portions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member` int(10) unsigned NOT NULL,
  `bill` int(10) unsigned NOT NULL,
  `payment_date` date NOT NULL,
  `value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT;