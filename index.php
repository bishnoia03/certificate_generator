<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Har Ghar Tiranga</title>
  <?php
  include 'cdn.php';
  ?>
</head>

<body class="bg">
  <?php
  include 'conn.php';
  ?>
  <div class="container">
    <div class="row pt-3 m-0">
      <div class="col-3"></div>
      <div class="col-6">
        <center>
          <h1>Har Ghar Tiranga</h1>
        </center>
      </div>
      <div class="col-3 m-0">
        <a href="#" data-bs-toggle="modal" data-bs-target="#myModal" class="login arrow">Official Login</a>
      </div>
    </div>
  </div>
  <div class="content">
    <section>
      <div class="register-wrapper">
        <div class="register-block">
          <h3 class="register-title">Register Yourself</h3>
          <p>Welcome To MM PG College</p>
          <form method="post" action="" enctype=multipart/form-data>
            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Your Name" required />
            <input type="number" name="mobile" class="form-control" placeholder="Enter Your Mobile No." required />
            <input type="email" name="email" class="form-control" placeholder="E-mail Address" required />
            <input type="file" name="file" class="form-control" placeholder="Photo" accept="image/*" capture="camera" required />
            <input type="submit" name="generate" value="Submit" />
          </form>
        </div>
      </div>
    </section>
  </div>
  <!-- login modal -->
  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <center>
            <h4 class="modal-title">Log In</h4>
          </center>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <form method="post" action="">
            <input type="email" name="username" class="form-control" placeholder="Enter Username" /><br>
            <input type="password" name="password" class="form-control" placeholder="Password" required />
            <div class="modal-footer">
              <input type="submit" name="login" class="btn btn-success" value="Log In">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>

        <!-- Modal footer -->


      </div>
    </div>
  </div>

</body>

</html>
<?php
if (
  isset($_POST["login"]) &&
  isset($_POST["username"]) &&
  isset($_POST["password"])
) {

  if (
    !empty($_POST["username"]) &&
    !empty($_POST["password"])
  ) {
    // proceed
    print_r($_POST);
    $username = $_POST["username"];
    $user_password = $_POST["password"];


    // check user authentication
    // $password = md5($password);

    include "./conn.php";
    // $sql =  $db_conn->prepare("SELECT * FROM admin_input WHERE username= ? AND pass= ?");
    // $sql->bind_param("ss", $username, $password);

    // print_r($sql);
    // $sql->execute();
    // $result = $sql->get_result();
    // print_r($result);

    echo $sql = "SELECT * FROM admin_input WHERE username= '$username' AND password= '$user_password'";
    $result = $db_conn->query($sql);
    if ($result->num_rows === 0) {
      // unauthenticate user
?>
      <script>
        alert("Sorry, invalid email AND password");
      </script>
    <?php
    } else {
      // authenticate user
      if ($row = $result->fetch_assoc()) {
        $_SESSION["admin__auth_id"] = $row["id"];
        header("Location:./admin");
      }
    }
    // $sql->close();
    // $db_conn->close();


    ?>
    <script>
      history.pushState({}, "", "")
    </script>
<?php
  }
}
?>


<?php
if (isset($_POST["mobile"])) {
  //print_r($_FILES);

  $name = $_POST["name"];
  $mobile = $_POST["mobile"];
  $email = $_POST["email"];
  $file = $_FILES['file'];
  //Getting the file name of the uploaded file
  $fileName = $_FILES['file']['name'];
  //Getting the Temporary file name of the uploaded file
  $fileTempName = $_FILES['file']['tmp_name'];
  //Getting the file size of the uploaded file
  $fileSize = $_FILES['file']['size'];
  //getting the no. of  in uploading the file
  $fileError = $_FILES['file']['error'];
  //Getting the file type of the uploaded file
  $fileType = $_FILES['file']['type'];

  //Getting the file ext
  $fileExt = explode('.', $fileName);
  $fileActualExt = strtolower(end($fileExt));

  $allowedExt = array("jpg", "jpeg", "png");

  //Checking, Is file extentation is in allowed extentation array
  if (in_array($fileActualExt, $allowedExt)) {
    //Checking, Is there any file error
    if ($fileError == 0) {
      //Checking,The file size is bellow than the allowed file size
      if ($fileSize < 10000000) {
        //Creating a unique name for file
        $fileNemeNew = uniqid('', true) . "." . $fileActualExt;
        //File destination
        $fileDestination = 'uploads/' . $fileNemeNew;
        //function to move temp location to permanent location
        move_uploaded_file($fileTempName, $fileDestination);
        //Message after success
        echo "File Uploaded successfully";
        $user_detail = "INSERT INTO user_input(name,mobile,email,image)VALUES('$name','$mobile','$email','$fileNemeNew')";
        $result = $db_conn->query($user_detail);
      } else {
        //Message,If file size greater than allowed size
        echo "File Size Limit beyond acceptance";
      }
    } else {
      //Message, If there is some error
      echo "Something Went Wrong Please try again!";
    }
  } else {
    //Message,If this is not a valid file type
    echo "You can't upload this extention of file";
  }
}
?>