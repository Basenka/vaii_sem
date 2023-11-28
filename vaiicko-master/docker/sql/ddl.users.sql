CREATE TABLE `Users` (
                         `id` int(150) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         `name` varchar(50) NOT NULL,
                         `surname` varchar(50) NOT NULL,
                         `username` varchar(50) NOT NULL,
                         `email` varchar(50) NOT NULL,
                         `password` varchar(50) NOT NULL,
                         `address` varchar(60) NOT NULL
);

ALTER TABLE Users
    ADD CONSTRAINT unique_username UNIQUE (username);
