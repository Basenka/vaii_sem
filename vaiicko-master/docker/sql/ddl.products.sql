
CREATE TABLE `products` (
                          `id` int(150) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                          `name` text NOT NULL,
                          `image` varchar(300) NOT NULL,
                          `description` text NOT NULL,
                          `price` float NOT NULL,
                          `care` text NOT NULL,
                          `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

