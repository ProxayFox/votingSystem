	<?php
	// start the session
	session_start();
	// validate session 
	if (!empty($_SESSION['username'])) {
		// session is valid, the user is ready to logout
		unset($_SESSION['username']);
		session_destroy();
		header("Location: ../index.php?logout=success");
	}else {
		session_destroy();
		// session is not valid, return to index
		header("Location: ../index.php?logout=unseccessful");
	}

?>