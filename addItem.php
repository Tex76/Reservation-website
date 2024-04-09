<?php
session_start();
if (!isset($_SESSION['active']))
    header("location:SignUp.php");
else if ($_SESSION['type'] != "admin")
    die("you'r not allow to enter here!!");

if (isset($_POST['sub'])) {
    extract($_POST);
    $error = false;
    if ($rname == trim("") || $rprice == trim("") || $rDis == trim("") || !isset($_FILES['file'])) {
        $message = "*please full all require blanks.";
        $error = true;
    }
    if (!preg_match("/^(?! )[A-Za-z ]+$/i", $rname)) {
        $nError = "*please enter name in right form only letters and spaces name must start with letter.";
        $error = true;
    }
    if (!preg_match("/^(?![\.0])[0-9]{1,3}\.[0-9]{1}$/i", $rprice)) {
        $pError = "*please enter price in valid form, not allowed to start with zero and must consist from maximum 3 digit and should in float form with one digit after the point.";
        $error = true;
    }
    if (!preg_match("/^(?![ \W])[^<>\/']+$/i", $rDis)) {
        $error = true;
        $dError = "*discription must not start with space or special character and dose not contain special characters (gretaer than or less than or slashes or ').";
    }
    if ($_FILES['file']['error'] != 0) {
        $error = true;
        $fuError = "*there is an error with uploading the file.";
    }
    $array = array("png", "jpg", "jpeg");
    $arrayType = explode(".", $_FILES['file']['name']);
    $last = end($arrayType);
    $type = strtolower($last);
    if (in_array($type, $array)) {
        if ($_FILES['file']['size'] > 10e+6) {
            $error = true;
            $sfError = "*please file must not exceed 10 mgb.";
        }
    } else {
        $error = true;
        $tError = "*please enter right type of file PNG, JPG, JPEG only.";
    }

    if (!$error) {
        $fileName = time() . uniqid(rand(1, 999)) . $_FILES['file']['name']; //create a unique file name
        if (!move_uploaded_file($_FILES["file"]["tmp_name"], "roomImges/$fileName")) //move file to location
            $moveError = "there is a problem with moving the file to it's location.";
        else {
            try {
                require("connect.php");
                $r = $db->exec("INSERT INTO room(name,description,price,picture) values('$rname','$rDis','$rprice','$fileName')");
                if ($r == 1) {
                    $good = "<span style='color:green;'>Rooms has successfuly added. Thank You</span>";
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
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
    <title>find your passion</title>
    <style>
        /* add item code ready */
        html {
            height: 100% !important;
        }

        * {
            padding: 0px;
            margin: 0px;
            font-family: 'Roboto';
            font-size: 15px;
            line-height: 150%;
            box-sizing: border-box;

        }

        .sub {
            display: flex;
            justify-content: end;
            margin-top: 20px;
        }

        .buttom {
            background-color: #FFD334;
            color: white;
            border: none;
            border-radius: 4px;
            width: 30%;
            padding: 15px;
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

        main {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: lightgray;
            width: 100%;
            height: 800px;
        }

        container {
            margin-top: 90px;
            width: 60%;
            height: auto;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #143A4F;
            border-radius: 13px;
        }

        container p {
            font-family: 'Times New Roman';
            font-style: normal;
            font-weight: 700;
            font-size: 24px;
            line-height: 150%;
            color: white;
            text-align: center;
            margin-top: 10px;
        }

        container .line {
            width: 122px;
            height: 1px;
            background: #FFD334;
            margin-top: 5px;
        }

        container form {
            display: flex;
            flex-direction: column;
            margin-top: 50px;
            width: 100%;
        }

        label {
            font-family: 'Times New Roman';
            font-style: normal;
            font-weight: 400;
            font-size: 24px;
            line-height: 150%;
            color: #FFFFFF;
            width: 50%;

        }

        .namePart label {
            width: 50%;
        }

        .namePart input {
            width: 50%;
            height: 40px;
            background: #FFFFFF;
            border-radius: 3px;
        }

        .namePart {

            width: 100%;
            flex-wrap: wrap;

            display: flex;

        }


        .pricePart {
            width: 100%;
            margin-top: 40px;
            display: flex;
            flex-wrap: wrap;

        }


        .pricePart input {
            width: 50%;
            height: 40px;
            background: #FFFFFF;
            border-radius: 3px;
        }

        .areaPart {
            flex-wrap: wrap;

            width: 100%;
            margin-top: 40px;
            display: flex;
        }



        .areaPart textarea {
            background: #FFFFFF;
            border-radius: 3px;
            width: 50%;
            height: 126px;
        }


        .picturePart {
            flex-wrap: wrap;

            width: 100%;
            margin-top: 40px;
            display: flex;
        }

        .picturePart label {

            width: 50%;
        }

        .picturePart input {
            margin-top: 10px;
            width: 50%;
        }



        /* media quries for tablet */
        @media (max-width: 1024px) {

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
        @media (max-width: 750px) {
            container form {
                padding: 30px;
                margin-top: 0px;
            }

            container {
                width: 500px;
                font-size: 20px;
            }

            .namePart input {
                width: 50%;

            }

            .namePart label {
                width: 50%;
                margin-right: 0px;
                font-size: 20px;
            }

            .pricePart label {
                margin-right: 0px;
                width: 50%;
                font-size: 20px;
            }

            .pricePart input {
                width: 50%;
            }

            .areaPart label {
                margin-right: 0px;
                width: 50%;
                font-size: 20px;
            }

            .picturePart label {
                margin-right: 0px;
                width: 50%;
                font-size: 20px;
            }

            .areaPart textarea {
                width: 50%;
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

            container {
                padding: 0px;
                width: 90%;
            }

            .namePart label {
                width: 100%;
            }

            .namePart input {
                width: 100%;
            }

            .pricePart label {
                width: 100%;
            }

            .pricePart input {
                width: 100%;
            }

            .areaPart label {
                width: 100%;
            }

            .areaPart textarea {
                width: 100%;
            }

            .picturePart label {
                width: 100%;
            }

            .picturePart input {
                width: 100%;
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
            <li><a href="showDetails.php">Show users</a></li>
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
        <container>
            <p>Add Room</p>
            <div class="line"></div>
            <form action="" enctype="multipart/form-data" method="POST">
                <div class="namePart">
                    <label>Room Name:</label><input type="text" name="rname" placeholder="Room Name..">
                </div>
                <div class="pricePart">
                    <label>Room price per night:</label><input type="text" name="rprice" placeholder="Room Price..">
                </div>
                <div class="areaPart">
                    <label>Room description:</label> <textarea name="rDis" rows="4" cols="4"></textarea>
                </div>
                <div class="picturePart">
                    <label>Room Picture:</label> <input type="file" name="file">
                </div>
                <span style="color:red;">
                    <?php
                    if (isset($message)) echo $message . "<br>";
                    else {
                        if (isset($nError)) echo $nError . "<br>";
                        if (isset($pError)) echo $pError . "<br>";
                        if (isset($dError)) echo $dError . "<br>";
                        if (isset($tError)) echo $tError . "<br>";
                        if (isset($sfError)) echo $sfError . "<br>";
                    }
                    if (isset($moveError))
                        echo $moveError . "<br>";

                    ?></span>
                <?php if (isset($good))
                    echo $good . "<br>"; ?>
                <div class="sub">
                    <input class="buttom" type="submit" value="Add Item" name="sub">
                </div>
            </form>
        </container>
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
    </script>

</body>

</html>