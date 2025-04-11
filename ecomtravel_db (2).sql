-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 07:07 AM
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
-- Database: `ecomtravel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$.ucvGC0MjoZ9rAvCRGOfLem3w0iidu.LAJCWQVhnP0TuNGPwd9pMa');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `package_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `booking_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `package_id`, `customer_name`, `email`, `phone`, `booking_date`) VALUES
(1, 1, 'John Doe', 'john@example.com', '123-456-7890', '2024-03-15'),
(2, 2, 'Jane Smith', 'jane@example.com', '987-654-3210', '2024-04-01'),
(3, 2, 'Mer chetan', 'fjdjvhdjvh@gmail.com', '8686067688', '2025-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'Alice Brown', 'alice@example.com', 'Paris Package Inquiry', 'Can you provide more details about the Paris package?', '2025-02-14 16:50:36'),
(2, 'Bob Wilson', 'bob@example.com', 'Group Discounts', 'Do you offer discounts for group bookings?', '2025-02-14 16:50:36');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'abhi', 'dsd@mmd.com', 'junagadh trip', 'i wanted charted plane', '2025-04-02 02:23:03');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `trip_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `description`, `price`, `image`, `trip_details`) VALUES
(1, 'Paris Vacation', '5-day tour including Eiffel Tower and Louvre visit', 899.99, 'paris.jpg', NULL),
(2, 'Bali Retreat', '7-day luxury resort stay with spa treatments', 1299.99, 'bali.jpg', NULL),
(3, 'Safari Adventure', '4-day wildlife experience in Kenya', 1499.99, 'safari.jpg', 'Day 1: Arrival in Nairobi &amp; Transfer to Maasai Mara\r\n\r\nMorning: Arrive at Jomo Kenyatta International Airport in Nairobi, where you’ll be warmly welcomed by your guide. After a brief introduction, embark on a scenic drive (or short flight) to the world-famous Maasai Mara National Reserve.\r\n\r\nAfternoon: Check into your luxury safari lodge or tented camp, nestled in the heart of the reserve. Enjoy a delicious lunch while soaking in the stunning views of the savannah.\r\n\r\nEvening: Set out on your first game drive in the Maasai Mara, home to the Big Five (lion, leopard, elephant, buffalo, and rhino) and the Great Migration (seasonal). Witness the golden hues of the sunset over the plains as you spot herds of wildebeest, zebras, and gazelles.\r\n\r\nDinner &amp; Overnight: Return to your lodge for a sumptuous dinner under the stars, followed by a restful night surrounded by the sounds of the wild.\r\n\r\nDay 2: Full Day Exploring Maasai Mara\r\n\r\nMorning: Rise early for a sunrise game drive, the best time to spot predators on the hunt. Enjoy a packed breakfast at a scenic spot in the park as you watch the savannah come alive.\r\n\r\nMidday: Return to the lodge for a leisurely lunch and some relaxation. Take a dip in the pool, enjoy a spa treatment, or simply unwind on your private deck with a view of the wildlife.\r\n\r\nAfternoon: Head out for another thrilling game drive, exploring different regions of the reserve. Visit the Mara River, where crocodiles and hippos reside, and if you’re lucky, witness the dramatic river crossings during the Great Migration.\r\n\r\nEvening: Optional visit to a Maasai village to learn about the local culture, traditions, and way of life. Engage in traditional dances, visit a homestead, and shop for handmade crafts.\r\n\r\nDinner &amp; Overnight: Return to your lodge for another delightful dinner and overnight stay.\r\n\r\nDay 3: Maasai Mara to Lake Nakuru National Park\r\n\r\nMorning: After breakfast, bid farewell to the Maasai Mara and drive (or fly) to Lake Nakuru National Park, known for its flamingos and rhino sanctuary.\r\n\r\nAfternoon: Arrive at your lodge or camp near the lake and enjoy lunch. Then, embark on an afternoon game drive around the lake, where you’ll spot flocks of pink flamingos, pelicans, and other bird species. Keep an eye out for white and black rhinos, lions, and leopards.\r\n\r\nEvening: Relax at your accommodation, enjoying the serene surroundings and perhaps a sundowner by the lake.\r\n\r\nDinner &amp; Overnight: Enjoy a hearty dinner and spend the night at your lodge or camp.\r\n\r\nDay 4: Lake Nakuru to Nairobi &amp; Departure\r\n\r\nMorning: Start your day with an early morning game drive in Lake Nakuru, capturing the park’s beauty in the soft morning light. Afterward, return to your lodge for breakfast.\r\n\r\nMidday: Check out and begin your journey back to Nairobi. En route, stop at the Great Rift Valley viewpoint for a breathtaking panoramic photo opportunity.\r\n\r\nAfternoon: Arrive in Nairobi and enjoy lunch at a local restaurant. If time permits, visit the David Sheldrick Wildlife Trust to see orphaned elephants or the Giraffe Centre to interact with endangered Rothschild giraffes.\r\n\r\nEvening: Transfer to Jomo Kenyatta International Airport for your departure flight, taking with you unforgettable memories of Kenya’s incredible wildlife and landscapes.\r\n\r\nIncluded:\r\n\r\nAccommodation in luxury lodges or tented camps\r\n\r\nAll meals (breakfast, lunch, and dinner)\r\n\r\nGame drives in Maasai Mara and Lake Nakuru\r\n\r\nPark entrance fees\r\n\r\nProfessional English-speaking guide/driver\r\n\r\nTransportation in a 4x4 safari vehicle\r\n\r\nAirport transfers\r\n\r\nNot Included:\r\n\r\nInternational flights\r\n\r\nVisa fees\r\n\r\nTips and gratuities\r\n\r\nPersonal expenses (souvenirs, drinks, etc.)\r\n\r\nOptional activities (Maasai village visit, balloon safari, etc.)\r\n\r\nThis 4-day wildlife experience in Kenya offers an unforgettable adventure, combining the thrill of safari game drives with the beauty of Kenya’s diverse landscapes and rich cultural heritage');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `created_at`, `verified`) VALUES
(1, 'abhishek chauhan', '1232@gami.com', '$2y$10$IKpKa3LSVGEnrmdKHpsj1uGNSC8P3/yj6iiR271K1wefKWBqqveFS', '1234567890', '2025-02-28 11:01:29', 0),
(2, 'Abhi', 'uwnw@gmail.com', '$2y$10$fnRCKSYr04cWzeSBy/.LveHMLrqwKAav0lR76KT4SmV4/zEEThxJe', '6494679464', '2025-02-28 14:03:36', 0),
(3, 'Vhshxhvhd', 'vhshchsgd@gmail.com', '$2y$10$IwcgQ6Rnbcnp4msuFyLIi.OcRSxbc0eYA3yCv27cRzzSb/jpbAe0W', '8686067688', '2025-02-28 14:05:01', 0),
(4, 'abhi', 'abhi@gmail.com', '$2y$10$n/kJ4yfBsdgHa4xnuRF5huoWPCTo6UDCJjc00W3X35ZVTb0mt5I7u', '1234567890', '2025-04-01 20:24:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL,
  `visit_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`id`, `visit_time`) VALUES
(1, '2025-04-02 02:03:03'),
(2, '2025-04-02 02:05:09'),
(3, '2025-04-02 02:05:21'),
(4, '2025-04-02 02:05:30'),
(5, '2025-04-02 02:05:38'),
(6, '2025-04-02 02:05:42'),
(7, '2025-04-02 02:05:43'),
(8, '2025-04-02 02:05:45'),
(9, '2025-04-02 02:07:04'),
(10, '2025-04-02 02:10:49'),
(11, '2025-04-02 02:12:04'),
(12, '2025-04-02 02:12:09'),
(13, '2025-04-02 02:12:14'),
(14, '2025-04-02 02:12:31'),
(15, '2025-04-02 02:13:59'),
(16, '2025-04-02 02:14:13'),
(17, '2025-04-02 02:20:41'),
(18, '2025-04-02 02:20:43'),
(19, '2025-04-02 02:22:38'),
(20, '2025-04-02 02:22:42'),
(21, '2025-04-02 02:23:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `package_id` (`package_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
