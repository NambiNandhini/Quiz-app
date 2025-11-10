-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 10, 2025 at 06:16 AM
-- Server version: 9.1.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Web Development', 'Questions about web technologies and programming'),
(2, 'Mathematics', 'Mathematical concepts and problems'),
(3, 'General Knowledge', 'General knowledge questions'),
(4, 'Science', 'Scientific concepts and facts'),
(5, 'Programming', 'Computer programming concepts and languages');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `question` text NOT NULL,
  `option1` text NOT NULL,
  `option2` text NOT NULL,
  `option3` text NOT NULL,
  `option4` text NOT NULL,
  `correct_option` int NOT NULL,
  `difficulty` enum('easy','medium','hard') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `category_id`, `question`, `option1`, `option2`, `option3`, `option4`, `correct_option`, `difficulty`, `created_at`) VALUES
(1, 1, 'What does HTML stand for?', 'Hyper Text Markup Language', 'High Tech Modern Language', 'Hyper Transfer Markup Language', 'Home Tool Markup Language', 1, 'easy', '2025-11-04 09:54:49'),
(2, 1, 'Which of the following is NOT a JavaScript framework?', 'React', 'Angular', 'Vue', 'Laravel', 4, 'easy', '2025-11-04 09:54:49'),
(3, 1, 'What is the purpose of CSS?', 'To structure web content', 'To add interactivity to web pages', 'To style web pages', 'To manage databases', 3, 'easy', '2025-11-04 09:54:49'),
(4, 1, 'What does API stand for?', 'Application Programming Interface', 'Advanced Programming Interface', 'Automated Programming Interface', 'Application Protocol Interface', 1, 'medium', '2025-11-04 09:54:49'),
(5, 1, 'Which method is used to add an element to the end of an array in JavaScript?', 'push()', 'pop()', 'shift()', 'unshift()', 1, 'medium', '2025-11-04 09:54:49'),
(6, 1, 'What is the virtual DOM in React?', 'A direct representation of the real DOM', 'A concept where UI is kept in memory and synced with the real DOM', 'A DOM that exists only during development', 'A DOM that is not accessible to JavaScript', 2, 'hard', '2025-11-04 09:54:49'),
(7, 1, 'What is the time complexity of binary search?', 'O(1)', 'O(n)', 'O(log n)', 'O(n log n)', 3, 'hard', '2025-11-04 09:54:49'),
(8, 2, 'What is the value of π (pi) approximately?', '3.14', '2.71', '1.62', '1.41', 1, 'easy', '2025-11-04 09:54:49'),
(9, 2, 'What is the derivative of x²?', 'x', '2x', '2', 'x²', 2, 'medium', '2025-11-04 09:54:49'),
(10, 2, 'What is the integral of 1/x?', 'ln|x| + C', 'x²/2 + C', '1/x² + C', 'x + C', 1, 'hard', '2025-11-04 09:54:49'),
(11, 3, 'Which planet is known as the Red Planet?', 'Venus', 'Mars', 'Jupiter', 'Saturn', 2, 'easy', '2025-11-04 09:54:49'),
(12, 3, 'Who wrote \"Romeo and Juliet\"?', 'Charles Dickens', 'William Shakespeare', 'Jane Austen', 'Mark Twain', 2, 'easy', '2025-11-04 09:54:49'),
(13, 3, 'What is the capital of Japan?', 'Seoul', 'Beijing', 'Tokyo', 'Bangkok', 3, 'easy', '2025-11-04 09:54:49'),
(14, 3, 'Which element has the chemical symbol \"Au\"?', 'Silver', 'Gold', 'Aluminum', 'Argon', 2, 'medium', '2025-11-04 09:54:49'),
(15, 4, 'What is the chemical formula for water?', 'H2O', 'CO2', 'NaCl', 'O2', 1, 'easy', '2025-11-04 09:54:49'),
(16, 4, 'Which gas do plants absorb from the atmosphere?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen', 3, 'easy', '2025-11-04 09:54:49'),
(17, 4, 'What is the speed of light in vacuum?', '299,792,458 m/s', '300,000,000 m/s', '150,000,000 m/s', '1,080,000,000 km/h', 1, 'hard', '2025-11-04 09:54:49'),
(18, 1, 'Which CSS property is used to change text color?', 'text-color', 'font-color', 'color', 'text-style', 3, 'easy', '2025-11-07 10:15:59'),
(19, 1, 'Which HTML tag is used to create a hyperlink?', '<link>', '<a>', '<href>', '<hyperlink>', 2, 'easy', '2025-11-07 10:15:59'),
(20, 1, 'What does CSS stand for?', 'Computer Style Sheets', 'Creative Style System', 'Cascading Style Sheets', 'Colorful Style Sheets', 3, 'easy', '2025-11-07 10:15:59'),
(21, 1, 'Which symbol is used for ID selector in CSS?', '.', '#', '@', '*', 2, 'easy', '2025-11-07 10:15:59'),
(22, 1, 'What is the purpose of the z-index property in CSS?', 'To change font size', 'To control element stacking order', 'To set background color', 'To create animations', 2, 'medium', '2025-11-07 10:18:22'),
(23, 1, 'Which JavaScript method is used to parse JSON string?', 'JSON.parse()', 'JSON.stringify()', 'JSON.decode()', 'JSON.convert()', 1, 'medium', '2025-11-07 10:18:22'),
(24, 1, 'What does the \"box model\" in CSS consist of?', 'Margin, Border, Padding, Content', 'Width, Height, Depth, Color', 'Top, Right, Bottom, Left', 'Header, Body, Footer, Sidebar', 1, 'medium', '2025-11-07 10:18:22'),
(25, 1, 'Which HTML5 tag is used for drawing graphics?', '<graphic>', '<draw>', '<canvas>', '<svg>', 3, 'medium', '2025-11-07 10:18:22'),
(26, 1, 'What is the purpose of media queries in CSS?', 'To play media files', 'To apply styles based on device characteristics', 'To optimize images', 'To create responsive tables', 2, 'medium', '2025-11-07 10:18:22'),
(27, 1, 'What is the difference between == and === in JavaScript?', 'No difference', '== checks value, === checks value and type', '=== is newer version', '== is for strings, === for numbers', 2, 'hard', '2025-11-07 10:20:21'),
(28, 1, 'What is the purpose of the \"this\" keyword in JavaScript?', 'Refers to current function', 'Refers to parent element', 'Refers to current object', 'Refers to global object', 3, 'hard', '2025-11-07 10:20:21'),
(29, 1, 'What is CORS in web development?', 'A programming language', 'A database system', 'A security feature', 'A CSS framework', 3, 'hard', '2025-11-07 10:20:21'),
(30, 1, 'What is the virtual DOM in React?', 'A real DOM copy', 'A programming concept', 'A lightweight copy of real DOM', 'A browser feature', 3, 'hard', '2025-11-07 10:20:21'),
(31, 1, 'What is the time complexity of array insertion in JavaScript?', 'O(1)', 'O(n)', 'O(log n)', 'It depends on the operation', 4, 'hard', '2025-11-07 10:20:21'),
(32, 2, 'What is 15 + 27?', '32', '42', '38', '45', 2, 'easy', '2025-11-07 10:22:02'),
(33, 2, 'What is the value of π (pi) approximately?', '3.14', '2.71', '1.61', '3.41', 1, 'easy', '2025-11-07 10:22:02'),
(34, 2, 'What is 8 × 7?', '54', '56', '64', '48', 2, 'easy', '2025-11-07 10:22:02'),
(35, 2, 'What is the square root of 64?', '6', '7', '8', '9', 3, 'easy', '2025-11-07 10:22:02'),
(36, 2, 'What is 144 ÷ 12?', '10', '11', '12', '13', 3, 'easy', '2025-11-07 10:22:02'),
(37, 2, 'Solve for x: 2x + 5 = 15', 'x = 5', 'x = 10', 'x = 7.5', 'x = 5.5', 1, 'medium', '2025-11-07 10:23:35'),
(38, 2, 'What is the area of a circle with radius 7?', '49π', '14π', '28π', '154π', 1, 'medium', '2025-11-07 10:23:35'),
(39, 2, 'What is 3/4 as a decimal?', '0.25', '0.5', '0.75', '1.33', 3, 'medium', '2025-11-07 10:23:35'),
(40, 2, 'What is the Pythagorean theorem?', 'a² + b² = c²', 'E = mc²', 'a² - b² = (a+b)(a-b)', 'V = πr²h', 1, 'medium', '2025-11-07 10:23:35'),
(41, 2, 'What is the value of 5! (5 factorial)?', '25', '60', '120', '125', 3, 'medium', '2025-11-07 10:23:35'),
(42, 2, 'What is the derivative of x³?', '3x²', '3x', 'x²', '2x³', 1, 'hard', '2025-11-07 10:24:47'),
(43, 2, 'What is the value of ∫(2x dx) from 0 to 3?', '6', '9', '12', '18', 2, 'hard', '2025-11-07 10:24:47'),
(44, 2, 'What is the probability of getting two heads in two coin tosses?', '1/4', '1/2', '3/4', '1/3', 1, 'hard', '2025-11-07 10:24:47'),
(45, 2, 'What is the value of log₁₀1000?', '2', '3', '4', '10', 2, 'hard', '2025-11-07 10:24:47'),
(46, 2, 'What is the solution to the quadratic equation x² - 5x + 6 = 0?', 'x = 2,3', 'x = 1,6', 'x = -2,-3', 'x = -1,-6', 1, 'hard', '2025-11-07 10:24:47'),
(47, 5, 'What is a variable in programming?', 'A constant value', 'A container for storing data', 'A type of function', 'A programming language', 2, 'easy', '2025-11-07 10:29:09'),
(48, 5, 'Which loop runs at least once?', 'for loop', 'while loop', 'do-while loop', 'if statement', 3, 'easy', '2025-11-07 10:29:09'),
(49, 5, 'What does IDE stand for?', 'Integrated Development Environment', 'International Development Engine', 'Integrated Design Environment', 'Interactive Development Editor', 1, 'easy', '2025-11-07 10:29:09'),
(50, 5, 'Which data type represents true/false values?', 'Integer', 'String', 'Boolean', 'Float', 3, 'easy', '2025-11-07 10:29:09'),
(51, 5, 'What is the purpose of comments in code?', 'To execute code', 'To explain code to humans', 'To create variables', 'To fix errors', 2, 'easy', '2025-11-07 10:29:09'),
(52, 5, 'What is object-oriented programming?', 'A database system', 'A programming paradigm based on objects', 'A type of loop', 'A web framework', 2, 'medium', '2025-11-07 10:29:45'),
(53, 5, 'What is recursion?', 'A type of loop', 'A function calling itself', 'A data structure', 'A sorting algorithm', 2, 'medium', '2025-11-07 10:29:45'),
(54, 5, 'What is a constructor?', 'A special method to initialize objects', 'A type of variable', 'A loop structure', 'A database query', 1, 'medium', '2025-11-07 10:29:45'),
(55, 5, 'What is version control?', 'A programming language', 'A method for tracking code changes', 'A type of database', 'A testing framework', 2, 'medium', '2025-11-07 10:29:45'),
(56, 5, 'What is polymorphism in OOP?', 'Creating multiple objects', 'Same interface, different implementations', 'Inheriting from multiple classes', 'Hiding implementation details', 2, 'hard', '2025-11-07 10:30:12'),
(57, 5, 'What is a memory leak?', 'Fast memory access', 'Memory that is never released', 'Small memory size', 'Memory encryption', 2, 'hard', '2025-11-07 10:30:12'),
(58, 5, 'What is the difference between stack and heap?', 'No difference', 'Stack for static, heap for dynamic memory', 'Stack for dynamic, heap for static memory', 'Stack is faster, heap is slower', 2, 'hard', '2025-11-07 10:30:12'),
(59, 5, 'What is a singleton pattern?', 'A class with multiple instances', 'A class with only one instance', 'A database pattern', 'A sorting algorithm', 2, 'hard', '2025-11-07 10:30:12'),
(60, 5, 'What is tail recursion?', 'Recursion without base case', 'Recursion where the recursive call is the last operation', 'Infinite recursion', 'Recursion with multiple calls', 2, 'hard', '2025-11-07 10:30:12'),
(61, 4, 'What is photosynthesis?', 'Plant respiration', 'Process of making food using light', 'Plant reproduction', 'Water absorption', 2, 'medium', '2025-11-10 04:43:24'),
(62, 4, 'What is DNA?', 'An energy molecule', 'Genetic material', 'A protein', 'A cell membrane', 2, 'medium', '2025-11-10 04:43:24'),
(63, 4, 'What causes tides?', 'Earth\'s rotation', 'Moon\'s gravity', 'Sun\'s heat', 'Ocean currents', 2, 'medium', '2025-11-10 04:43:24'),
(64, 4, 'What is the pH of pure water?', '5', '6', '7', '8', 3, 'medium', '2025-11-10 04:43:24'),
(65, 4, 'What type of energy is stored in batteries?', 'Kinetic energy', 'Chemical energy', 'Thermal energy', 'Nuclear energy', 2, 'medium', '2025-11-10 04:43:24'),
(66, 4, 'What is quantum entanglement?', 'A chemical bond', 'Particles connected regardless of distance', 'A type of gravity', 'Nuclear fusion', 2, 'hard', '2025-11-10 04:44:12'),
(67, 4, 'What is the Heisenberg Uncertainty Principle?', 'Energy conservation', 'Position and momentum cannot both be known precisely', 'Relativity theory', 'Quantum superposition', 2, 'hard', '2025-11-10 04:44:12'),
(68, 4, 'What is dark matter?', 'Black holes', 'Invisible matter affecting gravity', 'Anti-matter', 'Dark energy', 2, 'hard', '2025-11-10 04:44:12'),
(69, 4, 'What is the theory of relativity?', 'Newton\'s laws', 'Einstein\'s theory of gravity and spacetime', 'Quantum mechanics', 'String theory', 2, 'hard', '2025-11-10 04:44:12'),
(70, 4, 'What is CRISPR?', 'A telescope', 'Gene editing technology', 'A particle accelerator', 'A space probe', 2, 'hard', '2025-11-10 04:44:12'),
(71, 3, 'What is the capital of France?', 'London', 'Berlin', 'Paris', 'Madrid', 3, 'easy', '2025-11-10 04:45:34'),
(72, 3, 'How many continents are there?', '5', '6', '7', '8', 3, 'easy', '2025-11-10 04:45:34'),
(73, 3, 'What is the largest planet in our solar system?', 'Earth', 'Saturn', 'Jupiter', 'Mars', 3, 'easy', '2025-11-10 04:45:34'),
(74, 3, 'Who wrote \"Romeo and Juliet\"?', 'Charles Dickens', 'William Shakespeare', 'Jane Austen', 'Mark Twain', 2, 'easy', '2025-11-10 04:45:34'),
(75, 3, 'What is the chemical symbol for gold?', 'Go', 'Gd', 'Au', 'Ag', 3, 'easy', '2025-11-10 04:45:34'),
(76, 3, 'Which element has the atomic number 1?', 'Oxygen', 'Helium', 'Hydrogen', 'Carbon', 3, 'medium', '2025-11-10 04:45:58'),
(77, 3, 'What year did World War II end?', '1944', '1945', '1946', '1947', 2, 'medium', '2025-11-10 04:45:58'),
(78, 3, 'Which planet is known as the Red Planet?', 'Venus', 'Mars', 'Jupiter', 'Saturn', 2, 'medium', '2025-11-10 04:45:58'),
(79, 3, 'Who painted the Mona Lisa?', 'Vincent van Gogh', 'Pablo Picasso', 'Leonardo da Vinci', 'Michelangelo', 3, 'medium', '2025-11-10 04:45:58'),
(80, 3, 'What is the largest ocean on Earth?', 'Atlantic Ocean', 'Indian Ocean', 'Arctic Ocean', 'Pacific Ocean', 4, 'medium', '2025-11-10 04:45:58'),
(81, 3, 'What is the speed of light in vacuum?', '299,792,458 m/s', '300,000,000 m/s', '299,792 km/s', '186,282 m/s', 1, 'hard', '2025-11-10 04:46:15'),
(82, 3, 'Who discovered penicillin?', 'Marie Curie', 'Alexander Fleming', 'Louis Pasteur', 'Albert Einstein', 2, 'hard', '2025-11-10 04:46:15'),
(83, 3, 'What is the smallest country in the world?', 'Monaco', 'Vatican City', 'San Marino', 'Liechtenstein', 2, 'hard', '2025-11-10 04:46:15'),
(84, 3, 'Which element is liquid at room temperature?', 'Bromine', 'Mercury', 'Both A and B', 'Gallium', 3, 'hard', '2025-11-10 04:46:15'),
(85, 3, 'What is the hardest natural substance on Earth?', 'Gold', 'Iron', 'Diamond', 'Platinum', 3, 'hard', '2025-11-10 04:46:15');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_sessions`
--

DROP TABLE IF EXISTS `quiz_sessions`;
CREATE TABLE IF NOT EXISTS `quiz_sessions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) NOT NULL,
  `category_id` int DEFAULT NULL,
  `difficulty` varchar(20) DEFAULT NULL,
  `total_questions` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `completed` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_id` (`session_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `quiz_sessions`
--

INSERT INTO `quiz_sessions` (`id`, `session_id`, `category_id`, `difficulty`, `total_questions`, `score`, `completed`, `created_at`) VALUES
(1, 'quiz_6909ce9c69fec8.51510303', 1, 'easy', 3, 0, 1, '2025-11-04 10:00:14'),
(2, 'quiz_6909cec2e42eb3.21990363', 1, 'all', 7, 0, 1, '2025-11-04 10:01:27'),
(3, 'quiz_6909d040486fb2.44521186', NULL, 'all', 10, 8, 1, '2025-11-04 10:07:40'),
(4, 'quiz_690c6e021b1831.68161150', NULL, 'all', 10, 9, 1, '2025-11-06 09:45:51'),
(5, 'quiz_690dc1fded0c77.84053834', NULL, 'all', 10, 9, 1, '2025-11-07 09:56:22'),
(6, 'quiz_690dc2546484a7.65752670', 2, 'hard', 1, 1, 1, '2025-11-07 09:56:41'),
(7, 'quiz_690dc25e98a911.56660635', 4, 'all', 3, 3, 1, '2025-11-07 09:56:58'),
(8, 'quiz_690dc26f1bc312.72357807', 3, 'all', 4, 3, 1, '2025-11-07 09:57:16'),
(9, 'quiz_690dc9349efcd9.59350004', 1, 'easy', 7, 5, 1, '2025-11-07 10:26:36'),
(10, 'quiz_69116b54a1bb59.73765270', NULL, 'all', 10, 7, 1, '2025-11-10 04:36:10'),
(11, 'quiz_69117244449182.95225279', NULL, 'all', 10, 9, 1, '2025-11-10 05:05:09'),
(12, 'quiz_6911735f922ac1.09334422', NULL, 'all', 10, 9, 1, '2025-11-10 05:10:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

DROP TABLE IF EXISTS `user_answers`;
CREATE TABLE IF NOT EXISTS `user_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) DEFAULT NULL,
  `question_id` int DEFAULT NULL,
  `user_answer` int DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `answered_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  KEY `question_id` (`question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `session_id`, `question_id`, `user_answer`, `is_correct`, `answered_at`) VALUES
(1, 'quiz_6909ce9c69fec8.51510303', 1, 1, 0, '2025-11-04 10:00:14'),
(2, 'quiz_6909ce9c69fec8.51510303', 3, 3, 0, '2025-11-04 10:00:14'),
(3, 'quiz_6909ce9c69fec8.51510303', 2, 4, 0, '2025-11-04 10:00:14'),
(4, 'quiz_6909cec2e42eb3.21990363', 7, 2, 0, '2025-11-04 10:01:27'),
(5, 'quiz_6909cec2e42eb3.21990363', 3, 3, 0, '2025-11-04 10:01:27'),
(6, 'quiz_6909cec2e42eb3.21990363', 1, 1, 0, '2025-11-04 10:01:27'),
(7, 'quiz_6909cec2e42eb3.21990363', 2, 4, 0, '2025-11-04 10:01:27'),
(8, 'quiz_6909cec2e42eb3.21990363', 6, 1, 0, '2025-11-04 10:01:27'),
(9, 'quiz_6909cec2e42eb3.21990363', 4, 1, 0, '2025-11-04 10:01:27'),
(10, 'quiz_6909cec2e42eb3.21990363', 5, 3, 0, '2025-11-04 10:01:27'),
(11, 'quiz_6909d040486fb2.44521186', 6, 2, 1, '2025-11-04 10:07:40'),
(12, 'quiz_6909d040486fb2.44521186', 9, 2, 1, '2025-11-04 10:07:40'),
(13, 'quiz_6909d040486fb2.44521186', 12, 2, 1, '2025-11-04 10:07:40'),
(14, 'quiz_6909d040486fb2.44521186', 4, 1, 1, '2025-11-04 10:07:40'),
(15, 'quiz_6909d040486fb2.44521186', 15, 1, 1, '2025-11-04 10:07:40'),
(16, 'quiz_6909d040486fb2.44521186', 3, 3, 1, '2025-11-04 10:07:40'),
(17, 'quiz_6909d040486fb2.44521186', 17, 2, 0, '2025-11-04 10:07:40'),
(18, 'quiz_6909d040486fb2.44521186', 10, 3, 0, '2025-11-04 10:07:40'),
(19, 'quiz_6909d040486fb2.44521186', 5, 1, 1, '2025-11-04 10:07:40'),
(20, 'quiz_6909d040486fb2.44521186', 1, 1, 1, '2025-11-04 10:07:40'),
(21, 'quiz_690c6e021b1831.68161150', 2, 4, 1, '2025-11-06 09:45:51'),
(22, 'quiz_690c6e021b1831.68161150', 3, 3, 1, '2025-11-06 09:45:51'),
(23, 'quiz_690c6e021b1831.68161150', 15, 1, 1, '2025-11-06 09:45:51'),
(24, 'quiz_690c6e021b1831.68161150', 8, 1, 1, '2025-11-06 09:45:51'),
(25, 'quiz_690c6e021b1831.68161150', 17, 1, 1, '2025-11-06 09:45:51'),
(26, 'quiz_690c6e021b1831.68161150', 10, 1, 1, '2025-11-06 09:45:51'),
(27, 'quiz_690c6e021b1831.68161150', 16, 1, 0, '2025-11-06 09:45:51'),
(28, 'quiz_690c6e021b1831.68161150', 9, 2, 1, '2025-11-06 09:45:51'),
(29, 'quiz_690c6e021b1831.68161150', 12, 2, 1, '2025-11-06 09:45:51'),
(30, 'quiz_690c6e021b1831.68161150', 13, 3, 1, '2025-11-06 09:45:51'),
(31, 'quiz_690dc1fded0c77.84053834', 8, 1, 1, '2025-11-07 09:56:22'),
(32, 'quiz_690dc1fded0c77.84053834', 12, 2, 1, '2025-11-07 09:56:22'),
(33, 'quiz_690dc1fded0c77.84053834', 9, 2, 1, '2025-11-07 09:56:22'),
(34, 'quiz_690dc1fded0c77.84053834', 7, 4, 0, '2025-11-07 09:56:22'),
(35, 'quiz_690dc1fded0c77.84053834', 10, 1, 1, '2025-11-07 09:56:22'),
(36, 'quiz_690dc1fded0c77.84053834', 17, 1, 1, '2025-11-07 09:56:22'),
(37, 'quiz_690dc1fded0c77.84053834', 11, 2, 1, '2025-11-07 09:56:22'),
(38, 'quiz_690dc1fded0c77.84053834', 13, 3, 1, '2025-11-07 09:56:22'),
(39, 'quiz_690dc1fded0c77.84053834', 1, 1, 1, '2025-11-07 09:56:22'),
(40, 'quiz_690dc1fded0c77.84053834', 2, 4, 1, '2025-11-07 09:56:22'),
(41, 'quiz_690dc2546484a7.65752670', 10, 1, 1, '2025-11-07 09:56:41'),
(42, 'quiz_690dc25e98a911.56660635', 15, 1, 1, '2025-11-07 09:56:58'),
(43, 'quiz_690dc25e98a911.56660635', 16, 3, 1, '2025-11-07 09:56:58'),
(44, 'quiz_690dc25e98a911.56660635', 17, 1, 1, '2025-11-07 09:56:58'),
(45, 'quiz_690dc26f1bc312.72357807', 14, 3, 0, '2025-11-07 09:57:16'),
(46, 'quiz_690dc26f1bc312.72357807', 12, 2, 1, '2025-11-07 09:57:16'),
(47, 'quiz_690dc26f1bc312.72357807', 13, 3, 1, '2025-11-07 09:57:16'),
(48, 'quiz_690dc26f1bc312.72357807', 11, 2, 1, '2025-11-07 09:57:16'),
(49, 'quiz_690dc9349efcd9.59350004', 21, 1, 0, '2025-11-07 10:26:36'),
(50, 'quiz_690dc9349efcd9.59350004', 19, 2, 1, '2025-11-07 10:26:36'),
(51, 'quiz_690dc9349efcd9.59350004', 2, 4, 1, '2025-11-07 10:26:36'),
(52, 'quiz_690dc9349efcd9.59350004', 18, 1, 0, '2025-11-07 10:26:36'),
(53, 'quiz_690dc9349efcd9.59350004', 1, 1, 1, '2025-11-07 10:26:36'),
(54, 'quiz_690dc9349efcd9.59350004', 3, 3, 1, '2025-11-07 10:26:36'),
(55, 'quiz_690dc9349efcd9.59350004', 20, 3, 1, '2025-11-07 10:26:36'),
(56, 'quiz_69116b54a1bb59.73765270', 7, 3, 1, '2025-11-10 04:36:10'),
(57, 'quiz_69116b54a1bb59.73765270', 28, 3, 1, '2025-11-10 04:36:10'),
(58, 'quiz_69116b54a1bb59.73765270', 31, 4, 1, '2025-11-10 04:36:10'),
(59, 'quiz_69116b54a1bb59.73765270', 49, 1, 1, '2025-11-10 04:36:10'),
(60, 'quiz_69116b54a1bb59.73765270', 29, 1, 0, '2025-11-10 04:36:10'),
(61, 'quiz_69116b54a1bb59.73765270', 53, 2, 1, '2025-11-10 04:36:10'),
(62, 'quiz_69116b54a1bb59.73765270', 41, 3, 1, '2025-11-10 04:36:10'),
(63, 'quiz_69116b54a1bb59.73765270', 46, 1, 1, '2025-11-10 04:36:10'),
(64, 'quiz_69116b54a1bb59.73765270', 26, 1, 0, '2025-11-10 04:36:10'),
(65, 'quiz_69116b54a1bb59.73765270', 60, 4, 0, '2025-11-10 04:36:10'),
(66, 'quiz_69117244449182.95225279', 40, 1, 1, '2025-11-10 05:05:09'),
(67, 'quiz_69117244449182.95225279', 79, 3, 1, '2025-11-10 05:05:09'),
(68, 'quiz_69117244449182.95225279', 75, 3, 1, '2025-11-10 05:05:09'),
(69, 'quiz_69117244449182.95225279', 24, 1, 1, '2025-11-10 05:05:09'),
(70, 'quiz_69117244449182.95225279', 48, 3, 1, '2025-11-10 05:05:09'),
(71, 'quiz_69117244449182.95225279', 23, 1, 1, '2025-11-10 05:05:09'),
(72, 'quiz_69117244449182.95225279', 9, 2, 1, '2025-11-10 05:05:09'),
(73, 'quiz_69117244449182.95225279', 14, 2, 1, '2025-11-10 05:05:09'),
(74, 'quiz_69117244449182.95225279', 70, 2, 1, '2025-11-10 05:05:09'),
(75, 'quiz_69117244449182.95225279', 73, 2, 0, '2025-11-10 05:05:09'),
(76, 'quiz_6911735f922ac1.09334422', 23, 1, 1, '2025-11-10 05:10:06'),
(77, 'quiz_6911735f922ac1.09334422', 44, 1, 1, '2025-11-10 05:10:06'),
(78, 'quiz_6911735f922ac1.09334422', 12, 2, 1, '2025-11-10 05:10:06'),
(79, 'quiz_6911735f922ac1.09334422', 41, 3, 1, '2025-11-10 05:10:06'),
(80, 'quiz_6911735f922ac1.09334422', 74, 2, 1, '2025-11-10 05:10:06'),
(81, 'quiz_6911735f922ac1.09334422', 75, 3, 1, '2025-11-10 05:10:06'),
(82, 'quiz_6911735f922ac1.09334422', 29, 3, 1, '2025-11-10 05:10:06'),
(83, 'quiz_6911735f922ac1.09334422', 47, 2, 1, '2025-11-10 05:10:06'),
(84, 'quiz_6911735f922ac1.09334422', 11, 2, 1, '2025-11-10 05:10:06'),
(85, 'quiz_6911735f922ac1.09334422', 57, 1, 0, '2025-11-10 05:10:06');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
