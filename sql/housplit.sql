CREATE TABLE IF NOT EXISTS members (
    username VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    salt VARCHAR(255) NOT NULL,
    active TINYINT(1) NOT NULL DEFAULT TRUE,
    admin TINYINT(1) NOT NULL DEFAULT FALSE,
    PRIMARY KEY (username)
);

CREATE TABLE IF NOT EXISTS transactions (
    id INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    payer VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    type ENUM('Settle Up', 'Bill', 'Loan') NOT NULL,
    value FLOAT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (payer)
        REFERENCES members(username)
);

CREATE TABLE IF NOT EXISTS portions (
    id INT(255) UNSIGNED NOT NULL AUTO_INCREMENT,
    member VARCHAR(255) NOT NULL,
    transaction INT(255) UNSIGNED NOT NULL,
    value INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (member)
        REFERENCES members(username),
    FOREIGN KEY (transaction)
        REFERENCES transactions(id)
);