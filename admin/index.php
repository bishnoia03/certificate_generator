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
<?php
include '../cdn.php';
?>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-3"></div>
        <div class="col-6">
        <center><h1>User's Input Data</h1></center>
        </div>
        <div class="col-3">
        <a  href="http://harghartiranga.zya.me/admin/logout.php">Log Out</a>
        </div>
        </div>
       
    </div>
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
                    <td><img src="http://harghartiranga.zya.me/uploads/<?php echo $row['image'] ?>" id="img1" alt="image" width="70px" height="70px" onclick="showImg('http://harghartiranga.zya.me/uploads/<?php echo $row['image'] ?>')"></td>
                    <td>
                     <form action="" method="post">  
                        <input type="hidden" name="name" value="<?php echo $row['name'];?>">  
                      <button class="btn btn-success" type="submit" name="generate">Approve</button></td>
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

if(isset($_POST["generate"])){
$output = "certificate.png";
$font="font.ttf";
$image=imagecreatefrompng("../certificate.png");
$color =imagecolorallocate($image,228,217,8);
imagettftext($image,30,0,250,250,$color,$font,$_POST["name"]);
imagepng($image,$output, 3);
imagedestroy($image);
?>
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
    download("http://localhost/admin/certificate.png");
   
</script>

<?php 
// send mail 


// (A) EMAIL SETTINGS
// $mailTo = "abc@gmail.com";
// $mailSubject = "Test Attachment";
// $mailMessage = "<strong>Test Message</strong>";
// $mailAttach = "http://localhost/admin/certificate.png";

// (B) GENERATE RANDOM BOUNDARY TO SEPARATE MESSAGE & ATTACHMENTS
// $mailBoundary = md5(time());


// $mailHead = implode("\r\n", [
//   "MIME-Version: 1.0",
//   "Content-Type: multipart/mixed; boundary=\"$mailBoundary\""
// ]);

// // (C) DEFINE THE EMAIL MESSAGE
// $mailBody = implode("\r\n", [
//   "--$mailBoundary",
//   "Content-type: text/html; charset=utf-8",
//   "",
//   $mailMessage
// ]);

// // (D) MANUALLY ENCODE & ATTACH THE FILE
// $mailBody .= implode("\r\n", [
//   "",
//   "--$mailBoundary",
//   "Content-Type: application/octet-stream; name=\"". basename($mailAttach) . "\"",
//   "Content-Transfer-Encoding: base64",
//   "Content-Disposition: attachment",
//   "",
//   chunk_split(base64_encode(file_get_contents($mailAttach))),
//   "--$mailBoundary--"
// ]);

// // (E) SEND
// echo mail($mailTo, $mailSubject, $mailBody, $mailHead)
//   ? "OK" : "ERROR" ;



// }?>