<?php

//the following code will check weather all values are true and add them to the data base

if (isset($_POST['Sigup'])) {
    $error = false;
    //check if all blanks where empty
    if ($_POST['name'] == trim("") || $_POST['email'] == trim("") || $_POST['pass'] == trim("") || $_POST['cpass'] == trim("")) {
        $blanks = "<span style='color:red;'>*please full all the blanks</span>";
        $error = true;
    }
    //check for name that must contain letters or numbers without white spaces
    if (!preg_match("/^(?=[A-Za-z]*[0-9]*)[A-Za-z].{1,18}$/i", $_POST['name'])) {
        $nameEr = "<span style='color:red;'>*please name must contain only numbers and letters without special characters and must start with letter</span>";
        $error = true;
    }
    if (!preg_match("/^[0-9A-Za-z._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i", $_POST['email'])) {
        $emailEr = "<span style='color:red;'>*please enter a valid email of form email@example.com</span>";
        $error = true;
    }
    if (preg_match("/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*\W)(?!.*[\\\<\>])(?!.* ).{8,16}$/", $_POST['pass'])) {
        if ($_POST['pass'] != $_POST['cpass']) {
            $passNotMatch = "<span style='color:red;'>*passwords are not matches</span>";
            $error = true;
        }
    } else {
        $passEr = "<span style='color:red;'>*password must consist from 8-16 characters long contain at least one uppercase and lower case letters, one digit, one special character not allow (< / >)</span>";
        $error = true;
    }

    if (!$error) {
        try {
            require("connect.php");
            $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $name = $_POST['name'];
            $email = $_POST['email'];
            $r = $db->exec("INSERT INTO users(userName,email,password) VALUES('$name','$email','$password')");
            if ($r != 1)
                die("error in inserting values");
            $db = null;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }

        header("location:login.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="SignUp.css">
    <title>Hotel Booking</title>
    <style>
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

        burgerIcon {
            display: none;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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


        /* main style start here */

        .mainrow {

            display: flex;
            flex-wrap: wrap;

        }

        .picture,
        .loginpnal {

            height: 100vh;
            width: 50%;
        }

        .pic {

            width: 100%;
            height: 100%;
        }


        .loginpnal {

            background-color: #143A4F;
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            align-content: center;
            justify-content: center;
            align-items: center;

        }



        .loginpnal h1 {

            font-family: 'Crimson Text';
            font-style: normal;
            font-weight: 700;
            font-size: 48px;
            line-height: 62px;
            text-align: center;

            color: #FFFFFF;

        }

        .info {

            width: 60%;
            margin-left: 100px;
            padding: 65px 0px;

        }

        .info p {

            font-family: 'Roboto';
            font-style: normal;
            font-size: 16px;
            color: #FFFFFF;
            padding: 3px;
        }

        .info a {

            font-family: 'Roboto';
            font-style: normal;
            font-size: 10px;
            color: #6F95F8;
            text-transform: inherit;
            text-decoration: none;

        }

        .ue {
            width: 90%;
            height: 30px;
            background: #FFFFFF;
            border-radius: 5px;
            padding: 20px 0px;

        }

        .info p {

            font-family: 'Roboto';
            font-style: normal;
            font-size: 16px;
            color: #FFFFFF;
        }

        label {

            font-family: 'Roboto';
            font-style: normal;
            font-size: 10px;
            color: #FFFFFF;


        }

        input[type="checkbox" i] {

            box-sizing: border-box;
            border: 1px solid #FFFFFF;
            margin: 0px 5px;
            appearance: auto;
            -webkit-appearance: auto;
            height: 16px;
            width: 18px;
            background-color: #d5d5d5;
            border-radius: 2px;
            cursor: pointer;
        }

        label#l1 {

            font-family: 'Roboto';
            font-style: normal;
            font-weight: 300;
            font-size: 15px;
            line-height: 150%;
            color: #FFFFFF
        }

        label#l1 a {

            color: #8CACFF;
            font-size: 15px;
        }

        .SiginBytton {
            color: white;
            width: 93%;
            height: 40px;
            background: #FF9129;
            border-radius: 5px;
            margin: 35px 0px;
        }

        .SiginBytton:hover {

            width: 93%;
            height: 36px;
            background: #ff9129cc;
        }



        /* main style ends here */





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

            /* picture tablet start */
            div.picture {

                display: flex;
                flex-direction: column;
                width: 100%;
                height: 500px;
            }

            /* picture tablet ends*/



            /* loginpnal tablet start*/
            .loginpnal {

                display: flex;
                flex-direction: column;
                width: 100%;
                height: 700px;

            }

            .loginpnal h1 {

                font-size: 20px;
                margin-top: 10px;
            }

            .info {

                width: 60%;
                margin-left: 100px;
                padding: 10px 0px;
                margin: 3px 0px;

            }

            /* loginpnal tablet ends*/

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
                width: 100%;
            }

            /* nav phone ends*/




            /* picture phone start */
            div.picture {

                display: flex;
                flex-direction: column;
                width: 100%;
                height: 500px;
            }

            /* picture phone ends*/



            /* loginpnal phone start*/
            .loginpnal {

                display: flex;
                flex-direction: column;
                width: 100%;
                height: 600px;

            }

            .loginpnal h1 {

                font-size: 20px;
                margin-top: 10px;
            }

            .info {

                width: 60%;
                margin-left: 100px;
                padding: 10px 0px;
                margin: 3px 0px;

            }



            /* loginpnal phone ends*/

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
            <a href="homePage.php">About Us</a>
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


    <div class="mainrow">


        <div class="picture">
            <img class="pic" src="Img/p4.jpeg" alt="">
        </div>


        <form class="loginpnal" method="post">
            <div class="info">
                <h1> Sign Up </h1>
                <p>Name*</p>
                <input type="text" class="ue" name="name" placeholder="Enter Your Name" />

                <p>Email*</p>
                <input type="text" class="ue" name="email" placeholder="Enter Your Email" />

                <p>Password*</p>
                <input type="password" class="ue" name="pass" placeholder="Enter Your Password" /><br>
                <label> Password must be at least 8 characters.</label>

                <p>Confirm Password*</p>
                <input type="password" class="ue" name="cpass" placeholder="Enter Your Confirm Password" />
                <?php
                if (isset($blanks))
                    echo "<br>" . $blanks;
                else {
                    if (isset($nameEr))
                        echo "<br>" . $nameEr;
                    if (isset($emailEr))
                        echo "<br>" . $emailEr;
                    if (isset($passEr))
                        echo "<br>" . $passEr;
                    else if (isset($passNotMatch))
                        echo "<br>" . $passNotMatch;
                }

                ?>



                <br /><br><br>
                <label id="l1"><input type="checkbox" name="check" for="la">Creating an account means you're okay with
                    our <a href="#"> Terms of Service, Privacy Policy</a>, and our default <a href="#"> Notification
                        Settings.</a></label>
                <br />
                <input type="submit" class="SiginBytton" name="Sigup" value="Create Account">
            </div>
        </form>


    </div>

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