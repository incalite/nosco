-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 27, 2019 at 12:29 AM
-- Server version: 5.6.35
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nosco_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `administration`
--

CREATE TABLE `administration` (
  `admin_id` int(11) NOT NULL,
  `admin_username` text NOT NULL,
  `admin_password` text NOT NULL,
  `admin_rank` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `administration`
--

INSERT INTO `administration` (`admin_id`, `admin_username`, `admin_password`, `admin_rank`) VALUES
(1, 'bishop', 'f6fdffe48c908deb0f4c3bd36c032e72', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `inquiry_id` int(11) NOT NULL,
  `user_c_id` int(11) NOT NULL,
  `comment_body` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`comment_id`, `inquiry_id`, `user_c_id`, `comment_body`) VALUES
(5, 5, 9, 'For example, is it true to say that if the surface areas are equal then the solid must be a regular tetrahedron? If the answer is negative, then what else we need to fully determine the shape of the tetrahedron in space?'),
(7, 12, 4, ' I was wondering if the four areas of a tetrahedron faces were sufficient information to uniquely determine its shape. For example, is it true to say that if the surface areas are equal then the solid must be a regular tetrahedron? '),
(8, 5, 10, 'You need to use concatenation and build the string before alerting it.'),
(9, 12, 10, 'Where did you even find such question?'),
(10, 14, 10, 'Course you can dummy. You just need to use the &quot;this&quot; variable coupled with a jquery selector.');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `inq_id` int(11) NOT NULL,
  `user_inq_id` int(11) NOT NULL,
  `inq_title` text NOT NULL,
  `inq_body` longtext NOT NULL,
  `inq_tags` text NOT NULL,
  `inq_level` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`inq_id`, `user_inq_id`, `inq_title`, `inq_body`, `inq_tags`, `inq_level`) VALUES
(12, 9, 'Does knowing the surface area of all faces uniquely determine a tetrahedron?', 'I was wondering if the four areas of a tetrahedron faces were sufficient information to uniquely determine its shape. For example, is it true to say that if the surface areas are equal then the solid must be a regular tetrahedron? If the answer is negative, then what else we need to fully determine the shape of the tetrahedron in space?', 'geometry, polyhendra', 'Advanced'),
(14, 9, 'Calculating multiple input values in JavaScript', 'I have multiple items, where you are able to input the QTY. I have wrote the function but it only works for the first item.\r\n\r\nI used the same classNames and ID\'s in the HTML, So I think it would add up everywhere there is a input.\r\n\r\nI put it in a fiddle https://jsfiddle.net/detgz2Ls/\r\n\r\nI have to keep everything with the same class/ID\'s, because this is going to be a list that is able to generate multiple items dynamically.\r\n', 'javascript, js, html', 'Advanced'),
(15, 10, 'What is a NullPointerException, and how do I fix it?', 'What are Null Pointer Exceptions (java.lang.NullPointerException) and what causes them? What methods/tools can be used to determine the cause so that you stop the exception from causing the program to terminate prematurely?', 'java, NullPointerException, try-catch', 'Advanced'),
(16, 10, 'How to fix java.lang.UnsupportedClassVersionError: Unsupported major.minor version', 'I am trying to use Notepad++ as my all-in-one tool edit, run, compile, etc.\r\n\r\nI have JRE installed, and I have setup my path variable to the .../bin directory.\r\n\r\nWhen I run my \"Hello world\" in Notepad++, I get this message:\r\n\r\njava.lang.UnsupportedClassVersionError: test_hello_world :\r\n Unsupported major.minor version 51.0\r\n    at java.lang.ClassLoader.defineClass1(Native Method)\r\n    at java.lang.ClassLoader.defineClassCond(Unknown Source)\r\n       .........................................\r\nI think the problem here is about versions; some versions of Java may be old or too new.\r\n\r\nHow do I fix it?\r\nShould I install the JDK, and setup my path variable to the JDK instead of JRE?\r\nWhat is the difference between the PATH variable in JRE or JDK?', 'java, jvm, incompatibility, unsupported-class-version', 'Expert');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `user_password` text NOT NULL,
  `user_email` text NOT NULL,
  `user_skills` text NOT NULL,
  `user_title` text NOT NULL,
  `user_desc` text NOT NULL,
  `user_projects` text NOT NULL,
  `user_experience` text NOT NULL,
  `user_recoms` text NOT NULL,
  `user_education` mediumtext NOT NULL,
  `user_titles` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `user_name`, `user_password`, `user_email`, `user_skills`, `user_title`, `user_desc`, `user_projects`, `user_experience`, `user_recoms`, `user_education`, `user_titles`) VALUES
(4, 'admin', 'admin', 'admin', '66b65567cedbc743bda3417fb813b9ba', 'admin@admin.asd', 'SQL, Java, C, C++, Javascript, Python', 'Full Stack Developer', 'I teach superpowers.', 'None.', 'edX, Coursera', 'None.', 'MIT, Hopkins, Harvard, Boston', ''),
(9, 'Jorge', 'Zafiris', 'jorge4', '66b65567cedbc743bda3417fb813b9ba', 'jorge@gmail.com', 'Python, C++, C Programming, HTML, CSS, Java, JavaScript, NodeJS, SQL, PHP, CSS3, SASS, XML, Machine Learning', 'Software Engineer', 'An enthusiastic and focused engineer and a jack-of-all-trades who thrives to learn and further advance the principles of his field while pursuing an array of other disciplines, attempting to explore every branch of science, with main goal of becoming an efficient and resourceful problem solver focused on individual growth. As an avid reader of the journal, he tests new concepts and implementations of various problems, acquiring an even better degree of understanding. Alongside his discipline, he\'s also passionate about calculus, physics, biochemistry, mechanical engineering, innovation, machine learning, playing jazz, writing and taking online courses.', 'The Complete Web Development Course,Beginners\' Chinese,     FreeCodeCamp Front End Certification', 'No experience', '', 'Harvard, MIT College', 'Bachelor of Science, MSc. Biochemistry'),
(10, 'Steven', 'McCarthy', 'steven', '3577d8a72ac78b51d299b0be0ca60f2e', 'mccarthy@gmail.com', 'C++, Java, XML, jQuery, SCSS, SASS, Gulp', 'UX Designer', 'I teach superpowers.', 'UX Complete Certification - Open2Study, Frontend Certification - FreeCodeCamp', 'Softworks, Crytek, Stark industries', 'Upon request.', 'MIT, Harvard, Caltech', 'Bachelor of Science, PhD');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `vote_id` int(11) NOT NULL,
  `vote_user_id` int(11) NOT NULL,
  `vote_q_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`vote_id`, `vote_user_id`, `vote_q_id`) VALUES
(6, 9, 5),
(12, 10, 12),
(14, 10, 5),
(15, 10, 14),
(16, 9, 16),
(17, 9, 17),
(18, 9, 15),
(19, 4, 14),
(20, 4, 17),
(21, 4, 16);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administration`
--
ALTER TABLE `administration`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`inq_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`vote_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administration`
--
ALTER TABLE `administration`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `inq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `vote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
