<?php
include('db.php');

$result = $conn->query("SELECT * FROM recipes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe App</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Recipes</h1>
    <a href="add.php" class="btn btn-primary mb-3">Add Recipe</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Ingredients</th>
            <th>Instructions</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['title'] ?></td>
                <td><?= $row['ingredients'] ?></td>
                <td><?= $row['instructions'] ?></td>
                <td>
                    <?php if (!empty($row['image'])): ?>
                        <img src="<?= $row['image'] ?>" alt="<?= $row['title'] ?>" style="max-width: 100px;">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="details.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">View</a>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="deleteRecipe(<?= $row['id'] ?>)">Delete</button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function deleteRecipe(recipeId) {
        var confirmDelete = confirm("Are you sure you want to delete this recipe?");
        
        if (confirmDelete) {
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: {id: recipeId},
                success: function(response) {
                    // Reload the page or update the table as needed
                    location.reload();
                },
                error: function(error) {
                    console.error('Error deleting recipe:', error);
                }
            });
        }
    }
</script>
</body>
</html>
