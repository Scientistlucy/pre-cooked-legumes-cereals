<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('D:\Restaurantly\Restaurantly\includes\connect.php');
if(isset($_POST['insert-product'])){
  $product_title = $_POST['product_title'];
  $product_keywords=$_POST['product_keywords'];
$product_price=$_POST['product_price'];
$product_status='true';
//accessing images
$product_image1=$_FILES['product_image1']['name'];
//accessing image tmp name
$temp_image1=$_FILES['product_image1']['tmp_name'];
//checking emepty condition
if($product_title==''  or $product_keywords=='' or
$product_price=='' or $product_image1==''  ){
echo "<script>alert('Please fill all the available fields')</script>";
exit();
}else{
    move_uploaded_file($temp_image1, ".\product_images\$product_image1");
   
  //insert query
  $insert_products = "INSERT INTO products (product_title, product_keyword, product_image1, product_price, date, status) VALUES ('$product_title', '$product_keywords', '$product_image1', '$product_price', NOW(), '$product_status')";
  $result_query = mysqli_query($con, $insert_products);
  if($result_query){
    echo"<script>alert('Successefully inserted the products')</script>";
  }
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products.Admin Dashboard</title>
       <!--boostrap css link -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <!--font awesome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <!--css file-->
     
</head>
<body class="bg-light">
    <div class="container mt-3">
      <h1 class="text-center">
        Insert Products
      </h1>
      <!--form-->
       <form action="" method="post" enctype="multipart/form-data">
        <!--title-->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_title"class="form-label">product title</label>
            <input type="text" name="product_title" id="product_title" class="form-control"placeholder="Enter product title" autocomplete="off" required="required">
        </div>
       
          <!--keywords-->
          <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_keywords"class="form-label">product keywords</label>
            <input type="text" name="product_keywords" id="product keywords" class="form-control"placeholder="Enter product keywords" autocomplete="off" required="required">
        </div>
       
       
         <!--image 1-->
         <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_image 1"class="form-label">product image1</label>
            <input type="file" name="product_image1" id="product_image1" class="form-control"required="required">
        </div>
           
           <!--price-->
           <div class="form-outline mb-4 w-50 m-auto">
            <label for="product_price"class="form-label">product price</label>
            <input type="text" name="product_price" id="product_price" class="form-control"placeholder="Enter product price" autocomplete="off" required="required">
        </div>
        <!--submit button-->
         <div class="form-outline mb-4 w-50 m-auto">
           <input type="submit" name="insert-product" class="btn btn-primary  mb-3 px-3" value="insert products">
        </div>
       </form>
    </div>
   
</body>
</html>