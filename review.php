
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('D:\Restaurantly\Restaurantly\includes\connect.php');

session_start();

// Get the product ID from the URL
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : 0;

// Fetch the product details
$product_query = "SELECT * FROM products WHERE product_id = $product_id";
$product_result = mysqli_query($con, $product_query);
$product = mysqli_fetch_assoc($product_result);

// Fetch the existing reviews for the product
$review_query = "SELECT * FROM product_reviews WHERE product_id = $product_id ORDER BY created_at DESC";
$review_result = mysqli_query($con, $review_query);
$reviews = mysqli_fetch_all($review_result, MYSQLI_ASSOC);

// Handle the form submission for creating or updating a review
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
    $review_text = isset($_POST['review_text']) ? mysqli_real_escape_string($con, $_POST['review_text']) : '';

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = (int)$_SESSION['user_id'];

        // Fetch the logged-in user's username
        $user_query = "SELECT username FROM user_table WHERE user_id = $user_id";
        $user_result = mysqli_query($con, $user_query);
        $user = mysqli_fetch_assoc($user_result);
        $reviewer_name = $user['username'] ?? 'Anonymous'; // Fallback to "Anonymous" if username is not found

         // Insert the review with user information
         $insert_review_query = "INSERT INTO product_reviews (product_id, user_id, rating, review_text, reviewer_name) 
         VALUES ($product_id, $user_id, $rating, '$review_text', '$reviewer_name')";
         mysqli_query($con, $insert_review_query);

} else {
// For non-logged-in users, reject review submission (or handle anonymously if required)
die("You must be logged in to leave a review.");
}

// Execute the query and handle errors
if (!mysqli_query($con, $insert_review_query)) {
$error = "Error submitting the review.";
} else {
header("Location: review.php?product_id=$product_id");
exit;
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

    

  </div>

</div>

</header>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Review - <?php echo htmlspecialchars($product['product_title'] ?? ''); ?></title>
    
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Custom Review Page Styles -->
    <style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .review-page-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
        }

        .review-content {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            color: #ff4500;
        }

        .product-preview {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
        }

        .product-preview .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 20px;
        }

        .product-details h3 {
            margin: 0 0 10px 0;
            color: #333;
        }

        .review-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .rating-section {
            margin-bottom: 20px;
            color: #ff4500;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            gap: 10px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            color: #ddd;
            font-size: 24px;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ff4500;
        }

        .review-text-section textarea {
            width: 100%;
            min-height: 150px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            resize: vertical;
            font-size: 16px;
            outline:none;
        }
        .review-text-section textarea:focus {
            outline: none;
            border-color: #ff4500;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
          
        }

        .submit-review,
        .cancel-button {
            padding: 12px 24px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            text-align: center;
            font-size: 16px;
        }

        .submit-review {
            background-color: #ff4500;
            color: white;
        }
        .submit-review:hover {
            background-color: #e63900;
        }

        .cancel-button {
            background-color: #eee;
            color: #333;
        }
        .cancel-button:hover {
            background-color: #ddd;
            color: #111;
        }
        .error-message {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .review-list {
            margin-top: 40px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .review-list h3 {
            color: #ff4500;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        .review-item {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            color: #333;
            margin-bottom: 20px;
            
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-rating {
            color: #ff4500;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .review-text {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 8px;
            
        }

        .review-date {
            font-size: 14px;
            color: #888;
            text-align: right;
        }
    </style>
</head>
<body>
    <main id="main">
        <section class="review-section">
            <div class="review-page-container">
                <div class="review-content">
                    <h2 class="text-2xl font-bold mb-4">Write a Review for <?php echo htmlspecialchars($product['product_title'] ?? ''); ?></h2>

                    <?php if (isset($error)): ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <div class="product-preview">
                        <img src="./assets/img/product/<?php echo htmlspecialchars($product['product_image1'] ?? ''); ?>" 
                             alt="<?php echo htmlspecialchars($product['product_title'] ?? ''); ?>" 
                             class="product-image">
                        <div class="product-details">
                            <h3 class="text-xl font-medium"><?php echo htmlspecialchars($product['product_title'] ?? ''); ?></h3>
                            <p class="text-lg font-medium">Ksh <?php echo htmlspecialchars($product['product_price'] ?? ''); ?></p>
                        </div>
                    </div>

                    <form action="" method="POST" class="review-form">
                        <div class="rating-section">
                            <p class="mb-2">Select your rating:</p>
                            <div class="star-rating">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <input type="radio" id="star<?php echo $i; ?>" 
                                           name="rating" value="<?php echo $i; ?>"
                                           <?php if(isset($existing_review) && $existing_review['rating'] == $i) echo 'checked'; ?>>
                                    <label for="star<?php echo $i; ?>">
                                        <i class="fas fa-star"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="review-text-section">
                            <label for="review_text" class="block mb-2 font-medium">Your Review:</label>
                            <textarea name="review_text" id="review_text" required class="shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"><?php 
                                if(isset($existing_review)) echo htmlspecialchars($existing_review['review_text']); 
                            ?></textarea>
                        </div>

                        <div class="form-buttons">
                            <button type="submit" class="submit-review">
                                <?php echo isset($existing_review) ? 'Update Review' : 'Submit Review'; ?>
                            </button>
                            <a href="product_details.php?product_id=<?php echo htmlspecialchars($product_id); ?>" 
                               class="cancel-button">Cancel</a>
                        </div>
                    </form>
                </div>

                <div class="review-list">
                    <h3 class="mb-4">All Reviews</h3>
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div class="review-item">
                                <div class="review-rating">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?php echo ($i <= $review['rating']) ? '' : '-o'; ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <p class="review-text"><?php echo htmlspecialchars($review['review_text']); ?></p>
                                <p class="review-date">By <strong><?php echo htmlspecialchars($review['reviewer_name']); ?></strong> on <?php echo date("F j, Y", strtotime($review['created_at'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">No reviews yet. Be the first to review this product!</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <script>
        // AJAX form submission
        document.getElementById('review-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent normal form submission

            const formData = new FormData(this);
            formData.append('ajax', '1'); // Append flag for AJAX handling in PHP

            fetch('review.php?product_id=<?php echo $product_id; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data) {
                    // Create new review element and append it to the review list
                    const reviewList = document.getElementById('review-list');
                    const reviewItem = document.createElement('div');
                    reviewItem.classList.add('review-item');
                    reviewItem.innerHTML = `
                        <div class="review-rating">
                            ${'★'.repeat(data.rating)}${'☆'.repeat(5 - data.rating)}
                        </div>
                        <p class="review-text">${data.review_text}</p>
                        <p class="review-date">${data.created_at}</p>
                    `;
                    reviewList.insertBefore(reviewItem, reviewList.children[1]); // Insert new review at the top
                }
            })
            .catch(error => console.error('Error submitting review:', error));
        });
    </script>
</body>
</html>