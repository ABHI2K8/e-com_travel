<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Handle delete
if (isset($_GET['delete'])) {
    $package_id = (int)$_GET['delete'];
    
    try {
        $stmt = $conn->prepare("DELETE FROM packages WHERE id = ?");
        $stmt->bind_param("i", $package_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Package deleted successfully";
        } else {
            throw new Exception("Delete failed: " . $stmt->error);
        }
    } catch(Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    header('Location: packages.php');
    exit();
}

// Fetch packages
$packages = [];
try {
    $stmt = $conn->prepare("SELECT * FROM packages ORDER BY id DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $packages = $result->fetch_all(MYSQLI_ASSOC);
} catch(Exception $e) {
    $_SESSION['error'] = "Error loading packages: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Packages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include __DIR__ . '/admin_nav.php'; ?>
    
    <div class="container mt-4">
        <!-- Session Messages -->
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Manage Travel Packages</h4>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($packages as $package): ?>
                            <tr>
                                <td><?= $package['id'] ?></td>
                                <td><?= htmlspecialchars($package['name']) ?></td>
                                <td>$<?= number_format($package['price'], 2) ?></td>
                                <td>
                                    <img src="../images/<?= $package['image'] ?>" 
                                         alt="<?= htmlspecialchars($package['name']) ?>" 
                                         class="img-thumbnail" 
                                         style="max-width: 100px;">
                                </td>
                                <td>
                                    <a href="edit_package.php?id=<?= $package['id'] ?>" 
                                       class="btn btn-sm btn-warning">Edit</a>
                                    <a href="packages.php?delete=<?= $package['id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Delete this package permanently?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>