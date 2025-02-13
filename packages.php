<?php
include 'config.php';
include 'header.php';

// Fetch packages from database
$sql = "SELECT * FROM packages";
$result = $conn->query($sql);
?>

<div class="container">
    <h2 class="mb-4">Travel Packages</h2>
    <div class="row">
        <?php if ($result->num_rows > 0):
            while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="images/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-primary">$<?php echo $row['price']; ?></h4>
                            <a href="booking.php?package_id=<?php echo $row['id']; ?>" class="btn btn-success">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile;
        else: ?>
            <div class="col-12">
                <div class="alert alert-warning">No packages available at the moment.</div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>