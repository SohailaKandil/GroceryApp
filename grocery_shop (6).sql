-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2023 at 02:11 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grocery_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `brand_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(20, 'Adidas'),
(70, 'Air Arabia'),
(59, 'Al Ahram'),
(45, 'Al Jazeera'),
(65, 'Al-Futtaim'),
(51, 'Almarai'),
(22, 'Amazon'),
(17, 'Apple'),
(47, 'Aramex'),
(69, 'Bank Misr'),
(5, 'Barilla'),
(61, 'Bateel'),
(6, 'Bibigo'),
(8, 'Brigadeiro Bakery'),
(19, 'Coca-Cola'),
(38, 'Colgate'),
(66, 'Dallah Al-Baraka'),
(13, 'egypt foods'),
(60, 'Emaar'),
(49, 'Emirates Airlines'),
(46, 'Etisalat'),
(28, 'Facebook'),
(35, 'General Electric'),
(27, 'Google'),
(39, 'H&M'),
(7, 'Haribo'),
(30, 'Honda'),
(14, 'Hostess'),
(36, 'IBM'),
(33, 'Intel'),
(53, 'Jazeera Paints'),
(1, 'Juhayna'),
(64, 'Jumeirah'),
(3, 'Kellogg\'s'),
(68, 'Kuwait Airways'),
(43, 'Lamborghini'),
(9, 'Lindt'),
(41, 'LOreal'),
(31, 'Louis Vuitton'),
(48, 'MBC'),
(32, 'McDonald\'s'),
(29, 'Mercedes-Benz'),
(23, 'Microsoft'),
(57, 'Mobily'),
(34, 'Nestlé'),
(40, 'Netflix'),
(16, 'Nike'),
(58, 'Oman Air'),
(63, 'Oman Oil'),
(50, 'Ooredoo'),
(26, 'Pepsi'),
(37, 'Procter & Gamble'),
(56, 'Qatar Airways'),
(71, 'QNB Group'),
(44, 'Rolls-Royce'),
(54, 'Rotana'),
(21, 'Samsung'),
(67, 'Savola Group'),
(24, 'Sony'),
(52, 'STC'),
(4, 'Sushi Samba'),
(25, 'Tesla'),
(18, 'Toyota'),
(10, 'Vegemite'),
(42, 'Volkswagen'),
(11, 'Want Want'),
(55, 'Zain');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'alaa', 'alaa.moheb@ejust.edu.eg', 'Hi! , I am  testing', '2023-12-23 21:38:17'),
(2, 'manhal', 'sohaila.kandil@ejust.edu.eg', 'i love palestine', '2023-12-26 20:51:29'),
(3, 'sohaila', 'sohaila.kandil@ejust.edu.eg', 'i am wondering about haribo price', '2023-12-28 17:20:40');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ordering_address` varchar(255) DEFAULT NULL,
  `order_date` date DEFAULT curdate(),
  `order_phone` varchar(12) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `discount` int(11) DEFAULT 0,
  `brand_id` int(11) NOT NULL,
  `exp_date` date NOT NULL,
  `product_image` varchar(400) DEFAULT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `discount`, `brand_id`, `exp_date`, `product_image`, `amount`) VALUES
(27, 'haribo caramel', 10, 0, 7, '2024-01-08', 'IMG-658d17ebd02552.09378407.jpg', 20),
(30, 'bibigo hot', 14, 0, 6, '2024-04-04', 'IMG-658d196e44a0c0.95416014.jpg', 23),
(122, 'Milk', 12, 0, 16, '2028-04-20', 'milk.jpg', 28),
(123, 'Oscar Ice Cream', 18, 0, 17, '2028-05-05', 'oscar_ice_cream.jpg', 42),
(124, 'Pampers', 5, 10, 16, '2028-06-15', 'pampers.png', 55),
(125, 'Pantene Shampoo', 8, 0, 17, '2028-07-01', 'pantene_shampoo.jpg', 40),
(126, 'Rusky Toast', 12, 0, 16, '2028-08-12', 'rusky_toast.jpg', 28),
(127, 'Soap Marrocan', 10, 5, 17, '2028-09-25', 'soap_marrocan.jpg', 33),
(130, 'Sunny Plast Icecream', 12, 0, 16, '2028-12-03', 'sunny_plast_icecream.jpg', 30),
(131, 'Tiger Egyptian Chips', 15, 0, 17, '2029-01-15', 'tiger_egyptian_chips.jpg', 22),
(132, 'Twinkees', 10, 5, 16, '0000-00-00', 'twinkees.png', 35),
(133, 'Vegimete', 8, 0, 17, '2029-03-12', 'vegimete.jpg', 40),
(134, 'Bibigo3', 12, 0, 16, '2027-04-20', 'bibigo3.jpg', 28),
(135, 'Bibigo4', 18, 0, 17, '2027-05-05', 'bibigo4.jpg', 42),
(136, 'Biscuit', 5, 10, 16, '2027-06-15', 'biscuit.jpg', 55),
(137, 'Bravo Egyptian Chips', 8, 0, 17, '2027-07-01', 'bravo_egyptian_chips.jpg', 40),
(138, 'Dove Shampoo', 12, 0, 16, '2027-08-12', 'dove_shampoo.jpg', 28),
(139, 'Dream Cake', 10, 5, 17, '2027-09-25', 'dream_cake.jpg', 33),
(140, 'Friday Icecream', 18, 0, 16, '2027-10-10', 'friday_icecream.jpg', 25),
(141, 'Golden Strand Shampoo', 7, 0, 17, '2027-11-18', 'golden_strand_shampoo.jpg', 48),
(142, 'Hohos', 12, 0, 16, '2027-12-03', 'hohos.jpg', 30),
(143, 'IMG Product', 15, 0, 17, '2028-01-15', 'IMG-658e0fd7267727.53764976.jpg', 22),
(144, 'Johnson Shampoos', 10, 5, 16, '2028-02-29', 'johnson_shampoos.png', 35),
(145, 'Juice', 8, 0, 17, '2028-03-12', 'juice.jpg', 40),
(146, 'Salad Dressing', 12, 0, 16, '2026-04-20', 'salad_dressing.jpg', 28),
(147, 'Salsa Sauce', 18, 0, 17, '2026-05-05', 'salsa_sauce.jpg', 42),
(148, 'Spaghetti', 5, 10, 16, '2026-06-15', 'spaghetti.jpg', 55),
(149, 'Sriracha Sauce', 8, 0, 17, '2026-07-01', 'sriracha_sauce.jpg', 40),
(150, 'Sunflower Seeds', 12, 0, 16, '2026-08-12', 'sunflower_seeds.jpg', 28),
(151, 'Sweet Potato Chips', 10, 5, 17, '2026-09-25', 'sweet_potato_chips.jpg', 33),
(152, 'Tomato Sauce', 18, 0, 16, '2026-10-10', 'tomato_sauce.jpg', 25),
(153, 'Trail Mix', 7, 0, 17, '2026-11-18', 'trail_mix.jpg', 48),
(154, 'Turmeric Powder', 12, 0, 16, '2026-12-03', 'turmeric_powder.jpg', 30),
(155, 'Vanilla Extract', 15, 0, 17, '2027-01-15', 'vanilla_extract.jpg', 22),
(156, 'Vegetable Oil', 10, 5, 16, '0000-00-00', 'vegetable_oil.jpg', 35),
(157, 'Walnuts', 8, 0, 17, '2027-03-12', 'walnuts.jpg', 40),
(158, 'Pantene Shampoo', 22, 0, 16, '2024-04-20', 'pantene_shampoo.jpg', 48),
(159, 'Rusky Toast', 30, 0, 17, '2024-05-05', 'rusky_toast.jpg', 18),
(160, 'Soap Marrocan', 5, 10, 16, '2024-06-15', 'soap_marrocan.jpg', 55),
(163, 'Sunny Plast Icecream', 10, 5, 17, '2024-09-25', 'sunny_plast_icecream.jpg', 33),
(164, 'Tiger Egyptian Chips', 18, 0, 16, '2024-10-10', 'tiger_egyptian_chips.jpg', 25),
(165, 'Twinkees', 7, 0, 17, '2024-11-18', 'twinkees.png', 48),
(166, 'Vegimete', 12, 0, 16, '2024-12-03', 'vegimete.jpg', 30),
(167, 'Vegimete2', 15, 0, 17, '2025-01-15', 'vegimete2.png', 22),
(168, 'Want Want', 10, 5, 16, '0000-00-00', 'want_want.jpg', 35),
(169, 'Wave Biscuit Morrocoian', 8, 0, 17, '2025-03-12', 'wave_biscuit_morrocoian.jpg', 40),
(170, 'American Garden Peanut Butter', 5, 0, 16, '2023-01-29', 'american_garden_peanut_butter.jpg', 40),
(171, 'Bibigo3', 10, 0, 17, '2023-02-15', 'bibigo3.jpg', 30),
(172, 'Bibigo4', 8, 5, 16, '2023-03-10', 'bibigo4.jpg', 50),
(173, 'Biscuit', 15, 0, 17, '2023-04-20', 'biscuit.jpg', 45),
(174, 'Bravo Egyptian Chips', 12, 0, 16, '2023-05-05', 'bravo_egyptian_chips.jpg', 35),
(175, 'Dove Shampoo', 25, 0, 17, '2023-06-15', 'dove_shampoo.jpg', 20),
(176, 'Dream Cake', 6, 10, 16, '2023-07-01', 'dream_cake.jpg', 60),
(177, 'Friday Ice Cream', 18, 0, 17, '2023-08-12', 'friday_icecream.jpg', 25),
(178, 'Golden Strand Shampoo', 9, 0, 16, '2023-09-25', 'golden_strand_shampoo.jpg', 38),
(179, 'Hohos', 12, 5, 17, '2023-10-10', 'hohos.jpg', 42),
(180, 'Johnson Shampoos', 15, 0, 16, '2023-11-18', 'johnson_shampoos.png', 28),
(181, 'Juice', 8, 0, 17, '2023-12-03', 'juice.jpg', 50),
(182, 'Milk', 20, 0, 16, '2024-01-15', 'milk.jpg', 15),
(188, 'Meatballs', 10, 5, 38, '2027-09-25', 'meatballs.jpg', 33),
(190, 'Dates from UAE', 7, 0, 45, '2027-11-18', 'dates.jpg', 48),
(194, 'Swiss Chocolate', 8, 0, 33, '2028-03-12', 'chocolate.jpg', 40),
(195, 'Cairo Spice Blend', 15, 5, 58, '2027-04-20', 'egyptian_product1.jpg', 30),
(196, 'Nile Valley Honey', 20, 0, 58, '2027-05-05', 'egyptian_product2.jpg', 25),
(197, 'Desert Rose Perfume', 18, 0, 50, '2027-10-10', 'saudi_product1.jpg', 22),
(198, 'Arabian Nights Incense', 12, 0, 50, '2027-11-18', 'saudi_product2.jpg', 35),
(203, 'Bravo Egyptian Chips', 25, 10, 58, '2023-12-31', 'bravo_egyptian_chips.jpg', 50),
(210, 'Johnson Shampoos', 28, 8, 61, '2023-07-25', 'johnson_shampoos.png', 22),
(219, 'Johnson Shampoos', 28, 8, 61, '2023-07-25', 'johnson_shampoos.png', 22),
(224, 'Bravo Egyptian Chips', 25, 10, 58, '2023-12-31', 'bravo_egyptian_chips.jpg', 50),
(226, 'shamedan wafer biscuit', 28, 8, 13, '2022-12-15', 'shamedan wafer egyptian.jpg', 22),
(227, 'spero spites lemon', 28, 8, 13, '2022-12-15', 'spero spytes lemon egyptian.jpg', 22),
(228, 'juhayna milk', 28, 8, 13, '2022-12-15', 'milk.jpg', 22),
(229, 'twinkees arabic', 28, 8, 45, '2022-12-15', 'twinkees.png', 22),
(230, 'arabic vegimite', 28, 8, 5, '2022-12-15', 'vegimete.jpg', 22);

-- --------------------------------------------------------

--
-- Table structure for table `purchasing_cart`
--

CREATE TABLE `purchasing_cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ordering_address` varchar(255) DEFAULT NULL,
  `order_date` date DEFAULT curdate(),
  `order_phone` varchar(12) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shareholders`
--

CREATE TABLE `shareholders` (
  `shareholder_id` int(11) NOT NULL,
  `shareholder_name` varchar(255) DEFAULT NULL,
  `nationality` enum('egypt','algeria','morocco','saudi_arabia','qatar','jordan','lebanon','iraq','tunisia','kuwait','bahrain','oman','syria','yemen','pakistan','india','usa','china','brazil') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shareholders`
--

INSERT INTO `shareholders` (`shareholder_id`, `shareholder_name`, `nationality`) VALUES
(1, 'Ali Hassan', 'egypt'),
(3, 'Fatima Khaldi', 'algeria'),
(4, 'Mehdi Benhaddou', 'morocco'),
(5, 'Noura Al Saud', 'saudi_arabia'),
(6, 'Khalid Al Thani', 'qatar'),
(7, 'Lina Abu-Hassan', 'jordan'),
(8, 'Fadi Nasrallah', 'lebanon'),
(9, 'Zainab Al-Maliki', 'iraq'),
(10, 'Hassan Ben Ali', 'tunisia'),
(11, 'Fatima Al Sabah', 'kuwait'),
(12, 'Ali Mansoor', 'bahrain'),
(13, 'Salim Al Riyami', 'oman'),
(14, 'Layla Khoury', 'syria'),
(15, 'Abdul Rahman Al Hadi', 'yemen'),
(16, 'Sana Malik', 'pakistan'),
(17, 'Raj Patel', 'india'),
(18, 'Emily Johnson', 'usa'),
(19, 'Li Wei', 'china'),
(20, 'Ana Silva', 'brazil'),
(21, 'emily jonson', 'usa'),
(23, 'Michael Johnson', 'usa'),
(24, 'Steve Jobs', 'usa'),
(25, 'Yoshida Tanaka', ''),
(26, 'Elizabeth Rodriguez', 'usa'),
(27, 'Hans Schmidt', ''),
(28, 'Ji-hoon Park', ''),
(29, 'Jeff Bezos', 'usa'),
(30, 'Bill Gates', 'usa'),
(31, 'Akihiko Kikumura', ''),
(32, 'Elon Musk', 'usa'),
(33, 'Samantha Thompson', 'usa'),
(34, 'Larry Page', 'usa'),
(35, 'Mark Zuckerberg', 'usa'),
(36, 'Anna Müller', ''),
(37, 'Kenji Nakamura', ''),
(38, 'Sophie Leclerc', ''),
(39, 'John McDonald', 'usa'),
(40, 'Robert Johnson', 'usa'),
(41, 'Elena Müller', ''),
(42, 'David Smith', 'usa'),
(43, 'Karen Williams', 'usa'),
(44, 'Jennifer Davis', 'usa'),
(45, 'Christopher Brown', 'usa'),
(46, 'Emma Lindgren', ''),
(47, 'Melissa Taylor', 'usa'),
(48, 'Antoine Martin', ''),
(49, 'Hans Becker', ''),
(50, 'Giovanni Rossi', ''),
(51, 'Emma Jones', ''),
(52, 'Mohammed Al-Maktoum', 'qatar'),
(53, 'Fatima Ahmed', ''),
(54, 'Rami Al-Mansour', 'jordan'),
(55, 'Khaled Al-Faisal', ''),
(56, 'Sheikh Abdullah', ''),
(57, 'Laila Al-Thani', 'qatar'),
(58, 'Abdulaziz Al-Khateeb', ''),
(59, 'Noura Al-Saud', ''),
(60, 'Yousef Al-Muhanna', ''),
(61, 'Ahmad Al-Jaber', ''),
(62, 'Hassan Al-Husseini', 'kuwait'),
(63, 'Fatima Al-Thani', 'qatar'),
(64, 'Fahad Al-Dhaheri', ''),
(65, 'Salim Al-Maskari', 'oman'),
(66, 'Aisha Abdel-Rahman', 'egypt'),
(67, 'Mohammed Al-Abdullah', ''),
(68, 'Sara Al-Ghamdi', ''),
(69, 'Faisal Al-Khalaf', ''),
(70, 'Sultan Al-Hajri', 'oman'),
(71, 'Fatima Al-Mazrouei', ''),
(72, 'Ahmed Al-Futtaim', ''),
(73, 'Hassan Al-Mubarak', ''),
(74, 'Lina Al-Saleh', ''),
(75, 'Abdullah Al-Rashid', 'kuwait'),
(76, 'Youssef Al-Masri', 'egypt'),
(77, 'Rashid Al-Mansoori', ''),
(78, 'Hassan Al-Thani', 'qatar');

-- --------------------------------------------------------

--
-- Table structure for table `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shopping_cart`
--

INSERT INTO `shopping_cart` (`user_id`, `product_id`) VALUES
(8, 124),
(8, 132),
(8, 136);

-- --------------------------------------------------------

--
-- Table structure for table `stakeholding`
--

CREATE TABLE `stakeholding` (
  `shareholders_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stakeholding`
--

INSERT INTO `stakeholding` (`shareholders_id`, `brand_id`) VALUES
(1, 1),
(1, 3),
(1, 5),
(1, 11),
(1, 13),
(3, 4),
(4, 5),
(4, 10),
(5, 6),
(6, 7),
(7, 8),
(8, 9),
(9, 10),
(10, 11),
(15, 8),
(15, 13),
(17, 4),
(17, 6),
(18, 7),
(19, 6),
(21, 14),
(23, 16),
(24, 17),
(25, 18),
(26, 19),
(27, 20),
(28, 21),
(29, 22),
(30, 23),
(31, 24),
(32, 25),
(33, 26),
(34, 27),
(35, 28),
(36, 29),
(37, 30),
(38, 31),
(39, 32),
(40, 33),
(41, 34),
(42, 35),
(43, 36),
(44, 37),
(45, 38),
(46, 39),
(47, 40),
(48, 41),
(49, 42),
(50, 43),
(51, 44),
(52, 45),
(53, 46),
(54, 47),
(55, 48),
(56, 49),
(57, 50),
(58, 51),
(59, 52),
(60, 53),
(61, 54),
(62, 55),
(63, 56),
(64, 57),
(65, 58),
(66, 59),
(67, 60),
(70, 63),
(71, 64),
(72, 65),
(73, 66),
(74, 67),
(75, 68),
(76, 69),
(77, 70);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `rule` enum('user','manager') DEFAULT 'user',
  `user_password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `phone`, `address`, `rule`, `user_password`) VALUES
(1, 'manhal', '1210422357', 'alexandria', 'user', '1234'),
(4, 'manhal_anwar', '1210422357', 'alexandria', 'user', '1234'),
(5, 'hadil', '1210422358', 'alexandria', 'user', '1234'),
(7, 'hadil_anwar', '1210422358', 'alexandria', 'user', '12345'),
(8, 'sohaila', '1210422357', 'alexandria', 'manager', '1234'),
(9, 'hadel', '01210422358', 'alexandria', 'user', '1234'),
(16, 'mohannad', '01210422358', 'alexandria', 'user', '1234'),
(18, 'anwar', '01210422357', 'alexandria', 'user', '1234'),
(19, 'anwaar', '01210422357', 'alexandria', 'user', '1234'),
(28, 'aseel', '01210422357', 'portsaid', 'user', '12345'),
(29, 'Essam-123', '01210422357', 'alexandria', 'user', '1234'),
(31, 'andalus', '01210422358', 'portsaid', 'user', '1234'),
(32, 'hadola', '01210422357', 'alexandria', 'user', '1234'),
(34, 'qassam', '01210422358', 'portsaid', 'user', '1234'),
(35, 'qassamo', '01210422358', 'portsaid', 'user', '1234'),
(36, 'essamo', '01210422357', 'alexandria', 'user', '1234'),
(38, 'horya', '01210422357', 'alexandria', 'user', '1234'),
(39, 'horyaa', '01210422357', 'portsaid', 'user', '1234'),
(40, 'horyaaa', '01210422358', 'portsaid', 'user', '1234'),
(41, 'basmala', '01210422357', 'portsaid', 'user', '1234'),
(46, 'fathy', '01210422357', 'alexandria', 'user', '1234'),
(50, 'fatooh', '01210422357', 'alexandria', 'user', '$2y$10$vNDG6PcdRpNXUWzsqKnepeKC1maj8vzWzj.D2DkvPx5PiB2dkkElC'),
(51, 'sohailola', '01210422357', 'alexandria', 'user', '$2y$10$GnjTsM8ccoIqDw3q78TwS.scKLcRdr.zmfvDU4tmyqsBxRPgdBu.q'),
(52, 'mahlola', '01210422357', 'portsaid', 'user', '$2y$10$EFJiDH2E/0AADzCiTLK8GO.1e5BaiTYr8oFsIknStjlTEQPJZLqdG'),
(53, 'farah', '01210422357', 'portsaid', 'user', '$2y$10$cReYoUvOXlspFqQdALBgN.1BXoVC.EbjBvkuyfgFQKCYNNo.PZmoi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`),
  ADD UNIQUE KEY `brand_name` (`brand_name`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_orders_product` (`product_id`),
  ADD KEY `FK` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `purchasing_cart`
--
ALTER TABLE `purchasing_cart`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `FK_pur_product` (`product_id`),
  ADD KEY `FK_pur_user` (`user_id`);

--
-- Indexes for table `shareholders`
--
ALTER TABLE `shareholders`
  ADD PRIMARY KEY (`shareholder_id`),
  ADD UNIQUE KEY `shareholder_name` (`shareholder_name`);

--
-- Indexes for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `stakeholding`
--
ALTER TABLE `stakeholding`
  ADD PRIMARY KEY (`shareholders_id`,`brand_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=231;

--
-- AUTO_INCREMENT for table `purchasing_cart`
--
ALTER TABLE `purchasing_cart`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `shareholders`
--
ALTER TABLE `shareholders`
  MODIFY `shareholder_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `FK_orders_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`);

--
-- Constraints for table `purchasing_cart`
--
ALTER TABLE `purchasing_cart`
  ADD CONSTRAINT `FK_pur_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `FK_pur_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `shopping_cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `shopping_cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `stakeholding`
--
ALTER TABLE `stakeholding`
  ADD CONSTRAINT `stakeholding_ibfk_1` FOREIGN KEY (`shareholders_id`) REFERENCES `shareholders` (`shareholder_id`),
  ADD CONSTRAINT `stakeholding_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
