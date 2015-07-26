CREATE TABLE IF NOT EXISTS members (
    username TEXT NOT NULL,
    name TEXT NOT NULL,
    password TEXT NOT NULL,
    salt TEXT NOT NULL,
    active BOOL NOT NULL DEFAULT TRUE,
    admin BOOL NOT NULL DEFAULT FALSE,
    PRIMARY KEY (username)
);

CREATE TABLE IF NOT EXISTS transactions (
    id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    payer int NOT NULL,
    date DATE NOT NULL,
    type ENUM('Settle Up', 'Bill', 'Loan') NOT NULL,
    value FLOAT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (payer)
        REFERENCES members(username)
);

CREATE TABLE IF NOT EXISTS portions (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    member TEXT UNSIGNED NOT NULL,
    transaction INT(10) UNSIGNED NOT NULL,
    value INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (member)
        REFERENCES members(username),
    FOREIGN KEY (transaction)
        REFERENCES transactions(id)
);