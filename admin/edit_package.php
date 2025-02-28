<?php
session_start();
require '../config.php';

// Authentication check
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Initialize variables
$error = '';
$success = '';
$package = [];

// Get package ID
if (!isset($_GET['id'])) {
    header('Location: packages.php');
    exit();
}
$package_id = (int)$_GET['id'];

// Fetch package data
try {
    $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
    $stmt->bind_param("i", $package_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception("Package not found!");
    }
    $package = $result->fetch_assoc();
} catch(Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: packages.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = (float)$_POST['price'];
    $trip_details = htmlspecialchars($_POST['trip_details']);
    $image = $_FILES['image'];

    try {
        // Validate inputs
        if (empty($name) || empty($description) || empty($price) || empty($trip_details)) {
            throw new Exception("All fields are required!");
        }

        // Image handling
        $current_image = $package['image'];
        $new_image = $current_image;
        
        if ($image['error'] === UPLOAD_ERR_OK) {
            // Validate new image
            $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
            $file_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file_ext, $allowed_types)) {
                throw new Exception("Invalid image format! Allowed: JPG, JPEG, PNG, WEBP");
            }

            // Generate unique filename
            $upload_dir = "../images/";
            $new_filename = uniqid('package_') . '.' . $file_ext;
            $target_path = $upload_dir . $new_filename;

            if (!move_uploaded_file($image['tmp_name'], $target_path)) {
                throw new Exception("Failed to upload image!");
            }
            
            $new_image = $new_filename;
            // Remove old image
            if (file_exists($upload_dir . $current_image)) {
                unlink($upload_dir . $current_image);
            }
        }

        // Update database
        $stmt = $conn->prepare("UPDATE packages SET 
                                name = ?, 
                                description = ?, 
                                price = ?, 
                                image = ?, 
                                trip_details = ? 
                                WHERE id = ?");
        $stmt->bind_param("ssdssi", $name, $description, $price, $new_image, $trip_details, $package_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Update failed: " . $stmt->error);
        }

        $_SESSION['success'] = "Package updated successfully!";
        header("Location: packages.php");
        exit();

    } catch(Exception $e) {
        $error = $e->getMessage();
        $_SESSION['error'] = $error;
        header("Location: edit_package.php?id=$package_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Package</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .current-image {
            max-width: 300px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .image-preview {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 600;
        }
    </style>
</head>
<body>
    <?php include 'admin_nav.php'; ?>
    
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Edit Package</h4>
                    </div>
                    <div class="card-body">
                        <?php if(isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $package['id'] ?>">

                            <div class="mb-4">
                                <label class="form-label">Current Image</label>
                                <div class="image-preview">
                                    <img src="../images/<?= $package['image'] ?>" 
                                         alt="Current Package Image" 
                                         class="current-image">
                                    <div class="mt-2 text-muted">
                                        Upload new image to replace
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Package Name</label>
                                <input type="text" name="name" class="form-control" 
                                       value="<?= htmlspecialchars($package['name']) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($package['description']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" name="price" step="0.01" 
                                       class="form-control" 
                                       value="<?= $package['price'] ?>" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Trip Details</label>
                                <textarea name="trip_details" class="form-control" rows="6" required><?= htmlspecialchars($package['trip_details']) ?></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">New Image (Optional)</label>
                                <input type="file" name="image" class="form-control" 
                                       accept="image/*">
                                <div class="form-text">
                                    Leave blank to keep current image
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Update Package
                                </button>
                                <a href="packages.php" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>