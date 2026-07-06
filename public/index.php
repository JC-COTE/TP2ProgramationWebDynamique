<?php
require_once __DIR__ . '/../includes/header.php';

$stmt = $pdo->query(
    "SELECT article.id_article, article.titre, article.contenu, article.date_publication,
            utilisateur.id_utilisateur, utilisateur.nom
     FROM article
     JOIN utilisateur ON article.id_utilisateur = utilisateur.id_utilisateur
     ORDER BY article.date_publication DESC"
);
$articles = $stmt->fetchAll();
?>

<h1>Forum Collège Maisonneuve</h1>

<?php if (empty($articles)): ?>
    <p>Aucun article a été publié.</p>
<?php else: ?>
    <?php foreach ($articles as $article): ?>
        <div class="article-card">
            <h2><?= htmlspecialchars($article['titre']) ?></h2>
            <div class="article-meta">
                Par <?= htmlspecialchars($article['nom']) ?> —
                <?= date('d/m/Y à H:i', strtotime($article['date_publication'])) ?>
            </div>
            <div class="article-content">
                <?= nl2br(htmlspecialchars($article['contenu'])) ?>
            </div>

            <?php if ($est_connecte && $_SESSION['id_utilisateur'] == $article['id_utilisateur']): ?>
                <div class="article-actions">
                    <a href="/modifier_article.php?id=<?= $article['id_article'] ?>">Modifier</a>
                    <a href="/supprimer_article.php?id=<?= $article['id_article'] ?>"
                       onclick="return confirm('Supprimer cet article ?')">Supprimer</a>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>