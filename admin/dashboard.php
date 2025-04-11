<?php
session_start();
require_once __DIR__ . '/../config.php';

// Authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch data
$bookings = $conn->query("
    SELECT bookings.*, packages.name AS package_name 
    FROM bookings
    LEFT JOIN packages ON bookings.package_id = packages.id
    ORDER BY bookings.id DESC LIMIT 10
");

$contacts = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 10");
$packages = $conn->query("SELECT * FROM packages ORDER BY id DESC LIMIT 5");

// Fetch recent contact messages
$messages = [];
$stmt = $conn->prepare("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/admin_nav.php'; ?>
    
    <div class="container mt-4">
        <h2 class="mb-4">Dashboard Overview</h2>
        
        <div class="row">
            <!-- Bookings Section -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Recent Bookings</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($bookings->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Package</th>
                                            <th>Customer</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($booking = $bookings->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $booking['id'] ?></td>
                                            <td><?= $booking['package_name'] ?? 'N/A' ?></td>
                                            <td><?= $booking['customer_name'] ?></td>
                                            <td><?= date('d M Y', strtotime($booking['booking_date'])) ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">No recent bookings found</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Contacts Section -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Recent Messages</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($contacts->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($contact = $contacts->fetch_assoc()): ?>
                                        <tr>
                                            <td><?= $contact['name'] ?></td>
                                            <td><?= substr($contact['subject'], 0, 20) ?>...</td>
                                            <td><?= date('d M Y', strtotime($contact['created_at'])) ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">No recent messages</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Packages Section -->
        <div class="card">
            <div class="card-header">
                <h5>Recent Packages</h5>
            </div>
            <div class="card-body">
                <?php if ($packages->num_rows > 0): ?>
                    <div class="row">
                        <?php while($package = $packages->fetch_assoc()): ?>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="../images/<?= $package['image'] ?>" class="card-img-top">
                                <div class="card-body">
                                    <h6><?= $package['name'] ?></h6>
                                    <p class="text-muted">$<?= number_format($package['price'], 2) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No packages found</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Contact Messages Section -->
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h5>Recent Contact Messages</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($messages)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $index => $message): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= htmlspecialchars($message['name']) ?></td>
                                        <td><?= htmlspecialchars($message['email']) ?></td>
                                        <td><?= htmlspecialchars($message['subject']) ?></td>
                                        <td><?= date('F j, Y, g:i a', strtotime($message['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">No recent messages found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>