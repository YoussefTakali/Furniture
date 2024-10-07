-- phpMyAdmin SQL Dump
-- version 5.2.1-4.fc40
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : jeu. 03 oct. 2024 à 12:41
-- Version du serveur : 10.11.8-MariaDB
-- Version de PHP : 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `furniture_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) DEFAULT 0.00,
  `status` varchar(20) DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`, `updated_at`) VALUES
(3, 17, 0.00, NULL, '2024-10-03 08:54:34', '2024-10-03 08:54:34'),
(10, 17, 0.00, NULL, '2024-10-03 11:23:53', '2024-10-03 11:23:53'),
(11, 17, 0.00, NULL, '2024-10-03 11:25:28', '2024-10-03 11:25:28'),
(12, 17, 0.00, NULL, '2024-10-03 11:29:07', '2024-10-03 11:29:07'),
(13, 17, 0.00, NULL, '2024-10-03 12:02:12', '2024-10-03 12:02:12');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(2, 3, 2, 3, 0.00),
(3, 10, 5, 1, 0.00),
(4, 11, 5, 3, 0.00),
(5, 12, 5, 4, 0.00),
(6, 12, 4, 3, 0.00),
(7, 12, 2, 4, 0.00),
(8, 13, 5, 1, 0.00),
(9, 13, 4, 1, 0.00),
(10, 13, 2, 1, 0.00);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `price`, `image`, `created_at`) VALUES
(2, 'aaaaa', 'aerreaaaaa', 50.00, '../uploads/66fe57560d8ca.png', '2024-10-03 08:35:34'),
(4, 'table', 'table de salon', 59.69, '../uploads/66fe75d235d81.jpg', '2024-10-03 10:45:38'),
(5, 'tawla', 'table de revesion', 69.69, '../uploads/66fe76194b7f1.jpg', '2024-10-03 10:46:49'),
(7, 'ezfaezf', 'zeafzaef', 20.00, '../uploads/66fe8c45d4581.webp', '2024-10-03 12:21:25'),
(8, 'aerzear', 'aezrzear', 20.00, '../uploads/66fe8cd8eb46b.jpg', '2024-10-03 12:23:52'),
(9, 'azerzear', 'aeraezr', 20.00, '../uploads/66fe8cf3c0c62.webp', '2024-10-03 12:24:19'),
(10, 'azefazef', 'azefazef', 200.00, '../uploads/66fe8d1c2b593.webp', '2024-10-03 12:25:00'),
(11, 'azeraer', 'azerazre', 50.00, '../uploads/66fe8ef93d6d0.webp', '2024-10-03 12:32:57');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `profile_picture`) VALUES
(16, 'youssef1', 'earaezr@gmail.com', '$2y$10$1qgzcm24zgZd.nYiC4gNruVJ4zvgYWckhCZ3Phsh3iLDxCZBE5spa', 'user', '2024-10-03 08:39:44', 'Capture dâ€™Ã©cran du 2024-10-02 10-33-39.png'),
(17, 'youssef2', 'aeraezr@gmail.com', '$2y$10$iamkuQxWulRwb2w0OabtuuqotzYKIQUG5zjEQlFVrKFQboecphQyC', 'user', '2024-10-03 08:42:32', 'Capture dâ€™Ã©cran du 2024-10-02 10-07-12.png'),
(18, 'aaaa', 'aaaa@gmail.com', '$2y$10$/XNBSPpc9boOgIASwGmUL.urJe06Yqyrp8sRUjtdQRI4JAXOqJX5O', 'admin', '2024-10-03 10:34:07', 'Capture dâ€™Ã©cran du 2024-10-02 10-33-39.png'),
(20, 'ezrezar', 'aereazr@gmail.fr', '$2y$10$hwytjyPRfiOc76slyNGeius92/hhx/XOD3tssqy2leuQCTxAytWWC', 'user', '2024-10-03 12:19:12', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `files_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
