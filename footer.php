<?php
require_once 'config.php'; // Include database connection

// Increment visitor count
$stmt = $conn->prepare("INSERT INTO visitors (visit_time) VALUES (NOW())");
$stmt->execute();

// Fetch total visitor count
$stmt = $conn->prepare("SELECT COUNT(*) AS total_visitors FROM visitors");
$stmt->execute();
$result = $stmt->get_result();
$total_visitors = $result->fetch_assoc()['total_visitors'];
?>

</main>
<!-- Footer -->
<footer class="footer bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-6 mb-4">
                <h5 class="mb-3">About TravelGo</h5>
                <p class="text-muted">Your trusted partner for unforgettable travel experiences. Explore the world with us!</p>
                <div class="social-icons">
                    <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-6 mb-4">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="packages.php" class="text-white text-decoration-none">Packages</a></li>
                    <li><a href="contact.php" class="text-white text-decoration-none">Contact</a></li>
                    <li><a href="terms_of_service.php" class="text-white text-decoration-none">Terms of Service</a></li>
                    <li><a href="privacy_policy.php" class="text-white text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <hr class="mb-4">
        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0">&copy; <?= date('Y') ?> TravelGo. All rights reserved.</p>
                <p>Total Visitors: <?= $total_visitors ?></p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>