CREATE TABLE `orders` (
                          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                          `user_id` INT NULL,
                          `date` TIMESTAMP NOT NULL,
                          `total_price` INT NOT NULL,
                          `status` VARCHAR(50) NOT NULL DEFAULT 'Processing',
                          FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

CREATE TABLE `orderitems` (
                               `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                               `order_id` INT NULL,
                               `product_id` INT NOT NULL,
                               `quantity` INT NOT NULL,
                               `unit_price` INT NOT NULL,
                               FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`),
                               FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)
);
