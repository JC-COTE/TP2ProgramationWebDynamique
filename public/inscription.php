<?php
require_once __DIR__ . '/../includes/header.php';

$erreur = '';
$succes = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom             = trim($_POST['nom'] ?? '');
    $nom_utilisateur = trim($_POST['nom_utilisateur'] ?? '');
    $mot_de_passe    = $_POST['mot_de_passe'] ?? '';
    $date_naissance  = $_POST['date_naissance'] ?? '';

    if ($nom === '' || $nom_utilisateur === '' || $mot_de_passe === '' || $date_naissance === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (strlen($mot_de_passe) < 6) {
        $erreur = "Le mot de passe doit contenir au moins 6 caractères.";
    } else {
        // Vérifier si le nom d'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT id_utilisateur FROM utilisateur WHERE nom_utilisateur = ?");
        $stmt->execute([$nom_utilisateur]);

        if ($stmt->fetch()) {
            $erreur = "Ce nom d'utilisateur est déjà pris.";
        } else {
            $hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);

            $stmt = $pdo->prepare(
                "INSERT INTO utilisateur (nom, nom_utilisateur, mot_de_passe, date_naissance)
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([$nom, $nom_utilisateur, $hash, $date_naissance]);

            $succes = "Compte a été créé";
        }
    }
}
?>

<div class="form-card">
    <h1>Créer un compte</h1>

    <?php if ($erreur): ?>
        <div class="message erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <?php if ($succes): ?>
        <div class="message succes">
            <?= htmlspecialchars($succes) ?>
            — <a href="/connexion.php">Se connecter</a>
        </div>
    <?php else: ?>
        <form method="POST" action="/inscription.php">
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" id="nom" name="nom" required
                       value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="nom_utilisateur">Nom de user</label>
                <input type="text" id="nom_utilisateur" name="nom_utilisateur" required
                       value="<?= htmlspecialchars($_POST['nom_utilisateur'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="mot_de_passe">Mot de passe</label>
                <input type="password" id="mot_de_passe" name="mot_de_passe" required minlength="6">
            </div>

            <div class="form-group">
                <label for="date_naissance">Date de NAissance</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>

            <button type="submit" class="btn">Créer mon compte</button>
        </form>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
