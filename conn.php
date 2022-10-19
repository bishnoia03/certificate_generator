<!-- php db connection here -->
<?php 
    $host_name = "localhost";
    $user_name  = "root";
    $password = "";
    $db_name = "certificate_generator";
    $db_conn = new mysqli($host_name,$user_name,$password,$db_name); 
    ///print_r($db_conn);
?>