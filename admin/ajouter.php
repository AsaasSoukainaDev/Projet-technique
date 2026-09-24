<?php
require_once '../config.php';

$chefs = $pdo->query("SELECT * FROM chef ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$types = $pdo->query("SELECT * FROM type_cuisine ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $image = $_POST['image'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    $id_chef = $_POST['id_chef'];
    $id_type_cuisine = $_POST['id_type_cuisine'];

    if (!empty($nom) && !empty($ingredients) && !empty($instructions) && !empty($id_chef) && !empty($id_type_cuisine)) {
        $sql = "INSERT INTO recette (nom, image, ingredients, instructions, id_chef, id_type_cuisine) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nom, $image, $ingredients, $instructions, $id_chef, $id_type_cuisine]);

        header('Location: afficher.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une recette</title>
    <link rel="stylesheet" href="../style/ajouter.css">
</head>
<body>
    <div class="container">
        <h1>Ajouter une recette</h1>

        <form method="POST">
            <div class="form-group">
                <label for="nom">Nom de la recette :</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="image">URL de l'image :</label>
                <input type="text" id="image" name="image" placeholder="https://...">
            </div>

            <div class="form-group">
                <label for="id_chef">Chef :</label>
                <select id="id_chef" name="id_chef" required>
                    <option value="">-- Choisir un chef --</option>
                    <?php foreach ($chefs as $chef): ?>
                        <option value="<?php echo $chef['id']; ?>">
                            <?php echo htmlspecialchars($chef['prenom'] . ' ' . $chef['nom']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="id_type_cuisine">Type de cuisine :</label>
                <select id="id_type_cuisine" name="id_type_cuisine" required>
                    <option value="">-- Choisir un type --</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo $type['id']; ?>">
                            <?php echo htmlspecialchars($type['libelle']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingrédients :</label>
                <textarea id="ingredients" name="ingredients" required></textarea>
            </div>

            <div class="form-group">
                <label for="instructions">Instructions :</label>
                <textarea id="instructions" name="instructions" required></textarea>
            </div>

            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>