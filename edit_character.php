<?php
// Include database connection file
include 'db_connect.php';
include 'session.php';
include 'menu.php';


// Retrieve the user ID from the session
$user_id = $_SESSION['user_id'];

// Get character ID from query string
$id = $_GET['id'];

// Fetch the character associated with the user
$query = "SELECT * FROM characters WHERE id = ? AND user_id = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("ii", $id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the character was found and is associated with the user
if ($result->num_rows > 0) {
    // Fetch character data
    $character = $result->fetch_assoc();

    // Set readonly variable
    $readonly = '';
} else {
    // Character not found or not associated with the user
    echo "Character not found or access denied.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Character</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Edit Character</h1>
        <form id="character-form">
            <input type="hidden" id="id" value="<?php echo $character['id']; ?>">
            <?php include 'character_sheet.php'; ?>
            <button type="button" class="btn btn-primary" id="save-button">Save Changes</button>
        </form>
        <form id="deleteForm" action="delete_character.php" method="post">
        <input type="hidden" name="id" value="<?php echo $character['id']; ?>">
        <button type="button" onclick="confirmDelete()">Delete Character</button>
        </form>

        <script>
        function confirmDelete() {
            if (confirm("Are you sure you want to delete this character?")) {
                document.getElementById("deleteForm").submit();
            }
        }
        </script>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="character.js"></script>
</body>
</html>
