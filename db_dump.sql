-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Ноя 28 2023 г., 10:55
-- Версия сервера: 5.7.34
-- Версия PHP: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `parent_id`) VALUES
(1, 'Категория-1', NULL),
(2, 'Категория-2', NULL),
(3, 'Категория-3', NULL),
(4, 'Категория-1-1', 1),
(5, 'Категория-1-1-1', 4),
(6, 'Категория-3-1', 3);

-- --------------------------------------------------------

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`id`, `name`, `description`) VALUES
(1, 'Продукт-1', 'Продукт присутствует в одной категории: 1'),
(2, 'Продукт-2', 'Продукт присутствует в трех категориях: 1, 1-1-1, 3-1');

-- --------------------------------------------------------

--
-- Дамп данных таблицы `product_category`
--

INSERT INTO `product_category` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(2, 5),
(2, 6);
