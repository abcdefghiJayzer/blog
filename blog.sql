-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2024 at 02:15 AM
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
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'Adrian Mata', '$2y$10$omK1jE.JngfZahhwdQkY8.Qq5gXNH3ou190/4JJ09ylx1VCYzJye.');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `heart` int(11) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `updatetime` datetime DEFAULT NULL,
  `likes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `author`, `title`, `category`, `image`, `content`, `heart`, `datetime`, `updatetime`, `likes`) VALUES
(17, 'Adrian Mata', 'The AI', 'Internet of Things (IoT)', 'ai.jpg', '<p><strong>Artificial Intelligence (AI)</strong> has rapidly transitioned from a futuristic concept to an integral part of our everyday lives. It\'s not just the stuff of science fiction movies; it\'s here, shaping how we interact with technology and the world around us.</p>\r\n<p>&nbsp;</p>\r\n<p>What Exactly is AI? At its core, AI is about creating systems that can perform tasks that would normally require human intelligence. This includes learning from experience, understanding natural language, recognizing patterns, and making decisions. Think of it as giving machines the ability to think and learn, but at speeds and with data capacities far beyond human capabilities.</p>\r\n<p>&nbsp;</p>\r\n<p>AI in Daily Life You might not realize it, but AI is already a part of your daily routine. Virtual assistants like Siri and Alexa help you manage your tasks. Recommendation algorithms suggest what to watch on Netflix or what to listen to on Spotify. Even your email&rsquo;s spam filter uses AI to keep unwanted messages at bay. These smart systems learn from your interactions to provide a more personalized experience.</p>\r\n<p>&nbsp;</p>\r\n<p>Transforming Industries AI is revolutionizing industries across the board. In healthcare, AI systems are used for diagnostics and personalized treatment plans. In finance, they help detect fraudulent activities and analyze market trends. The automotive industry is using AI to develop self-driving cars, aiming to make our roads safer. Agriculture is benefiting from AI-driven technologies that monitor crop health and optimize yields.</p>\r\n<p>&nbsp;</p>\r\n<p>Challenges and Ethical Considerations While AI brings tremendous benefits, it also poses significant challenges. Concerns about job displacement, privacy, and bias in AI systems are ongoing debates. Ensuring that AI is developed and used ethically is crucial. This includes creating transparent algorithms, protecting user data, and striving for unbiased AI models. The goal is to harness AI\'s power while minimizing potential risks.</p>\r\n<p>&nbsp;</p>\r\n<p>Looking Ahead The future of AI is incredibly promising. Advances in natural language processing, such as more human-like conversational bots, and AI&rsquo;s potential in solving complex global challenges are just the beginning. As AI continues to evolve, it&rsquo;s essential that we remain informed and adaptable to make the most of its capabilities while addressing its challenges.</p>\r\n<p>&nbsp;</p>\r\n<p>Conclusion AI is more than a technological advancement; it\'s a transformative force that is reshaping our world. By understanding its applications, benefits, and challenges, we can better navigate the AI-driven future. Embracing AI with a balanced perspective allows us to leverage its potential to improve lives while maintaining ethical standards.</p>', NULL, '2024-10-19 17:54:18', '2024-10-19 18:29:48', 1),
(18, 'Adrian Mata', 'The Backbone of the Digital World', 'Software', 'software.jfif', '<p>Software, in essence, is a set of instructions that tells a computer how to perform tasks. It ranges from operating systems like Windows and macOS that manage hardware resources, to applications like Photoshop and Microsoft Word that enable us to create and communicate.</p>\r\n<p>&nbsp;</p>\r\n<p>Categories of Software</p>\r\n<p>Software comes in many flavors:</p>\r\n<p>&nbsp;</p>\r\n<p>System Software: This includes operating systems, device drivers, and utilities that manage hardware and basic system operations.</p>\r\n<p>&nbsp;</p>\r\n<p>Application Software: Programs that perform specific tasks for users, such as word processors, games, and media players.</p>\r\n<p>&nbsp;</p>\r\n<p>Development Software: Tools like compilers and code editors that developers use to create other software.</p>\r\n<p>&nbsp;</p>\r\n<p>Open Source vs. Proprietary</p>\r\n<p>A key division in the software world is between open source and proprietary software:</p>\r\n<p>&nbsp;</p>\r\n<p>Open Source: Software with source code that anyone can inspect, modify, and enhance. Examples include Linux and the Apache HTTP Server.</p>\r\n<p>&nbsp;</p>\r\n<p>Proprietary Software: Software that is owned by an individual or company, with restrictions on its use and modification. Microsoft Office and Adobe Photoshop are prime examples.</p>\r\n<p>&nbsp;</p>\r\n<p>The Evolution of Software</p>\r\n<p>From punch cards to cloud computing, the evolution of software has been rapid and transformative. Early programs were simple and specific, but today&rsquo;s software can manage vast data sets, perform complex analyses, and support intricate virtual environments.</p>\r\n<p>&nbsp;</p>\r\n<p>Impact on Everyday Life</p>\r\n<p>Think about your daily routine: checking your smartphone, working on a computer, streaming music or videos. All these activities are made possible by software. It&rsquo;s deeply integrated into industries like healthcare, finance, and entertainment, driving innovation and efficiency.</p>\r\n<p>&nbsp;</p>\r\n<p>The Future of Software</p>\r\n<p>As we move towards AI and machine learning, the future of software looks more intelligent and intuitive. We&rsquo;re heading into an era where software not only follows commands but anticipates needs, adapts to environments, and learns from interactions.</p>\r\n<p>&nbsp;</p>\r\n<p>In the grand tapestry of technology, software is the thread that brings the picture to life. From the simplest apps to the most complex systems, it&rsquo;s the digital wizard making magic happen behind the scenes.</p>', NULL, '2024-10-20 23:38:30', '2024-10-20 23:45:23', 13),
(19, 'Adrian Mata', 'The Constant Evolution', 'Hardware', 'internet-technology-hg-3840x2160.jpg', '<p>Technology moves at the speed of light&mdash;literally. What was cutting-edge last year is old news today. It&rsquo;s a relentless march forward, driven by innovation, creativity, and sometimes sheer necessity. Think about the rapid development of 5G networks, promising faster speeds and more reliable connections for everything from smartphones to smart homes.</p>\r\n<p>&nbsp;</p>\r\n<p>The Rise of Artificial Intelligence</p>\r\n<p>AI is no longer the stuff of science fiction. It&rsquo;s here, and it&rsquo;s transforming industries. From healthcare where AI helps diagnose diseases, to finance where it powers algorithmic trading, AI is becoming an integral part of our daily lives. It&rsquo;s all about making machines smarter, so they can help us make better decisions.</p>\r\n<p>&nbsp;</p>\r\n<p>The Internet of Things (IoT)</p>\r\n<p>Imagine a world where your fridge orders milk when you&rsquo;re running low, or your thermostat adjusts itself based on your routine. That&rsquo;s the promise of IoT. It&rsquo;s about creating a network of interconnected devices that communicate seamlessly, making our lives more efficient and convenient.</p>\r\n<p>&nbsp;</p>\r\n<p>Sustainability Through Tech</p>\r\n<p>Technology is also our ally in the fight against climate change. From renewable energy solutions like solar and wind power to electric vehicles and smart grids, tech is paving the way for a greener future. Innovations in materials science are even creating biodegradable electronics, reducing e-waste.</p>\r\n<p>&nbsp;</p>\r\n<p>The Digital Economy</p>\r\n<p>Cryptocurrencies and blockchain technology are revolutionizing finance. These digital assets are creating new economic opportunities and democratizing financial systems. It&rsquo;s about more than just Bitcoin&mdash;it&rsquo;s about decentralized finance (DeFi) that operates independently of traditional banks.</p>\r\n<p>&nbsp;</p>\r\n<p>The Future is Now</p>\r\n<p>Augmented reality (AR) and virtual reality (VR) are changing the way we interact with the world. From gaming to education and even remote work, these technologies offer immersive experiences that bridge the gap between the digital and physical worlds.</p>\r\n<p>&nbsp;</p>\r\n<p>The Cybersecurity Challenge</p>\r\n<p>As we become more interconnected, cybersecurity becomes paramount. Protecting data and privacy is a growing concern, with tech companies continually developing new ways to secure our digital lives. It&rsquo;s a constant cat-and-mouse game between cybercriminals and security experts.</p>\r\n<p>&nbsp;</p>\r\n<p>Conclusion</p>\r\n<p>Technology is the engine driving modern society forward. It&rsquo;s not just about gadgets and gizmos; it&rsquo;s about creating a better, more connected, and sustainable world. Whether it&rsquo;s through AI, IoT, or sustainable tech, the future is filled with endless possibilities.</p>', NULL, '2024-10-20 23:44:41', '2024-10-20 23:45:51', 3),
(20, 'Adrian Mata', 'sad', 'Artificial Intelligence (AI)', '87423d7ed9b767f2a979ba7e6a9d3200.jpg', '<p><strong>hello&nbsp;</strong></p>', NULL, '2024-10-21 13:28:15', '2024-10-21 13:28:33', 0),
(22, 'Adrian Mata', 'The Ai', 'Software', '225794.jpg', '<p>dsasdas</p>', NULL, '2024-10-21 13:30:13', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `post_id` int(11) NOT NULL,
  `commentdate` datetime NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `username`, `post_id`, `commentdate`, `text`) VALUES
(1, 'Baldo', 17, '2024-10-20 14:44:26', 'Amazing!'),
(5, 'Adrian Mata', 17, '2024-10-20 23:48:08', 'Cool!'),
(6, 'sad', 19, '2024-10-21 00:39:51', 'sad'),
(7, 'Sad123', 19, '2024-10-21 10:04:12', 'Amazing'),
(8, 'Sad123', 19, '2024-10-21 10:09:35', 'Nice one'),
(9, 'sad', 19, '2024-10-21 13:26:46', 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `join_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `join_date`) VALUES
(1, 'mcbee', 'mcbee@boy.com', '$2y$10$SCqmIfKxdzdcXj387DGrhO9ZsQPhnchZZ22r/0H9N58L3AT3bKwii', '2024-10-20'),
(2, 'mcbee', 'mcbee@boy.com', '$2y$10$jJ/2LMIThOUyPeOACKsjA.3pqJg/R8FzWEabuIl0sQFBiul2Y0VGa', '2024-10-20'),
(3, 'sad', 'sad@sad.com', '$2y$10$oQpQYSZEpzZC55ykQjYzjeF6Qkh9P/bG5H52y0TbexouM/b/m5RUG', '2024-10-20'),
(4, 'sad', 'sad@sad', '$2y$10$S1d0GnxowLa5bqRr6p4mEuiHH7Tvjzov6J7Nddoj0x.oSY19JVKSa', '2024-10-20'),
(5, 'sad', 'sad@sad', '$2y$10$UHl3LkNI4dpyrzH6HIJWL.Hha7Q1nJoNvpUh6V6Fj9NXR2t00tSHa', '2024-10-20'),
(6, 'sad', 'sad@sad', '$2y$10$WBnIQKoDw0bjURWXOwqxgOxosKkQfEIjVPCFMClQ5ZSVvTswl7Bna', '2024-10-20'),
(7, 'sad', 'sad@sad', '$2y$10$nTHfc/kMO2kS2uGMjH1PbuDHMzDZ33qF1.B.Ix3VCFi7HGoHCkUQC', '2024-10-20'),
(8, 'sad', 'sad@sad', '$2y$10$mDA/8f0JQ/RsJWg4MmS0ku9NkAD3wNKWhg46tJaWOwGlmXP5NuTHm', '2024-10-20'),
(9, 'Sad123', 'sad@sad', '$2y$10$/IXUEy33c5HWag.RocP/GeHPlPGn1cqwGJxO/ELf/pPBuchlyJltm', '2024-10-21'),
(10, 'sad', 'sad@sad.com', '$2y$10$ixne23iDm1dDc64aXT2pq.JAEXKoyaqxv/zoxEav1yeedst/8gR2q', '2024-10-21'),
(11, 'sad', 'sad@sad.com', '$2y$10$F/zRLylDyDA4EpGR3Vvic.vb3w4qRr7NDpS5skKQKANKqAsgvPc.m', '2024-10-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
