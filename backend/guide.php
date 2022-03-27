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
    <title>24change guide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main-six.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>';
    }

    function get_body()
    {
        $top = get_top_menu("guide");
        $bottom = get_bottom_menu("guide");
        $res = <<<body
<div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-box">
            <div class="top-menu-exchange-box-item">
                <div class="top-menu-exchange-box-item-detail top-menu-exchange-box-item-detail-one">
                    <p>step 1</p>
                    <p>Choose the crypto pair you’d like to exchange. Make sure you are okay with the best rate on the market and the 1% service fee.</p>
                </div>
                <img src="img/undraw_Choose_bwbs%20(1).svg"/>
            </div>
            <div class="top-menu-exchange-box-item">
                <div class="top-menu-exchange-box-item-detail top-menu-exchange-box-item-detail-two">
                    <p>step 2</p>
                    <p>Copy our wallet address related to your currency that you want to exchange and make the payment then, save your transaction link and submit it for us !</p>
                </div>

                <img src="img/undraw_publish_article_icso.svg"/>
            </div>
            <div class="top-menu-exchange-box-item">
                <div class="top-menu-exchange-box-item-detail top-menu-exchange-box-item-detail-three">
                    <p>step 3</p>
                    <p>Submit your destination wallet address and review all information exactly to make sure everything is right.</p>
                </div>
                <img src="img/undraw_link_shortener_mvf6.svg"/>
            </div>
            <div class="top-menu-exchange-box-item">
                <div class="top-menu-exchange-box-item-detail top-menu-exchange-box-item-detail-one">
                    <p>step 4</p>
                    <p>Your transaction has been successfully created and is under processing by us so be patient your transaction will be confirmed about 5 - 30 minutes.</p>
                </div>
                <img src="img/undraw_Choose_bwbs%20(1).svg"/>
            </div>
            <div class="top-menu-exchange-box-item">
                <div class="top-menu-exchange-box-item-detail top-menu-exchange-box-item-detail-two">
                    <p>step 5</p>
                    <p>Until the transaction is under processing, our support partner is ready to get connected with you and following up any problems.</p>
                </div>

                <img src="img/undraw_publish_article_icso.svg"/>
            </div>
        </div>
    </div>
</div>
$bottom
body;
        return $res;
    }

    function get_footer()
    {
        return '<script src="js/jquery.min.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
<script src="js/guide.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    echo get_header();
    echo get_body();
    echo get_footer();
}
?>