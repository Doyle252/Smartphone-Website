-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 20, 2025 at 10:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `new_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`new_id`, `title`, `author`, `content`, `image`, `link`) VALUES
(1, 'Iphone lừng lẫy một thời nay giá giảm mạnh, hiệu năng vẫn tốt', 'Phan Hoàng', '\"Ra mắt cách đây gần 4 năm nhưng iPhone 12 vẫn là một trong những chiếc điện thoại được người dùng ưa chuộng.\"', 'Iphone12.webp', 'https://www.24h.com.vn/thoi-trang-hi-tech/iphone-lung-lay-mot-thoi-nay-gia-giam-manh-hieu-nang-van-tot-c407a1586180.html'),
(2, 'Galaxy Z Fold 6 và iPhone 15 Pro Max: Đâu mới là “ngôi vương”?', 'Khánh Linh', 'Galaxy Z Fold 6 đã chính thức ra mắt người dùng và trở thành “đối thủ” đáng gờm của iPhone 15 Pro Max trong \"cuộc chiến\" giữ ngôi đầu bảng trên thị trường smartphone cao cấp.\"', 'Samsung Z Fold6 & IP15.png', 'https://www.24h.com.vn/thoi-trang-hi-tech/galaxy-z-fold-6-va-iphone-15-pro-max-dau-moi-la-ngoi-vuong-c407a1587888.html'),
(3, 'iPhone màn hình gập sẽ xuất hiện vào 2 năm tới, hoặc là khum', 'Trần Vy', '&#34;Theo báo cáo mới nhất, chiếc iPhone màn hình gập đầu tiên sẽ ra mắt vào năm 2026 với thiết kế giống Galaxy Z Flip của Samsung.&#34;', 'Iphone Flip.jpg', 'https://www.24h.com.vn/thoi-trang-hi-tech/iphone-man-hinh-gap-se-xuat-hien-vao-2-nam-toi-c407a1588153.html'),
(4, 'Trình làng \"siêu phẩm\" Nubia Z60s Pro và Z60 Ultra với pin 6000 mAh, giá từ 14,4 triệu đồng', 'Trần Vy', '\"Cặp smartphone Nubia Z60S Pro và Nubia Z60 Ultra mới cùng được tích hợp chip cực mạnh, thiết kế ấn tượng và có giá không quá cao.\"', 'Nubia Z60 Ultra.jpg', 'https://www.24h.com.vn/thoi-trang-hi-tech/trinh-lang-sieu-pham-nubia-z60s-pro-va-z60-ultra-voi-pin-6000-mah-gia-tu-144-trieu-dong-c407a1588433.html'),
(6, 'Very Nice', 'Nguyễn Trương Sang', 'Sleep', '454320762_516884694188561_8760633569957706147_n.jpg', 'https://www.youtube.com/watch?v=jN9nAtg-fHU');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'Đang xử lý',
  `order_items` varchar(1000) NOT NULL,
  `item_amounts` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `order_items`, `item_amounts`) VALUES
(56, 8, 'Nguyen Trong Thai', '0903901293', 'trongthuan321@gmail.com', 'Thanh toán khi nhận hàng', 'Phường 2e1231,Quận 1321, Thành Phố 312321, Đường 3123, Nước Vietnam - 312312', 'Xiaomi 13 Pro (1200 x 1) - Apple Iphone 12 Pro Max (1200 x 1) - ', 2400, '2025-09-20', 'Đã giao hàng', ',Xiaomi 13 Pro,Apple Iphone 12 Pro Max', ',1,1');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL,
  `anHien` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 là ẩn, 1 là hiện'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`, `anHien`) VALUES
(14, 'Apple Iphone 12 Pro Max', 'Kích thước: 146.7 x 71.5 x 7.4mm\r\nKhối lượng: 187g\r\nChip A14 Bionic\r\nRAM: 6GB\r\nBộ nhớ trong: 128GB/256GB/512GB', 1200, 'iPhone-12-Zach-Griff-8_large_large_large_large.jpeg', 'gsmarena_043.jpg', 'OIP (1).jfif', 1),
(16, 'Xiaomi 13 Pro', 'Màn hình: 6.73 inch, 120Hz, 2K\r\nTấm nền: LTPO OLED\r\nCamera trước: 32MP\r\nCamera sau: 50MP/50MP/50MP\r\nChip: Snapdragon 8 Gen 2', 1200, 'Xiaomi-13-Pro_featured-image-packshot-review-Recovered.jpg', 'Xiaomi_13-8.jpeg', 'Xiaomi-13-1670503329-0-0.webp', 1),
(17, 'Xiaomi 12S Ultra', 'Màn hình : AMOLED 6.73″ + 120Hz Hệ điều hành : MIUI 13 Chipset : Qualcomm Snapdragon 8+ Gen 1 GPU : Adreno 730 Camera trước : 32MP Camera sau : 50MP + 48MP + 48MP Chất lượng Video: 8K Pin : 4860mAh', 1000, 'R.jfif', 'Xiaomi_12S_Ultra54-e1659035162943-1020x706.jpg', '6044327_image.webp', 1),
(18, 'Oppo Reno 10', 'Oppo Reno 10 được trang bị màn hình AMOLED cong hỗ trợ tần số quét 120Hz1. Máy có cảm biến tele độ phân giải 32MP cùng với các cảm biến khác12. Thiết bị đi kèm với 8GB RAM và 256GB bộ nhớ trong13. Oppo Reno 10 hỗ trợ sạc nhanh SuperVOOC với công suất 67W1. Máy có màn hình 6.7 inch, sử dụng tấm nền OLED và có độ phân giải full HD+2. Oppo Reno 10 sẽ được cung cấp với các tùy chọn màu: Vàng, Xanh sặc sỡ và Đen Moonsea3.', 600, 'OIP.jfif', 'OIP (1).jfif', 'OIP (2).jfif', 1),
(19, 'Oppo A78', 'Hệ điều hành Android 12 ColorOS 14\r\nMàn hình 6.56 inch 720x1612 pixel\r\nPin 5000 mAh Li-Poly\r\nHiệu suất 4/8GB RAM Dimensity 700\r\nCamera 50MP 1080p', 1300, 'OIP (3).jfif', '51jGptxULlL._AC_SL1500_.jpg', 'my-11134207-23010-oroeqeueo4lv0b.jfif', 1),
(20, 'Realme 11 Pro', 'Realme 11 Pro được trang bị Màn hình tầm nhìn cong 120Hz, Camera OIS ProLight 100MP, Thiết kế da thuần chay cao cấp, Chipset Dimensity 7050 5G, Sạc SUPERVOOC 67W Pin lớn 5000mAh², Loa kép Dolby Atmos Chứng nhận âm thanh Hi-Res, RAM &ROM lớn 12 + 256GB và giao diện người dùng realme 4.0', 800, 'OIP (4).jfif', 'OIP (5).jfif', 'realme-11-pro-plus.jpg', 0),
(21, 'Lenovo Z5', 'Hệ điều hành Android 8.1 ZUI 3.9\r\nMàn hình 6.2 inch 1080x2246 pixel\r\nPin 3300 mAh Li-Ion\r\nHiệu suất 6GB RAM Snapdragon 636\r\nCamera 16MP 2160p', 650, '59fa02c3e979e4244184abdfb724af3f.jfif', 'OIP.jfif', 'Lenovo-Z5-Pro-GT-2.webp', 1),
(22, 'Lenovo Legion Y70', 'Màn hình: Kích thước 6.67 inch, tấm nền OLED, độ phân giải Full HD+, tần số quét 144 Hz. CPU: Snapdragon 8+ Gen 1. RAM: 8 GB, 12 GB, 16 GB. Bộ nhớ trong: 128 GB, 256GB, 512 GB. Camera sau: 50 MP + 13 MP + 2 MP. Camera selfie: 16 MP. Pin: 5.100 mAh, sạc nhanh 68 W.', 1150, 'OIP (1).jfif', 'lenovo-legion-y70-gia-re-5.jpg', 'lenovo-legion-y70-8.jpg.webp', 1),
(23, 'Asus Rog Phone 7', 'Màn hình: 6.78″ AMOLED Camera sau: 5MP, 13MP, 50MP Camera trước: 12MP CPU: Qualcomm Snapdragon 8+ Gen 1 Bộ nhớ: 256GB RAM: 12GB', 1400, 'R.jfif', 'OIP (2).jfif', 'R (1).jfif', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `reset_token` varchar(64) NOT NULL,
  `reset_expire` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `reset_token`, `reset_expire`) VALUES
(8, 'Nguyễn Trọng Thái', 'thainguyen2522004@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`new_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `new_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
