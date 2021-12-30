<?php
    // Using session to store results per page throughout the session 
    session_start();
    include("connection.php");
    
    // Checks If user inputs custom results per page 
    if(isset($_GET["res"])){
        $results_per_page = $_GET["res"];
        $_SESSION["res"] = $results_per_page;
    }
    else if(isset($_SESSION["res"])){
        $results_per_page = $_SESSION["res"];   
    }
    else{
        session_destroy();
        $results_per_page = 2;
    }

    if(!isset($_GET["page"])){
        $page = 1; 
    }
    else{
        $page = $_GET["page"];
    }
    $current = $page;
    $offset = ($page - 1) * $results_per_page;
    
    // Check if User searched for something in records 
    if(isset($_GET["fetched"])){
        $key = filter_var($_GET["fetched"], FILTER_SANITIZE_STRING);
        $key = mysqli_real_escape_string($conn, $key);
        $pattern = "%" . $key ."%";                     // searching pattern
        $filtered = "SELECT * FROM customers WHERE address like '$pattern' or ISD like '$pattern' or name like '$pattern' or email like '$pattern' or Mobile like '$pattern' or cust_ID like '$pattern'";
        $result = mysqli_query($conn, $filtered);
        $number_of_results=mysqli_num_rows($result);
        $number_of_pages = ceil($number_of_results/$results_per_page);
        $sql = "SELECT * FROM customers WHERE address like '$pattern' or ISD like '$pattern' or name like '$pattern' or email like '$pattern' or Mobile like '$pattern' or cust_ID like '$pattern' LIMIT  $offset , $results_per_page ";
        $result2 = mysqli_query($conn, $sql);
    }
    else{
        $sql1 = "SELECT * FROM customers";
        $result = mysqli_query($conn, $sql1);
        $number_of_results=mysqli_num_rows($result);
        $number_of_pages = ceil($number_of_results/$results_per_page);
        $sql = "SELECT * FROM customers LIMIT " . $offset . ',' . $results_per_page;
        $result2 = mysqli_query($conn, $sql);
    }    

?>
<html>
    <head>
        <title>
            Demo
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <style>
            label{
                font-weight:bold;
            }
            .fetched{
                font-weight:bold;
                text-align:center;
            }
        </style>
    </head>
    <body>
            <nav class="navbar navbar-dark bg-dark">
                <h3 class="navbar-brand">Customers</h3>
                <button class="btn btn-light" data-target="#add_cust" data-toggle="modal" type="button">Add Customer</button>
            </nav>

            <div class="modal" id="add_cust" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">

                                <h4 id="myModalLabel">Add new customer</h4>
                                <button class="close" data-dismiss="modal">&times;</button>
                        
                        </div>
                        <div class="modal-body">
                            <form method="POST" id="adding_new_cust">
                                <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputName">Customer name</label>
                                    <input type="text" class="form-control" name="inputName" placeholder="Name" required>
                                  </div>
                                  <div class="form-group col-md-6">
                                    <label for="inputEmail">Email</label>
                                    <input type="email" class="form-control" name="inputEmail" placeholder="Email" required>
                                    
                                    <input  type="checkbox" name="email_notifications">
                                    <label class="form-check-label" for="email_notifications">
                                      Enable Email Notifications
                                    </label>
                                  </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputAddress">Customer Address</label>
                                        <textarea class="form-control" name="inputAddress" placeholder="1234 Main St" required></textarea>
                                    </div>
                                        <div class="form-group col-sm-3">
                                            <label for="inputISD">ISD</label>

                                            <select class="form-control" name="inputISD" name="isd">
                                                
                                                <option value="91">India (+91)</option>
                                                <option value="62">Indonesia (+62)</option>
                                                <option value="81">Japan (+81)</option>
                                                <option value="64">New Zealand (+64)</option>
                                                <option value="47">Norway (+47)</option>
                                                <option value="44">United Kingdom (+44)</option>
                                            </select required><br>

                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="inputMobile">Mobile</label>
                                            <input type="number" class="form-control" name="inputMobile" placeholder="Mobile" required>
                                            <input  type="checkbox" name="sms_notifications">
                                            <label class="form-check-label" for="sms_notifications">
                                            Enable SMS
                                            </label>
                                        </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputNotes">Customer Notes</label>
                                        <textarea class="form-control" name="inputNotes" placeholder="Enter Notes if any"></textarea>
                                    </div>
                                </div>
                        </div>    
                              
                        <div class="modal-footer">  
                            <div class="form-group col-md-2">
                                <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>
                            <div class="form-group col-md-2 ml-auto">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>   
                        </div>
                        <div class="fetched">

                        </div> 
                    </div>
                </div>
            </div>

            <br>
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                        <form id="results" method="GET" action="index.php"> 
                            <span for="res">Show : </span>
                            <input name="res" type="number" min=1 max=50>
                            <input type="submit" style="display:none;">
                            <span>entries</span>
                        </form>
                    <div class="form-inline">
                        <form id="fetch" method="GET" action="index.php"> 
                            <span for="fetched">Search : </span>
                            <input name="fetched" type="text">
                            <input type="submit" style="display:none;">
                        </form>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table id="fetched_results" class="table table-striped table-hover table-bordered">
                        <tr><th>ID</th><th>Customer Name</th><th>Address</th><th>Email</th><th>Mobile</th></tr>
                        
                        <?php 
                            if(!$result2){
                                echo "ERROR : Currently No Data Found!";
                                exit;
                            }
                            $items = mysqli_fetch_all($result2, MYSQLI_ASSOC);
                            foreach($items as $item) {?>
                            <tr>
                                <td><?php echo $item["Cust_ID"];?></td>
                                <td><?php echo $item["Name"];?></td>
                                <td><?php echo $item["Address"];?></td>
                                <td><?php echo $item["Email"];?></td>
                                <td><?php echo "+" . $item["ISD"] . "-" . $item["Mobile"];?></td>
                            </tr>
                    <?php
                        } 
                    ?>
                    
                    </table>
                </div>
                
                <div class="d-flex justify-content-between">
                    <span>Showing <?php echo ($offset+1) . " to " . ($offset + $results_per_page) . " of " . ($number_of_results); ?> entries</span>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                        <li class="page-item disabled" id="prev"><a class="page-link">Previous</a></li>
                        <?php 
                        for($page=1 ; $page <= $number_of_pages ; $page++){
                            
                            // Checks if $key is set which denotes search pattern request
                            if(isset($key)){
                                echo '<li class="page-item" id="page'.$page.'"><a class="page-link" href="index.php?fetched=' . $key . '&page=' . $page . '">' . $page .'</a></li>';
                            }
                            else{
                                echo '<li class="page-item" id="page'.$page.'"><a class="page-link" href="index.php?page=' . $page . '">' . $page .'</a></li>';
                            }
                        }
                        ?>

                        <li class="page-item disabled" id="next"><a class="page-link">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
            <script src="./index.js"></script>
        
    </body>
</html>