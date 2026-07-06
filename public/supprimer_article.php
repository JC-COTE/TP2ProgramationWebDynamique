<?php
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['id_utilisateur'])) {
    header('Location: /connexion.php');
    exit;
}

$id_article = (int)($_GET['id'] ?? 0);

// La condition id_utilisateur = ? empêche de supprimer l'article de quelqu'un d'autre,
// même si l'id dans l'URL était modifié manuellement
$stmt = $pdo->prepare("DELETE FROM article WHERE id_article = ? AND id_utilisateur = ?");
$stmt->execute([$id_article, $_SESSION['id_utilisateur']]);

header('Location: /index.php');
exit;
