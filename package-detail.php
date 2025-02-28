<?php
require 'config.php';
include 'header.php';

if (!isset($_GET['id'])) {
    header('Location: packages.php');
    exit();
}

$package_id = (int)$_GET['id'];

// Fetch package details
$stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->bind_param("i", $package_id);
$stmt->execute();
$result = $stmt->get_result();
$package = $result->fetch_assoc();

if (!$package) {
    header('Location: packages.php');
    exit();
}
?>

<div class="container mt-5">
    <div class="row">
        <!-- Package Image -->
        <div class="col-md-6">
            <img src="images/<?= $package['image'] ?>" 
                 alt="<?= htmlspecialchars($package['name']) ?>" 
                 class="img-fluid rounded">
        </div>

        <!-- Package Details -->
        <div class="col-md-6">
            <h1 class="mb-4"><?= htmlspecialchars($package['name']) ?></h1>
            <h4 class="text-primary mb-4">$<?= number_format($package['price'], 2) ?></h4>
            
            <!-- Trip Details -->
            <div class="mb-4">
                <h3>Trip Details</h3>
                <p><?= nl2br(htmlspecialchars($package['trip_details'])) ?></p>
            </div>

            <!-- Booking Button -->
            <div class="d-grid">
                <a href="booking.php?package_id=<?= $package['id'] ?>" 
                   class="btn btn-primary btn-lg">Book Now</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>