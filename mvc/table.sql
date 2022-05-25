CREATE TABLE `contacts` (
    `id` INT AUTO_INCREMENT NOT NULL,
    `first_name` VARCHAR(150) NOT NULL,
    `last_name` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `comments` VARCHAR(200),
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO contacts(first_name, last_name, phone, comments) VALUES
('Komron', 'Mukhamadulloev', '992931668172', 'no data'),
('Andrey', 'Pavliashvili', '78931668172', 'some armenian guy who tried to sell me some stuff'),
('Jim', 'Carr', '245931668172', 'funny guy, comedian'),
('Zokir', 'Satorov', '992988586421', 'guy who can fix your router');