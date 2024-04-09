<?php
session_start();
if (!isset($_SESSION['active']))
    header("location:SignUp.php");
$rid = $_GET['id'];
$uid = $_SESSION['active'];
if (isset($_POST['sub'])) {
    $error = false;
    if ($_POST['ta'] == trim("") || $_POST['rt'] == trim("")) {
        $error = true;
        $noth = "<span style='color:red;'>*please full all the blanks.</span>";
    }
    if (!preg_match("/^[1-5]$/i", $_POST['rt'])) {
        $error = true;
        $rateError = "<span style='color:red;'>*please rate must be from 1-5 only.</span>";
    }
    if (!preg_match("/^(?!\W)[A-Za-z_\- ,\.\"]+$/i", $_POST['ta'])) {
        $error = true;
        $comError = "<span style='color:red;'>*please comment must consist from letters only no special character allowed or single quotation is allowed.</span>";
    }
    //to check weather the user is reserve the room or not
    try {
        require("connect.php");
        $v = $db->query("SELECT * FROM reservation where rid='$rid' AND uid='$uid'");
        if ($v->rowCount() == 0) {
            $error = true;
            $notReserve = "<span style='color:red;'>*please you must reserve this room in order to rate it<span>";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    //if there are not errors in inputs or reserving the room, user can comment
    if (!$error) {
        try {
            require('connect.php');
            $rate = $_POST['rt'];
            $comment = $_POST['ta'];
            $c = $db->exec("INSERT INTO comment values('$uid','$rid','$rate','$comment')");
            if ($c == 0) {
                die("error in inserting the comment.");
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
//this for booking reseravations first part of the page
if (isset($_POST['book'])) {
    $startD = date('Y-m-d', strtotime($_POST['sd']));
    $endD = date('Y-m-d', strtotime($_POST['ed']));
    try {
        require("connect.php");
        $reserError = false;
        $check = $db->query("SELECT * FROM reservation where rid='$rid' AND uid='$uid'");
        if ($check->rowCount() == 1) {
            $reserError = true;
            $reError = "<span style='color:red;'>*you reserve this room already.</span>";
        }
        if ($_POST['sd'] == trim("") || $_POST['ed'] == trim("")) {
            $reserError = true;
            $bothdateEr = "<span style='color:red;'>*plase chose start and end dates.</span>";
        }
        require("extra.php");
        if (getdaydiffer($_POST['sd'], $_POST['ed']) > 30) {
            $reserError = true;
            $yearError = "<span style='color:red;'>*you can reserve the room at maxumim 30 day.</span>";
        }
        if (checkStartDate($_POST['sd']) != trim("")) {
            $reserError = true;
            $startError = checkStartDate($_POST['sd']);
        }
        if (!$reserError) {
            $id = $_POST['loc'];
            $price = $_POST['pr'];
            header("location:finsh.php?id=$id&sr=$startD&ed=$endD&pr=$price");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
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
        /* product css ready */
        html {
            height: 100% !important;
        }

        comment h5 {
            text-align: center;
            width: 100%;
            font-family: 'Times New Roman', Times, serif;
            font-size: 30px;
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


        /*----------------------------------------- card codes ------------------------------------*/
        .container3 {
            width: 100%;
            min-height: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: lightgray;
            margin-top: 30px;

        }

        .top {
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



        /*----------------------------------------- card codes ends ------------------------------------*/
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
            width: 100%;
            height: auto;
        }

        /* first page section */

        div.info {
            display: flex;
            width: 100%;
            flex-direction: row;
            height: auto;
            padding: 30px;
        }

        div.content {
            width: 50%;
            display: flex;
            height: auto;
            flex-direction: column;
            justify-content: space-around;

        }

        div.content p {
            width: 80%;
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            font-size: 19px;
            line-height: 160%;
        }

        div.content .line {
            width: 80%;
            height: 4px;
            background: #FF9129;
        }

        div.content h4 {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 600;
            font-size: 48px;
            line-height: 150%;
            text-transform: capitalize;
            color: #000000;
        }

        div.content rate {
            margin-top: 10px;
        }

        div.content .price {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 160%;
        }

        div.content form {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: space-between;
            width: 95%;
        }

        .upper-form {
            display: flex;
            width: 100%;
            justify-content: space-between;
            margin-bottom: 20px;

        }

        div.content form input[type="submit"] {
            background: #15133C;
            border-radius: 8px;
            width: 150px;
            padding: 10px;
            color: white;
        }

        div.content form lable {
            font-family: 'Times New Roman', Times, serif;
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 160%;
        }





        div.picture {
            display: flex;
            width: 50%;
            justify-content: center;
        }

        div.picture img {
            width: 100%;
        }

        /* first page section ends */

        /*comment section start */
        comment {
            width: 100%;
            display: flex;
            flex-direction: column;
            padding: 50px;

        }

        comment h2 {
            font-family: 'Roboto';
            font-style: normal;
            font-weight: 400;
            font-size: 20px;
            line-height: 160%;
        }

        comment div.line2 {
            width: 100%;
            height: 1px;
            background-color: black;
            margin-bottom: 20px;
        }

        .personImage {

            width: 10%;

        }



        .comment {
            display: flex;
            margin: 2% 0px;
        }



        .details {
            width: 80%;
        }

        .rate {
            display: flex;
            width: 20%;
            margin-left: 30px;
        }

        .rate img {
            width: 20px;
            height: 20px;
        }

        .nameRate {
            display: flex;
            width: 60%;
            font-size: 15px;
            font-weight: 900;
            font-family: Arial, Helvetica, sans-serif;
        }

        .personImage img {

            border-radius: 50%;
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        conservation {
            display: flex;
            width: 100%;
            justify-content: center;

        }

        infoPerson {
            margin-bottom: 30px;
        }

        conservation form button {
            margin-top: 20px;
            width: 90px;
            height: 40px;
            border-radius: 7px;
            background: #73777B;
            border: none;
            color: white;
        }

        comment h4 {
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 163.15%;


        }

        .conver {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            margin: 3% 0px;
        }

        .conver h4 {
            margin: 30px 0px;
        }




        /* media quries for tablet */
        @media (max-width: 1024px) {
            .cd {
                width: 45%;
            }

            .cards {
                padding: 20px;
            }

            .nameRate {
                width: 100%;
            }

            .nameRate h4 {
                font-size: 15;
            }

            .content p {
                margin-top: 30px;
            }

            .personImage {
                width: 20%;
            }

            .details {
                width: 70%;
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

            div.content form {
                width: 95%;
            }

            div.info {
                flex-direction: column;
                justify-content: space-between;
                align-items: center;
                padding: 20px;
            }

            div.picture img {
                width: 100%;

            }

            div.picture {
                margin-top: 90px;
                width: 100%;
            }

            div.content form {
                margin-top: 50px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            div.upper-form {
                width: 100%;
            }



            /* .conver .personImage {
        margin-right: 120px;

            div.buttom-form {
                display: flex;
                justify-content: center;
                margin-top: 40px;
            }

            div.content {
                width: 100%;
                flex-direction: column;
                align-items: center;
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
        @media (max-width: 750px) {

            .cards {
                flex-direction: column;
                align-items: center;
            }

            blockimg {
                width: 100%;

            }

            blockImg img {
                border-radius: 17px 17px 0px 0px;
            }


            .cd {
                width: 80%;
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


            div.info {
                padding: 10px;
            }

            div.details {
                width: 100%;
            }

            div.comment {
                flex-direction: column;
                align-items: center;
                text-align: center;
                margin: 5% 0px;

            }



            .nameRate {
                width: 80%;
            }

            comment {
                padding: 20px;
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
            <li> <a href="addItem.php">Add item</a></li>
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
    <!---------------------------- Product code ---------------------------->
    <?php
    try {
        require("connect.php");
        $r = $db->query("SELECT rate from comment where rid='$rid'");
        if ($r->rowCount() > 0) {
            $totalrate = 0.0;
            foreach ($r as $row) {
                $totalrate += $row[0];
            }
            $totalrate /= $r->rowCount();
        } else
            $totalrate = 0;

        $n = $db->exec("UPDATE room SET rate='$totalrate' where id='$rid'");
        if ($n < 0) {
            die("there is a problem in update the room rate");
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
    ?>
    <main>
        <div class="info">
            <?php
            try {
                require("connect.php");
                $rid = $_GET['id'];
                $r = $db->query("SELECT * FROM room where ID='$rid'");

                foreach ($r as $row) {
            ?>
                    <div class="content">
                        <h4><?php echo $row[1]; ?></h4>
                        <div class="line"></div>
                        <p><?php echo $row[2]; ?></p>
                        <p class="price">Price: <?php echo $row[3]; ?>$/night</p>
                        <rate>
                            <?php
                            for ($i = 0; $i < round($row[4]); $i++) {
                            ?>
                                <img src="star.svg" alt="">
                            <?php } ?>
                        </rate>
                        <form action="" method="POST">
                            <div class="upper-form">
                                <lable>Start day:</lable><input type="date" name="sd"><br>
                                <lable>End day:</lable><input type="date" name="ed"><br>
                            </div>
                            <div class="buttom-form">
                                <input type="submit" value="Book Now" name="book">
                            </div>
                            <?php
                            if (isset($reError))
                                echo $reError . "<br>";
                            else {
                                if (isset($bothdateEr))
                                    echo $bothdateEr . "<br>";
                                else {
                                    if (isset($yearError))
                                        echo $yearError . "<br>";
                                    if (isset($startError))
                                        echo $startError . "<br>";
                                }
                            }
                            ?>
                            <input type="hidden" name="loc" value="<?php echo $row[0]; ?>">
                            <input type="hidden" name="pr" value="<?php echo $row[3]; ?>">
                        </form>
                    </div>
                    <div class="picture"><img src="roomImges/<?php echo $row[5]; ?>" alt="room-imge">
                    </div>

            <?php  }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }
            ?>
        </div> <!-- end of class product inf-->

        <comment>
            <h2>Comment Section</h2>
            <div class="line2"></div>
            <?php
            try {
                require("connect.php");
                $rc = $db->query("SELECT * FROM comment where rid='$rid'");
                if ($rc->rowCount() == 0) {
                    echo "<h5> There are no comments for this room yet </h5>";
                } else {
                    foreach ($rc as $row) {
            ?>
                        <div class="comment">
                            <!-- comment number 1-->
                            <div class="personImage"><img src="meta/Persons/<?php
                                                                            $ucommentId = $row[0];


                                                                            $ru = $db->query("SELECT userName,picture FROM users where ID='$ucommentId'");
                                                                            $rowu = $ru->fetch();
                                                                            echo $rowu[1];
                                                                            ?>" alt="person-imge"></div>
                            <div class="details">

                                <div class="nameRate">
                                    <h4><?php echo $rowu[0]; ?></h4>

                                    <div class="rate">
                                        <?php
                                        for ($i = 0; $i < $row[2]; $i++) {
                                        ?>
                                            <img src="star.svg">
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <p><?php echo $row[3]; ?></p>
                            </div>

                        </div> <!-- comment ends here -->
            <?php   }
                }
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            } ?>

            <div class="conver">
                <h4>Join the Conservation</h4>
                <conservation>
                    <?php
                    try {
                        $uidcomment = $_SESSION['active'];
                        require("connect.php");
                        $ruc = $db->query("SELECT picture from users where ID='$uidcomment'");
                        $rowuc = $ruc->fetch();
                        $uPicture = $rowuc[0];

                    ?>
                        <div class="personImage"><img src="meta/Persons/<?php echo $uPicture; ?>" alt="user-imge"></div>
                        <!-- here we try to submit user comment within the same page and added to database -->
                        <form action="" method="post">
                            <textarea name="ta" cols="30" rows="5"></textarea> <br>
                            Rate: <input type="text" size="3" name="rt"><br>
                            <?php
                            if (!isset($notReserve)) {
                                if (isset($noth))
                                    echo $noth . "<br>";
                                else {
                                    if (isset($comError))
                                        echo $comError . "<br>";
                                    if (isset($rateError))
                                        echo $rateError . "<br>";
                                }
                            } else
                                echo $notReserve . "<br>";

                            ?>
                            <button type="submit" name="sub">Post</button>
                        </form>

                    <?php  } catch (PDOException $e) {
                        die("Error: " . $e->getMessage());
                    } ?>

                </conservation>
            </div>
        </comment>

        <!--start of container of cards-->

        <div class="container3">
            <div class="top">
                <p class="p3">Luxuirous</p>
                <p class="p4">Best Rooms</p>
                <div class="line"></div>
            </div>
            <div class="cards">

                <!-- card 1 -->

                <?php

                try {
                    require("connect.php");
                    $r = $db->query("SELECT * FROM room");


                    $count = 0;
                    foreach ($r as $row) {
                        if ($count == 3)
                            break;
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
                        $count++;
                    }
                    $db = null;
                } catch (PDOException $e) {
                    die("error: " . $e->getMessage());
                }

                ?>

            </div>
            <button class="orange2" onclick="goMethod()">Discover all Rooms</button>

        </div>



    </main>
    <!---------------------------- Product code ends ---------------------------->
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

        function goMethod() {
            location.href = "findPassion.php";
        }
    </script>

</body>

</html>