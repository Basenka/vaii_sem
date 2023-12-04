CREATE TABLE `users` (
                         `id` int(150) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         `name` varchar(50)  NULL,
                         `surname` varchar(50)  NULL,
                         `username` varchar(50) NOT NULL,
                         `email` varchar(50) NOT NULL,
                         `password` varchar(200) NOT NULL,
                         `address` varchar(60)  NULL
);

