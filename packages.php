<?php
require 'config.php';
include 'header.php';

// Get search parameters
$search = $_GET['search'] ?? '';
$min_price = $_GET['min_price'] ?? 0;
$max_price = $_GET['max_price'] ?? 999999;
$sort = $_GET['sort'] ?? 'price_asc';

// Build query
$sql = "SELECT * FROM packages 
        WHERE name LIKE ? 
        AND price BETWEEN ? AND ?";

// Add sorting
$sort_options = [
    'price_asc' => 'price ASC',
    'price_desc' => 'price DESC',
    'name_asc' => 'name ASC'
];
$order_by = $sort_options[$sort] ?? 'price ASC';

$sql .= " ORDER BY $order_by";

// Prepare and execute
$stmt = $conn->prepare($sql);
$search_term = "%$search%";
$stmt->bind_param("sdd", $search_term, $min_price, $max_price);
$stmt->execute();
$result = $stmt->get_result();
$packages = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="container mt-5">
    <!-- Search Filters -->
    <div class="card mb-4 shadow">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search destinations..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" name="min_price" class="form-control" 
                           placeholder="Min price" value="<?= $min_price ?>">
                </div>
                <div class="col-md-2">
                    <input type="number" name="max_price" class="form-control" 
                           placeholder="Max price" value="<?= $max_price ?>">
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High to Low</option>
                        <option value="name_asc" <?= $sort === 'name_asc' ? 'selected' : '' ?>>Name: A-Z</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Package Cards -->
    <div class="row">
        <?php if (count($packages) > 0): ?>
            <?php foreach ($packages as $package): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <img src="images/<?= $package['image'] ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($package['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($package['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($package['description']) ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-primary">$<?= number_format($package['price'], 2) ?></h4>
                                <a href="booking.php?package_id=<?= $package['id'] ?>" 
                                   class="btn btn-success">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No packages found matching your criteria</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>