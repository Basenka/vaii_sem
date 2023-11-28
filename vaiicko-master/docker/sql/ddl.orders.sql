CREATE TABLE `Orders` (
                          `id` int(150) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                          `user_id` int(150) NOT NULL,
                          `plant_id` int(150) NOT NULL,
                          `quantity` int(50) NOT NULL,
                          `date` timestamp NOT NULL
);

ALTER TABLE Orders
    ADD CONSTRAINT fk_user
        FOREIGN KEY (user_id) REFERENCES Users(id),
    ADD CONSTRAINT fk_plant
        FOREIGN KEY (plant_id) REFERENCES Plants(id);

