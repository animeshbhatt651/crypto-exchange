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
    <title>24change History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main-three.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>';
    }

    function get_body($trans)
    {
        $top = get_top_menu("transactions");
        $bottom = get_bottom_menu("transactions");
        return <<<body
        <div class="body-darker"></div>
<div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-col">
           $trans
        </div>
    </div>
</div>
$bottom
body;
    }

    function get_body_error()
    {
        $top = get_top_menu("transactions");
        $bottom = get_bottom_menu("transactions");
        return <<<body
        <div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-col">
        <p><center>You don't have any transaction right now !</center></p>
        </div>
    </div>
</div>
$bottom
body;
    }

    function get_footer()
    {
        return '<script src="js/jquery.min.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
<script src="js/transactions.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    if (isset($_COOKIE["cs_auth"])) {
        $cookie = $_COOKIE["cs_auth"];
        $res = check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"]);
        if ($res == "s") {
            $transactions = transaction_get($cookie, $_SERVER["REMOTE_ADDR"]);
            echo get_header();
            if ($transactions != "i") {
                $transitems = "";
                foreach ($transactions as $item) {
                    $info = bill_get_info($item["bill_id"], $cookie, $_SERVER["REMOTE_ADDR"]);
                    $status = $item["status"];
                    if ($status == "pending") {
                        $transitems .= '<div class="top-menu-exchange-transaction top-menu-exchange-transaction-pending">
                <p>' . $info["created_time"] . '</p>
                <p>' . $item["from_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <p>' . $item["from_amount"] . " " . $item["from_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep"></div>
                <p>' . $item["to_sign"] . '</p>
                <p>' . $item["to_amount"] . " " . $item["to_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <p>Pending</p>
            </div>';
                    } else if ($status == "confirm") {
                        $transitems .= '<div class="top-menu-exchange-transaction top-menu-exchange-transaction-confirm">
                <p>' . $info["created_time"] . '</p>
                <p>' . $item["from_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <p>' . $item["from_amount"] . " " . $item["from_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep"></div>
                <p>' . $item["to_sign"] . '</p>
                <p>' . $item["to_amount"] . " " . $item["to_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <p>Confirm</p>
            </div>';
                    } else {
                        $transitems .= '<div class="top-menu-exchange-transaction top-menu-exchange-transaction-rejected">
                <p>' . $info["created_time"] . '</p>
                <p>' . $item["from_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <p>' . $item["from_amount"] . " " . $item["from_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep"></div>
                <p>' . $item["to_sign"] . '</p>
                <p>' . $item["to_amount"] . " " . $item["to_sign"] . '</p>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <div class="top-menu-exchange-transaction-sep top-menu-exchange-transaction-sep-hidden"></div>
                <p>Reject </p>
            </div>';
                    }
                }
                echo get_body($transitems);
            } else {
                echo get_body_error();
            }
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