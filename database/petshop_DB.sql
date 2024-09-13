-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: petshop
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `product_count` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (45,'web-82f7bc1f-8b4d-47a0-9902-ca35b06a6411.webp','Thức ăn hạt Dog Mania cho Chó trưởng thành 1kg',1,50000.00,1,4),(74,'wweb-21f8e72b-a7cf-475a-9fcc-051db613a7a6.webp','Bánh thưởng CATNIP cho mèooo',1,25000.00,2,2);
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_day` date NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Thức ăn thú cưng','Mô tả thức ăn thú cưng','2024-07-01','4ef0a9554b1943e1b54f16d2b1183510.jpg'),(2,'Quần áo thú cưng','Mô tả quần áo thú cưng','2024-07-01','025762ea4f504ee1a8370ca19720ba48.jpeg'),(3,'Khay bát ăn uống','Mô tả khay bát ăn ','2024-07-01','72a67e06014d4ad1abe6ddc23765a231.jpeg'),(4,'Y tế, Thuốc, Dinh dưỡng','Mô tả Y tế, Thuốc, Dinh dưỡng','2024-07-01','ad1b447a4b7a40f0908426e83a1fc704.jpeg'),(5,'Đồ chơi thú cưng','Mô tả đồ chơi thú cưng','2024-07-01','016a0d2ebf3341d4a77ae66deada4056.jpeg'),(6,'Lồng, Balo','Mô tả Lồng, Balo, Túi vận chuyển','2024-07-20','6c4d0f0212294d0cbcdc97f8ae7a98e6.jpeg');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment_product`
--

DROP TABLE IF EXISTS `comment_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment_product` (
  `cmt_id` int(11) NOT NULL AUTO_INCREMENT,
  `content` blob NOT NULL,
  `create_day` date NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`cmt_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  CONSTRAINT `comment_product_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment_product`
--

LOCK TABLES `comment_product` WRITE;
/*!40000 ALTER TABLE `comment_product` DISABLE KEYS */;
INSERT INTO `comment_product` VALUES (1,_binary 'good','2024-08-06',2,2),(2,_binary 'sản phẩm tốt\r\n','2024-08-06',2,2),(3,_binary 'Chất lượng','2024-08-06',8,2),(4,_binary 'dsdsds','2024-08-06',8,2),(7,_binary 'OK','2024-08-06',2,2),(8,_binary 'ok','2024-08-06',2,4);
/*!40000 ALTER TABLE `comment_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice_details` (
  `detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `cancel_reason` text DEFAULT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `invoice_details_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`),
  CONSTRAINT `invoice_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice_details`
--

LOCK TABLES `invoice_details` WRITE;
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
INSERT INTO `invoice_details` VALUES (1,1,3,2,108000.00,NULL),(2,1,4,1,50000.00,NULL),(3,1,5,1,90000.00,NULL),(4,1,9,1,65000.00,NULL),(5,1,10,1,45000.00,NULL),(6,2,7,1,145000.00,NULL),(7,2,2,1,25000.00,NULL),(8,2,19,1,23000.00,NULL),(9,2,21,1,34000.00,NULL),(10,3,6,1,17000.00,NULL),(11,3,7,1,145000.00,NULL),(12,3,4,1,50000.00,NULL),(13,3,2,1,25000.00,NULL),(14,4,3,2,108000.00,NULL),(15,4,4,1,50000.00,NULL),(16,4,5,1,90000.00,NULL),(17,4,8,1,60000.00,NULL),(18,5,3,1,54000.00,NULL),(19,6,3,1,54000.00,NULL);
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `payment_status` enum('online','offline') DEFAULT NULL,
  `created_day` date NOT NULL,
  `total_money` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_status` enum('pending','confirmed','cancelled') NOT NULL DEFAULT 'pending',
  `cancel_reason` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'Lê Nguyên Hùng','0966418674','408 hoàng diệu','online','2024-07-20',358000.00,2,'confirmed',NULL),(2,'Trọng Quân','0366459875','122121','offline','2024-07-20',227000.00,2,'cancelled','deo cho m dat'),(3,'Nguyên Hùng','0905648513','408 hoàng diệu','offline','2024-07-20',237000.00,2,'confirmed',NULL),(4,'Lê Nguyên Hùng','0905648513','408 hoàng diệu','online','2024-07-21',308000.00,2,'confirmed',NULL),(5,'Thích bom hàng','0366459875','tự tìm nhé','offline','2024-07-21',54000.00,2,'cancelled','assadsadasd'),(6,'Lê Nguyên Hùng','0366459875','408 hoàng diệu','online','2024-08-06',54000.00,2,'pending',NULL);
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` blob NOT NULL,
  `created_day` date NOT NULL,
  `price` float NOT NULL,
  `image` varchar(255) NOT NULL,
  `quantity` int(10) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (2,'Bánh thưởng CATNIP cho mèooo',_binary 'BÁNH THƯỞNG CATNIP cho mèo, hỗ trợ tiêu hoá, thư giãn và giảm stress','2024-07-08',25000,'wweb-21f8e72b-a7cf-475a-9fcc-051db613a7a6.webp',49,4),(3,' Que ăn vặt Chicken Cat Grass cho mèo',_binary 'Que ăn vặt Chicken Cat Grass bổ sung cả đạm, chất xơ và chất dinh dưỡng cho mèo.','2024-07-01',54000,'17032024024130_222701.jpg_thumb_300x300.jpg',20,1),(4,'Thức ăn hạt Dog Mania cho Chó trưởng thành 1kg',_binary 'Thức ăn hạt dinh dưỡng cho chó Dog Mania Adult giúp da và lông bóng mượt, thể chất vượt trội. Không chỉ cung cấp nguồn dinh dưỡng toàn...','2024-07-01',50000,'web-82f7bc1f-8b4d-47a0-9902-ca35b06a6411.webp',7,1),(5,'Hạt Kitchen Flavor Cuisine Naples Cheese cho chó con - vị Gà & Phô mai',_binary 'Global Cuisine (ẩm thực toàn cầu) Định nghĩa về thực phẩm dành cho người sành ăn là hoàn toàn khác nhau giữa các quốc gia.','2024-07-01',90000,'shope.webp',31,1),(6,'Sốt kem Tell Me Creamy cho Mèo 85g',_binary '  Pate cho mèo Tellme Creamy dạng xốt 3 vị túi mini 85g phù hợp đưa mèo đi du lịch, thức ăn ướt cho mèo tiện dụng đang là loại pate được nhiều người nuôi mèo tin dùng. Pate cho mèo Tellme...','2024-07-01',17000,'web-ca-hoi-ca-ngu.webp',44,1),(7,'Thức ăn cho Mèo Anh Lông Ngắn',_binary 'Thức ăn cho mèo Royal Canin British Shorthair Adult - dành cho những chú Mèo Anh Lông Ngắn trên 12 tháng tuổi. ','2024-07-01',145000,'web-9f09ce34-be07-4b1c-99cf-e6423426c6ba.webp',21,1),(8,'Áo Cam Cổ Bèo Có Nơ Xinh Xắn',_binary ' Được làm từ chất liệu mềm mại, êm ái, không kích ứng da, phù hợp cho chó mèo yêu nhà bạn,nhiều size cho mọi dòng chó, mèo.','2024-07-01',60000,'339188138-3407116149525883-6162761643820935882-n.webp',16,2),(9,'Áo Bông Đỏ Họa Tiết Thỏ Trắng ',_binary ' Áo bông họa tiết con thỏ được làm từ chất liệu mềm mại, êm ái, không kích ứng da, phù hợp cho chó mèo yêu nhà bạn,nhiều size cho mọi dòng chó, mèo.','2024-07-01',65000,'sg-11134201-7rblq-lnl139hz3xdccf.webp',5,2),(10,'Áo Thun Cam Họa Tiết Gấu Thỏ',_binary ' Áo bông họa tiết con thỏ được làm từ chất liệu mềm mại, êm ái, không kích ứng da, phù hợp cho chó mèo yêu nhà bạn,nhiều size cho mọi dòng chó, mèo.','2024-07-01',45000,'358586746-654215906737511-996552724458310653-n.webp',4,2),(11,'Váy Cam 2 Bông Hoa Xinh Xắn',_binary 'Được làm từ chất liệu mềm mại, êm ái, không kích ứng da, phù hợp cho chó mèo yêu nhà bạn,nhiều size cho mọi dòng chó, mèo.','2024-07-01',40000,'336145599-567632895467844-5385755012873369301-n.webp',11,2),(12,'Tủ Quần Áo Cao Cấp Cho Thú Cưng',_binary 'Tủ quần áo có 1 kích cỡ duy nhất, với thiết kế phù hợp cho việc đựng quần áo và đồ dùng của bé yêu.','2024-07-01',750000,'tu-quan-ao.webp',12,2),(14,'Bát tre đôi hình xương',_binary 'Được sản xuất từ 100% nguyên liệu tre cao cấp, tuyển chọn từng cây tre chất lượng tốt nhất. - An toàn tuyệt đối. - Dễ dàng vệ sinh - Bền, đẹp','2024-07-01',65000,'21687670-1303477133111995-7700641658236866048-n.webp',18,3),(15,'Bình sữa chó mèo con 150ml',_binary 'Bình sữa chó con 150ml','2024-07-01',35000,'4631662488-680009232.webp',22,3),(16,'Bát nhựa đôi hình mèo',_binary 'Bát ăn đôi hình mèo cute cho thú cưng. Dùng để đựng thức ăn, nước uống. Màu sắc đa dạng, giao màu ngẫu nhiên.','2024-07-01',25000,'4333498193-181355791-2ab6668e-39e8-431e-9490-44865378d4dc.webp',33,3),(17,'Khăn Ướt DORRIKEY Lau Mắt & Lau Tai Cho Thú Cưng (130 miếng)',_binary 'Khăn ướt chó mèo Tinh chất lô hội An toàn cho mắt ','2024-07-01',44000,'vn-11134201-23020-zukkuhs5prnvd8.webp',24,4),(18,'Thuốc nhỏ tai Vemedim đặc trị viêm tai ngoài cho chó mèo 10 ml ',_binary 'Thuốc nhỏ tai Vemedim đặc trị viêm tai ngoài cho chó mèo 10 ml  CÔNG DỤNG:  Đặc trị viêm tai ngoài do vi khuẩn và nấm gây ra ở chó mèo. Chống chỉ định :  Không dùng cho chó mèo bị thủng màng nhĩ.  Không...','2024-07-01',20000,'wweb-21f8e72b-a7cf-475a-9fcc-051db613a7a6.webp',31,4),(19,'Gel cung cấp vitamin hỗ trợ miễn dịch cho mèo 50g',_binary 'Khối lượng: 50gr Gel dinh dưỡng vị phô mai giúp lông da bóng mượt, móng săn chắc cho mèo Sản...','2024-07-01',23000,'192728438-3825406427585707-6158234947733842369-n.webp',54,4),(20,'Canxi Delice lẻ 10 viên - Bổ sung Canxi & Khoáng chất cho thú cưng',_binary 'Canxi Pháp Calci Delice Virbac - Bổ sung Canxi và khoáng chất thiết yếu ','2024-07-01',33000,'c3b8c8166c905b24f74452fa732528dc.webp',19,4),(21,'Đồ chơi nhồi bông có âm thanh cho thú cưng',_binary 'Đồ chơi chút chít nhồi bông phù hợp với tất cả các bạn chó ở mọi lứa tuổi, mọi giống, dù trai hay gái ạ. ✓ Giúp thú cưng thư giãn, vui vẻ ✓ Luyện răng cho đỡ ngứa, đỡ cắn đồ...','2024-07-01',34000,'web-a072adce-2a23-4480-9b7a-751cd7b7467a.webp',6,5),(22,'Đồ chơi cho chó vải bện',_binary 'Kiểu dáng:  Cà rốt, xương vải, tay cầm bóng vải, xương bóng 2 đầu - Dây bện thừng có nhiều màu sắc, mẫu mã và kích thước đa dạng. - Được sản xuất từ những sợi dây bông nhiều màu, dây dù...','2024-07-01',15000,'z3051661724893-b8955e3173225a114cfc609cb4eef661.webp',11,5),(23,'Bóng gai nhiều màu',_binary 'Bóng tròn âm thanh -25k','2024-07-01',25000,'d3aa95643e324c3a8d62c50fe8805d74.jpg',33,5),(24,'Lồng vận chuyển size nhỏ 48x30x30cm',_binary 'Lồng vận chuyển size nhỏ 48x30x30cm','2024-07-01',320000,'6c4d0f0212294d0cbcdc97f8ae7a98e6.jpeg',10,6),(25,'Balo phi hành gia',_binary 'Balo phi hành gia','2024-07-01',225000,'30faa8ed100b4ef2baa1d0ea2e4b25c2.jpeg',5,6),(26,'Đồ chơi Kem chút chít 10cm',_binary 'Đồ chơi Kem chút chít 10cm','2024-07-02',10000,'a188ab62f4074c2183ee278f828c12eb.jpeg',12,5);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Lê Nguyên Hùng','admin','admin','nguyenhungitt@gmail.com','0966418674','2024-07-19','male','h6-team-2.jpg','admin'),(2,'Lê Nguyên Hùng','user','070601','nguyenhungit@gmail.com','0905648513','2024-07-28','male','h6-team-2.jpg','user'),(8,'văn bèo','vanbeo','11111','vanbeo@gmail.com','0365489751','2024-07-18','female','img-forgot-pass.jpg','user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-06 16:12:25
