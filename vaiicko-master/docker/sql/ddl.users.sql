CREATE TABLE `users` (
                         `id` INT AUTO_INCREMENT PRIMARY KEY,
                         `name` VARCHAR(50) NULL,
                         `surname` VARCHAR(50) NULL,
                         `username` VARCHAR(50) NOT NULL,
                         `email` VARCHAR(50) NOT NULL,
                         `password` VARCHAR(200) NOT NULL,
                         `address` VARCHAR(60) NULL,
                         `role` VARCHAR(20) NOT NULL,
                         `salt` VARCHAR(200) NOT NULL
);



