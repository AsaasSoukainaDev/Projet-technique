<?php
require_once 'config.php';

$sql = "SELECT r.nom, r.image, r.ingredients, r.instructions, r.date_creation,
               c.nom AS chef_nom, c.prenom AS chef_prenom,
               t.libelle AS type_cuisine
        FROM recette r
        INNER JOIN chef c ON r.id_chef = c.id
        INNER JOIN type_cuisine t ON r.id_type_cuisine = t.id
        ORDER BY r.date_creation DESC";

$recettes =$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les recettes</title>
    <link rel="stylesheet" href="afficher.css">
</head>
<body>
    <div class="container">
        <h1>Nos recettes</h1>

        <a href="ajouter.php" class="btn-ajouter">Ajouter une recette</a>

        <div class="recettes-grid">
            <?php foreach ($recettes as $recette): ?>
                <div class="recette-card">
                    <img src="<?php echo htmlspecialchars($recette['image']); ?>" alt="Image de la recette" class="recette-image">

                    <h2><?php echo htmlspecialchars($recette['nom']); ?></h2>

                    <div class="recette-meta">
                        <span class="badge"><?php echo htmlspecialchars($recette['chef_prenom'] . ' ' . $recette['chef_nom']); ?></span>
                        <span class="badge"> <?php echo htmlspecialchars($recette['type_cuisine']); ?></span>
                    </div>

                    <div class="recette-section">
                        <h3>Ingrédients</h3>
                        <p><?php echo htmlspecialchars($recette['ingredients']); ?></p>
                    </div>

                    <div class="recette-section">
                        <h3>Instructions</h3>
                        <p><?php echo htmlspecialchars($recette['instructions']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>