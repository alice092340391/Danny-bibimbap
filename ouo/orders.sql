CREATE TABLE orders (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerName VARCHAR(100),
    DishName VARCHAR(100),
    Quantity INT,
    TotalPrice DECIMAL(10, 2),
    Status VARCHAR(50)
);
