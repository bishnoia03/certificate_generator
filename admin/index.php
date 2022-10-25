<?php
session_start();
if (!isset($_SESSION["admin__auth_id"])) {
    header("location:../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
<?php
include '../cdn.php';
?>
</head>
<body>
<!-- sidebar -->
<div id="mySidebar" class="sidebar">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <a href="#">About</a>
  <a href="#">Services</a>
  <a href="#">Contact</a>
  <a  href="http://localhost/certificate_generator/admin/logout.php">Log Out</a>
</div>
<!-- navbar  -->
<nav>
<div class="row">
    <div class="col-4">
    <div id="main">
  <button class="openbtn" onclick="openNav()">☰</button>  
</div>
    </div>
    <div class="col-4">
    <center><h1>User's Input Data</h1></center>
    </div>
    <div class="col-3">
    <form class="d-flex align-items-center justify-content-center">
      <input class="form-control m-3" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success m-2" type="submit">Search</button>
    </form>
    </div>
</div>
</nav>
<!-- Dashboard -->
    <?php
    include '../conn.php';
    ?>
  <div class="container">
    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">
          
           <table class="table table-striped table-hover">
                <thead>
                    <td>Sr. No.</td>
                    <td>Name</td>
                    <td>Mobile</td>
                    <td>Email Address</td>
                    <td>Image</td>
                    <td>Action</td>
                </thead>
                <tr>
                <?php
 $sql = "SELECT * FROM user_input";
 $result = $db_conn->query($sql);
 while($row = $result->fetch_assoc())
 {
 ?>
                    <td><?php echo $row['user_id'] ?></td>
                    <td id="name"><?php echo $row['name'] ?></td>
                    <td><?php echo $row['mobile'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><img src="http://localhost/certificate_generator/uploads/<?php echo $row['image'] ?>" id="img1" alt="image" width="70px" height="70px" onclick="showImg('http://localhost/certificate_generator/uploads/<?php echo $row['image'] ?>')"></td>
                    <td>
                     <form action="" method="post">  
                        <input type="hidden" name="name" value="<?php echo $row['name'];?>">  
                      <input class="btn btn-success" type="submit" name="aprove" value="Approve"></td>
                     </form>

                </tr><?php 
            } 
 ?>
            </table>
        </div>
        <div class="col-1"></div>
    </div>
  </div>
  <!-- img modal -->

  <div class="modal fade" id="imgmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: #0000 !important;";>
     <div class="modal-body p-0" id="largeImg">
           
      </div>
      </div>
  </div>
</div>

<script>
     var myModal = new bootstrap.Modal(document.getElementById('imgmodal'), {
  keyboard: false
})
    function showImg(imgUrl){
        document.getElementById("largeImg").innerHTML = `<img src='${imgUrl}' width="600px" height="500px">`;
        myModal.toggle();
}
</script>
</body>
</html>
<!-- certificate generate here -->
<?php

if(isset($_POST["aprove"])){
$output = "certificate.png";
$font="font.ttf";
$image=imagecreatefrompng("../certificate.png");
$color =imagecolorallocate($image,228,217,8);
imagettftext($image,30,0,250,250,$color,$font,$_POST["name"]);
imagepng($image,$output, 3);
imagedestroy($image);
}?>
<script>
    function download(source) {
        const fileName = source.split('/').pop();
        var el = document.createElement("a");
        el.setAttribute("href", source);
        el.setAttribute("download", fileName);
        document.body.appendChild(el);
        el.click();
        el.remove();
    }
    const btn = document.querySelector('.aprove');
    btn.addEventListener('click', function (e) {
        alert("certificate approved");
        download("http://localhost/certificate_generator/admin/certificate.png");
  e.stopPropagation();
});
// sidebar code here

function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
   
</script>