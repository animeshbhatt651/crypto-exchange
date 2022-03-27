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
    <title>24change currencies stat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main-seven.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>';
    }

    function get_body($trans)
    {
        $top = get_top_menu("exchange");
        $bottom = get_bottom_menu("exchange");
        return <<<body
        <div class="body-darker"></div>
<div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-box">
            <p class="top-menu-exchange-box-title">Here you can see the list of currencies which are accepted by our platform, All coin price will be updated every 5 seconds</p>
            <div class="top-menu-exchange-table-title">
                <p>sign</p>
                <p>coin</p>
                <p>price</p>
                <p>change(24h)</p>
                <p>sign</p>
                <p>coin</p>
                <p>price</p>
                <p>change(24h)</p>
            </div>
            <div class="top-menu-exchange-table">
            $trans
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
<script src="js/allcr.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    $res = all_currencies_get();
    echo get_header();
    echo get_body($res);
    echo get_footer();

}
?>