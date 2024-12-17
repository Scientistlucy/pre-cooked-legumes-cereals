<?php

include('D:\Restaurantly\Restaurantly\includes\connect.php');
include('D:\Restaurantly\Restaurantly\Admin\functions\common_function.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
     <!--boostrap css link -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <!--font awesome link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!--css file-->
<link rel="stylesheet" href="../style.css">
<style>
    :root {
        --primary-color: #ff6600; /* Orange color */
        --primary-hover: #ff8533; /* Hover effect */
    }

    .admin-image {
        width: 50%;
        object-fit: contain;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .footer {
        position: absolute;
        bottom: 0;
    }

    /* Navbar with the new orange color */
    .navbar {
        background-color: var(--primary-color);
    }

    /* Buttons with orange color */
    .btn-custom {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 8px 15px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s;
        border-radius: 4px;
    }

    .btn-custom:hover {
        background-color: var(--primary-hover);
        color: white;
    }

    /* Active nav links with the orange color */
    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
    }

    .nav-pills .nav-link {
        color: var(--primary-color);
    }

    /* Background color for table headings */
    th {
        background-color: #f8f9fa;
    }

    /* Buttons in the admin dashboard with the new color */
    .button button a {
        background-color: var(--primary-color);
        color: white;
        padding: 8px 15px;
        border-radius: 4px;
        text-decoration: none;
    }

    .button button a:hover {
        background-color: var(--primary-hover);
    }
</style>

</head>
<body>
<!--navbar-->
<div class="container-fluid p-0">
    <!--firstchild-->
    <nav class="navbar navbar-expand-ig navbar-light">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-ig">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="" class="nav-link">Welcome Admin</a>
                    </li>
                </ul>
            </nav> 
        </div>
    </nav>

     <!--second child-->
     <div class="bg-light">
        <h3 class="text-center p-2">Manage Details</h3>
    </div>
    <!--third child-->
    <div class="row">
        <div class="col-md-12 bg-dark p-2 d-flex align-items-center">
            <div class="p-3">
                <a href="#">
                    <img src="..\images\shoes a (14).jpg" alt="" class="admin-image p-2">
                </a>
            </div>
            <!--button-->
            <div class="button text-center">
    <button class="my-3">
        <a href="insert_product.php" class="nav-link text-light" style="background-color: var(--primary-color); padding: 8px 15px; border-radius: 4px; text-decoration: none;">Insert Products</a>
    </button>
    <button class="my-3">
        <a href="view_product.php" class="nav-link text-light" style="background-color: var(--primary-color); padding: 8px 15px; border-radius: 4px; text-decoration: none;">View Products</a>
    </button>
   
    <button>
        <a href="index.php?list_orders" class="nav-link text-light" style="background-color: var(--primary-color); padding: 8px 15px; border-radius: 4px; text-decoration: none;">All Orders</a>
    </button>

    <button>
        <a href="index.php?list_payment" class="nav-link text-light" style="background-color: var(--primary-color); padding: 8px 15px; border-radius: 4px; text-decoration: none;">All Payments</a>
    </button>
    <button>
        <a href="index.php?list_user" class="nav-link text-light" style="background-color: var(--primary-color); padding: 8px 15px; border-radius: 4px; text-decoration: none;">All Users</a>
    </button>
    <button>
        <a href="index.php?list_messages" class="nav-link text-light" style="background-color: var(--primary-color); padding: 8px 15px; border-radius: 4px; text-decoration: none;">Messages</a>
    </button>

     <button>
        <a href="order_report.php" class="nav-link text-light" style="background-color: var(--primary-color); padding: 8px 15px; border-radius: 4px; text-decoration: none;">All Orders Report</a>
    </button>
</div>

        </div>
    </div>

    <!--fourth child-->
    <div class="container my-3">
        <?php
        if (isset($_GET['list_orders'])) {
            include('list_order.php');
        }
        if (isset($_GET['list_payment'])) {
            include('list_payment.php');
        }

        if (isset($_GET['list_user'])) {
            include('list_user.php');
        }
        if (isset($_GET['list_messages'])) {
            include('list_messages.php');
        }
       
       
           
        
        ?>
    </div>

    <!--last child-->
    

</div>

<!--boostrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
