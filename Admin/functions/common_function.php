<?php

//include connect file
include('D:\Restaurantly\Restaurantly\includes\connect.php');
//getting products using functions
function getproducts() {
    global $con;

    $select_query = "SELECT p.*, 
        COALESCE(AVG(r.rating), 0) as average_rating,
        COUNT(r.id) as total_reviews
        FROM products p
        LEFT JOIN product_reviews r ON p.product_id = r.product_id
        GROUP BY p.product_id
        ORDER BY rand() LIMIT 0, 9";
  

    $result_query = mysqli_query($con, $select_query);

    if (!$result_query) {
        die("Query failed: " . mysqli_error($con));
    }

    // Check if there are products returned
    if (mysqli_num_rows($result_query) > 0) {
        while ($row = mysqli_fetch_assoc($result_query)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_image1 = $row['product_image1'];
            $product_price = $row['product_price'];
            $average_rating = number_format($row['average_rating'], 1);
            $total_reviews = $row['total_reviews'];

            // Generate star rating based on average
            $full_stars = floor($average_rating);
            $half_star = $average_rating - $full_stars >= 0.5;
            $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);

            $stars_html = '';
            // Add full stars
            for ($i = 0; $i < $full_stars; $i++) {
                $stars_html .= '<i class="fas fa-star"></i>';
            }
            // Add half star if needed
            if ($half_star) {
                $stars_html .= '<i class="fas fa-star-half-alt"></i>';
            }
            // Add empty stars
            for ($i = 0; $i < $empty_stars; $i++) {
                $stars_html .= '<i class="far fa-star"></i>';
            }

            echo "
            <div class='product-card'>
                <img src='assets/img/product/$product_image1' alt='$product_title' class='product-image'>
                <div class='product-info'>
                    <div class='product-name'>$product_title</div>
                    <div class='product-price'>Ksh $product_price</div>
                    <a href='review.php?product_id=$product_id' class='product-rating'>
                        $stars_html
                        <span>($average_rating)</span>
                        <span class='review-count'>$total_reviews reviews</span>
                    </a>
                     <a href='index.php?add_to_cart=$product_id' class='add-to-cart btn'>Add to Cart</a>
                    
                </div>
            </div>";
        }
    } else {
        echo "No products found.";
    }
}









//displaying the brands using function in the sidenav


function search_product(){
  global $con;
  if(isset($_GET['search_data'])){
      $search_data_value = $_GET['search_data'];
      $search_query = "SELECT * FROM products WHERE product_keyword LIKE '%$search_data_value%'";
      $result_query = mysqli_query($con, $search_query);
      if (!$result_query) {
          die("Query failed: " . mysqli_error($con));
      }
      $num_of_rows = mysqli_num_rows($result_query);
      if($num_of_rows == 0){
          echo "<h2 class=' margin: 20px auto text-danger'> No products found .</h2>";
      } else {
          while($row = mysqli_fetch_assoc($result_query)){
              $product_id = $row['product_id'];
              $product_title = $row['product_title'];
              $product_description = $row['product_description'];
              $product_image1 = $row['product_image1'];
              $product_price = $row['product_price'];
              echo "
              <div class='product-card'>
                  <img src='assets/img/product/$product_image1' alt='$product_title' class='product-image'>
                  <div class='product-info'>
                      <div class='product-name'>$product_title</div>
                      <div class='product-price'>Ksh $product_price</div>
                      <p class='product-description'>$product_description</p>
                      <div class='product-rating'>
                          <i class='fas fa-star'></i>
                          <i class='fas fa-star'></i>
                          <i class='fas fa-star'></i>
                          <i class='fas fa-star'></i>
                          <i class='fas fa-star-half-alt'></i>
                          <span>(4.5)</span>
                      </div>
                      <a href='index.php?add_to_cart=$product_id' class='add-to-cart btn'>Add to Cart</a>
                      <a href='#' class='view-more btn'>View More</a>
                  </div>
              </div>";
          }
      }
  }
}
//$ip = getIPAddress();  
//echo 'User Real IP Address - '.$ip;
//cart function
// Get IP Address Function
function getIPAddress() {  
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
      return $_SERVER['HTTP_CLIENT_IP'];  
  }  
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
      return $_SERVER['HTTP_X_FORWARDED_FOR'];  
  }  
  else {  
      return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'UNKNOWN';  
  }  
}  

// Cart Function
function cart() {
  if (isset($_GET['add_to_cart'])) {
      global $con;
    
      $get_ip_address = getIPAddress(); // Get the IP address
      $get_product_id = $_GET['add_to_cart'];

      // Prepared statement to check if the item is already in the cart
      $select_query = "SELECT * FROM cart_details WHERE ip_address = ? AND product_id = ?";
      $stmt = mysqli_prepare($con, $select_query);
      mysqli_stmt_bind_param($stmt, 'si', $get_ip_address, $get_product_id);
      mysqli_stmt_execute($stmt);
      $result_query = mysqli_stmt_get_result($stmt);
      $num_of_rows = mysqli_num_rows($result_query);
      
      if ($num_of_rows > 0) {
          echo "<script>alert('This item is already inside the cart')</script>";
          echo "<script>window.open('index.php','_self')</script>";
      } else {
          // Initialize quantity to 1 when adding a new item
          $insert_query = "INSERT INTO cart_details (product_id, ip_address, quantity) VALUES (?, ?, 1)";
          $insert_stmt = mysqli_prepare($con, $insert_query);
          mysqli_stmt_bind_param($insert_stmt, 'is', $get_product_id, $get_ip_address);
          $insert_result = mysqli_stmt_execute($insert_stmt);
          
          if ($insert_result) {
              echo "<script>alert('Item is added to cart')</script>";
              echo "<script>window.open('index.php','_self')</script>";
          } else {
              echo "<script>alert('Failed to add item to cart')</script>";
          }
      }

      // Close prepared statements
      mysqli_stmt_close($stmt);
      mysqli_stmt_close($insert_stmt);
  }
}

//function to get cart item numbers
function cart_item(){
  if(isset($_GET['add_to_cart'])){
    global $con;
  $get_ip_address = getIPAddress();
  $select_query="SELECT * FROM cart_details WHERE ip_address='$get_ip_address'";
  $result_query=mysqli_query($con,$select_query);
  $count_cart_items=mysqli_num_rows( $result_query);
  }else{
    global $con;
    $get_ip_address = getIPAddress();
    $select_query="SELECT * FROM cart_details WHERE ip_address='$get_ip_address'";
    $result_query=mysqli_query($con,$select_query);
    $count_cart_items=mysqli_num_rows( $result_query);
  }
echo  $count_cart_items;
}
//total price function
function total_cart_price(){
  global $con;
  $get_ip_address = getIPAddress();
  $total_price = 0;
  $cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_address'";
  $result = mysqli_query($con, $cart_query);
  
  while ($row = mysqli_fetch_array($result)) {
    $product_id = $row['product_id'];
    $select_products = "SELECT product_price FROM products WHERE product_id='$product_id'";
    $result_products = mysqli_query($con, $select_products);
    while ($row_product_price = mysqli_fetch_array($result_products)) {
      if (isset($row_product_price['product_price'])) {
        $product_price = $row_product_price['product_price']; // No need for str_replace
            $total_price += intval($product_price); // Add price as integer
      } else {
        echo "product_price is not set!";
      }
    }
  }
  
  echo $total_price;

}
//get user order details
function get_user_order_details(){
  global $con;
    $username = $_SESSION['username'];
  $get_details="SELECT * FROM user_table WHERE username='$username'";
  $result_query=mysqli_query($con,$get_details);
  while($row_query=mysqli_fetch_array($result_query)){
    $user_id=$row_query['user_id'];
    if(!isset($_GET['edit_account'])){
      if(!isset($_GET['my_orders'])){
      if(!isset($_GET['delete_account'])){
        $get_orders="SELECT * FROM user_orders WHERE user_id='$user_id' AND order_status='pending'";
        $result_orders_query=mysqli_query($con,$get_orders);
        $row_count=mysqli_num_rows( $result_orders_query);
        if($row_count>0 ){
echo "<h3 class='text-center text-primary my-5'>You have <span class='text-danger'> $row_count</span> pending orders</h3>
<p class='text-center'><a href='profile.php?my_oders' class='text-dark'>Order Details</a></p>";
        }else{
          echo "<h3 class='text-center text-primary my-5'>you have zero pending orders</h3>
          <p class='text-center'><a href='includes\users_area\index.php' class='text-dark'>Explore products</a></p>";
        }
      }
      }
    }
  }
}

?>




