<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve recipe details from the database
    $result = $conn->query("SELECT * FROM recipes WHERE id=$id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Recipe not found.";
        exit();
    }
} else {
    echo "Invalid recipe ID.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Recipe Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $row['title'] ?></h5>
            <?php if (!empty($row['image'])): ?>
                <img src="<?= $row['image'] ?>" alt="<?= $row['title'] ?>" class="img-fluid">
            <?php endif; ?>
            <p class="card-text"><strong>Ingredients:</strong> <?= $row['ingredients'] ?></p>
            <p class="card-text"><strong>Instructions:</strong> <?= $row['instructions'] ?></p>        
        </div>
    </div>

    <a href="index.php" class="btn btn-primary mt-3">Back to Recipes</a>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>
</body>
</html>
