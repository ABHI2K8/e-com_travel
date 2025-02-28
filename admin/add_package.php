<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = (float)$_POST['price'];
    $image = $_FILES['image'];

    try {
        // Validate inputs
        if (empty($name) || empty($description) || empty($price)) {
            throw new Exception("All fields are required!");
        }

        // Validate image
        if ($image['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Please upload an image!");
        }

        $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
        $file_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        
        if (!in_array($file_ext, $allowed_types)) {
            throw new Exception("Only JPG, JPEG, PNG & WEBP files are allowed!");
        }

        // Create upload directory if it doesn't exist
        $upload_dir = "../images/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Generate unique filename
        $new_filename = uniqid('package_') . '.' . $file_ext;
        $target_path = $upload_dir . $new_filename;

        // Move uploaded file
        if (!move_uploaded_file($image['tmp_name'], $target_path)) {
            throw new Exception("Failed to upload image!");
        }

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO packages (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $new_filename);
        
        if (!$stmt->execute()) {
            throw new Exception("Database error: " . $stmt->error);
        }

        $success = "New package added successfully!";
        $_SESSION['success'] = $success;
        header('Location: packages.php');
        exit();

    } catch(Exception $e) {
        $error = $e->getMessage();
        $_SESSION['error'] = $error;
        header('Location: add_package.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Package</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/admin_nav.php'; ?>
    
    <div class="container mt-4">
        <h2 class="mb-4">Add New Package</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Package Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" step="0.01" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Package</button>
        </form>
    </div>
</body>
</html>