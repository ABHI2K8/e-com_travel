<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$package = [];
if (isset($_GET['id'])) {
    $package_id = (int)$_GET['id'];
    
    try {
        $stmt = $conn->prepare("SELECT * FROM packages WHERE id = ?");
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $package = $stmt->get_result()->fetch_assoc();
        
        if (!$package) {
            throw new Exception("Package not found!");
        }
    } catch(Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: packages.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $package_id = (int)$_POST['id'];
    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $price = (float)$_POST['price'];
    $image = $_FILES['image'];

    try {
        // Get existing image
        $stmt = $conn->prepare("SELECT image FROM packages WHERE id = ?");
        $stmt->bind_param("i", $package_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $current_image = $result['image'];

        // Handle new image upload
        $new_image = $current_image;
        if ($image['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];
            $file_ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
            
            if (!in_array($file_ext, $allowed_types)) {
                throw new Exception("Invalid image format!");
            }

            $upload_dir = "../images/";
            $new_filename = uniqid('package_') . '.' . $file_ext;
            $target_path = $upload_dir . $new_filename;

            if (!move_uploaded_file($image['tmp_name'], $target_path)) {
                throw new Exception("Image upload failed!");
            }
            
            $new_image = $new_filename;
            // Remove old image
            if (file_exists($upload_dir . $current_image)) {
                unlink($upload_dir . $current_image);
            }
        }

        // Update database
        $stmt = $conn->prepare("UPDATE packages SET name=?, description=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("ssdsi", $name, $description, $price, $new_image, $package_id);
        
        if (!$stmt->execute()) {
            throw new Exception("Update failed: " . $stmt->error);
        }

        $_SESSION['success'] = "Package updated successfully!";
        header('Location: packages.php');
        exit();

    } catch(Exception $e) {
        $_SESSION['error'] = $e->getMessage();
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
</head>
<body>
    <?php include __DIR__ . '/admin_nav.php'; ?>
    
    <div class="container mt-4">
        <h2 class="mb-4">Edit Package</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $package['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label">Package Name</label>
                <input type="text" name="name" class="form-control" value="<?= $package['name'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= $package['description'] ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" step="0.01" class="form-control" value="<?= $package['price'] ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <img src="../images/<?= $package['image'] ?>" width="150" class="d-block mb-2">
                <label class="form-label">Upload New Image (optional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            
            <button type="submit" class="btn btn-primary">Update Package</button>
        </form>
    </div>
</body>
</html>