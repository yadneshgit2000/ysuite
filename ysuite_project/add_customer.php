<?php
include("connection.php");

$Name = filter_var($_POST["inputName"], FILTER_SANITIZE_STRING);
$Address = filter_var($_POST["inputAddress"], FILTER_SANITIZE_STRING);
$Notes = filter_var($_POST["inputNotes"], FILTER_SANITIZE_STRING);
$ISD = filter_var($_POST["inputISD"], FILTER_SANITIZE_NUMBER_INT);
$Mobile = filter_var($_POST["inputMobile"], FILTER_SANITIZE_NUMBER_INT);
$Email = filter_var($_POST["inputEmail"], FILTER_SANITIZE_EMAIL);

$errors = "";
$Contact_Error = "<p>Please Enter Valid Contact of 10 digits</p>";

if(strlen((string)$Mobile) != 10){
    $errors .= $Contact_Error;
    echo "<div class='alert alert-danger alert-dismissible fade show'>$errors</div>";
    exit;
}
else{
    $Name = mysqli_real_escape_string($conn, $Name);
    $Email = mysqli_real_escape_string($conn, $Email);
    $Address = mysqli_real_escape_string($conn, $Address);
    $Notes = mysqli_real_escape_string($conn, $Notes);

    $sql_insert = "INSERT INTO customers(Name, Address, Email, ISD, Mobile, Notes) VALUES('$Name', '$Address', '$Email', '$ISD', '$Mobile', '$Notes')";
    $result_insert = mysqli_query($conn, $sql_insert);
    if(!$result_insert){
        echo "<div class='alert alert-success alert-dismissible fade show'>ERROR : Inserting a Record Failed. Please check insert query and attributes!</div>";
        exit;
    }
    else{
        echo "<div class='alert alert-success alert-dismissible fade show'><strong>Success! </strong> Customer is Added Successfully !</div>";					
        # Redirect to main_page location
        ?>
        
        <script>setTimeout(() => {
                    window.location="index.php";
                }, 800);
        </script>
        
        <?php
        exit;
    }
}
?>