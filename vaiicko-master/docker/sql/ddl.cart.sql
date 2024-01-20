CREATE TABLE shoppingcarts (
                               id INT PRIMARY KEY AUTO_INCREMENT,
                               session_id VARCHAR(255), -- Identifikátor relácie alebo cookie, ktorý reprezentuje neprihláseného používateľa
                               user_id INT NULL,
                               product_id INT,
                               quantity INT,
                               price DECIMAL(10, 2),
                               created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                               FOREIGN KEY (product_id) REFERENCES products(id),
                               FOREIGN KEY (user_id) REFERENCES users(id)
);
