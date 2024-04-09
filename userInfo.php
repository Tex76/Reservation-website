<?php
session_start();
if (!isset($_SESSION['active']))
  header("location:SignUp.php");

$id = $_SESSION['active'];
if (isset($_POST['sub'])) {
  $error = false;
  if ($_POST['mail'] == trim("")) {
    $error = true;
    $mailError = "<span style='color:red;'>*please mail is require<span>";
  }
  if (!preg_match("/^[0-9A-Za-z._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i", $_POST['mail'])) {
    $emailEr = "<span style='color:red;'>*please enter a valid email of form email@example.com</span>";
    $error = true;
  }
  if ($_POST['fname'] != trim("")) {
    if (!preg_match("/^(?! )[A-Za-z ]+$/i", $_POST['fname'])) {
      $error = true;
      $fnameError = "<span style='color:red;'>*please name msut consist from only letters no special character and no spaces and maxumim 20 letter.<span>";
    }
  }
  if ($_POST['about'] != trim("")) {
    if (!preg_match("/^(?! )[A-Za-z ]+$/i", $_POST['about'])) {
      $error = true;
      $aboutError = "<span style='color:red;'>*about field must consist from letters and spaces only and MUST start with letter no special characters is allowed.";
    }
  }
  if ($_FILES['file']['name'] != trim("")) {
    if ($_FILES['file']['error'] > 0)
      die("THERE IS AN ERROR IN UPLOADING THE FIIILEEEE!!!!");
    $fileName = $_FILES['file']['name'];
    $arr = array("png", "jpg", "jpeg");
    $var = explode(".", $fileName);
    $typefile = strtolower(end($var));
    if (in_array($typefile, $arr)) {
      if ($_FILES['file']['size'] > 5e+6) {
        $error = true;
        $sizeError = "<span style='color:red;'>*please file size msut not exceed 5 mg <span>";
      }
    } else {
      $error = true;
      $typeError = "<span style='color:red;'>*please the type of file must be img only (PNG, JPG, JPEG)";
    }
  }
  if (!$error) {
    try {
      require("connect.php");
      $q = $db->query("SELECT picture FROM users where ID='$id'");
      $v = $q->fetch();
      $oldPic = $v[0];

      extract($_POST);
      $name = $fname;
      if ($_FILES['file']['name'] != trim("")) {
        $picture = time() . uniqid(rand(1, 999)) . $_FILES['file']['name']; //create a unique file name
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], "meta/Persons/$picture")) //move file to location
          $moveError = "there is a problem with moving the file to it's location.";
      } else {
        if ($oldPic == "defaultimg.jpg")
          $picture = 'defaultimg.jpg';
        else
          $picture = $oldPic;
      }
      $r = $db->exec("UPDATE users set name='$name',about='$about',email='$mail',picture='$picture' where ID='$id'");
    } catch (PDOException $e) {
      die("Error :" . $e->getMessage());
    }
  }
}
// container two for old-new password checking
if (isset($_POST['ps'])) {
  $errorPs = false;
  if ($_POST['ops'] == trim("") || $_POST['nps'] == trim("") || $_POST['cps'] == trim("")) {
    $errorPs = true;
    $emptyPsError = "<span style='color:red;'>*please full all password blanks first.<span>";
  }
  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*[\\\<\>])(?!.* ).{8,16}$/", $_POST['ops'])) {
    $errorPs = true;
    $oldError = "<span style='color:red;'>*old passwrod must consist from 8-16 characters long contain at least one uppercase and lower case letters, one digit, one special character not allow (< / >).</span>";
  }
  if (!preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*[\\\<\>])(?!.* ).{8,16}$/", $_POST['cps'])) {
    $errorPs = true;
    $confirmError = "<span style='color:red;'>*confirm passwrod must consist from 8-16 characters long contain at least one uppercase and lower case letters, one digit, one special character not allow (< / >).</span>";
  }
  if (preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*[\\\<\>])(?!.* ).{8,16}$/", $_POST['nps'])) {
    if ($_POST['nps'] != $_POST['cps']) {
      $passNotMatch = "<span style='color:red;'>*passwords are not matches</span>";
      $errorPs = true;
    }
  } else {
    $passEr = "<span style='color:red;'>*new password must consist from 8-16 characters long contain at least one uppercase and lower case letters, one digit, one special character not allow (< / >).</span>";
    $errorPs = true;
  }


  if (!$errorPs) {
    extract($_POST);
    try {
      require("connect.php");
      $val = $db->query("SELECT password from users where ID='$id'");
      if ($val->rowCount() == 0) {
        die("there is a problem in selecting user password form database");
      }
      $rowv = $val->fetch();
      $oldpass = $rowv[0];
      if (!password_verify($ops, $oldpass)) {
        $errorOldPass = "<span style='color:red;'>*error in old password not match</span>";
      } else {
        $newpass = password_hash($nps, PASSWORD_DEFAULT);
        $in = $db->exec("UPDATE users SET password='$newpass' where ID='$id'");
        if ($in == 0)
          die("there is a problem in updating the password value");
        else
          $succes = "<span style='color:green;'>your new password succesfuly update it</span>";
      }
    } catch (PDOException $e) {
      die("Error: " . $e->getMessage());
    }
  }
}

if (isset($_POST['del'])) {
  $roomid = $_POST['de'];
  try {
    require("connect.php");
    $n = $db->exec("DELETE FROM reservation where uid='$id' AND rid='$roomid'");
    if ($n == 0)
      die("there is a problem in deleting the row");
  } catch (PDOException $e) {
    die("error: " . $e->getMessage());
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>find your passion</title>
  <style>
    /* user info code added*/
    html {
      height: 100% !important;
    }


    .delete {
      width: 20%;
      margin-top: 30px;
      border: none;
      border-radius: 7px;
      padding: 5px;
      color: white;
      font-size: 15px;
      font-weight: 500;
      background-color: #FF9129;
    }

    .infoPerson .no {
      display: flex;
      width: 40%;
      color: white;
      font-family: 'Times New Roman', Times, serif;
    }

    * {
      padding: 0px;
      margin: 0px;
      font-family: 'Roboto';
      font-size: 15px;
      line-height: 150%;
      box-sizing: border-box;

    }

    burgerIcon {
      display: none;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: lightgray;
    }

    burger {
      display: none;
    }

    /* nav style start here */
    nav {
      display: flex;
      justify-content: space-between;
      padding: 20px;
      width: auto;
      height: 90px;
      background-color: #15133C;
      align-items: center;

    }

    nav form {
      display: flex;
      align-items: center;
      width: 30%;
    }

    nav form input {
      padding: 10px;
      width: 20%;
      font-size: 13px;
      border-radius: 7px;
      border: none;
    }

    nav form input[type="submit"] {
      color: white;
      background-color: #2F414B;
      font-weight: 500px;
    }

    nav form input[type="search"] {
      width: 70%;
      margin-right: 10px;
    }

    nav img {
      width: 5%;

    }

    links {
      margin-right: auto;
      margin-left: 20px;
      display: flex;
      width: 50%;
      justify-content: left;
      align-items: center;
    }

    links a {
      text-decoration: none;
      color: white;
      margin-left: 40px;
      font-size: 13px;
      line-height: 150%;
    }

    /* nav style ends here */
    /* ------------------------- main code starts here ----------------------------- */
    main {
      width: 100%;
      height: auto;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 50px;
    }

    /* container-1 START here */
    choose {
      width: 100%;
      height: auto;
      display: flex;
      justify-content: start;
    }

    .btn {
      background-color: lightgray;
      border-left: none;
      border-right: none;
      border-top: none;
      border-bottom: 3px solid #FF9129;
      font-family: Arial, Helvetica, sans-serif;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 150%;
      text-transform: uppercase;
      padding-left: 14px;
      padding-right: 14px;
    }

    .container-1 {
      width: 100%;
      background-color: white;
      padding: 40px 80px;
      display: flex;
    }

    label {
      font-family: 'Arial';
      font-style: normal;
      font-weight: 700;
      font-size: 15px;
      line-height: 150%;
    }

    .left-box {
      width: 30%;
      display: flex;
      height: auto;
    }

    .left-box img {
      width: 200px;
      object-fit: cover;
      border-radius: 50%;
      height: 200px;
    }

    .right-box {
      width: 70%;
      display: flex;
      flex-direction: column;
    }

    .right-box h2 {
      font-family: Arial, Helvetica, sans-serif;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 150%;
    }

    .right-box .line {
      width: 100%;
      height: 1px;
      border-radius: 50%;
      background-color: black;
    }

    .right-box form {
      margin-top: 30px;
      display: flex;
      width: 100%;
      flex-wrap: wrap;
      justify-content: space-between;
    }

    input {
      padding: 5px;
    }

    .right-box textarea {
      padding: 5px;
      height: 150px;
    }

    .right-box .first {
      display: flex;
      width: 100%;
      flex-direction: column;
    }


    .right-box .email {
      display: flex;
      flex-direction: column;
      width: 100%;
      margin-top: 20px;
    }

    .right-box .about {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .right-box .save {
      margin-top: 20px;
      display: flex;
      width: 100%;
      justify-content: end;
    }

    .right-box .save button {
      padding: 10px 20px;
      background: #FF9129;
      border-radius: 7px;
      border: none;
      color: white;

    }

    /* container-1 finsh here */


    /* container-2 start here */
    .container-2 {
      width: 100%;
      background-color: white;
      padding: 40px 190px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .container-2 h2 {
      width: 100%;
      font-family: Arial, Helvetica, sans-serif;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 150%;
      text-align: start;
    }

    .container-2 .line {
      width: 100%;
      background-color: black;
      height: 1px;
      border-radius: 50%;
    }

    .container-2 form {
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .oldPassword {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .newPassword {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .confirmPassword {
      margin-top: 20px;
      display: flex;
      flex-direction: column;
      width: 100%;
    }

    .container-2 .save {
      margin-top: 20px;
      display: flex;
      width: 100%;
      justify-content: end;
    }

    .container-2 .save button {
      padding: 10px 20px;
      background: #FF9129;
      border-radius: 7px;
      border: none;
      color: white;

    }

    /* container-2 finsh here */
    /* container-3 start here */
    .container-3 {
      width: 100%;
      background-color: white;
      padding: 70px 40px;
      display: flex;
      flex-direction: column;
    }

    .container-3 h2 {
      font-family: Arial, Helvetica, sans-serif;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 150%;
    }

    .container-3 .line {
      width: 100%;
      background-color: black;
      height: 1px;
      border-radius: 50%;
    }

    .history {
      display: flex;
      width: 100%;
      background-color: #15133C;
      border-radius: 12px;
      margin-top: 30px;
    }

    .history .rimge {
      width: 30%;


    }

    .rimge img {
      width: 100%;
      height: 100%;
      border-radius: 12px 0px 0px 12px;
    }

    .details {
      display: flex;
      padding: 15px;
      width: 70%;
      flex-direction: column;
    }

    .details h3 {
      font-family: 'Times New Roman', Times, serif;
      font-style: normal;
      font-weight: 600;
      font-size: 24px;
      line-height: 150%;
      text-transform: capitalize;
      color: #FFD334;
    }

    .details p {
      margin-top: 10px;
      font-family: Arial, Helvetica, sans-serif;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 160%;
      color: #FFFFFF;
    }

    .infoPerson {
      display: flex;
      width: 80%;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .infoPerson cap {
      color: white;
      font-family: 'Times New Roman', Times, serif;
      font-weight: 400;
      font-size: 15px;
      line-height: 160%;
      width: 15%;
    }

    .infoPerson rate {
      display: flex;
      width: 40%;
    }

    .infoPerson rate img {
      width: 20px;
    }

    .infoPerson date {
      font-family: 'Times New Roman', Times, serif;
      color: white;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 160%;
    }

    .infoPerson rate+cap {
      width: 12%;
    }

    date+cap,
    cap+price {
      margin-top: 10px;
    }

    price {
      font-family: 'Times New Roman', Times, serif;
      font-style: normal;
      font-weight: 400;
      font-size: 15px;
      line-height: 160%;
      color: #FFFFFF;

    }



    /* ------------------------- main code ends here ----------------------------- */
    /* footer style start here */
    footer {
      display: flex;
      justify-content: space-between;
      padding: 30px;
      width: auto;
      height: 400px;
      background-color: #15133C;
      color: white;
      margin-top: auto;
    }

    footer column {
      width: 20%;
      display: flex;
      flex-direction: column;
    }

    footer h3 {
      margin-top: 20%;
      font-style: normal;
      font-weight: 700;
      font-size: 16px;
      line-height: 19px;
      letter-spacing: 0.1em;
      text-transform: capitalize;
    }

    a.captions-links {
      margin-top: 10px;
      font-style: normal;
      font-weight: 600;
      font-size: 16px;
      line-height: 163.15%;
      color: #BBC8D4;
      text-decoration: none;
    }

    footer column.big {
      width: 40%;
      margin-bottom: 50px;
    }


    footer column.big form {
      margin-top: 50px;
    }

    footer column.big form input[type="email"] {
      width: 80%;
      background: #FFFFFF;
      border: 2px solid #BBC8D4;
      border-radius: 17px;
      padding: 10px;
    }

    column:nth-of-type(1) img {
      width: 50px;
      margin-top: 35px;
    }

    column p {
      font-style: normal;
      font-weight: 600;
      font-size: 16px;
      line-height: 163.15%;
      color: #BBC8D4;
      max-width: 199px;
      margin-top: 20px;
    }

    footer media {
      margin-top: 20px;
    }

    footer column.big h3 {
      margin-top: 44px;
    }

    footer media img {
      margin-right: 5px;
    }

    /* footer style ends here */


    /* media quries for tablet */
    @media (max-width: 1024px) {
      main {
        padding: 30px;
      }

      .history .rimge {
        width: 30%;
        border-radius: 12px 0px 0px 12px;
      }

      .history .details {
        width: 70%;
      }

      .details h3 {
        font-size: 18px;
      }

      .details p {
        font-size: 12px;
      }

      .infoPerson cap {
        font-size: 11px;
      }

      .infoPerson date,
      .infoPerson price {
        font-size: 11px;
      }





      /* nav start tablet*/
      nav {
        padding: 20px;
      }

      links a {
        font-size: 12px;
        margin-left: 20px;
      }

      nav form input {
        padding: 8px;
        font-size: 12px;
      }

      /* nav end tablet*/
      .container-1 {
        padding: 20px 20px;
        flex-direction: column;
        align-items: center;
      }

      .left-box {
        width: 100%;
        flex-direction: column;
        align-items: center;
        padding: 20px 0px;
      }

      .right-box {
        width: 100%;
      }

      .container-2 {
        padding: 20px 120px;
      }



      /*footer start tablet*/
      footer {
        padding: 20px;
      }

      footer h3 {
        font-size: 13px;
      }

      footer p {
        font-size: 12px;
      }

      a.captions-links {
        font-size: 13px;
      }

      column:nth-of-type(1) p {

        font-size: 13px;

      }

      footer column.big form input[type="email"] {

        padding: 8px;
      }

      /*footer ends tablet*/

    }

    /* media quries between tablet and phone */
    @media (max-width: 800px) {

      .container-2 {
        padding: 20px 10px;
      }

      .container-3 {
        align-items: center;

        padding: 30px;
      }

      .history {
        flex-direction: column;
        align-items: center;
        width: 80%;
        justify-content: center;
      }

      .history .rimge {
        width: 100%;
      }

      .rimge img {
        border-radius: 12px 12px 0px 0px;
        width: 100%;
      }


      .history .details {
        width: 100%;
        margin-bottom: 50px;
        margin-top: 10px;
      }

      .infoPerson {
        width: 100%;

      }

      date+cap,
      cap+price {
        margin-top: 0px;
      }

      .infoPerson cap,
      .infoPerson rate+cap {
        margin-top: 10px;
        width: 100%;
      }

      /* nav start between tablet and phone*/
      nav {
        padding: 10px;
      }

      links a {
        margin-left: 10px;
        font-size: 9px;
      }

      nav form input {
        padding: 6px;
        font-size: 10px;
      }

      /* nav end between tablet and phone*/

      /* footer start between tablet and phone*/
      footer {
        padding: 10px;
        height: 280px;
      }

      footer h3 {
        font-size: 10px;
        margin-top: 10px;
      }

      footer p {
        font-size: 12px;
      }

      footer column.big h3 {
        margin-top: 10px;
      }

      a.captions-links {
        font-size: 10px;
      }

      column:nth-of-type(1) p {

        font-size: 10px;
      }

      footer column img.logoFooter {
        margin-top: 10px;
      }

      /* footer ends between tablet and phone*/
    }

    /* media quries for phone */
    @media (max-width: 550px) {
      main {
        padding: 10px;
      }

      .container-1 {
        padding: 15px;
      }

      /* nav phone start*/
      links {
        display: none;
      }

      burgerIcon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30%;

      }

      nav img {
        width: 20%;
      }

      burgerIcon img {
        width: 40%;
      }

      nav form {
        display: none;
      }

      burger {
        display: flex;
        text-align: center;
        justify-content: center;
        background-color: #15133C;

      }

      burger a {
        text-decoration: none;
        color: white;

      }

      burger ul {
        display: block;
        width: 100%;
      }

      burger ul li {
        list-style-type: none;
        padding: 10px;
        display: block;
        border: 1px solid white;
        width: 100%;

      }

      burger form {
        display: flex;
        justify-content: center;
      }

      burger form input {
        padding: 10px;
        width: 20%;
        font-size: 12px;
        border-radius: 7px;
        border: none;
      }

      burger form input[type="submit"] {
        color: white;
        background-color: #2F414B;
        font-weight: 500px;
      }

      burger form input[type="search"] {
        width: 60%;
        margin-right: 10px;
      }

      burger {
        display: none;
      }

      /* nav phone ends*/

      /* footer phone start*/
      footer {

        flex-direction: column;
        align-items: center;
        padding: 10px;
        width: auto;
        height: auto;
        background-color: #15133C;
        color: white;
        margin-top: auto;
      }

      footer column {
        text-align: center;
        align-items: center;
        flex-direction: column;
        margin-top: 50px;
        width: 100%;
      }

      footer column.big {
        width: 100%;
      }

      footer column.big form {
        margin-top: 20px;
        width: 100%;
      }


      footer input[type="email"] {
        width: 100%;

      }

      /* footer phone ends*/



    }
  </style>
  <!-- Don't open this until we write PHP I alert you, you will scroll for rest of your life this is css code for page -->
</head>

<body>
  <!-- navbar start Open by clikcing on arrow, but keep it close for your mental health-->
  <nav>
    <img id="logo" src="meta/Logo.svg" alt="logo" width="50px" height="50px">
    <links>
      <a href="homePage.php">Home</a>
      <a href="userInfo.php">Profile</a>
      <a href="aboutUs.php">About Us</a>
      <a href="Login.php">Login</a>
      <a href="SignUp.php">Sign Up</a>
      <a href="addItem.php">Add Room</a>
      <a href="showDetails.php">Show users</a>

    </links>
    <form action="https://www.google.com">
      <input type="search" placeholder="Search for room name,place..." name="search">
      <input type="submit" value="Search" name="search_btm">
    </form>
    <burgerIcon>
      <img src="meta/burgerIcon.svg" alt="burger">
    </burgerIcon>
  </nav>
  <burger>
    <!-- burger menu  -->
    <ul>
      <li><a href="homePage.php">Home</a></li>
      <li><a href="userInfo.php">Profile</a></li>
      <li><a href="Login.php">Login</a></li>
      <li><a href="SignUp.php">Sign Up</a></li>
      <li> <a href="aboutUs.php">About Us</a> </li>
      <li> <a href="addItem.php">Add Room</a></li>
      <li> <a href="showDetails.php">Show users</a></li>

      <li>
        <form action="https://www.google.com">
          <input type="search" placeholder="Search for room name,place..." name="search">
          <input type="submit" value="Search" name="search_btm">
        </form>
      </li>
    </ul>
  </burger>
  <!-- navbar end -->

  <!---------------------------- Your Code is here ---------------------------->
  <main>
    <choose>
      <button class="btn" onclick="profile()">My Profile</button>
      <button class="btn" onclick="changePassword()">Change Password</button>
      <button class="btn" onclick="history()">History</button>
    </choose>
    <!-- start of container-1 -->



    <div class="container-1">
      <div class="left-box">
        <!-- <div class="imgBlock"> -->
        <?php
        try {
          require("connect.php");
          $value = $db->query("SELECT * FROM users where ID='$id'");
          if ($value->rowCount() == 0) {
            die("there is error in selecting the user info from the data base");
          } else {

            foreach ($value as $row) {
              if (isset($row[2]))
        ?>
              <img src="meta/Persons/<?php echo $row[5] ?>" alt="person image">
              <!-- </div> -->
              <!-- icons that use to change image-->
      </div>
      <div class="right-box">
        <h2>Personal information</h2>
        <div class="line"></div>


        <form action="" enctype="multipart/form-data" method="POST">
          <div class="first">
            <label>Name:</label><input type="text" name="fname" placeholder="Your First name..." value="<?php echo $row[2]; ?>">
          </div>
          <div class="email">
            <label>Email:</label><input type="text" name="mail" placeholder="Your Email..." value="<?php echo $row[3]; ?>">
          </div>
          <div class="about">
            <label>About:</label><textarea placeholder="write about yourself.." name="about"><?php echo $row[6]; ?></textarea>
          </div>
          <div class="photo">
            <label>Upload New picture:</label><input type="file" name="file">
          </div>
    <?php       }
          }
        } catch (PDOException $e) {
          die("Error: " . $e->getMessage());
        }
    ?>
    <?php
    if (isset($mailError)) {
      echo $mailError . "<br>";
    } else {
      if (isset($emailEr))
        echo  $emailEr . "<br>";
      if (isset($fnameError))
        echo $fnameError . "<br>";
      if (isset($aboutError))
        echo $aboutError . "<br>";
      if (isset($typeError))
        echo $typeError . "<br>";
      if (isset($sizeError))
        echo $sizeError . "<br>";
      if (isset($moveError))
        echo $moveError . "<br>";
    }


    ?>
    <div class="save">
      <button type="submit" name="sub">Save Changes</button>
    </div>
        </form>
      </div>
    </div>


    <!-- ends of container-1 -->

    <!-- start of contianer-2 -->
    <div class="container-2">
      <h2>Password Change</h2>
      <div class="line"></div>


      <form action="" method="post">
        <div class="oldPassword">
          <label>Old Password</label><input type="password" name="ops" placeholder="old Password...">
        </div>
        <div class="newPassword">
          <label>New Password</label><input type="password" name="nps" placeholder="new Password...">
        </div>
        <div class="confirmPassword">
          <label>Confirm New Password</label><input type="password" name="cps" placeholder="confirm Password...">
        </div>
        <?php
        if (isset($emptyPsError)) {
          echo $emptyPsError . "<br>";
        } else {
          if (isset($oldError))
            echo $oldError . "<br>";

          if (isset($confirmError))
            echo $confirmError . "<br>";
          else
            if (isset($passNotMatch))
            echo $passNotMatch . "<br>";

          if (isset($passEr))
            echo $passEr . "<br>";
        }
        if (isset($errorOldPass))
          echo $errorOldPass . "<br>";
        else
        if (isset($succes))
          echo $succes . "<br>";



        ?>
        <div class="save">
          <button type="submit" name="ps">Save Changes</button>
        </div>
      </form>


    </div>
    <!-- ends of contianer-2 -->


    <!--start of contianer-3 -->
    <div class="container-3">
      <h2>Reservaiton History</h2>
      <div class="line"></div>
      <?php
      try {
        require('connect.php');
        $c = $db->query("SELECT * FROM reservation where uid='$id'");
        if ($c->rowCount() == 0) {
          echo "<h5>You don't have any reserved room</h5>";
        } else {
          foreach ($c as $row) {
            $rid = $row[1];
            $d = $db->query("SELECT description,picture,name,rate from room where ID='$rid'");
            $varle = $d->fetch();
      ?>
            <!--history card 1 start here-->
            <div class="history">
              <div class="rimge">
                <img src="roomImges/<?php echo $varle[1]; ?>" alt="imge of some room">
              </div>
              <div class="details">
                <h3><?php echo $varle[2]; ?></h3>
                <p>
                  <?php
                  echo $varle[0];
                  ?>
                </p>
                <div class="infoPerson">
                  <cap>
                    Your Rate:
                  </cap>
                  <?php

                  if ($varle[3] == 0) {
                    echo "<lable class='no'>You didn't rate</lable>";
                  } else {
                  ?>

                    <rate>
                      <?php
                      for ($i = 0; $i < $varle[3]; $i++) {
                      ?>
                        <img src="star.svg" alt="">
                      <?php } ?>
                    </rate>
                  <?php } ?>
                  <cap>
                    Date:
                  </cap>
                  <date>
                    <?php echo $row[2]; ?> - <?php echo $row[3]; ?>
                  </date>
                  <cap>
                    Total Price:
                  </cap>
                  <price>
                    <?php echo $row[4]; ?>
                  </price>
                </div>
                <form method="post">
                  <button class="delete" type="submit" name="del">Delete</button>
                  <input type="hidden" name="de" value="<?php echo $rid; ?>">
                </form>
              </div>
            </div>

      <?php
          }
        }
      } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
      }


      ?>

    </div>
    <!--ends of contianer-3 -->
  </main>





  <!---------------------------- Your Code end is here ---------------------------->
  <!-- footer code start here -->
  <footer>
    <column>
      <!--column 1 width="20%"-->
      <img class="logoFooter" src="meta/Logo.svg">
      <p>The best collaboration application </p>
    </column>
    <column>
      <!--column 2 width="20%"-->
      <h3>Features</h3>
      <a href="#page" class="captions-links">Sharing</a>
      <a href="#page" class="captions-links">IOS & androide</a>
      <a href="#page" class="captions-links">File Sharing</a>
      <a href="#page" class="captions-links">Video Call</a>
    </column>
    <column>
      <!--column 3 width="20%"-->
      <h3>Company</h3>
      <a href="#page" class="captions-links">Careers</a>
      <a href="#page" class="captions-links">Departments</a>
      <a href="#page" class="captions-links">Contact Us</a>
    </column> <!-- end of col 3-->
    <column class="big">
      <!--column 4 width="40%"-->
      <h3>Stay Up To Date</h3>
      <p>Subsecribe for new upadates</p>
      <form class="footerEmail">
        <input type="email" placeholder="Email">
      </form>
      <media>
        <img src="meta/media/twitter.svg">
        <!--onClick event must be insert-->
        <img src="meta/media/linkedIn.svg">
        <img src="meta/media/instagram.svg">
        <img src="meta/media/google.svg">
      </media>
    </column><!-- end of col 4-->
  </footer>
  <!-- ends of footer -->


  <!--java script code for burger menu-->
  <script>
    const burgerIcon = document.querySelector("nav burgerIcon");
    const burgerMenu = document.querySelector("burger");
    burgerIcon.addEventListener("click", () => {
      if (burgerMenu.style.display == "none")
        burgerMenu.style.display = "flex";
      else
        burgerMenu.style.display = "none";

    });

    const btn_profile = document.getElementsByClassName("btn")[0];
    const btn_password = document.getElementsByClassName("btn")[1];
    const btn_history = document.getElementsByClassName("btn")[2];

    window.onload = profile;

    function profile() {
      btn_password.style.border = 'none';
      btn_history.style.border = 'none';
      btn_profile.style.borderBottom = '3px solid #FF9129';
      document.querySelector(".container-1").style.display = 'flex';
      document.querySelector(".container-2").style.display = 'none';
      document.querySelector(".container-3").style.display = 'none';
    }


    function history() {
      btn_password.style.border = 'none';
      btn_profile.style.border = 'none';
      btn_history.style.borderBottom = '3px solid #FF9129';
      document.querySelector(".container-3").style.display = 'flex';
      document.querySelector(".container-1").style.display = 'none';
      document.querySelector(".container-2").style.display = 'none';
    }

    function changePassword() {
      btn_history.style.border = 'none';
      btn_profile.style.border = 'none';
      btn_password.style.borderBottom = '3px solid #FF9129';
      document.querySelector(".container-2").style.display = 'flex';
      document.querySelector(".container-1").style.display = 'none';
      document.querySelector(".container-3").style.display = 'none';
    }

    function Delete() {
      let deleteBtn = document.getElementById("del");
      const xhttp = new XMLHttpRequest();
      xhttp.onload = function() {

      }
    }
  </script>

</body>

</html>