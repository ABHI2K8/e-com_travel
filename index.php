<?php 
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/header.php';
?>
<div class="container mt-5">
    <h1 class="mb-4">Welcome to TravelGo</h1>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <img src="images/banner.jpg" class="card-img-top" alt="Travel Banner">
                <div class="card-body">
                    <h5 class="card-title">Explore the World</h5>
                    <p class="card-text">Discover amazing destinations with our exclusive packages.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Special Offers</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Summer Discount 20% Off</li>
                        <li class="list-group-item">Group Travel Packages</li>
                        <li class="list-group-item">Honeymoon Special</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>