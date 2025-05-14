-- Tạo bảng ServiceType
CREATE TABLE ServiceType (
    servicetype_id INT PRIMARY KEY,
    name VARCHAR(255),
    description TEXT
);

-- Tạo bảng Service, có khóa ngoại đến bảng ServiceType
CREATE TABLE Service (
    service_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2),
    original_price DECIMAL(10,2),
    duration INT,
    servicetype_id INT,
    FOREIGN KEY (servicetype_id) REFERENCES ServiceType(servicetype_id)
);
