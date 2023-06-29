<?php
// Start session
session_start();

// Include database connection file
include 'db_connect.php';
include 'menu.php';


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get username/email and password from POST data
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    // Prepare SQL query
    $query = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $usernameOrEmail, $usernameOrEmail);

    // Execute SQL query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // User exists, check password
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variable
            $_SESSION['username'] = $usernameOrEmail;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            // Redirect to index page
            header('Location: index.php');
            exit;
        } else {
            // Password is incorrect, show error message
            $error = "Invalid username/email or password.";
        }
    } else {
        // User does not exist, show error message
        $error = "Invalid username/email or password.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="usernameOrEmail">Username or Email</label>
                <input type="text" id="usernameOrEmail" name="usernameOrEmail" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
