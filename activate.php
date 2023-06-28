<?php
// Include database connection file
include 'db_connect.php';
include 'menu.php';


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get token and password from POST data
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Prepare SQL query
    $query = "UPDATE users SET password = ?, status = 'active' WHERE token = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $password, $token);

    // Execute SQL query
    if ($stmt->execute()) {
        echo 'Account activated successfully. You can now <a href="login.php">login</a>.';
    } else {
        echo 'Failed to activate account: ' . $stmt->error;
    }
} else {
    // Get token from GET request
    $token = $_GET['token'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Activate Account</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Activate Account</h1>
        <form action="activate.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Activate</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
    