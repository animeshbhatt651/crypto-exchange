<?php
{
    require_once "core.php";
    function get_header()
    {
        return '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    	<meta name="description" content="localhost/ExchangeWebsite/backend is the most simple,secure,reliable and trusted crypto exchanging online platform that providers best rate on the market price and with 1% service fee , Without any limitation or identity verification you can exchange your cryptocurrency fast and easily and support team is ready to get connected with you every time">
    <title>24change Support System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main-eight.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>';
    }

    function get_body($tickets)
    {
        $top = get_top_menu("setting");
        $bottom = get_bottom_menu("setting");
        $res = <<<body
<div class="top-menu">
$top
    <div class="top-menu-exchange">
            <div class="top-menu-exchange-menu">
            <a href="info-setting.php" class="top-menu-exchange-menu-item ">
                <p>Information</p>
            </a>
            <a href="wallet-setting.php" class="top-menu-exchange-menu-item ">
                <p>Wallets</p>
            </a>
            <a href="support.php" class="top-menu-exchange-menu-item top-menu-exchange-menu-item-active">
                <p>Support</p>
            </a>
        </div>
        <div class="top-menu-exchange-box">
            <p class="top-menu-exchange-box-title">support tickets</p>
            <div class="top-menu-exchange-box-row">
                <div class="top-menu-exchange-box-row-left">
                    <p class="top-menu-exchange-box-row-left-title">Subject</p>
                    <input id="subject-text" class="top-menu-exchange-box-row-left-input" type="text"/>
                    <p class="top-menu-exchange-box-row-left-title">Priority</p>
                    <select id="priority-select" class="top-menu-exchange-box-row-left-select">
                        <option value="High">High</option>
                        <option value="Medium">Medium</option>
                        <option value="Low" selected>Low</option>
                    </select>
                    <p class="top-menu-exchange-box-row-left-title">Section</p>
                    <select id="section-select" class="top-menu-exchange-box-row-left-select">
                    	<option name="Technical"selected>Technical</option>
                        <option name="Transactions">Transactions</option>
                        <option name="NeedHelp">Need Help</option>
                        <option name="Feedback">Feedback</option>
                        <option name="Other">Other</option>
                    </select>
                </div>
                <div class="top-menu-exchange-box-row-left">
                    <p class="top-menu-exchange-box-row-left-title">Write down your message here : </p>
                    <textarea class="top-menu-exchange-box-row-left-textarea"></textarea>
                    <button class="top-menu-exchange-box-row-left-button">Send</button>
                </div>
            </div>
            <br>
            <p class="top-menu-exchange-box-title">your tickets status</p>
            <div class="top-menu-exchange-table">
            $tickets
            </div>
$bottom
body;
        return $res;
    }

    function get_footer()
    {
        return '<script src="js/jquery.min.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
<script src="js/support.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    if (isset($_COOKIE["cs_auth"])) {
        $cookie = $_COOKIE["cs_auth"];
        $res = check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"]);
        if ($res == "s") {
            $tickets = get_tickets($cookie, $_SERVER["REMOTE_ADDR"]);
            if ($tickets == "n") {
                $tickets = "there is no tickets";
                echo get_header();
                echo get_body($tickets);
                echo get_footer();
            } else if ($tickets == "i") {
                setcookie("cs_auth", "", time() - 3600);
                header("Location: login.php");
            } else {
                echo get_header();
                echo get_body($tickets);
                echo get_footer();
            }
        } else {
            setcookie("cs_auth", "", time() - 3600);
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
    }
}
?>