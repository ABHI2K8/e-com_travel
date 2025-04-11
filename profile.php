<?php
require 'config.php';
include 'header.php';

// Check if the user is authenticated
checkAuthentication();

// Fetch user details
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="container mt-5">
    <h1 class="mb-4">Profile</h1>
    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title">Welcome, <?= htmlspecialchars($user['name']) ?></h3>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Joined:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>