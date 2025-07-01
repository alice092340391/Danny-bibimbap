-- 創建菜單表
CREATE TABLE Menus (
    MenuID INT PRIMARY KEY AUTO_INCREMENT,
    MenuName NVARCHAR(50),
    Price DECIMAL(10, 2)
);

-- 創建基底選項表
CREATE TABLE BaseChoices (
    BaseID INT PRIMARY KEY AUTO_INCREMENT,
    MenuID INT,
    BaseName NVARCHAR(50),
    FOREIGN KEY (MenuID) REFERENCES Menus(MenuID)
);

-- 創建配料選項表
CREATE TABLE SideChoices (
    SideID INT PRIMARY KEY AUTO_INCREMENT,
    MenuID INT,
    SideName NVARCHAR(50),
    AdditionalPrice DECIMAL(10, 2),
    FOREIGN KEY (MenuID) REFERENCES Menus(MenuID)
);

-- 創建蛋白質選項表
CREATE TABLE ProteinChoices (
    ProteinID INT PRIMARY KEY AUTO_INCREMENT,
    MenuID INT,
    ProteinName NVARCHAR(50),
    AdditionalPrice DECIMAL(10, 2),
    FOREIGN KEY (MenuID) REFERENCES Menus(MenuID)
);

-- 創建醬料選項表
CREATE TABLE SauceChoices (
    SauceID INT PRIMARY KEY AUTO_INCREMENT,
    MenuID INT,
    SauceName NVARCHAR(50),
    FOREIGN KEY (MenuID) REFERENCES Menus(MenuID)
);

-- 創建撒料選項表
CREATE TABLE SprinkleChoices (
    SprinkleID INT PRIMARY KEY AUTO_INCREMENT,
    MenuID INT,
    SprinkleName NVARCHAR(50),
    FOREIGN KEY (MenuID) REFERENCES Menus(MenuID)
);

-- 創建飲料選項表
CREATE TABLE DrinkChoices (
    DrinkID INT PRIMARY KEY AUTO_INCREMENT,
    MenuID INT,
    DrinkName NVARCHAR(50),
    DrinkPrice DECIMAL(10, 2),
    FOREIGN KEY (MenuID) REFERENCES Menus(MenuID)
);

-- 插入菜單數據
INSERT INTO Menus (MenuName, Price) VALUES 
('豪華波奇', 360),
('素食波奇', 260),
('簡單波奇', 230);

-- 插入基底選項數據
INSERT INTO BaseChoices (MenuID, BaseName) VALUES 
(1, '生菜'),
(1, '紫米'),
(1, '各半');

-- 插入配料選項數據
INSERT INTO SideChoices (MenuID, SideName, AdditionalPrice) VALUES 
(1, '毛豆仁', 0),
(1, '花椰菜', 0),
(1, '水煮蛋', 0),
(1, '鷹嘴豆', 0),
(1, '小番茄', 0),
(1, '秋葵', 0),
(1, '玉米粒', 0),
(1, '小黃瓜', 0),
(1, '地瓜泥', 0),
(1, '紫薯泥', 20),
(1, '海帶絲', 0),
(1, '洋蔥', 0),
(1, '玉子燒', 0),
(1, '杏鮑菇', 0),
(1, '黑豆', 0),
(1, '玉米筍', 0),
(1, '黃金泡菜', 0);

-- 插入蛋白質選項數據
INSERT INTO ProteinChoices (MenuID, ProteinName, AdditionalPrice) VALUES 
(1, '無蛋白質', 0),
(1, '鮭魚', 70),
(1, '豆腐', 50),
(1, '鮮蝦', 70),
(1, '章魚', 70),
(1, '鮪魚', 70);

-- 插入醬料選項數據
INSERT INTO SauceChoices (MenuID, SauceName) VALUES 
(1, '辣美乃滋'),
(1, '墨西哥辣醬'),
(1, '和風胡麻醬'),
(1, '柚香甜醬油'),
(1, '義式油醋醬'),
(1, '不需要醬料');

-- 插入撒料選項數據
INSERT INTO SprinkleChoices (MenuID, SprinkleName) VALUES 
(1, '黑芝麻'),
(1, '核桐麥'),
(1, '七味粉'),
(1, '香鬆'),
(1, '海苔絲'),
(1, '蒜酥');

-- 插入飲料選項數據
INSERT INTO DrinkChoices (DrinkID, MenuID, DrinkName, DrinkPrice) VALUES 
(1, 1, '四季春冷泡茶', 38),
(2, 1, '柚香清茶', 38),
(3, 1, '無糖豆漿', 20),
(4, 1, '紅茶', 25);
