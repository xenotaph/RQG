<?php
// Include database connection file
include 'db_connect.php';
include 'session.php';
include 'menu.php';


// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Fetch characters associated with the user
$query = "SELECT * FROM characters WHERE user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$characters = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Load Character</title>

</head>
<body>
    <div class="container">
        <h1>Load Character</h1>
        <form action="edit_character.php" method="get">
            <div class="form-group">
                <label for="character">Character</label>
                <select id="character" name="id" class="form-control">
                    <?php foreach ($characters as $character): ?>
                        <option value="<?php echo $character['id']; ?>">
                            <?php echo $character['name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Load Character</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
