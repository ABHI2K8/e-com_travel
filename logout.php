<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Regenerate session ID for security
session_regenerate_id(true);

// Determine redirect URL
$redirect_url = 'login.php'; // Default redirect

// If coming from admin, redirect to admin login
if (isset($_SESSION['admin_logged_in'])) {
    $redirect_url = 'admin/login.php';
}

// If coming from user session, redirect to homepage
if (isset($_SESSION['user_id'])) {
    $redirect_url = 'index.php';
}

// If there's a stored redirect URL, use it
if (isset($_SESSION['redirect_url'])) {
    $redirect_url = filter_var($_SESSION['redirect_url'], FILTER_SANITIZE_URL);
}

// Redirect to appropriate page
header("Location: " . $redirect_url);
exit();
?>