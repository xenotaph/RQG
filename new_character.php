<?php
// Include database connection file
include 'db_connect.php';
include 'session.php';
include 'menu.php';


// Fetch all column names from characters table
$query = "SHOW COLUMNS FROM characters";
$result = $db->query($query);
$columns = $result->fetch_all(MYSQLI_ASSOC);

// Initialize character array with column names as keys and empty strings as values
$character = array_fill_keys(array_column($columns, 'Field'), '');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Update the character array with form data
    foreach ($_POST as $key => $value) {
        if (array_key_exists($key, $character)) {
            $character[$key] = $value;
        }
    }

    // Associate the user ID with the character
    $character['user_id'] = $user_id;

    // Prepare SQL query
    $query = "INSERT INTO characters (" . implode(',', array_keys($character)) . ") VALUES (" . implode(',', array_fill(0, count($character), '?')) . ")";
    $stmt = $db->prepare($query);
    $stmt->bind_param(str_repeat('s', count($character)), ...array_values($character));

    // Execute SQL query
    if ($stmt->execute()) {
        echo 'Character saved successfully!';
    } else {
        echo 'Failed to save character: ' . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Character</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <div class="container">
        <h1>New Character</h1>
        <form id="character-form" method="post">
            <?php include 'character_sheet.php'; ?>
            <button type="submit" id="save-button" class="btn btn-primary">Save Character</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="character.js"></script>
</body>
</html>
    