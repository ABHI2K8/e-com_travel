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
            
            <!-- Tabbed Interface -->
            <ul class="nav nav-tabs" id="packageTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                </li>
            </ul>

            <div class="tab-content mt-4" id="packageTabsContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                    <h3>Overview</h3>
                    <p id="overview-content" class="text-truncate" style="max-height: 150px; overflow: hidden;">
                        <?= nl2br(htmlspecialchars($package['trip_details'])) ?>
                    </p>
                    <button id="toggle-overview" class="btn btn-link p-0">Read More</button>
                </div>

                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                    <h3>Reviews</h3>
                    <p>No reviews available yet.</p>
                </div>
            </div>

            <!-- Booking Button -->
            <div class="d-grid mt-4">
                <a href="booking.php?package_id=<?= $package['id'] ?>" 
                   class="btn btn-primary btn-lg">Book Now</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const overviewContent = document.getElementById('overview-content');
        const toggleButton = document.getElementById('toggle-overview');

        toggleButton.addEventListener('click', function () {
            if (overviewContent.classList.contains('text-truncate')) {
                overviewContent.classList.remove('text-truncate');
                overviewContent.style.maxHeight = 'none';
                toggleButton.textContent = 'Read Less';
            } else {
                overviewContent.classList.add('text-truncate');
                overviewContent.style.maxHeight = '150px';
                toggleButton.textContent = 'Read More';
            }
        });
    });
</script>