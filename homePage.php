<?php
session_start();
if (!isset($_SESSION['active'])) {
    header("location:SignUp.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">
    <title>Luxury Rooms&Hotels</title>
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

        .centerBox-modified {
            display: none;
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

        /* main section style start here */
        main {
            width: 100%;
            height: auto;
        }

        /* container1 */
        .container1 {
            width: 100%;
            min-height: 900px;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.4) 62.29%, rgba(0, 0, 0, 0) 100%), url(img/div1bg.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            flex-direction: column;

            align-items: center;

            position: relative;
        }

        /* center title */
        .p1 {
            width: 100%;
            height: 50px;
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 600;
            margin-top: 50px;
            font-size: 24px;
            line-height: 150%;
            text-align: center;
            color: #FFFFFF;
        }

        /* horizontal line */
        .line {
            margin: 30px 0px;
            width: 87px;
            height: 3px;
            background: #FFFFFF;
        }

        /* big center title */
        .p2 {
            width: 700px;
            font-family: 'Times New Roman', Times, serif;
            height: 276px;
            font-weight: 400;
            font-size: 100px;
            text-align: center;
            color: #FFFFFF;
        }



        .orangelB {
            width: 262px;
            margin-top: 90px;
            height: 59px;
            border: none;
            color: white;
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 150%;
            border-radius: 7px;
            background: #FF9129;
        }

        /* center box */
        .centerBox {
            position: absolute;
            width: 936px;
            height: 202px;
            background: #FFFFFF;
            border-radius: 5px;
            display: flex;
            transform: translate(-50%, -50%);
            top: 100%;
            left: 50%;
        }

        /* left white box (inside center box) */
        .leftWhiteBox {
            width: 75%;
            height: 100%;
            border-radius: 5px 0px 0px 5px;
            background: #F2F2F2;
            display: flex;
            justify-content: space-around;
        }

        /* left part */
        .RI {
            border-right: 1px solid #15133C;
            padding-right: 60px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* right part */
        .LE {
            border-left: 1px solid #15133C;
            padding-left: 60px;
            margin-top: 10px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
        }

        .rate {
            padding-top: 7px;
        }

        .star-img {
            padding-bottom: 2px;
        }

        /* center part */
        .CE {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* text inside all parts */
        .leftWhiteBox-divs p {
            text-align: center;
        }



        .one {
            margin-top: 20px;
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 300;
            font-size: 16px;
            line-height: 150%;
            text-align: center;
            color: #000000;
        }

        .two {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 400;
            font-size: 48px;
            line-height: 150%;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .rate-number {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 400;
            font-size: 48px;
            line-height: 100%;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 6px;
            color: #0B1B25;
        }

        .three {
            font-size: 12px;
            line-height: 100%;
        }

        /* right yellow box (inside center box) */
        .rightYellowBox {
            width: 25%;
            height: 100%;
            background: #FFC800;
            border-radius: 0px 5px 5px 0px;
        }

        .rightYellowBox p {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 400;
            font-size: 48px;
            line-height: 100%;
            /* or 48px */
        }

        /* text inside yellow part */
        .rightYellowBox p {
            width: 30%;
            height: 104px;
            font-weight: 400;
            font-size: 48px;
            line-height: 100%;
            padding-top: 50px;
            padding-left: 60px;
            text-align: center;
            color: #000000;
        }



        /* container2 */


        .container3 {
            position: relative;
            width: 100%;
            min-height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: lightgray;
            margin-top: 200px;

        }

        .top {
            position: absolute;
            top: -100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: white;
            width: 100%;
            margin-bottom: 30px;
            background-color: inherit;

        }

        .p3 {
            /* Luxuirous */
            width: 100%;
            height: auto;
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 600;
            font-size: 12px;
            line-height: 150%;
            margin-top: 20px;

            display: block;
            align-items: center;
            text-align: center;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: #73777B;
        }

        .p4 {
            /* Best Rooms */
            width: 100%;
            height: auto;
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 600;
            font-size: 38px;
            line-height: 150%;
            /* or 36px */
            text-align: center;
            color: #000000;
        }

        .container3 .line {
            width: 10%;
            height: 2px;
            background: #000000;
            margin-top: 10px;
        }

        .cards {

            width: 100%;
            height: auto;
            background-color: lightgray;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 30px;
        }

        blockImg img {
            border-radius: 15px 15px 0px 0px;
            width: 100%;
            object-fit: cover;
            height: 350px;
        }

        .cd {
            width: 30%;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            box-shadow: 5px 4px 15px rgba(0, 0, 0, 0.18);
            border-radius: 19px;
            margin-top: 30px;
            background-position: bottom;
        }

        detailsBlock {
            padding: 10px 20px 20px 20px;
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-top: 15px;

        }

        detailsBlock p {
            margin-top: 10px;
            font-style: normal;
            font-weight: 400;
            font-size: 15px;
            line-height: 160%;
        }

        .cd rate {
            margin-top: 10px;
        }

        .cd rate img {
            width: 20px;
        }

        detailsBlock h2 {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 600;
            font-size: 24px;
            line-height: 150%;
            text-transform: capitalize;
            color: #000000;
        }


        detailsBlock price {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 160%;
        }

        detailsBlock button {
            background: #15133C;
            border-radius: 7px;
            width: 199px;
            color: white;
            margin-top: 10px;
            padding: 10px;
        }

        .orange2 {
            width: 262px;
            height: 59px;
            left: 591px;
            top: 609px;
            margin: 20px 0px;
            background: #FF9129;
            border-radius: 7px;
            border: none;
            color: white;
            font-style: normal;
            font-weight: 500;
            font-size: 20px;
            line-height: 150%;
        }


        .container4 {
            width: 100%;
            height: auto;
            background: #15133C;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .img {
            width: 50%;
            height: auto;
        }

        .img img {
            width: 100%;
            height: 100%;
        }

        .para {
            width: 45%;
            display: flex;
            flex-direction: column;
        }

        .pa1 {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 160%;
            letter-spacing: 0.165em;
            text-transform: uppercase;
            color: #B4B4B4;
            margin-top: 100px;
        }

        .pa2 {
            width: 455px;
            height: auto;
            font-family: 'Times New Roman', Times, serif;
            font-weight: 600;
            font-size: 64px;
            line-height: 127%;
            color: #FFFFFF;
        }

        .pa2 span {
            width: 455px;
            height: 165px;
            font-weight: 600;
            font-size: 64px;
            line-height: 127%;
            font-family: 'Times New Roman', Times, serif;
            color: #FFC700;
        }


        .pa3 p {
            width: 429px;
            height: auto;
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-weight: 600;
            font-size: 15px;
            line-height: 165%;
            color: #FFFFFF;
        }

        .pa3 p:nth-of-type(1) {
            margin: 30px 0px;
        }

        .readMore {
            width: 206px;
            height: 48px;
            left: 847px;
            top: 4009px;
            background: #FFC800;
            border-radius: 7px;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
            border: none;
            margin: 40px 0px;
            font-style: normal;
            font-weight: 600;
            font-size: 15px;
            line-height: 160%;
        }

        .readMore a {
            text-decoration: none;
            font-size: 20px;
            color: #FFFFFF;
        }

        /* main section style ends here */

        /* footer style start here */
        footer {
            display: flex;
            justify-content: space-between;
            padding: 30px;
            width: auto;
            height: 400px;
            background: #2F414B;
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

            .p1 {
                font-size: 20px;
            }

            .p2 {
                font-size: 80px;
            }

            .orangelB {
                font-size: 15px;
                width: 200px;
                margin-top: 60px;
            }

            .centerBox {
                width: 800px;
            }

            .rightYellowBox p {
                width: 30%;
            }

            .LE {
                padding-left: 35px;
            }

            .img {
                width: 100%;
            }

            .para {
                width: 100%;
                align-items: center;
                text-align: center;
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

            .cd {
                width: 45%;
            }

            .cards {
                padding: 20px;
            }

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

            .container2 {
                margin-top: 30px;
            }

            .container2-text {
                width: 100%;
                align-items: center;
                text-align: center;
            }

            .centerBox {
                display: none;
            }

            .imgRightBox {
                margin-top: 50px;
                width: 100%;

            }

            /* main starts between tablet and phone*/

            .centerBox-modified {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .line2 {
                background: #15133C;
                border-radius: 20px;
                width: 150px;
                height: 1px;
            }

            .cards {
                flex-direction: column;
                align-items: center;
            }

            blockimg {
                width: 100%;

            }

            blockImg img {
                border-radius: 17px 17px 0px 0px;
                width: 100%;
            }

            .cd {
                width: 80%;
            }

            .p1-m {
                width: 100%;
                text-align: center;
                font-family: Arial, Helvetica, sans-serif;
                font-style: normal;
                font-weight: 300;
                font-size: 16px;
                line-height: 150%;
                margin-top: 30px;
            }

            .p2-m {
                font-family: 'Times New Roman', Times, serif;
                margin-top: 20px;
                font-style: normal;
                font-weight: 400;
                font-size: 48px;
                line-height: 150%;
            }

            .p3-m {
                font-family: 'Times New Roman', Times, serif;
                font-style: normal;
                font-weight: 600;
                font-size: 14px;
                line-height: 150%;
                text-align: center;
                margin-bottom: 20px;
            }

            .number-m {
                font-family: 'Times New Roman', Times, serif;
                font-style: normal;
                font-weight: 400;
                font-size: 48px;
                line-height: 100%;
                text-align: center;
                color: #0B1B25;
                margin: 20px 0px;
            }

            /* main end between tablet and phone*/

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
            }

            /* nav phone ends*/

            .p2 {
                width: 500px;
                font-size: 50px;
                margin-top: 40px;
            }

            .orange2 {
                margin: 40px 0px;
            }

            .pa2 {
                font-size: 58px;
            }

            .pa3 p {
                min-width: 300px;
                font-size: 13px;
            }

            .orangelB {
                margin-top: 30px;
                font-size: 18px;
                font-weight: 500;
            }

            /* footer phone start*/
            footer {

                flex-direction: column;
                align-items: center;
                padding: 10px;
                width: auto;
                height: auto;
                background: #2F414B;
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
    <!--make 4 container inside one main-->
    <main>
        <!--start container1-->
        <div class="container1">
            <!--center title-->
            <p class="p1">Luxury Rooms & Hotels</p>
            <!--horizontal line-->
            <div class="line"></div>
            <!--big center title-->
            <p class="p2">Enjoy A Luxury Experience</p>
            <!--center button-->
            <form action="findPassion.php" method="post">
                <input type="submit" class="orangelB" value="Reserve Now">
            </form>
            <!-- <button class="orangelB">Reserve Now</button> -->
            <!--start center box-->
            <div class="centerBox">
                <!--start left white box (inside center box)-->
                <div class="leftWhiteBox">
                    <!--divided the white part into 3 div-->
                    <!--left part-->
                    <div class="leftWhiteBox-divs RI">
                        <p class="one">CUSTOMES</p>
                        <p class="two">+300</p>
                        <p class="three">Happy Customers</p>
                    </div>
                    <!--center part-->
                    <div class="leftWhiteBox-divs CE">
                        <p class="one">ROOMS</p>
                        <p class="two">+2500</p>
                        <p class="three">Room Avalilable</p>
                    </div>
                    <!--right part-->
                    <div class="leftWhiteBox-divs LE">
                        <div>
                            <p class="one">RATES</p>
                        </div>
                        <div class="rate">
                            <p style='font-size:45px' class="rate-number">4.6</p>
                        </div>
                        <!--stars rate-->
                        <div class="star-img">
                            <img src="img/star.png" alt="">
                            <img src="img/star.png" alt="">
                            <img src="img/star.png" alt="">
                            <img src="img/star.png" alt="">
                            <img src="img/star.png" alt="">
                        </div>
                        <div>
                            <p class="three">Over 200 Rateings</p>
                        </div>
                    </div>
                </div>
                <!--end left white box (inside center box)-->
                <!--start right yellow box (inside center box)-->
                <div class="rightYellowBox">
                    <p>Until Now</p>
                </div>
                <!--end right yellow box (inside center box)-->
            </div>
            <!--end center box-->
        </div>
        <!--end container1-->

        <div class="centerBox-modified">
            <p class="p1-m">CUSTOMES</p>
            <p class="p2-m">+300</p>
            <p class="p3-m">Happy Customers</p>
            <div class="line2"></div>
            <p class="p1-m">ROOMS</p>
            <p class="p2-m">+2500</p>
            <p class="p3-m">Room Available</p>
            <div class="line2"></div>
            <p class="p1-m">RATES</p>
            <p class="number-m">4.6</p>
            <div class="star-img">
                <img src="img/star.png" alt="">
                <img src="img/star.png" alt="">
                <img src="img/star.png" alt="">
                <img src="img/star.png" alt="">
                <img src="img/star.png" alt="">
            </div>
            <p class="p3-m">Over 200 Rateings</p>
        </div>





        <!--start container2-->

        <!--end container2-->


        <!-------------------------- code of PHP starts here -------------------->
        <div class="container3">
            <div class="top">
                <p class="p3">Luxuirous</p>
                <p class="p4">Best Rooms</p>
                <div class="line"></div>
            </div>
            <div class="cards">
                <?php

                try {
                    require("connect.php");
                    $r = $db->query("SELECT * FROM room");


                    foreach ($r as $row) {
                ?>
                        <!-- card 1 -->
                        <form class="cd" method="POST" action="Product.php?id=<?php echo $row[0]; ?>">
                            <blockImg>
                                <img class="card-img" src="roomImges/<?php echo $row[5]; ?>">
                            </blockImg>
                            <detailsBlock>
                                <h2><?php echo $row[1]; ?></h2>
                                <p><?php echo $row[2]; ?></p>
                                <price><?php echo $row[3]; ?>$ Per Night </price>
                                <rate>
                                    <?php for ($i = 0; $i < round($row[4]); $i++) { ?>
                                        <img src="star.svg" alt="start-rate">
                                    <?php } ?>
                                </rate>
                                <button type="submit">Book Now</button>
                            </detailsBlock>
                        </form>

                <?php
                    }
                    $db = null;
                } catch (PDOException $e) {
                    die("error: " . $e->getMessage());
                }

                ?>
            </div>
            <form action="findPassion.php" method="post">
                <input type="submit" class="orange2" value="Discover all Rooms">
            </form>
            <!-- <button class="orange2">Discover all Rooms</button> -->
        </div>


        <div class="container4">
            <div class="img">
                <img src="img/leftSide.jpeg" alt="">
            </div>
            <div class="para">
                <p class="pa1">Luxury Hotels & Rest Rooms</p>
                <p class="pa2">Discover Our <span>locations</span></p>
                <div class="pa3">
                    <p>Interdum et malesuada fames ac ante ipsum primis in faucibus.
                        Sed posuere egestas nunc ut tempus. Fusce sagittis bibendum est.
                        Pellentesque eu tortor euismod, varius odio ac, auctor arcu. Nam mauris
                        neque, dictum ac velit ut, ultricies efficitur sapien.</p>

                    <p>Vestibulum in velit in elit pharetra commodo ac vel justo. Nulla facilisi.
                        Praesent aliquet lorem dolor, vitae sodales felis sodales eu.
                        Aenean semper mi vitae urna luctus, luctus auctor lacus eleifend. Pellentesque id mauris
                        non neque dapibus pretium eu eu neque. Praesent dictum justo erat, ac rutrum tellus feugiat at.
                    </p>
                </div>
                <form action="aboutUs.php" method="post">
                    <input type="submit" class="readMore" value="Read More">
                </form>
                <!-- <button class="readMore">Read More</button> -->
            </div>
        </div>

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