-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2025 at 05:44 AM
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
-- Database: `computer_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(20, 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `shipping_address` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_zip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_price`, `order_date`, `shipping_address`, `shipping_city`, `shipping_zip`) VALUES
(2, 2, 11585.26, '2025-11-30 04:26:47', NULL, NULL, NULL),
(3, 2, 1522.87, '2025-12-02 13:30:17', NULL, NULL, NULL),
(4, 2, 4568.60, '2025-12-02 13:33:29', NULL, NULL, NULL),
(5, 3, 4805.33, '2025-12-02 13:34:38', NULL, NULL, NULL),
(6, 2, 1522.87, '2025-12-02 15:25:48', NULL, NULL, NULL),
(7, 2, 1356.00, '2025-12-02 15:36:54', '80 Orenda Court', 'Delhi', 'L6W 3N1'),
(9, 2, 5648.78, '2025-12-05 20:57:19', '18-7251 Copenhagen Rd Mississauga', 'Mississauga', 'L5N 2H6'),
(11, 5, 2259.99, '2025-12-05 23:11:18', '80 Orenda Court', 'Brampton', 'L6W 3N1');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(1, 2, 2, 'Office Desktop Pro', 850.50, 5),
(2, 2, 3, 'Ultrabook Slim', 999.99, 6),
(3, 3, 4, 'ASUS TUF A15 Ryzen 7 5800h NVIDIA RTX3060 1TB ', 1347.67, 1),
(4, 4, 4, 'ASUS TUF A15 Ryzen 7 5800h NVIDIA RTX3060 1TB ', 1347.67, 3),
(5, 5, 2, 'Office Desktop Pro', 850.50, 5),
(6, 6, 4, 'ASUS TUF A15 Ryzen 7 5800h NVIDIA RTX3060 1TB ', 1347.67, 1),
(7, 7, 1, 'Gaming Laptop X1', 1200.00, 1),
(9, 9, 28, 'ASUS ROG Maximus Z790 Hero WiFi 6E LGA 1700 Motherboard', 629.99, 1),
(10, 9, 27, 'Corsair Dominator Titanium RGB 64GB (2x32GB) DDR5 6000MHz', 299.99, 1),
(11, 9, 29, 'CORSAIR RM850x Fully Modular Low-Noise ATX Power Supply', 209.99, 1),
(12, 9, 26, 'Samsung 990 PRO 2TB PCIe 4.0 NVMe M.2 SSD', 179.99, 1),
(13, 9, 25, 'Intel Core i9-14900K 14th Gen 24-Core (8P+16E) Processor', 589.99, 1),
(14, 9, 23, 'ASUS ROG Strix GeForce RTX® 4090 Gaming Graphics Card (PCIe 4.0, 24GB GDDR6X, HDMI 2.1a, DisplayPort 1.4a)', 1599.00, 1),
(15, 9, 13, 'Alienware 34 Curved QD-OLED Gaming Monitor (AW3423DWF)', 1099.99, 1),
(16, 9, 14, 'Corsair K70 MAX RGB Magnetic-Mechanical Gaming Keyboard', 229.99, 1),
(17, 9, 10, 'Logitech G502 X PLUS Millennium Falcon Edition Wireless Gaming Mouse', 159.99, 1),
(19, 11, 1, 'ASUS ROG Zephyrus G14 Ryzen 9 8945HS RTX 4070 1TB', 1999.99, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image_url`, `category`, `stock`) VALUES
(1, 'ASUS ROG Zephyrus G14 Ryzen 9 8945HS RTX 4070 1TB', 'Redefine portability with the 2024 Zephyrus G14. Weighing just 1.5kg, this machine packs the AI-ready AMD Ryzen 9 8945HS processor and NVIDIA RTX 4070 graphics into a stunningly thin aluminum chassis. It is the perfect blend of power and mobility for gamers on the go.\r\n\r\nThe star of the show is the ROG Nebula OLED display, offering perfect blacks and vivid colors. Despite its size, the G14 stays cool thanks to the ROG Intelligent Cooling ecosystem, featuring liquid metal and improved airflow channels.\r\n\r\nKey Features:\r\nProcessor: AMD Ryzen 9 8945HS – Efficient, AI-enabled performance for creators and gamers\r\nGraphics: NVIDIA GeForce RTX 4070 8GB – Powerful graphics in a compact form factor\r\nStorage: 1TB PCIe 4.0 NVMe SSD – Fast and reliable storage\r\nDisplay: 14\" 3K OLED 120Hz – G-SYNC compatible with 0.2ms response time\r\nDesign: CNC-machined aluminum chassis with Slash Lighting array\r\nAudio: 6-speaker system with Dolby Atmos for immersive sound\r\nPerfect for students, travelers, and creators who need a laptop that can game hard and travel light.', 1999.99, 'media/laptop.png', 'Laptops', 9),
(2, 'MSI Aegis RS 14 i7-14700KF RTX 4070 Ti Super 2TB', 'MSI Aegis RS 14 – i7-14700KF & RTX 4070 Ti Super Gaming Desktop\r\n\r\nThe MSI Aegis RS is built to be the ultimate esports tournament machine. Assembled in the USA with high-quality MSI components, it features the Intel Core i7-14700KF and the new RTX 4070 Ti Super for incredible 1440p and 4K gaming.\r\n\r\nThe Gungnir chassis provides excellent airflow and features aggressive styling with Mystic Light RGB. Because it uses standard MSI parts (motherboard, GPU, case), it is fully upgradable and easy to maintain for years to come.\r\n\r\nKey Features:\r\nProcessor: Intel Core i7-14700KF – 20 Cores (8P + 12E) up to 5.6GHz\r\nGraphics: NVIDIA GeForce RTX 4070 Ti Super 16GB – AI-enhanced graphics\r\nRAM: 32GB DDR5 5600MHz (Expandable to 128GB)\r\nStorage: 2TB NVMe Gen4 SSD – Massive space for modern games\r\nMotherboard: MSI Pro Z790 WiFi\r\nPeripherals: Includes MSI Gaming Mouse & Keyboard', 2199.99, 'media/desktop.png', 'Desktops', 8),
(3, 'Alienware m18 R2 i9-14900HX RTX 4090 4TB', 'Replace your desktop entirely with the colossal Alienware m18 R2. This 18-inch titan offers unmatched screen real estate and performance, powered by the Intel Core i9-14900HX and the RTX 4090. It is designed to handle the most demanding sims, VR, and AAA titles with ease.\r\n\r\nStorage anxiety is a thing of the past with a massive 4TB storage configuration. The Element 31 thermal interface material (Gallium-Silicone matrix) ensures the CPU and GPU perform at their peak capabilities for longer periods than traditional pastes.\r\n\r\nKey Features:\r\nProcessor: Intel Core i9-14900HX – Extreme performance for heavy workloads and gaming\r\nGraphics: NVIDIA GeForce RTX 4090 16GB – Maximum TGP for unthrottled graphical power\r\nStorage: 4TB RAID 0 SSD – Unrivaled storage space and speed\r\nDisplay: 18\" FHD+ 480Hz – The ultimate refresh rate for competitive shooters\r\nCooling: Cryo-tech™ cooling with quad fans and Element 31 thermal interface\r\nKeyboard: CherryMX ultra-low-profile mechanical keyboard for tactile feedback\r\nThe ultimate choice for gamers who want a desktop-replacement experience without the tower.', 3999.99, 'media/alienware_m18.avif', 'Laptops', 10),
(4, 'ASUS TUF A15 Ryzen 7 5800h NVIDIA RTX3060 1TB ', 'ASUS TUF A15 – Ryzen 7 & RTX 3060 Gaming Laptop (1TB SSD)\r\n\r\nUnleash smooth, high-performance gaming with the ASUS TUF A15 powered by an AMD Ryzen 7 5800H processor and NVIDIA GeForce RTX 3060 graphics. Whether you’re grinding ranked matches, editing videos, or multitasking with dozens of tabs open, this laptop is built to handle it all with ease.\r\n\r\nWith a fast 1TB SSD, you get quick boot times, near-instant load screens, and plenty of space for your game library, software, and files—no more constantly deleting games to make room for new ones. The TUF A15 also features a durable, battle-tested chassis designed to meet military-grade standards, so it’s ready for daily use, travel, and long gaming sessions.\r\n\r\n**Key Features:**\r\n\r\n* **Processor:** AMD Ryzen 7 5800H – powerful 8-core CPU for gaming, streaming, and productivity\r\n* **Graphics:** NVIDIA GeForce RTX 3060 – ray tracing and DLSS support for modern AAA titles\r\n* **Storage:** 1TB SSD – fast load times and ample storage for games and media\r\n* **Design:** TUF series durability with a robust, gamer-centric look\r\n* **Cooling:** Optimized cooling system to maintain performance during intense gameplay\r\n* **Keyboard:** Gaming keyboard with precise keys and comfortable layout for long sessions\r\n\r\nPerfect for gamers, creators, and power users, the ASUS TUF A15 Ryzen 7 + RTX 3060 configuration delivers a strong blend of performance, reliability, and style.\r\n', 1347.99, 'media/tuf_a15_3060_r7.png', 'Laptops', 10),
(5, 'MSI Raider GE78 HX 13V Core i9-13980HX RTX 4080 2TB', 'Light up the lobby with the MSI Raider GE78 HX, a powerhouse defined by its Matrix Light Bar and extreme performance. Powered by the desktop-grade Intel Core i9-13980HX and the NVIDIA GeForce RTX 4080, this machine is built to crush AAA titles at max settings without breaking a sweat.\r\n\r\nWith a massive 2TB SSD, you have ample room for a massive library of games and 4K media content. The Raider GE78 also features the latest Cooler Boost 5 technology, sharing heat pipes between the CPU and GPU to ensure stability during marathon gaming sessions.\r\n\r\nKey Features:\r\nProcessor: Intel Core i9-13980HX – 24 cores of raw processing power for elite gaming\r\nGraphics: NVIDIA GeForce RTX 4080 12GB – AI-powered graphics with DLSS 3 support\r\nStorage: 2TB NVMe SSD – Lightning-fast load times and massive capacity\r\nDisplay: 17-inch QHD+ 240Hz – Buttery smooth visuals with 100% DCI-P3 color gamut\r\nCooling: MSI Cooler Boost 5 with shared pipe design for optimal thermal management\r\nKeyboard: SteelSeries Per-Key RGB gaming keyboard for limitless customization\r\nDesigned for enthusiasts who demand the absolute best, the MSI Raider GE78 HX offers a desktop-class experience in a portable form factor.', 2899.99, 'media/msi_raider_ge78.png', 'Laptops', 10),
(6, 'Razer Blade 16 OLED i9-14900HX RTX 4090 2TB', 'Experience the world’s first OLED 240Hz display on a 16-inch gaming laptop. The Razer Blade 16 combines the absurd power of the Intel Core i9-14900HX and the flagship NVIDIA GeForce RTX 4090 inside a precision-milled aluminum chassis that is incredibly thin and durable.\r\n\r\nThis laptop isn\'t just about looks; it is an engineering marvel. It features a vapor chamber cooling system to keep temperatures in check and a massive 2TB SSD for all your creative projects and gaming adventures. It is the ultimate machine for creators and gamers alike.\r\n\r\nKey Features:\r\nProcessor: Intel Core i9-14900HX – Desktop-level performance in a laptop\r\nGraphics: NVIDIA GeForce RTX 4090 16GB – The most powerful laptop GPU available\r\nStorage: 2TB NVMe Gen4 SSD – Next-gen storage speeds for instant booting\r\nDisplay: 16\" OLED 240Hz – Incredible contrast, deep blacks, and ultra-fast response times\r\nDesign: Unibody Aluminum CNC Chassis – Sleek, durable, and surprisingly portable\r\nKeyboard: Razer Chroma RGB anti-ghosting keyboard with 16.8 million colors\r\nPerfect for power users who refuse to compromise on build quality, display fidelity, or raw performance.', 3599.99, 'media/razer_blade16.jpg', 'Laptops', 10),
(7, 'Lenovo Legion Pro 7i Gen 8 i9-13900HX RTX 4080 1TB', 'Dominate the competition with the AI-tuned Lenovo Legion Pro 7i. Featuring the Lenovo AI Engine+ powered by the LA2-Q AI chip, this laptop optimizes your system in real-time for maximum FPS. Under the hood lies the beastly i9-13900HX and RTX 4080, delivering top-tier performance for esports and cinematic gaming.\r\n\r\nThe Legion Coldfront 5.0 cooling system uses massive intake and exhaust systems to keep your framerates high and your temperatures low. With a sturdy, sustainable build and a factory-calibrated display, it is ready for battle right out of the box.\r\n\r\nKey Features:\r\nProcessor: Intel Core i9-13900HX – Hybrid architecture for seamless multitasking\r\nGraphics: NVIDIA GeForce RTX 4080 12GB – Ray tracing glory with DLSS 3.0 frame generation\r\nStorage: 1TB PCIe Gen4 SSD – Rapid access to your favorite titles\r\nCooling: Legion Coldfront 5.0 with vapor chamber technology\r\nDesign: Sustainable design using recycled aluminum and magnesium\r\nKeyboard: Legion TrueStrike Keyboard with 100% anti-ghosting and soft-landing switches\r\nIdeal for competitive gamers who need intelligent performance tuning and reliable cooling for long-term play.', 2299.49, 'media/lenovo_legion_pro7i.webp', 'Laptops', 10),
(8, 'Acer Predator Helios 16 i9-13900HX RTX 4080 1TB', 'Step into the game with the Acer Predator Helios 16. This laptop is a neon-soaked beast featuring a Mini-LED display that makes HDR content pop. Driven by the i9-13900HX and RTX 4080, it delivers blistering frame rates in Cyberpunk 2077 and Call of Duty.\r\n\r\nCooling is handled by dual custom-engineered 5th Gen AeroBlade 3D fans and liquid metal thermal grease, ensuring you stay cool under fire. The PredatorSense software gives you total control over lighting, fan speeds, and overclocking.\r\n\r\nKey Features:\r\nProcessor: Intel Core i9-13900HX – High-core count for multitasking domination\r\nGraphics: NVIDIA GeForce RTX 4080 12GB – High-end performance with advanced ray tracing\r\nStorage: 1TB SSD – Quick game loads and system responsiveness\r\nDisplay: 16\" WQXGA Mini-LED 250Hz – 1000 nits brightness for true HDR gaming\r\nCooling: 5th Gen AeroBlade 3D Technology with Liquid Metal\r\nKeyboard: Per-key RGB Mini LED backlit keyboard\r\nA visually stunning choice for gamers who value screen brightness and customizable RGB aesthetics.', 2149.99, 'media/acer_helios16.jpg', 'Laptops', 7),
(9, 'HP OMEN 16 Ryzen 9 7940HS RTX 4070 1TB', 'Go beyond performance with the HP OMEN 16. Powered by the efficient AMD Ryzen 9 7940HS and NVIDIA RTX 4070, this laptop delivers consistent performance without overheating, thanks to the OMEN Tempest Cooling technology.\r\n\r\nThe 16.1-inch display offers a massive viewing area with a fast 165Hz refresh rate, ensuring you never miss a frame. With OMEN Gaming Hub, you can optimize your performance, customize lighting, and aggregate your games in one place.\r\n\r\nKey Features:\r\nProcessor: AMD Ryzen 9 7940HS – 8 Cores, 16 Threads of Zen 4 power\r\nGraphics: NVIDIA GeForce RTX 4070 8GB – Sweet spot performance for 1440p gaming\r\nStorage: 1TB PCIe Gen4 NVMe SSD – Plenty of space for modern AAA titles\r\nDisplay: 16.1\" QHD 165Hz – Anti-glare micro-edge screen\r\nCooling: OMEN Tempest Cooling technology preventing thermal throttling\r\nAudio: Audio by Bang & Olufsen for premium sound quality\r\nA reliable, mainstream choice for gamers who want a well-rounded machine with great battery life and thermal performance.', 1649.99, 'media/hp_omen16.avif', 'Laptops', 8),
(10, 'Logitech G502 X PLUS Millennium Falcon Edition Wireless Gaming Mouse', 'Logitech G502 X PLUS – LIGHTSPEED Wireless Gaming Mouse with LIGHTFORCE Hybrid Switches\r\n\r\nThe world\'s most popular gaming mouse has been reinvented. The G502 X PLUS combines a legacy of performance with the latest advanced gaming technologies. It features the first-ever LIGHTFORCE hybrid optical-mechanical switches for incredible speed and reliability, along with precise actuation.\r\n\r\nLIGHTSYNC RGB powers a flowing 8-LED lighting experience that adapts as you play. With the pro-grade LIGHTSPEED wireless connectivity, you get a response rate 68% faster than the previous generation, ensuring your inputs are instant in the heat of battle.\r\n\r\nKey Features:\r\nSensor: HERO 25K Sensor – Sub-micron precision with zero smoothing, filtering, or acceleration\r\nSwitches: LIGHTFORCE Hybrid Optical-Mechanical – Speed of optical, feel of mechanical\r\nWireless: LIGHTSPEED Wireless – Pro-grade connectivity with ultra-low latency\r\nBattery Life: Up to 120 hours (37 hours with RGB on)\r\nCustomization: 13 Programmable Controls with adjustable DPI-Shift button\r\nDesign: Lightweight exoskeleton design at just 106 grams\r\nAn icon tailored for the modern gamer who demands speed, customization, and wireless freedom.', 159.99, 'media/logitech_g502.webp', 'Accessories', 14),
(11, 'SteelSeries Apex Pro TKL Wireless (2023) Mechanical Keyboard', 'SteelSeries Apex Pro TKL – World\'s Fastest Wireless Gaming Keyboard\r\n\r\nExperience the ultimate competitive advantage with the Apex Pro TKL. It features the revolutionary OmniPoint 2.0 adjustable switches, allowing you to customize the actuation distance of every single key from a feather-light 0.2mm to a deep 3.8mm.\r\n\r\nThe \"Rapid Trigger\" mode eradicates latency caused by the physical movement of the switch, allowing for dynamic activation and deactivation based on travel distance. Built with an aircraft-grade aluminum alloy frame, this keyboard is a tank designed to last a lifetime of victories.\r\n\r\nKey Features:\r\nSwitches: OmniPoint 2.0 Adjustable HyperMagnetic Switches – Fully customizable sensitivity\r\nConnectivity: Quantum 2.0 Wireless – Lag-free 2.4GHz and Bluetooth 5.0\r\nDisplay: OLED Smart Display – View settings, profiles, and updates on the fly\r\nDurability: Series 5000 Aircraft Grade Aluminum Frame\r\nKeycaps: Double Shot PBT Keycaps – Fadeproof and textured for grip\r\nWrist Rest: Magnetic soft-touch wrist rest included\r\nThe perfect keyboard for those who want to fine-tune their equipment to their exact playstyle.', 249.99, 'media/steelseries_apex_pro.webp', 'Accessories', 14),
(12, 'Razer BlackShark V2 Pro (2023) Wireless Esports Headset', 'Razer BlackShark V2 Pro – Premium Wireless Esports Headset\r\n\r\nIf esports is your calling, answer it with the definitive headset for competitive play. The Razer BlackShark V2 Pro features crystal-clear audio powered by Razer TriForce Titanium 50mm Drivers, designed to tune highs, mids, and lows independently for a richer, brighter sound.\r\n\r\nThe highlight is the Razer HyperClear Super Wideband Mic, which covers a wider frequency range of sound, capturing an incredible amount of detail in your voice so that every shotcall to your team sounds clear, rich, and natural.\r\n\r\nKey Features:\r\nAudio: Razer TriForce Titanium 50mm Drivers – High-fidelity sound tuning\r\nMicrophone: HyperClear Super Wideband Mic – Professional-grade voice quality\r\nConnectivity: Razer HyperSpeed Wireless – Industry-leading low latency audio\r\nComfort: Ultra-soft FlowKnit memory foam ear cushions\r\nBattery: Up to 70 hours of battery life with Type-C charging\r\nIsolation: Advanced passive noise cancellation\r\nDesigned for pros, this headset offers the clarity and isolation needed to clutch the win.', 199.99, 'media/razer_blackshark.jpg', 'Accessories', 7),
(13, 'Alienware 34 Curved QD-OLED Gaming Monitor (AW3423DWF)', 'Alienware 34 QD-OLED – 165Hz Curved Gaming Monitor\r\n\r\nImmerse yourself in colors you have never seen before. The Alienware 34 Curved QD-OLED Gaming Monitor features Quantum Dot Display Technology, enabling a slim panel design and delivering superior color performance with a higher peak luminance and greater color gamut range vs WOLED.\r\n\r\nWith an infinite contrast ratio, the panel delivers incredibly deep blacks and bright whites. The 0.1ms GtG response time and 165Hz refresh rate ensure that fast-moving visuals remain crystal clear, giving you a competitive edge in fast-paced games.\r\n\r\nKey Features:\r\nDisplay: 34\" QD-OLED Curved 1800R Panel\r\nResolution: WQHD (3440 x 1440) – Ultrawide immersion\r\nSpeed: 165Hz Refresh Rate & 0.1ms Response Time – Instant pixel transition\r\nColor: 99.3% DCI-P3 Color Coverage – Cinema-grade color accuracy\r\nSync: AMD FreeSync Premium Pro – Tear-free, stutter-free gaming\r\nDesign: Legend 2.0 ID with customizable AlienFX lighting\r\nThe ultimate monitor for gamers who prioritize visual fidelity and immersion above all else.', 1099.99, 'media/alienware_curved_monitor.jpg', 'Accessories', 11),
(14, 'Corsair K70 MAX RGB Magnetic-Mechanical Gaming Keyboard', 'Corsair K70 MAX – Magnetic-Mechanical RGB Gaming Keyboard\r\n\r\nForge your legacy with the Corsair K70 MAX, equipped with adjustable CORSAIR MGX switches. These magnetic switches allow you to set every key\'s actuation point from a light 0.4mm to a strong 3.6mm, giving you complete control over your typing and gaming experience.\r\n\r\nIt features AXON Hyper-Processing Technology, transmitting inputs up to 8x faster than conventional gaming keyboards. The refined design includes a detachable magnetic memory foam palm rest and durable PBT double-shot keycaps that resist wear, fading, and shine.\r\n\r\nKey Features:\r\nSwitches: CORSAIR MGX Magnetic-Mechanical – Adjustable actuation points\r\nPerformance: Rapid Trigger Mode – Reset keys instantly for faster inputs\r\nPolling: 8000Hz Hyper-Polling – Register inputs faster than ever\r\nBuild: Etched Aluminum Frame – Stylish and durable\r\nAcoustics: Two layers of sound dampening for a satisfying typing sound\r\nSoftware: iCUE compatible for dynamic RGB lighting control\r\nA premium keyboard built for speed, durability, and a completely personalized feel.', 229.99, 'media/corsair_k70.webp', 'Accessories', 10),
(15, 'Logitech MX Brio Ultra HD 4K Collaboration Webcam', 'Logitech MX Brio – 4K Ultra HD Webcam with AI Enhancement\r\n\r\nLook your absolute best on every stream and call. The Logitech MX Brio features our largest webcam sensor yet, delivering 2x finer image detail in difficult lighting conditions compared to the Brio 4K. With AI-enhanced image quality, you get auto-light correction and face-based exposure.\r\n\r\nCustomize your video with fine controls for ISO, shutter speed, temperature, and tint using Logi Options+. The integrated privacy shutter gives you peace of mind when the camera is not in use.\r\n\r\nKey Features:\r\nResolution: 4K Ultra HD at 30fps or 1080p at 60fps\r\nSensor: Advanced large sensor with Sony STARVIS technology\r\nMicrophone: Dual beamforming noise-reducing microphones\r\nModes: Show Mode allows you to tilt the camera down to show your desk\r\nMount: Universal mounting clip fits laptops, LCDs, or monitors\r\nConnection: USB-C 3.0 for high-bandwidth data transfer\r\nIdeal for streamers and professionals who refuse to look pixelated or washed out.', 199.99, 'media/logitech_webcam.webp', 'Accessories', 7),
(16, 'Elgato Stream Deck + Audio Mixer & Production Console', 'Elgato Stream Deck + – The Ultimate Audio & Video Controller\r\n\r\nStream Deck + gives you incredible power to interact with your setup. Trigger actions, control mics and cameras, adjust volume, lighting, and so much more. It features 8 customizable LCD keys, a touch strip, and 4 tactile dials that offer infinite control over your apps.\r\n\r\nUnlock Elgato Wave Link mixing software to control your audio sources perfectly. Whether you are streaming, editing video, or just multitasking, the Stream Deck + streamlines your entire workflow into one sleek device.\r\n\r\nKey Features:\r\nControls: 8 LCD Keys, 4 Push Dials, and a Dynamic Touch Strip\r\nAudio: Unlock Wave Link mixing software for professional audio control\r\nCustomization: Drag and drop actions in the Stream Deck app\r\nFeedback: Visual feedback on keys and the touch strip\r\nPlugins: Access thousands of royalty-free tracks and plugins\r\nStand: Integrated weighted stand with non-slip base\r\nThe command center for your desk, putting every app and tool right at your fingertips.', 199.99, 'media/elgato_stream_deck.avif', 'Accessories', 15),
(17, 'HyperX QuadCast S RGB USB Condenser Microphone', 'HyperX QuadCast S – RGB USB Microphone for Streamers\r\n\r\nSound as good as you look with the HyperX QuadCast S. This USB condenser microphone features stunning RGB lighting and dynamic effects that are customizable via HyperX NGENUITY software. It is a full-featured mic with a built-in anti-vibration shock mount to quiet the rumbles of daily life.\r\n\r\nSelect from four polar patterns (stereo, omnidirectional, cardioid, bidirectional) to optimize your broadcast setup and keep the focus on the sounds you want to be heard. The convenient tap-to-mute sensor with LED indicator prevents audio accidents.\r\n\r\nKey Features:\r\nLighting: Dynamic RGB lighting with customizable effects\r\nMount: Built-in anti-vibration shock mount\r\nPatterns: 4 Selectable Polar Patterns for versatility\r\nControls: Gain control adjustment dial and Tap-to-Mute sensor\r\nFilter: Built-in pop filter to smooth out plosive sounds\r\nCompatibility: PC, PS5, PS4, and Mac compatible\r\nThe definitive microphone for streamers who want broadcast-quality audio with a stylish aesthetic.', 159.99, 'media/hyperx_mic.jpg', 'Accessories', 6),
(18, 'Alienware Aurora R16 Gaming Desktop - Intel Core i7 14700F, 32GB DDR5 RAM, 1TB SSD, RTX 4070 ', 'All Aurora R16s gaming desktops are equipped with our 12-phase voltage regulation design. This high-performance technology ensures clean energy is consistently available, unleashing the top-level power of up to 14th Gen Intel Core processors as you game, livestream, and multi-task for hours on end.\r\n\r\nFRAMEWORK FOR SPEED: With Ada Lovelace architecture, GeForce RTX 40 Series Desktop GPUs deliver unparalleled gaming performance with double the power efficiency, enhanced AI, ray tracing, and Game Ready drivers.\r\n\r\nEFFICIENT AIRFLOW: Larger passageways and optimized internal cable management, allows airflow to be more productive, resulting in quieter acoustics.\r\n\r\nTOTAL COMMAND: Featuring the revamped Alienware Command Center software, where you can intuitively tailor and monitor your system’s performance and customize lighting and other settings across your setup.\r\n\r\nEXPRESSIVE GAMEPLAY: Show off your gaming style by customizing AlienFX lighting across your Alienware ecosystem with over 16.8 million RGB colors at your disposal.', 3787.99, 'media/desktop2.webp', 'Desktops', 4),
(19, 'HP OMEN 45L Ryzen 9 7900X RTX 4080 1TB', 'HP OMEN 45L – Ryzen 9 7900X & RTX 4080 Gaming Desktop (1TB SSD)\r\n\r\nThe HP OMEN 45L features the patented OMEN Cryo Chamber, a revolutionary cooling solution that pulls fresh cold air from outside the main compartment to cool the CPU liquid radiator. Powered by the AMD Ryzen 9 7900X and NVIDIA RTX 4080, it delivers relentless performance without thermal throttling.\r\n\r\nDesigned for upgradability, the tool-less chassis allows you to swap components effortlessly. The tempered glass panels show off the RGB lighting, which can be fully customized via the OMEN Gaming Hub.\r\n\r\nKey Features:\r\nProcessor: AMD Ryzen 9 7900X – 12 Cores, 24 Threads of Zen 4 power\r\nGraphics: NVIDIA GeForce RTX 4080 16GB – High-end ray tracing performance\r\nRAM: 32GB Kingston FURY DDR5-5200 MHz RGB\r\nCooling: OMEN Cryo Chamber™ with 360mm Liquid Cooler\r\nStorage: 1TB WD Black PCIe Gen4 NVMe SSD\r\nPower: 1200W 80 Plus Gold ATX Power Supply', 2799.99, 'media/desktop3.jpg', 'Desktops', 8),
(20, 'Corsair Vengeance i7500 i9-14900K RTX 4090 2TB', 'Corsair Vengeance i7500 – i9-14900K & RTX 4090 Gaming PC (64GB DDR5)\r\n\r\nBuilt with Corsair\'s award-winning components, the Vengeance i7500 is a showcase of performance and style. It pairs the Intel Core i9-14900K with the NVIDIA RTX 4090, housed in the high-airflow 4000D Airflow case.\r\n\r\nEvery detail is premium, from the H100i RGB Elite Liquid CPU Cooler to the Vengeance RGB DDR5 memory. It is tuned for silence and speed, making it perfect for streamers and pro gamers who need a system that looks as good as it performs.\r\n\r\nKey Features:\r\nProcessor: Intel Core i9-14900K – 24 Cores, overclockable powerhouse\r\nGraphics: NVIDIA GeForce RTX 4090 24GB – Top-tier 4K/8K gaming\r\nRAM: 64GB Corsair Vengeance RGB DDR5-6000MHz\r\nCooling: Corsair iCUE H100i RGB Elite Liquid Cooler\r\nCase: Corsair 4000D Airflow – Optimized for maximum cooling\r\nStorage: 2TB M.2 NVMe SSD', 3899.99, 'media/desktop4.webp', 'Desktops', 7),
(21, 'CyberPowerPC Gamer Supreme i9-14900KF RTX 4080 Super 4TB', 'CyberPowerPC Gamer Supreme – Liquid Cool i9-14900KF & RTX 4080 Super\r\n\r\nGet supreme performance without the custom shop price tag. This beast features the Intel Core i9-14900KF and the updated RTX 4080 Super, delivering a significant boost in ray-tracing capabilities.\r\n\r\nWhat sets this build apart is the massive 4TB SSD storage and 64GB of RAM, ensuring you never have to delete a game or close a tab again. The liquid cooling system keeps the CPU running efficiently during intense sessions, showcased through a tempered glass side panel.\r\n\r\nKey Features:\r\nProcessor: Intel Core i9-14900KF – 24-Core processing beast\r\nGraphics: NVIDIA GeForce RTX 4080 Super 16GB – Superior 4K performance\r\nRAM: 64GB DDR5 Memory – Heavy multitasking ready\r\nStorage: 4TB PCIe NVMe SSD – Huge library capacity\r\nCooling: 360mm AIO Liquid Cooler\r\nLighting: Custom RGB Case Lighting with Remote', 2499.99, 'media/desktop6.webp', 'Desktops', 10),
(22, 'Skytech Azure 2 Ryzen 7 7800X3D RTX 4070 Ti 1TB', 'Skytech Azure 2 – Ryzen 7 7800X3D & RTX 4070 Ti Gaming PC\r\n\r\nThe Skytech Azure 2 is designed for the pure gamer. It features the AMD Ryzen 7 7800X3D, widely considered the world\'s best gaming CPU due to its massive 3D V-Cache. Paired with the RTX 4070 Ti, it pushes incredibly high frame rates in competitive titles like Valorant and Call of Duty.\r\n\r\nHoused in a stunning InWin chassis with a mesh front for high airflow, this PC looks as unique as it performs. No bloatware, just pure performance tuning and quality build control.\r\n\r\nKey Features:\r\nProcessor: AMD Ryzen 7 7800X3D – The King of Gaming CPUs\r\nGraphics: NVIDIA GeForce RTX 4070 Ti 12GB – Ray tracing & DLSS 3 ready\r\nRAM: 32GB DDR5 5200MHz RGB\r\nStorage: 1TB NVMe Gen4 SSD\r\nDesign: Unique honeycomb mesh front panel for max airflow\r\nWarranty: 1-Year Parts & Labor with Lifetime Tech Support', 1899.99, 'media/desktop7.webp', 'Desktops', 11),
(23, 'ASUS ROG Strix GeForce RTX® 4090 Gaming Graphics Card (PCIe 4.0, 24GB GDDR6X, HDMI 2.1a, DisplayPort 1.4a)', 'NVIDIA GeForce RTX 4090 – The Ultimate GeForce GPU\r\n\r\nThe NVIDIA® GeForce RTX™ 4090 is the ultimate GeForce GPU. It brings an enormous leap in performance, efficiency, and AI-powered graphics. Experience ultra-high performance gaming, incredibly detailed virtual worlds with ray tracing, unprecedented productivity, and new ways to create. It’s powered by the NVIDIA Ada Lovelace architecture and comes with 24 GB of G6X memory to deliver the ultimate experience for gamers and creators.\r\n\r\nThe Founders Edition design features a dual-axial flow-through system that provides higher airflow for cooler, quieter, and smoother performance.\r\n\r\nKey Features:\r\nArchitecture: NVIDIA Ada Lovelace Streaming Multiprocessors\r\nMemory: 24GB GDDR6X – 384-bit memory interface\r\nRay Tracing: 3rd Gen RT Cores for hyper-realistic graphics\r\nAI Graphics: DLSS 3 with Optical Multi-Frame Generation\r\nCooling: Dual-Axial Flow Through for optimized thermal performance\r\nOutputs: HDMI 2.1a, 3x DisplayPort 1.4a\r\nThe absolute pinnacle of graphical power for 4K and 8K gaming.', 1599.00, 'media/rtx4090.jpg', 'Components', 5),
(24, 'AMD Ryzen 7 7800X3D 8-Core 4.2GHz (5.0GHz Turbo) AM5 Processor', 'AMD Ryzen 7 7800X3D – The Ultimate Gaming Processor\r\n\r\nDominate the competition with the AMD Ryzen™ 7 7800X3D. Featuring AMD 3D V-Cache™ technology, it stacks a massive 96MB of L3 cache directly on the processor, delivering game-changing performance in latency-sensitive titles.\r\n\r\nWith 8 cores and 16 threads based on the efficient Zen 4 architecture, this CPU is optimized purely for gaming performance, often outperforming flagship chips that cost nearly twice as much. It supports the latest PCIe 5.0 and DDR5 standards on the AM5 platform.\r\n\r\nKey Features:\r\nCores/Threads: 8 Cores, 16 Threads\r\nCache: 96MB L3 Cache with 3D V-Cache Technology\r\nClock Speed: 4.2 GHz Base, Up to 5.0 GHz Boost\r\nPlatform: Socket AM5 (LGA 1718)\r\nArchitecture: Zen 4 (5nm process technology)\r\nTDP: 120W – Highly efficient for the performance delivered\r\nThe current king of gaming CPUs, offering the best FPS per dollar on the market.', 449.99, 'media/ryzen7.jpg', 'Components', 15),
(25, 'Intel Core i9-14900K 14th Gen 24-Core (8P+16E) Processor', 'Intel Core i9-14900K – Unlocked Performance\r\n\r\nPush your workflow to the limit with the Intel Core i9-14900K. Featuring a hybrid architecture with 8 Performance-cores and 16 Efficient-cores, it handles demanding games and background multitasking simultaneously without skipping a beat.\r\n\r\nCapable of hitting a massive 6.0 GHz right out of the box with Intel Thermal Velocity Boost, this processor is designed for enthusiasts who want raw speed for gaming, streaming, and content creation.\r\n\r\nKey Features:\r\nCore Count: 24 Cores (8 Performance + 16 Efficient), 32 Threads\r\nSpeed: Up to 6.0 GHz Max Turbo Frequency\r\nCache: 36MB Intel® Smart Cache\r\nCompatibility: Intel 600 and 700 series chipset motherboards (LGA 1700)\r\nGraphics: Integrated Intel® UHD Graphics 770\r\nOverclocking: Unlocked for performance tuning\r\nA multitasking monster perfect for streamers and video editors who game on the side.', 589.99, 'media/i7-14th.jpg', 'Components', 8),
(26, 'Samsung 990 PRO 2TB PCIe 4.0 NVMe M.2 SSD', 'Samsung 990 PRO 2TB – Blazing Fast NVMe Storage\r\n\r\nReach max performance with the Samsung 990 PRO. This PCIe 4.0 NVMe SSD delivers blistering speeds of up to 7,450 MB/s read and 6,900 MB/s write, nearing the theoretical limit of the PCIe 4.0 interface.\r\n\r\nDesigned for hardcore gamers and tech-savvy professionals, the 990 PRO features a newly designed in-house controller for superior power efficiency and thermal control. Load games instantly and transfer massive 4K video files in seconds.\r\n\r\nKey Features:\r\nSpeed: Up to 7,450 MB/s Seq. Read, 6,900 MB/s Seq. Write\r\nInterface: PCIe Gen 4.0 x4, NVMe 2.0\r\nEfficiency: 50% improved performance per watt over the 980 PRO\r\nReliability: 1200 TBW (Terabytes Written) endurance\r\nThermal Control: Nickel-coated controller and heat spreader label\r\nSoftware: Samsung Magician software for health monitoring and updates\r\nThe gold standard for high-speed storage, compatible with PC and PS5.', 179.99, 'media/ssd.jpg', 'Components', 9),
(27, 'Corsair Dominator Titanium RGB 64GB (2x32GB) DDR5 6000MHz', 'Corsair Dominator Titanium RGB – Luxury High-Performance Memory\r\n\r\nExperience the pinnacle of memory performance with Corsair Dominator Titanium DDR5. Combining clean, refined styling with superior die-cast aluminum construction, this kit creates a premium look for any high-end build.\r\n\r\nIt features 11 vibrant addressable RGB LEDs per module, fully customizable via iCUE software. The patented DHX cooling technology cools the memory through both the ICs and the ground plane of the PCB, ensuring high performance even under extreme loads.\r\n\r\nKey Features:\r\nCapacity: 64GB (2 x 32GB) Kit\r\nSpeed: DDR5-6000MT/s (PC5-48000)\r\nLatency: CL30-36-36-76 for ultra-low latency response\r\nCooling: Patented DHX (Dual-Path Heat Exchange) cooling\r\nCustomization: Swappable top bars to change the look or add cooling fins\r\nProfiles: Supports Intel XMP 3.0 and AMD EXPO profiles\r\nLuxury memory for those who want the absolute best in aesthetics and speed.', 299.99, 'media/corsair_ram.jpg', 'Components', 15),
(28, 'ASUS ROG Maximus Z790 Hero WiFi 6E LGA 1700 Motherboard', 'ASUS ROG Maximus Z790 Hero – The Foundation of Excellence\r\n\r\nReady for the 14th Gen Intel Core processors, the ROG Maximus Z790 Hero is built for enthusiasts who demand robust power delivery and comprehensive cooling. It features 20+1 power stages rated for 90A, ensuring stable overclocking for the most powerful CPUs.\r\n\r\nConnectivity is unmatched with dual Thunderbolt 4 ports, WiFi 6E, and a PCIe 5.0 M.2 slot card included in the box. The Polymo Lighting on the I/O shroud adds a stunning pixelated light show to your build.\r\n\r\nKey Features:\r\nSocket: LGA 1700 for Intel 12th, 13th, & 14th Gen CPUs\r\nPower: 20+1 Teaming Power Stages (90A) for extreme overclocking\r\nStorage: 5x M.2 slots (1x PCIe 5.0, 4x PCIe 4.0) with heatsinks\r\nConnectivity: Dual Thunderbolt™ 4 USB-C, WiFi 6E, 2.5G Ethernet\r\nAudio: ROG SupremeFX ALC4082 with ESS® ES9218 QUAD DAC\r\nAesthetics: Polymo Lighting I/O cover with customizable Aura Sync RGB\r\nA premium motherboard that offers every feature a power user could dream of.', 629.99, 'media/asus_motherboard.jpg', 'Components', 5),
(29, 'CORSAIR RM850x Fully Modular Low-Noise ATX Power Supply', 'Fully Modular: Reliable and efficient low-noise power supply with fully modular cabling, so you only have to connect the cables your system needs.\r\n\r\nCybenetics Gold-Certified: Rated for up to 91% efficiency, resulting in lower power consumption, less noise, and cooler temperatures.\r\n\r\nATX 3.1 Compliant: Compliant with the ATX 3.1 power standard from Intel, supporting PCIe 5.1 and resisting transient power spikes.\r\n\r\nNative 12V-2x6 Connector: Ensures compatibility with the latest graphics cards with a direct GPU to PSU connection – no adapter necessary.\r\n\r\nEmbossed Cables with Low-Profile Combs: Sleek, ultra-flexible embossed cables look great and make installing and connecting the RMx a breeze.', 210.99, 'media/power_supply.jpg', 'Components', 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `password`, `is_admin`, `address`, `city`, `province`, `postal_code`) VALUES
(2, 'Masir Javed', 'masirmjaved28@gmail.com', 'itsmemasir', '$2y$10$dAUeomGOsr/xEfeHCu2g3eg1K1Z3sqj2Oh5AwRfs66u.Snmt8mMeO', 1, '18-7251 Copenhagen Rd Mississauga', 'Mississauga', 'Alberta', 'L5N 2H6'),
(3, 'Abdul Raafay Sheikh', 'abdulr44fay@gmail.com', 'mnmz2105', '$2y$10$.pE5paqZL72o1WqjXl33ne1Fza4FPHIt4NlvmcYcz1oC6yR4cvRZa', 0, '80 Orenda Court', 'Brampton', 'Ontario', 'L6W 3N1'),
(4, 'Ashok Fitness', 'meow@gmail.com', 'shokie123', '$2y$10$A7TNY.b27OzjZvMY/8/OK./.UzEBGsBNBG4/j12CIh5iD5NRYVwSm', 0, '7251 Copenhagen Rd Mississauga', 'Mississauga', 'Ontario', 'L5H 2H6'),
(5, 'Mohammed Shaikh', 'mo@gmail.com', 'mo123', '$2y$10$IjuX/poBbrtIPtfErZh8vuihQXZunExfHzDT0IVwG1GXmGyuqsB3e', 0, '80 Orenda Court', 'Brampton', 'Ontario', 'L6W 3N1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
