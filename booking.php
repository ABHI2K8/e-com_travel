<?php
include 'config.php';
include 'header.php';

// Initialize variables
$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $package_id = $_POST['package_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $booking_date = $_POST['booking_date'];

    // Basic validation
    if (empty($package_id) || empty($name) || empty($email) || empty($phone) || empty($booking_date)) {
        $error = 'All fields are required!';
    } else {
        // Insert booking into database
        $stmt = $conn->prepare("INSERT INTO bookings (package_id, customer_name, email, phone, booking_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $package_id, $name, $email, $phone, $booking_date);
        
        if ($stmt->execute()) {
            $success = 'Booking successfully submitted!';
        } else {
            $error = 'Error submitting booking: ' . $conn->error;
        }
        $stmt->close();
    }
}

// Get package details if coming from packages page
$package = [];
if (isset($_GET['package_id'])) {
    $package_id = $_GET['package_id'];
    $result = $conn->query("SELECT * FROM packages WHERE id = $package_id");
    $package = $result->fetch_assoc();
}
?>

<div class="container mt-5">
    <h2 class="mb-4">Book Travel Package</h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-6">
                <form method="POST">
                    <?php if ($package): ?>
                        <div class="mb-3">
                            <label class="form-label">Package:</label>
                            <input type="text" class="form-control" value="<?php echo $package['name']; ?>" readonly>
                            <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Preferred Travel Date</label>
                        <input type="date" name="booking_date" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit Booking</button>
                </form>
            </div>
            
            <?php if ($package): ?>
                <div class="col-md-6">
                    <div class="card">
                        <img src="images/<?php echo $package['image']; ?>" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $package['name']; ?></h5>
                            <p class="card-text"><?php echo $package['description']; ?></p>
                            <h4 class="text-primary">$<?php echo $package['price']; ?></h4>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>