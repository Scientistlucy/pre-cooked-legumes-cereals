

<!--connect file-->
<?php
include('C:\xampp\htdocs\Ecommerce Website\includes\connect.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="./assets/css/main.css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js " integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n " crossorigin="anonymous "></script>
    <title>Document</title>
    <style>
    :root {
        --gold-crayola: #f1b755;
        --smoky-black-1: #171615;
        --smoky-black-2: #1c1a19;
        --white: #ffffff;
        --transition-1: 250ms ease;
        --transition-2: 500ms ease;
    }

    .bgd-danger {
        background: linear-gradient(30deg, var(--smoky-black-1), var(--gold-crayola));
    }

    .btn-n, .btn-y {
        color: white;
        background: var(--smoky-black-2);
        transition: var(--transition-1);
        transform: skew(0deg);
    }

    .btn-n:hover {
        background: #f1b755;
        color: var(--smoky-black-1);
        box-shadow: 0 0 10px rgba(241, 183, 85, 0.5);
        transition: var(--transition-2);
        transform: scale(1.08) translateY(-3px);
    }

    .btn-y:hover {
        background: #f1b755;
        color: var(--smoky-black-1);
        box-shadow: 0 0 10px rgba(241, 183, 85, 0.5);
        transition: var(--transition-2);
        transform: scale(1.08) translateY(-3px);
    }

    .card-bg {
        transition: var(--transition-2);
    }

    .card-bg:hover {
        transform: skew(-10deg) scale(1.05);
        transition: var(--transition-2);
    }

    .icons {
        transition: var(--transition-1);
        cursor: pointer;
    }

    .icons:hover {
        color: #f1b755;
        transform: scale(1.05) translateY(-5px);
        transition: var(--transition-1);
    }

    .iconck {
        color: var(--gold-crayola);
        transform: scale(1.05) translateY(-5px);
    }

    .icon {
        transition: var(--transition-2);
    }

    .icon:hover {
        transform: scale(1.2);
        transition: var(--transition-2);
    }

    .text-trans {
        transition: var(--transition-1);
    }

    .text-trans:hover {
        transform: skew(-15deg);
        transition: var(--transition-1);
    }

    .btns {
        background: var(--gold-crayola);
        color: var(--smoky-black-1);
        font-weight: bold;
        font-size: 18px;
        transition: var(--transition-2);
    }

    .btns:hover {
        text-decoration: none;
        color: var(--smoky-black-1);
        box-shadow: 5px 5px 7px rgba(241, 183, 85, 0.5);
        transform: scale(1.05) translateY(-8px) skew(-10deg);
        transition: var(--transition-2);
    }

    .bg-alert {
        box-shadow: 0 0 3px rgba(241, 183, 85, 0.5);
    }

    .bg-alert-bg {
        box-shadow: 0 0 10px rgba(241, 183, 85, 0.5);
        transform: scale(1.05);
    }

    .w-35 {
        width: 36% !important;
    }

    .mrg-ct {
        margin-top: 5px;
        margin-bottom: 5px;
    }

    .int-chagne {
        transition: var(--transition-2);
    }

    .int-chagne:hover {
        transform: skew(-15deg);
        transition: var(--transition-2);
    }

    .turn {
        display: block;
        transform: none;
        transition: var(--transition-1);
    }

    .turnb {
        display: block;
        transform: rotate(-180deg);
        transition: var(--transition-1);
    }

    .clps {
        color: var(--gold-crayola);
        text-decoration: none !important;
    }

    .clps:hover {
        color: var(--gold-crayola);
    }

    .clps-btn-style {
        transition: var(--transition-1);
    }

    .clps-btn-style:hover {
        color: var(--gold-crayola);
        transform: skew(-15deg);
        transition: var(--transition-1);
    }

    p {
        margin-bottom: .5px !important;
    }
</style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <i class="fad fa-star-of-david mr-2" style="color: rgb(255, 255, 50);"></i>Strange Shop
        </a>
    </nav>
    <div class="container">
        <h1 class="text-center my-5">Checkout</h1>
        <div class="tab-content">
            <div class="tab-pane active" id="step1">
                <div class="row text-center">
                    <div class="col-sm col-12">
                        <div class="alert alert-primary bg-alert-bg" role="alert">
                            1 . Please enter your order information
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="alert alert-secondary" role="alert">
                            2 . Cash Payment
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="alert alert-secondary" role="alert">
                            3 . Complete
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="accordion" id="accordionExample">
                                        <div class="card border-0">
                                            <div class="card-header d-flex justify-content-between" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button id="turnbf" class="btn btn-link d-flex turnaf clps" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                       
                                                        
                                                    </button>
                                                </h2>
                                                <span class="my-2 text-danger h4">US $ 3600</span>
                                            </div>
                                           
                                            <div class="alert alert-secondary border-0 h4 text-center bg-alert rounded-0" role="alert">
                                                Orderer information
                                            </div>
                                            <form class="needs-validation" novalidate>
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control space" id="name" placeholder="please enter your name  . . ." required>
                                                        <div class="valid-feedback">
                                                            Correct format!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter your name . . .
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="email">Email</label>
                                                        <input type="text" class="form-control space" id="email" placeholder="please enter your email . . ." required>
                                                        <div class="valid-feedback">
                                                            Correct format!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter your email . . .
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="email">Telephone / Local phone</label>
                                                        <input type="tel" class="form-control space" id="email" placeholder="please enter your email . . ." required>
                                                        <div class="valid-feedback">
                                                            Correct format!
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter your email . . .
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="col-md-4 mb-3">
                                                        <label for="country">Country</label>
                                                        <select class="form-control" id="country . . ." required>
                                                                    <option>Mars</option>
                                                                    <option>Taiwan</option>
                                                                    <option>Japan</option>
                                                                    <option>Korea</option>
                                                                    <option>America</option>
                                                                    <option>Australia</option>
                                                                    <option>French</option>
                                                                    <option>Germany</option>
                                                                    <option>Italy</option>
                                                                </select>
                                                        <div class="valid-feedback">
                                                            Correct format !
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter your country . . .
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="city">City</label>
                                                        <input type="text" class="form-control space" id="city" placeholder="please enter your city . . ." required>
                                                        <div class="valid-feedback">
                                                            Correct format !
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter your city . . .
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label for="postal">Postal code</label>
                                                        <select class="form-control" id="country . . ." required>
                                                                    <option>990</option>
                                                                    <option>991</option>
                                                                    <option>992</option>
                                                                    <option>993</option>
                                                                    <option>994</option>
                                                                    <option>995</option>
                                                                    <option>996</option>
                                                                    <option>997</option>
                                                                    <option>998</option>
                                                                    <option>999</option>
                                                                </select>
                                                        <div class="valid-feedback">
                                                            Correct format !
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter your postal code . . .
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="address">Address</label>
                                                        <input type="text" class="form-control space" id="address" placeholder="please enter your town address . . ." required>
                                                        <div class="valid-feedback">
                                                            Correct format !
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Please enter your address . . .
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    <button class="btn btn-primary" type="submit">Submit orderer information</button>
                                                </div>
                                            </form>
                                            <div class="list-group mt-5 p-0 justify-content-center" id="allList" role="tablist" style="flex-direction: row;">
                                                <a href="#step2" class="list-group-item-dark w-35 py-2  rounded text-center btns" data-toggle="list" role="tab">
                                                    Next <i class="fal fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="step2">
                <div class="row text-center">
                    <div class="col-sm col-12">
                        <div class="alert alert-secondary" role="alert">
                            1 . Please enter your order information
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="alert alert-primary bg-alert-bg" id="appear-1" role="alert">
                            2 . Cash Payment
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="alert alert-secondary" role="alert">
                            3 . Complete
                        </div>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card my-5 text-center border-0">
                                            <div class="card-header bg-transparent" id="card">
                                                <ul class="nav nav-tabs card-header-tabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" href="#act1" data-toggle="tab" role="tab">
                                                            <p class="card-bg h6">Creadit card</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#act2" data-toggle="tab" role="tab">
                                                            <p class="card-bg h6">Phone pay</p>
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#act3" data-toggle="tab" role="tab">
                                                            <p class="card-bg h6">ATM</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="act1">
                                                    <div class="card-body border border-top-0 rounded-bottom">
                                                        <div class="d-sm-flex justify-content-around">
                                                            <i class="fab fa-cc-visa fa-7x icons"></i>
                                                            <i class="fab fa-cc-mastercard fa-7x icons"></i>
                                                            <i class="fab fa-cc-paypal fa-7x icons"></i>
                                                            <i class="fab fa-cc-jcb fa-7x icons"></i>
                                                        </div>
                                                        <h5 class="card-title mt-2">Choose your card type</h5>
                                                        <p class="card-text text-danger">If you can't use please contact bank blong to your creadit card thank you</p>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="act2">
                                                    <div class="card-body border border-top-0 rounded-bottom">
                                                        <form action="" class="d-sm-flex justify-content-around">
                                                            <label class="btn btn-dark d-block d-flex justify-content-center">
                                                            <input type="radio" name="options" id="option3" class="mrg-ct mr-2">
                                                            <p class="int-chagne">Taiwan Mobile</p>
                                                            </label>
                                                            <label class="btn btn-dark d-block d-flex justify-content-center">
                                                            <input type="radio" name="options" id="option3" class="mrg-ct mr-2">
                                                            <p class="int-chagne">Chunghwa Tele</p>
                                                            </label>
                                                            <label class="btn btn-dark d-block d-flex justify-content-center">
                                                            <input type="radio" name="options" id="option3" class="mrg-ct mr-2">
                                                            <p class="int-chagne">Asia Pacific Tele</p>
                                                            </label>
                                                            <label class="btn btn-dark d-block d-flex justify-content-center">
                                                            <input type="radio" name="options" id="option3" class="mrg-ct mr-2">
                                                            <p class="int-chagne">Local Calls</p>
                                                            </label>
                                                        </form>
                                                        <h5 class="card-title mt-3">Choose you phone tele</h5>
                                                        <p class="card-text text-danger">If you can't use please contact belong to your telecompany thank you</p>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="act3">
                                                    <div class="card-body border border-top-0 rounded-bottom">
                                                        <h5 class="card-title">Please transfer cash to the below account</h5>
                                                        <span class="d-block my-2">Seller's bank account number</span>
                                                        <span class="d-block text-danger font-weight-bold my-2">123-XXXXXXXXXXXXXXXX</span>
                                                        <p class="card-text">We will tell to seller your transfer account message<br>Then please him shipping for you</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group my-5 p-0 justify-content-center" id="allList" role="tablist" style="flex-direction: row;">
                                    <a href="#step1" class="list-group-item-dark mr-3 w-35 px-0 py-2 rounded text-center btns" data-toggle="list" role="tab">
                                        <i class="fal fa-arrow-circle-left"></i> Previous
                                    </a>
                                    <a href="#step3" class="list-group-item-dark ml-3 w-35 px-0 py-2  rounded text-center btns" data-toggle="list" role="tab">
                                        Next <i class="fal fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="step3">
                <div class="row text-center">
                    <div class="col-sm col-12">
                        <div class="alert alert-secondary" role="alert">
                            1 . Please enter your order information
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="alert alert-secondary" role="alert">
                            2 . Cash Payment
                        </div>
                    </div>
                    <div class="col-sm col-12">
                        <div class="alert alert-success bg-alert-bg" role="alert">
                            3 . Complete
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 class="text-center my-3">Bought information</h2>
                                    <div>
                                        <table class="table table-sm">
                                            <thead>
                                                <tr class="ml-3">
                                                    <th></th>
                                                    <th class="text-left" width="50%">Product</th>
                                                    <th class="text-center" width="45%">Pieces</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="rounded" style="background-image: url(https://unsplash.com/photos/ZBwQ2bCbJjw/download?force=true&w=640); width: 60px; height: 60px; background-size: cover;"></div>
                                                    </td>
                                                    <td class="align-middle text-left">Spy Suit</td>
                                                    <td class="align-middle text-center">1 pieces</td>
                                                    <td class="align-middle text-right">$698</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="rounded" style="background-image: url(https://unsplash.com/photos/vOwj38HFrJ0/download?force=true&w=640); width: 60px; height: 60px; background-size: cover;"></div>
                                                    </td>
                                                    <td class="align-middle text-left">Hyper Hero Suit</td>
                                                    <td class="align-middle text-center">2 pieces</td>
                                                    <td class="align-middle text-right">$1998</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="rounded" style="background-image: url(https://unsplash.com/photos/FxraOMAkLOs/download?force=true&w=640); width: 60px; height: 60px; background-size: cover;background-position: center center;"></div>
                                                    </td>
                                                    <td class="align-middle text-left">Stash Boots</td>
                                                    <td class="align-middle text-center">1 pieces</td>
                                                    <td class="align-middle text-right">$849</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="align-middle text-right">Freight</td>
                                                    <td class="align-middle text-right">55</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="align-middle text-right">Total</td>
                                                    <td class="align-middle text-right">3600</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h2 class="text-center my-3">Profile</h2>
                                    <div class="">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <td width="35%" class="align-middle text-left">Name</td>
                                                    <td class="text-left">Alick</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-left">Telephone</td>
                                                    <td class="align-middle text-left">0966-666666</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-left">Email</td>
                                                    <td class="align-middle text-left">A12345@gmail.com</td>
                                                </tr>
                                                <tr>
                                                    <td class="align-middle text-left">Address</td>
                                                    <td class="align-middle text-left">xxBlock xxRoad 123</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group mt-5 p-0 mb-3 justify-content-center" id="allList" role="tablist" style="flex-direction: row;">
                                <a href="#step1" class="list-group-item-dark ml-3 w-35 py-2  rounded text-center btns home" data-toggle="list" role="tab">
                                    <i class="fas fa-home"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
include('D:\Restaurantly\Restaurantly\includes\footer.php');

?>
    <!-- delete modal start-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bgd-danger border-bottom-0">
                    <h5 class="modal-title text-white" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body bg-dark text-white">
                    This is a demo so don't have any items .
                </div>
                <div class="modal-footer bg-dark btn-change">
                    <button type="button" class="btn btn-n" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-y" data-dismiss="modal">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete modal end-->
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        var btns = document.querySelector('.home')
        btns.addEventListener('click', function() {
            alert('Thank for your order !');
        }, false);
        $(document).ready(function() {
            $('#delete').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var item = button.data('title')
                var modal = $(this)
                modal.find('.modal-title').text(item)
            })
            $(function() {
                $('#allList').tab('show')
            })
            $(function() {
                $('#card').tab('show')
            })
            $('.icons').click(function() {
                $(this).toggleClass('iconck').siblings().removeClass('iconck')
            })
            $('#turnbf').click(function() {
                $('#turnbf span').addClass('turn')
            })
            $('.turnaf').click(function() {
                $('.turnaf span').toggleClass('turnb')
            })
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js " integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo " crossorigin="anonymous "></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js " integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6 " crossorigin="anonymous "></script>
</body>

</html>