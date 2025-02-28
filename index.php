<?php
require 'config.php'; // Include database connection
include 'header.php'; // Include header

// Fetch featured packages
$featured_packages = [];
try {
    $stmt = $conn->prepare("SELECT * FROM packages LIMIT 3");
    $stmt->execute();
    $result = $stmt->get_result();
    $featured_packages = $result->fetch_all(MYSQLI_ASSOC);
} catch(Exception $e) {
    $error = "Error loading packages: " . $e->getMessage();
}
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title mb-4">Discover Your Next Adventure</h1>
                <p class="hero-subtitle mb-5">Explore breathtaking destinations with exclusive travel packages</p>
                
                <!-- Search Form -->
                <form class="hero-search" action="packages.php" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" 
                               class="form-control form-control-lg" 
                               placeholder="Search destinations..."
                               aria-label="Search destinations">
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <i class="fas fa-chevron-down"></i>
    </div>
</section>

<!-- Featured Packages -->
<section class="featured-packages py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Popular Packages</h2>
        <div class="row">
            <?php if (!empty($featured_packages)): ?>
                <?php foreach ($featured_packages as $package): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card package-card h-100 shadow">
                            <img src="images/<?= $package['image'] ?>" class="card-img-top" alt="<?= $package['name'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= $package['name'] ?></h5>
                                <p class="card-text"><?= substr($package['description'], 0, 100) ?>...</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="text-primary mb-0">$<?= $package['price'] ?></h4>
                                    <a href="package-detail.php?id=<?= $package['id'] ?>" class="btn btn-success">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">No packages found.</div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose py-5">
    <div class="container">
        <h2 class="text-center mb-5">Why Choose TravelGo?</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                        <h5>Safe Travel</h5>
                        <p>24/7 support and verified partners</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <i class="fas fa-tag fa-3x text-primary mb-3"></i>
                        <h5>Best Price</h5>
                        <p>Price match guarantee on all bookings</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <i class="fas fa-globe-asia fa-3x text-primary mb-3"></i>
                        <h5>Global Destinations</h5>
                        <p>2000+ destinations across the world</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>