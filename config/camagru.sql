-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 23 2018 г., 06:39
-- Версия сервера: 5.7.22
-- Версия PHP: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `camagru`
--

CREATE DATABASE IF NOT EXISTS `camagru` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `camagru`;

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id_img` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `img_src` text NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `comments` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id_img`, `user_id`, `img_src`, `likes`, `comments`) VALUES
(1, 77, '../img/users/4.jpg', 1, 4),
(2, 77, '../img/users/01.jpg', 0, 2),
(3, 77, '../img/users/02.jpg', 0, 0),
(4, 77, '../img/users/03.jpg', 1, 0),
(5, 77, '../img/users/5.jpg', 1, 3),
(7, 78, '../img/users/3.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `image_id`) VALUES
(119, 77, 103),
(120, 77, 109),
(121, 77, 97),
(123, 77, 5),
(124, 77, 94),
(125, 77, 105),
(126, 77, 101),
(127, 77, 99),
(128, 78, 102),
(134, 77, 1),
(136, 77, 117),
(137, 77, 104),
(138, 77, 114),
(140, 77, 6),
(142, 77, 124),
(144, 77, 129);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(15) NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `activation_code` text NOT NULL,
  `activate` text NOT NULL,
  `comments` text NOT NULL,
  `user_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `activation_code`, `activate`, `comments`, `user_image`) VALUES
(53, 'admin', 'al13ra@gmail.com', '7e77279cb4b3e9ce20b50e853e466d5af7cd63faddca227c8ef7b6d5aaece35f340c1f35e9b468bebe73c29da1057bafa2790a5ec05176f3fb07cd3d9a43cb24', '', '1', '0', '../img/page/03.png'),
(76, 'anaumenk', 'al13ra@gmail.com', 'cf45682cd57b2125d1f753192a790fa258a4e1856869a5a07706957fed99dad0734e681bcbc1a64ec98e43a8238f609d75b2987f2d7388038b8362b2ad206cb6', 'dd09203d46b8fc04afdd7694022fff75d125828121f47bdd97cb0ade16bd28326f24836dcacd87b57c8e753c3d9f821f4072950cd36e944425d5ec363bd9e097', '1', '1', '../img/page/02.png'),
(77, 'alexandra', 'al13ra@gmail.com', '21d5cb651222c347ea1284c0acf162000b4d3e34766f0d00312e3480f633088822809b6a54ba7edfa17e8fcb5713f8912ee3a218dd98d88c38bbf611b1b1ed2b', '05fa508092235c5575fe5f15e633799ab958cf1ef8fbcc3d8f5b377ff93a4712837e730d647306faef0a1c29d9d5bff0623bf1fa31abf922bebe894a42141750', '1', '0', 'img/users/user_photo1529683698.png'),
(78, 'name', 'al13ra@gmail.com', 'cdde1372b965e9dcfd48432d5e5804c0ee94aef3fd28776cd04608685cb52bba8079b59ba0fe86fc23db862fed9b9d095677b791ee59ecad4b941753d165b810', '9303e31d9767b97e472690c189e0c2bc5ea871fb932b695134e7dec77b5a263e5d25ed28cef8f50bdb72975fe49e53d1f0c65d8d74abf6fcd5553167014364e2', '1', '1', '../img/page/03.png'),
(80, 'loginpassword', 'al13ra@gmail.com', '1e231390a9397cd0c8c0ba402aed558ea3cbaa3620314e115509b44cb4de7319c42dcfb31fd3e335a84e29c2770437681ee0bd406a670603d6b1e9865aee4733', '0f4b47e6064b0152e192bc8229e3c42ef1827006bd0f4c99a5b77314017e36f9ebfabfb270d7a8fdbcddec182a63586c0049fd0c1c42af39214c4012974d8f57', '1', '1', '../img/page/01.png'),
(83, 'new', 'al13ra@gmail.com', '21d5cb651222c347ea1284c0acf162000b4d3e34766f0d00312e3480f633088822809b6a54ba7edfa17e8fcb5713f8912ee3a218dd98d88c38bbf611b1b1ed2b', '418288a9dbd23a3f997ff935b8276ea11f7056509833d2f87efc6f0175ae8037249738763391ce3584bda27e30d8526b0ce60676fcaddc43656f43a59a90da59', '1', '1', 'img/users/user_photo1529487622.png'),
(85, 'newnew', 'al13ra@gmail.com', '8c9ec9f0ac6ad6fea526dad1171e7507262d0ea9541a2e6ddcc5767a239d1da9edea948dbde5494bb7fb27df24d6ac5dfc3ad47cc52af76a7e9146c5125c6cf5', '593176bbc50042d414f5a30ebbdb501b416c997436d27f7c892b20d9084c7befcc797722c72bcb6027d85829c6e7333dbb485501b390a4007fd65d4e8f383d00', '1', '1', 'img/page/user_image'),
(87, 'lol', 'al13ra@gmail.com', '8c9ec9f0ac6ad6fea526dad1171e7507262d0ea9541a2e6ddcc5767a239d1da9edea948dbde5494bb7fb27df24d6ac5dfc3ad47cc52af76a7e9146c5125c6cf5', 'e00365a13ada2dee3580ecca736dd160f1e1b1479fdc2869bf49ab49e8652581f1d9e18b28060b664771c1e296580631a27977c1ce666743fb77fbc244d429cf', '1', '1', 'img/page/user_image.png'),
(88, 'al', 'al13ra@gmail.com', '21d5cb651222c347ea1284c0acf162000b4d3e34766f0d00312e3480f633088822809b6a54ba7edfa17e8fcb5713f8912ee3a218dd98d88c38bbf611b1b1ed2b', '6eea213165fb7998b319cdc629c3e156b25dd8c250721686af6f3eaed84422d05a7fdc9a5ec2f94f653cda7267d8d8c0d21117de9bc9d1459ca55798ebe4ce49', '1', '1', 'img/page/user_image.png'),
(89, 'ale', 'al13ra@gmail.com', '21d5cb651222c347ea1284c0acf162000b4d3e34766f0d00312e3480f633088822809b6a54ba7edfa17e8fcb5713f8912ee3a218dd98d88c38bbf611b1b1ed2b', 'f0775ba9f14fea902e27e9c63ba420b3cab005af48d34c1663a64e1ea7cb492efb87cc8d26c8f2dc9af5fe079fce0f88c8e34e3eb99910f89d91b9eb5eb8d0d5', '0', '1', 'img/page/user_image.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id_img`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_name_2` (`user_name`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id_img` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
