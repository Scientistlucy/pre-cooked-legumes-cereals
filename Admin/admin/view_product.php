<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Insert Product
if(isset($_POST['insert-product'])){
  $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
  $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
  $product_price = mysqli_real_escape_string($con, $_POST['product_price']);
  $product_status = 'true';

  // Accessing images
  $product_image1 = $_FILES['product_image1']['name'];
  $temp_image1 = $_FILES['product_image1']['tmp_name'];

  // Checking empty condition
  if($product_title == '' or $product_keywords == '' or $product_price == '' or $product_image1 == ''){
    echo "<script>alert('Please fill all the available fields')</script>";
    exit();
  }else{
    // Generate unique filename
    $filename = uniqid() . '_' . basename($product_image1);
    $target_dir = "./product_images/";
    $target_file = $target_dir . $filename;

    // Move uploaded file
    if(move_uploaded_file($temp_image1, $target_file)){
      // Insert query
      $insert_products = "INSERT INTO products (product_title, product_keyword, product_image1, product_price, date, status) VALUES ('$product_title', '$product_keywords', '$filename', '$product_price', NOW(), '$product_status')";
      $result_query = mysqli_query($con, $insert_products);
      if($result_query){
        echo "<script>alert('Successfully inserted the product')</script>";
      } else {
        echo "<script>alert('Failed to insert product')</script>";
      }
    } else {
      echo "<script>alert('Failed to upload image')</script>";
    }
  }
}
// Delete Product
if (isset($_GET['delete_product'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['delete_product']);
    
    // First, get the image to delete from filesystem
    $get_image_query = "SELECT product_image1 FROM products WHERE product_id = '$product_id'";
    $image_result = mysqli_query($con, $get_image_query);
    $image_row = mysqli_fetch_assoc($image_result);
    
    // Delete product from database
    $delete_query = "DELETE FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($con, $delete_query);
    
    if ($result) {
        // Delete image file if it exists
        if (!empty($image_row['product_image1'])) {
            $image_path = "./product_images/" . $image_row['product_image1'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }
        
        echo json_encode(['status' => 'success', 'message' => 'Product deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete product']);
    }
    exit();
}

// Fetch single product for modal
if (isset($_GET['fetch_product'])) {
    $product_id = mysqli_real_escape_string($con, $_GET['fetch_product']);
    $get_product_query = "SELECT * FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($con, $get_product_query);
    $product = mysqli_fetch_assoc($result);
    
    // Return JSON for AJAX request
    header('Content-Type: application/json');
    echo json_encode($product);
    exit();
}

// Update Product
if (isset($_POST['update_product'])) {
    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);
    $product_title = mysqli_real_escape_string($con, $_POST['product_title']);
    $product_keywords = mysqli_real_escape_string($con, $_POST['product_keywords']);
    $product_price = mysqli_real_escape_string($con, $_POST['product_price']);

    // Handle image upload
    $filename = ''; // Default empty filename
    $update_image = false;

    if (!empty($_FILES['product_image']['name'])) {
        // Create unique filename
        $filename = uniqid() . '_' . basename($_FILES['product_image']['name']);
        $target_dir = "./product_images/";
        $target_file = $target_dir . $filename;

        // Move uploaded file
        if (move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file)) {
            $update_image = true;

            // Delete old image if exists
            $get_old_image_query = "SELECT product_image1 FROM products WHERE product_id = '$product_id'";
            $old_image_result = mysqli_query($con, $get_old_image_query);
            $old_image_row = mysqli_fetch_assoc($old_image_result);
            
            if (!empty($old_image_row['product_image1'])) {
                $old_image_path = $target_dir . $old_image_row['product_image1'];
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
        }
    }

    // Prepare update query
    if ($update_image) {
        // Update with new image
        $update_query = "UPDATE products SET 
                         product_title = '$product_title', 
                         product_keyword = '$product_keywords', 
                         product_price = '$product_price',
                         product_image1 = '$filename'
                         WHERE product_id = '$product_id'";
    } else {
        // Update without changing image
        $update_query = "UPDATE products SET 
                         product_title = '$product_title', 
                         product_keyword = '$product_keywords', 
                         product_price = '$product_price'
                         WHERE product_id = '$product_id'";
    }
    
    $result = mysqli_query($con, $update_query);
    
    if ($result) {
        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update product']);
    }
    exit();
}

// Rest of the existing code for delete, fetch, and update remains the same...
// (Previous delete, fetch product, and update product code remains unchanged)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        :root {
            --primary-color: #ff6600;
            --primary-hover: #e65c00;
        }
        
    /* Reduce the overall table width */
    .table {
        width: 80%; /* Adjust the percentage to make it narrower */
        margin: 0 auto; /* Center the table */
        /* Reduce font size to make content smaller */
    }

    /* Reduce padding inside table cells */
    .table th, .table td {
        padding: 5px 8px; 
        
    }

    /* Optionally reduce the height of the rows */
    .table tr {
        height: 2px; /* You can adjust the row height */
    }
    .edit-product {
        margin-right: 90px; /* Adjust the margin between the two buttons */
    }
    </style>
</head>
<body>
<div class="container mt-3">
    <h1 class="text-center mb-4"></h1>

    <!-- Insert Product Section -->
    <div class="row mb-5">
        <div class="col-md-8 offset-md-2">
            <div class="card">

            <div class="card-header" style="color: var(--primary-color);">

                    <h4 class="text-center">Insert New Product</h4>
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_title" class="form-label">Product Title</label>
                                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter product title" autocomplete="off" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="product_keywords" class="form-label">Product Keywords</label>
                                <input type="text" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter product keywords" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="product_image1" class="form-label">Product Image</label>
                                <input type="file" name="product_image1" id="product_image1" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="product_price" class="form-label">Product Price</label>
                                <input type="number" step="0.01" name="product_price" id="product_price" class="form-control" placeholder="Enter product price" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="text-center">
    <input type="submit" name="insert-product" class="btn px-4" value="Insert Product" style="background-color: var(--primary-color);">
</div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Table -->
    <h3 class="text-center" style="color: var(--primary-color)">Existing Products</h3>
    <table class="table table-bordered mt-1">
    <thead style="background-color: var(--primary-color);">
            <tr>
                <th></th>
                <th>Title</th>
               
               
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class='bg-dark text-light'>
            <?php
            $get_products = "SELECT * FROM products";
            $result = mysqli_query($con, $get_products);
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['product_id']}</td>
                        <td>{$row['product_title']}</td>
                        
                       
                        <td>
                            <button class='btn btn-primary edit-product' 
                                    data-id='{$row['product_id']}' 
                                    data-bs-toggle='modal' 
                                    data-bs-target='#editProductModal'>
                                Edit
                            </button>
                            <button class='btn btn-danger delete-product' 
                                    data-id='{$row['product_id']}'>
                                Delete
                            </button>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
 <!-- Edit Product Modal -->
 <div class="modal fade" id="editProductModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm" enctype="multipart/form-data">
                        <input type="hidden" id="edit-product-id" name="product_id">
                        
                        <div class="mb-3">
                            <label class="form-label">Product Title</label>
                            <input type="text" class="form-control" id="edit-product-title" name="product_title" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Product Keywords</label>
                            <input type="text" class="form-control" id="edit-product-keywords" name="product_keywords" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Product Price</label>
                            <input type="number" step="0.01" class="form-control" id="edit-product-price" name="product_price" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" class="form-control" name="product_image" accept="image/*">
                            <img id="current-product-image" src="" class="img-thumbnail mt-2" style="max-width: 200px; display: none;">
                        </div>
                        
                        <button type="submit" class="btn" style="background-color: var(--primary-color);">Update Product</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Edit Product Modal -->
    <!-- (Rest of the existing modal code remains unchanged) -->


<!-- Bootstrap and jQuery JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript for edit and delete functionality remains the same -->
<script>
    $(document).ready(function() {
    // When Edit button is clicked
    $('.edit-product').click(function() {
        var productId = $(this).data('id');
        
        // Fetch product details via AJAX
        $.ajax({
            url: '?fetch_product=' + productId,
            method: 'GET',
            dataType: 'json',
            success: function(product) {
                // Populate modal with product details
                $('#edit-product-id').val(product.product_id);
                $('#edit-product-title').val(product.product_title);
                $('#edit-product-keywords').val(product.product_keyword);
                $('#edit-product-price').val(product.product_price);
                
                // Show current product image
                $('#current-product-image').attr('src', './product_images/' + product.product_image1).show();
            },
            error: function() {
                alert('Failed to fetch product details');
            }
        });
    });

    // Form submission
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        
        // Create FormData object to send files
        var formData = new FormData(this);
        formData.append('update_product', 1);
        
        $.ajax({
            url: '',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    location.reload(); // Reload page to show updated data
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Failed to update product');
            }
        });
    });

    // Delete Product
    $('.delete-product').click(function() {
        var productId = $(this).data('id');
        
        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: '?delete_product=' + productId,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        location.reload(); // Reload page to remove deleted product
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Failed to delete product');
                }
            });
        }
    });
});
</script>
</body>
</html>