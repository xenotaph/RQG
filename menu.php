<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">RQG</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
	<ul class="navbar-nav">
	    <?php if (isset($_SESSION['username'])): ?>
		<li class="nav-item">
		  <a class="nav-link" href="new_character.php">New Character</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" href="load_character.php">Load Character</a>
		</li>
		<li class="nav-item">
		  <a class="nav-link" 
	    <li class="nav-item">
		    <a class="nav-link" href="change_password.php">Change Password</a>
		  </li>
		  href="logout.php">Logout</a>
		</li>
	  <?php else: ?>
		<li class="nav-item">
		  <a class="nav-link" href="login.php">Login</a>
		</li>
	  <?php endif; ?>
	</ul>
  </div>
</nav>
