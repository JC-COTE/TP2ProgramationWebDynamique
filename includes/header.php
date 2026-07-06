<?php
require_once __DIR__ . '/../config.php';

$est_connecte = isset($_SESSION['id_utilisateur']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Collège Maisonneuve</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="header-content">
            <a href="/index.php" class="logo">Forum Maisonneuve</a>
            <nav class="nav-menu">
                <a href="/index.php">Accueil</a>
                <?php if ($est_connecte): ?>
                    <a href="/nouvel_article.php">Nouvel article</a>
                    <span class="nav-user">Bonjour, <?= htmlspecialchars($_SESSION['nom_utilisateur']) ?></span>
                    <a href="/deconnexion.php">Déconnexion</a>
                <?php else: ?>
                    <a href="/connexion.php">Connexion</a>
                    <a href="/inscription.php">Inscription</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">