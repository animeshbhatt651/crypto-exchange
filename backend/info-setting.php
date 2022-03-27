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
    <title>24Chnage Account Setting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main-four.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>';
    }

    function get_body()
    {
        $top = get_top_menu("setting");
        $bottom = get_bottom_menu("setting");
        return <<<body
<div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-menu">
            <a href="info-setting.php" class="top-menu-exchange-menu-item top-menu-exchange-menu-item-active">
                <p>Information</p>
            </a>
            <a href="wallet-setting.php" class="top-menu-exchange-menu-item ">
                <p>Wallets</p>
            </a>
            <a href="support.php" class="top-menu-exchange-menu-item ">
                <p>Support</p>
            </a>
        </div>
        <div class="top-menu-exchange-col">
            <div class="top-menu-exchange-col-box">
                <p class="top-menu-exchange-col-box-main-title">Your information (only for authorized users)</p>
                <div class="top-menu-exchange-col-box-row-title">
                    <p>First name</p>
                </div>
                <input type="text" class="top-menu-exchange-col-box-input" disabled/>
                <div class="top-menu-exchange-col-box-row-title">
                    <p>Last name</p>
                </div>
                <input type="text" class="top-menu-exchange-col-box-input" disabled/>
                <div class="top-menu-exchange-col-box-row-title">
                    <p>Email</p>
                </div>
                <input type="text" class="top-menu-exchange-col-box-input" disabled/>
            </div>
            <div class="top-menu-exchange-col-sep"></div>
            <div class="top-menu-exchange-col-box">
                <p class="top-menu-exchange-col-box-main-title">create new password</p>
                <div class="top-menu-exchange-col-box-row-title">
                    <p>Current password</p>
                    <p id="old-password-input-error">Current password is invalid</p>
                </div>
                <input id="old-password" type="text" class="top-menu-exchange-col-box-input"/>
                <div class="top-menu-exchange-col-box-row-title">
                    <p>New passoword</p>
                    <p id="new-password-input-error">new password is invalid</p>
                </div>
                <input id="new-password" type="text" class="top-menu-exchange-col-box-input"/>
                <div class="top-menu-exchange-col-box-row-title">
                    <p>Confirm password</p>
                    <p id="new-confirm-password-input-error">Confirm password is invalid</p>
                </div>
                <input id="confirm-password" type="text" class="top-menu-exchange-col-box-input"/>
                <div class="top-menu-exchange-col-box-button-row">
                    <button id="button-submit-setting-change" class="top-menu-exchange-col-box-button">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
$bottom
body;
    }

    function get_footer()
    {
        return '<script src="js/jquery.min.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
<script src="js/setting.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    if (isset($_COOKIE["cs_auth"])) {
        $cookie = $_COOKIE["cs_auth"];
        $res = check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"]);
        if ($res == "s") {
            echo get_header();
            echo get_body();
            echo get_footer();
        } else {
            setcookie("cs_auth", "", time() - 3600);
            header("Location: login.php");
        }
    } else {
        header("Location: login.php");
    }
}
?>