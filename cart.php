<!--connect file-->
<?php
include('D:\Restaurantly\Restaurantly\includes\connect.php');
include('D:\Restaurantly\Restaurantly\Admin\functions\common_function.php');
session_start(); // Start the session


// Fetch the subtotal from JavaScript subtotal calculation
if (isset($_POST['subtotal'])) {
  // Update session subtotal with the value from the form or AJAX request
  $subtotal = floatval($_POST['subtotal']);
  $_SESSION['subtotal'] = $subtotal;
  
  // Optional: Add some debugging
  error_log("Subtotal received: " . $subtotal);
} else {
  // If no subtotal is received, set to the calculated total from cart
  $get_ip_address = getIPAddress();
  $cart_query = "SELECT SUM(total_price) as cart_total FROM cart_details WHERE ip_address='$get_ip_address'";
  $result = mysqli_query($con, $cart_query);
  $row = mysqli_fetch_assoc($result);
  $_SESSION['subtotal'] = floatval($row['cart_total'] ?? 0);
}

// Echo the subtotal for verification
echo "Subtotal is: " . $_SESSION['subtotal'];


// Get the IP address of the user
$get_ip_address = getIPAddress();

// Handle cart insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];  // Get product ID from the form
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;  // Set default quantity to 1 if not provided
    
    // Check if the product is already in the cart
    $check_cart = "SELECT * FROM cart_details WHERE product_id = ? AND ip_address = ?";
    $stmt_check = mysqli_prepare($con, $check_cart);
    mysqli_stmt_bind_param($stmt_check, 'is', $product_id, $get_ip_address);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Product is already in the cart, so update the quantity
        $update_cart = "UPDATE cart_details SET quantity = quantity + ? WHERE product_id = ? AND ip_address = ?";
        $stmt_update = mysqli_prepare($con, $update_cart);
        mysqli_stmt_bind_param($stmt_update, 'iis', $quantity, $product_id, $get_ip_address);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        echo "<script>alert('Cart updated with new quantity!')</script>";
    } else {
        // Product not in cart, insert new record
        $insert_cart = "INSERT INTO cart_details (product_id, quantity, ip_address) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($con, $insert_cart);
        mysqli_stmt_bind_param($stmt_insert, 'iis', $product_id, $quantity, $get_ip_address);
        if (mysqli_stmt_execute($stmt_insert)) {
            echo "<script>alert('Product added to cart!')</script>";
        } else {
            echo "<script>alert('Failed to add product to cart')</script>";
        }
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt_check);
}

// Handle quantity updates via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_cart'])) {
    $update_success = true;
    
    if (isset($_POST['qty'])) {
        foreach ($_POST['qty'] as $product_id => $quantity) {
            // Get the base price for this product
            $select_price = "SELECT product_price FROM products WHERE product_id = ?";
            $stmt = mysqli_prepare($con, $select_price);
            mysqli_stmt_bind_param($stmt, 'i', $product_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            
            if ($row) {
                $base_price = floatval(str_replace('kshs ', '', $row['product_price']));
                $total_price = $base_price * $quantity;
                
                // Update cart with new quantity and total price
                $update_cart = "UPDATE cart_details SET 
                    quantity = ?, total_price = ? 
                    WHERE product_id = ? AND ip_address = ?";
                    
                $update_stmt = mysqli_prepare($con, $update_cart);
                mysqli_stmt_bind_param($update_stmt, 'idis', $quantity, $total_price, $product_id, $get_ip_address);
                
                if (!mysqli_stmt_execute($update_stmt)) {
                    $update_success = false;
                }
                mysqli_stmt_close($update_stmt);
            }
            mysqli_stmt_close($stmt);
        }
    }
    
    if ($update_success) {
        echo "<script>alert('Cart updated successfully!')</script>";
    } else {
        echo "<script>alert('Failed to update cart')</script>";
    }
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre Cooked-cart details</title>
<!-- Icon Library-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!--boostrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

      <!--font awesome link -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     
      <!-- 
    - preload images
  -->
  
<link rel="preload" as="image" href="assets/img/image.jpeg">
<link rel="preload" as="image" href="assets/img/image.jpeg">
<link rel="preload" as="image" href="assets/img/image.jpeg">
  <!-- Favicons -->
 <!--search bar-->
 <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
      <style>
      
        
      </style>
     
</head>
<body>

<!--navbar-->

<header id="header" class="header fixed-top" style="background-color: black;">


<div class="topbar d-flex align-items-center">
  <div class="container d-flex justify-content-center justify-content-md-between">
    <div class="contact-info d-flex align-items-center">
      <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">wanjikul598@gmail.com</a></i>
      <i class="bi bi-phone d-flex align-items-center ms-4"><span>+254 796776208</span></i>
    </div>
    <div class="languages d-none d-md-flex align-items-center">
      <ul>
        <li>En</li>
        <li><a href="#">De</a></li>
      </ul>
    </div>
  </div>
</div><!-- End Top Bar -->

<div class="branding d-flex align-items-cente">

  <div class="container position-relative d-flex align-items-center justify-content-between">
    <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
      <!-- Uncomment the line below if you also wish to use an image logo -->
      <!-- <img src="assets/img/logo.png" alt=""> -->
      <h1 class="sitename">Pre Cooked</h1>
    </a>

    <nav id="navmenu" class="navmenu">
      <ul>
        <li><a href="index.php" class="active">Home<br></a></li>
            <li><a href="#foods-section">Foods</a></li>
            <li><a href="#gallery">Gallary</a></li>
            <li><a href="#testimonials">Testimonials</a></li>
            <li><a href="#why-us">About</a></li>
            <li><a href="#contact">Contact</a></li>
       
      </ul>
      <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>

    <a class="btn-book-a-table d-none d-xl-block" href="#book-a-table">Order Now</a>
    <a href="#" class="cart-icon d-none d-xl-inline-block">
      <!-- SVG version -->
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
      </svg>
      <sup><?php cart_item();?></sup></a>
    </a>

  </div>

</div>

</header>

<!--calling cart function-->

<?php
cart();


?>
<!--second child-->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <ul class="navbar-nav me-auto">
  <?php

if(!isset($_SESSION['username'])){
  echo"<li class='nav-item'>
  <a  class='nav-link'href='#'>Welcome Customer</a>
</li>";
}
else{
  echo" <li class='nav-item'>
  <a  class='nav-link'href='#'>welcome ". $_SESSION['username']."</a>
</li>";
}
    
    if(!isset($_SESSION['username'])){
      echo" <li class='nav-item'>
      <a  class='nav-link'href='includes\users_area\userlogin.php'>Login</a>
    </li>";
    }
    else{
      echo" <li class='nav-item'>
      <a  class='nav-link'href='includes\users_area\logout.php'>Logout</a>
    </li>";
    }
    
    ?>
  </ul>
</nav>
<!--third child-->
<div class="bg-light">
  <h3 class="text-center">NOOVA Online shop</h3>
  <p class="text-center">Your Destination For Quality</p>
</div>

  <!--fourth child -table-->
<div class="container">
    <div class="row">
      <form action="" method="post">
    <table class="table table-bordered text-center">

<tbody>
  <!--php code to display dynamics data-->
  <?php
  global $con;
  $get_ip_address = getIPAddress();
  $total_price = 0;
  $cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_address'";
  $result= mysqli_query($con, $cart_query);
  $result_count=mysqli_num_rows( $result);
  if($result_count>0){
    echo"<thead>
    <tr>
     <th>Product Image</th>
      <th>Product Title</th>
      <th>Quantity</th>
      <th> Price Per Cup</th>
      <th>Update</th>
      <th>Remove</th>
    
    </tr>
</thead>";
while ($row = mysqli_fetch_array($result)) {
    $product_id = $row['product_id'];
   
    $select_products = "SELECT product_title,product_image1, product_price FROM products WHERE product_id='$product_id'";
    $result_products = mysqli_query($con, $select_products);
    // Initialize variables to avoid undefined variable warnings
    $product_title = '';
    $product_price = 0;
   

    while ($row_product_price = mysqli_fetch_array($result_products))
     {
      $product_title = $row_product_price['product_title'];
      $product_image1 = $row_product_price['product_image1'];
    //<!--  $product_image1 = $row_product_price['product_image1'];-->
      if (isset($row_product_price['product_price'])) {
        $product_price = str_replace("kshs ", "", $row_product_price['product_price']); // Remove "kshs" prefix
        $total_price += intval($product_price); // Convert to integer before adding
      } else {
        echo "product_price is not set!";
      }
   
    }
  
  ?>
    <tr>
    <td>
  
                    <?php if (!empty($product_image1)): ?>
                        <img src="assets/img/product/<?php echo $product_image1; ?>"
                            
                             class="cart-item-image"
                             style="width: 80px; height: 60px;">
                    <?php else: ?>
                        <span>No image available</span>
                    <?php endif; ?>
               
</td>

        <td><?php echo  $product_title?></td>
   
        <td class="centered-cell">
    <input type="number" 
           name="qty[<?php echo $product_id; ?>]" 
           id="qty_<?php echo $product_id; ?>" 
           class="centered-input" 
           min="1" 
           value="<?php echo $row['quantity']; ?>"
           data-product-id="<?php echo $product_id; ?>">
</td>

<td>Ksh<span id="price_<?php echo $product_id; ?>" 
    data-base-price="<?php echo $product_price; ?>">
    <?php echo $product_price * $row['quantity']; ?>
</span>/-</td>


<?php
  $get_ip_address = getIPAddress(); // Assuming this function exists and returns the correct IP.
  // Initialize cart_items as an array
  $cart_items = [];

  if (isset($_POST['update_cart'])) {
    // Loop through the array of quantities
    foreach ($_POST['qty'] as $product_id => $quantity) {
      $quantity = intval($quantity); // Ensure the quantity is treated as an integer

      // Update the cart with the new quantity for each product
      $update_cart = "UPDATE cart_details 
                      SET quantity='$quantity' 
                      WHERE ip_address='$get_ip_address' 
                      AND product_id='$product_id'";
      
      $result_products_quantity = mysqli_query($con, $update_cart);

      // Optionally, update total price based on new quantities
      $total_price = $total_price * $quantity;
    }
  }
?>
<td>
 <!-- Form for Updating Item -->
<form method="post" action="cart.php">
  <?php foreach ($cart_items as $item) { ?> <!-- Assuming $cart_items is an array of items in the cart -->
    <div>
      <input type="number" name="qty[<?php echo $item['product_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1">
      <button type="submit" name="update_cart" class="update-item">
        <i class="fas fa-sync-alt"></i> Update
      </button>
    </div>
  <?php } ?>
  <button type="submit" name="update_cart">Update Cart</button>
</form>

</td>

        
        <td>
        <!-- Form for Removing Item -->
        <form method="post" action="cart.php">
            <input type="hidden" name="removeitem" value="<?php echo $product_id; ?>">
            <button type="submit" name="remove_cart" class="remove-item">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    </td>
    
    
       
        
    </tr>
    <?php
     }
    }
    else{
     echo "<h2 class='text-center text-danger'>Cart is empty</h2>"; 
    }
    ?>
</tbody>
    </table>

<!-- Subtotal -->
<div class="d-flex mb-5">
<h4 class="px-3">Subtotal: 
    <strong style="color: #ff4500;"> Ksh 
        <span id="subtotal" data-initial="<?php echo $total_price; ?>">
            <?php echo $total_price; ?>
        </span> /-
    </strong>
</h4>
<button type="button" class="px-3 py-2 border-0 mx-3" style="background-color: #ff4500; color: white;" onclick="window.location.href='index.php'">
    Continue Shopping
</button>


    <?php
    if(isset($_SESSION['username'])) {
        // User is logged in - show checkout button
        echo '<a href="includes/users_area/order_form.php" class="text-decoration-none">
                <button type="button" class="bg-secondary px-3 py-2 border-0 text-light">
                    Checkout
                </button>
              </a>';
    } else {
        // User is not logged in - redirect to login
        echo '<a href="includes/users_area/userlogin.php" class="text-decoration-none">
                <button type="button" class="bg-secondary px-3 py-2 border-0 text-light" 
                    onclick="alert(\'Please login to proceed with checkout\');">
                    Login to Checkout
                </button>
              </a>';
    }
    ?>
</div>
    </div>
</div>
</form>
<!--function to remove item-->
<?php
function remove_cart_item() {
    global $con;

    // Check if the form was submitted and if the remove_cart button was clicked
    if (isset($_POST['remove_cart']) && isset($_POST['removeitem'])) {
        // Get the product ID of the item to be removed
        $remove_id = $_POST['removeitem'];
        
        // Execute the DELETE query to remove the item from the cart
        $delete_query = "DELETE FROM cart_details WHERE product_id='$remove_id'";
        $run_delete = mysqli_query($con, $delete_query);

        // If the item was deleted successfully, refresh the cart page
        if ($run_delete) {
            echo "<script>window.open('cart.php','_self')</script>";
        }
    }
}

// Call the function to remove the item when the form is submitted
remove_cart_item();
?>



</div>

  

<script>
  function updatePrice(productId, basePrice) {
    // Get the quantity input
    const quantityInput = document.getElementById('qty_' + productId);
    const quantity = parseInt(quantityInput.value) || 1;

    // Get the price display element
    const priceElement = document.getElementById('price_' + productId);

    // Calculate new price for this item
    const newPrice = basePrice * quantity;

    // Update the displayed price for this item
    priceElement.textContent = newPrice;

    // Update the subtotal
    updateSubtotal();
}

function updateSubtotal() {
    let newSubtotal = 0;

    // Find all price elements
    const priceElements = document.querySelectorAll('[id^="price_"]');

    // Sum up all prices
    priceElements.forEach(element => {
        const price = parseInt(element.textContent) || 0;
        newSubtotal += price;
    });

    // Update the subtotal display
    const subtotalElement = document.getElementById('subtotal');
    subtotalElement.textContent = newSubtotal;

    // Update the M-Pesa form amount field
    const amountInput = document.getElementById('amount');
    amountInput.value = newSubtotal;
    
    // Update the displayed amount in the payment info section
    const displayAmount = document.getElementById('displayAmount');
    displayAmount.textContent = newSubtotal.toLocaleString('en-KE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Initialize the subtotal when the page loads
document.addEventListener('DOMContentLoaded', function() {
    updateSubtotal();
});

</script>
<SCRIPT>
 
function updateCartInDatabase(productId) {
    const quantity = document.getElementById('qty_' + productId).value;
    const basePrice = document.getElementById('price_' + productId).getAttribute('data-base-price');
    const totalPrice = quantity * basePrice;

    // Create FormData object
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    formData.append('total_price', totalPrice);

    // Send AJAX request to update cart
    fetch('updatecart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart updated successfully');
            updateSubtotal(); // Update the display
        } else {
            console.error('Failed to update cart:', data.message);
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
    });
}

// Modify your existing updatePrice function to include the database update
function updatePrice(productId, basePrice) {
    const quantityInput = document.getElementById('qty_' + productId);
    const quantity = parseInt(quantityInput.value) || 1;
    const priceElement = document.getElementById('price_' + productId);
    const newPrice = basePrice * quantity;
    
    priceElement.textContent = newPrice;
    updateSubtotal();
    
    // Add this line to trigger the database update
    updateCartInDatabase(productId);
}
</SCRIPT>


<script>
  // Function to update quantity in the database
function updateCartQuantity(productId, quantity) {
    const formData = new FormData();
    formData.append('qty[' + productId + ']', quantity);

    fetch('updatecart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart updated successfully');
            // Update the price display
            const basePrice = document.getElementById('price_' + productId).getAttribute('data-base-price');
            updatePrice(productId, basePrice);
        } else {
            console.error('Failed to update cart:', data.message);
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
    });
}

// Modified updatePrice function
function updatePrice(productId, basePrice) {
    const quantityInput = document.getElementById('qty_' + productId);
    const quantity = parseInt(quantityInput.value) || 1;
    const priceElement = document.getElementById('price_' + productId);
    
    // Calculate new price
    const newPrice = basePrice * quantity;
    
    // Update price display
    priceElement.textContent = newPrice;
    
    // Update subtotal
    updateSubtotal();
    
    // Update database
    updateCartQuantity(productId, quantity);
}

// Add event listeners to quantity inputs
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('input[name^="qty["]');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('name').match(/\[(\d+)\]/)[1];
            const basePrice = document.getElementById('price_' + productId).getAttribute('data-base-price');
            updatePrice(productId, basePrice);
        });
    });
});
</script>




<script>


 function updatePrice(productId, basePrice) {
    // Get the quantity input
    const quantityInput = document.getElementById('qty_' + productId);
    const quantity = parseInt(quantityInput.value) || 1;

    // Get the price display element
    const priceElement = document.getElementById('price_' + productId);

    // Calculate new price for this item
    const newPrice = basePrice * quantity;

    // Update the displayed price for this item
    priceElement.textContent = newPrice;

    // Update the subtotal
    updateSubtotal();
}

function updateSubtotal() {
    let newSubtotal = 0;

    // Find all price elements
    const priceElements = document.querySelectorAll('[id^="price_"]');

    // Sum up all prices
    priceElements.forEach(element => {
        const price = parseFloat(element.textContent) || 0;
        newSubtotal += price;
    });

    // Update the subtotal display
    const subtotalElement = document.getElementById('subtotal');
    subtotalElement.textContent = newSubtotal.toFixed(2);

    // Update the M-Pesa form amount field
    const amountInput = document.getElementById('amount');
    amountInput.value = newSubtotal;
    
    // Update the displayed amount in the payment info section
    const displayAmount = document.getElementById('displayAmount');
    displayAmount.textContent = newSubtotal.toLocaleString('en-KE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

    // Optional: Send subtotal to server
    sendSubtotalToServer(newSubtotal);
}




// AJAX function to send the subtotal to the backend
function updateSubtotalInSession(subtotal) {
    const formData = new FormData();
    formData.append('subtotal', subtotal);

    fetch('cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('Subtotal updated in session');
    })
    .catch(error => {
        console.error('Error updating subtotal:', error);
    });
}
function updateSubtotal() {
    let newSubtotal = 0;

    // Find all price elements
    const priceElements = document.querySelectorAll('[id^="price_"]');

    // Sum up all prices
    priceElements.forEach(element => {
        const price = parseInt(element.textContent) || 0;
        newSubtotal += price;
    });

    // Send subtotal to server via AJAX
    const formData = new FormData();
    formData.append('subtotal', newSubtotal);

    fetch('cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('Subtotal updated:', newSubtotal);
        console.log('Server response:', data);
    })
    .catch(error => {
        console.error('Error updating subtotal:', error);
    });
}



</SCript>























    <!--boostrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>