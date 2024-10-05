# EventQuest - Plateforme de Gestion d'Événements à Paris

## Description du Projet

EventQuest révolutionne la découverte des événements parisiens avec un agenda interactif pour planifier facilement. Achetez des billets directement, suivez vos amis et découvrez des événements exclusifs grâce à des notifications personnalisées. Une plateforme indispensable pour explorer la vie culturelle de Paris.

## Structure du Projet

- **assets/css** : Contient les fichiers CSS.
- **assets/images** : Contient les images du site (ex: logo, photos d'événements).
- **assets/js** : Contient les fichiers JavaScript pour les interactions du site.
- **includes** : Contient les fichiers PHP tels que la connexion à la base de données.
- **pages** : Contient les différentes pages HTML comme About, Contact, etc.

## Installation

1. Cloner ce dépôt Git.
2. Configurer la base de données dans `includes/db_connection.php`.
3. Lancer le serveur local et tester les fonctionnalités.

## Contribuer

- Utilisez des branches pour chaque nouvelle fonctionnalité.
- Faites des pull requests et vérifiez bien les conflits.

## SQL

CREATE TABLE `utilisateurs` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`nom_utilisateur` varchar(50) UNIQUE NOT NULL,
`email` varchar(100) UNIQUE NOT NULL,
`mot_de_passe` varchar(255) NOT NULL,
`nom_complet` varchar(100),
`role` varchar(20) NOT NULL,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
`mis_a_jour_le` datetime DEFAULT CURRENT_TIMESTAMP,
`derniere_connexion` datetime,
`notification_inactivite` boolean DEFAULT false
);

CREATE TABLE `agences` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`nom_agence` varchar(100) NOT NULL,
`utilisateur_id` int UNIQUE NOT NULL,
`description` text,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
`mis_a_jour_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `permissions` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`role` varchar(20) NOT NULL,
`action` varchar(100) NOT NULL,
`autorise` boolean DEFAULT true
);

CREATE TABLE `evenements` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`agence_id` int NOT NULL,
`titre` varchar(100) NOT NULL,
`description` text,
`categorie` varchar(50) NOT NULL,
`date_evenement` datetime NOT NULL,
`emplacement` varchar(255) NOT NULL,
`latitude` decimal(9,6),
`longitude` decimal(9,6),
`prix_billet` decimal(10,2),
`participants_max` int,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
`mis_a_jour_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`agence_id`) REFERENCES `agences`(`id`)
);

CREATE TABLE `codes_promo` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`code` varchar(20) UNIQUE NOT NULL,
`description` text,
`reduction` decimal(5,2) NOT NULL,
`valide_de` datetime,
`valide_jusqu_a` datetime
);

CREATE TABLE `billets` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`evenement_id` int NOT NULL,
`utilisateur_id` int NOT NULL,
`date_achat` datetime DEFAULT CURRENT_TIMESTAMP,
`quantite` int NOT NULL,
`code_promo_id` int,
`total_paye` decimal(10,2),
FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`),
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`),
FOREIGN KEY (`code_promo_id`) REFERENCES `codes_promo`(`id`)
);

CREATE TABLE `abonnements_vip` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`date_debut` datetime NOT NULL,
`date_fin` datetime NOT NULL,
`niveau_vip` varchar(50) NOT NULL,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `notations` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`evenement_id` int NOT NULL,
`note` int NOT NULL,
`commentaire` text,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`),
FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`)
);

CREATE TABLE `commentaires` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`evenement_id` int NOT NULL,
`utilisateur_id` int NOT NULL,
`contenu` text NOT NULL,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`),
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `suivi_utilisateurs` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`suivi_id` int NOT NULL,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`),
FOREIGN KEY (`suivi_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `notifications` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`evenement_id` int,
`message` varchar(255) NOT NULL,
`statut_lu` boolean DEFAULT false,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`),
FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`)
);

CREATE TABLE `notifications_temps_reel` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`message` varchar(255) NOT NULL,
`vu` boolean DEFAULT false,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `groupes_prives` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`nom_groupe` varchar(100) NOT NULL,
`proprietaire_id` int NOT NULL,
`description` text,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`proprietaire_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `membres_groupe` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`groupe_id` int NOT NULL,
`utilisateur_id` int NOT NULL,
`role` varchar(20) NOT NULL,
FOREIGN KEY (`groupe_id`) REFERENCES `groupes_prives`(`id`),
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `captcha_questions` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`question` varchar(255) NOT NULL,
`reponse` varchar(255) NOT NULL,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `logs` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int,
`action` varchar(255) NOT NULL,
`date_log` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `newsletters` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`titre` varchar(100) NOT NULL,
`contenu` text NOT NULL,
`envoye_le` datetime DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE `newsletter_envois` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`newsletter_id` int NOT NULL,
`date_envoi` datetime DEFAULT CURRENT_TIMESTAMP,
`status` varchar(50) DEFAULT 'envoyé',
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`),
FOREIGN KEY (`newsletter_id`) REFERENCES `newsletters`(`id`)
);

CREATE TABLE `recherche_index` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`evenement_id` int NOT NULL,
`contenu` text NOT NULL,
FOREIGN KEY (`evenement_id`) REFERENCES `evenements`(`id`)
);

CREATE TABLE `tickets_support` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`sujet` varchar(255) NOT NULL,
`priorite` varchar(50) NOT NULL,
`statut` varchar(50) NOT NULL,
`cree_le` datetime DEFAULT CURRENT_TIMESTAMP,
`mis_a_jour_le` datetime DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `preferences_utilisateurs` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`utilisateur_id` int NOT NULL,
`categorie_preferee` varchar(50),
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);

CREATE TABLE `archives` (
`id` int PRIMARY KEY AUTO_INCREMENT,
`type_element` varchar(50) NOT NULL,
`contenu` text NOT NULL,
`date_suppression` datetime NOT NULL,
`utilisateur_id` int NOT NULL,
FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs`(`id`)
);
