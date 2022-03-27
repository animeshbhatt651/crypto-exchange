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
    <title>24change main</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>

</head>
<body>';
    }

    function get_body()
    {
        $top = get_top_menu("exchange");
        $bottom = get_bottom_menu("exchange");
        $crypto_receive = get_cryptos();
        $crypto_send = get_cryptos(true);
        $main_prices = get_main_prices();
        $trans = main_get_transactions();
        if ($trans == "i") {
            $trans = "nothing";
        } else {
            $trans = implode($trans);
        }
        $res = <<<body
<input id="currency-send" type="hidden" value="BTC"/>
<input id="currency-receive" type="hidden" name="currency-receive" value="ETH"/>
<div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-box">
            <div id="box-select" class="top-menu-exchange-box-crypto-box">
                <div id="select-send" class="top-menu-exchange-box-cryptoselect send">
                    <div>
                        <img id="selector-send-currency-image" src="img/btc.svg"/>
                        <p id="selector-send-currency-name">Bitcoin</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.2 6.417">
                        <path id="_131-down-chevron" fill="#555"
                              d="M5.106 6.419a1.189 1.189 0 0 1-.835-.34L.359 2.237a1.2 1.2 0 0 1 0-1.706L.545.346a1.2 1.2 0 0 1 1.69.013L5.11 3.281 7.969.385a1.2 1.2 0 0 1 1.7-.008l.181.182a1.2 1.2 0 0 1-.008 1.7L8.567 3.518a.4.4 0 0 1-.56-.567L9.283 1.69a.4.4 0 0 0 0-.567L9.1.941a.4.4 0 0 0-.567 0l-3.14 3.188a.4.4 0 0 1-.284.119.4.4 0 0 1-.284-.119L1.667.918a.4.4 0 0 0-.563 0L.916 1.1a.4.4 0 0 0 0 .569L4.828 5.51a.4.4 0 0 0 .557 0l1.189-1.165a.4.4 0 0 1 .557.57L5.943 6.077a1.189 1.189 0 0 1-.835.342zm0 0"
                              data-name="131-down-chevron" transform="translate(0 -.002)"/>
                    </svg>
                    $crypto_send
                </div>
                <div class="top-menu-exchange-box-cryptoselect-swap">
                    <div class="top-menu-exchange-box-cryptoselect-swap-child">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17.011" height="17.044"
                             viewBox="0 0 17.011 17.044">
                            <path id="_125-refresh" fill="#49de61"
                                  d="M8.989 17.044h-.014a.666.666 0 0 1 0-1.332h.012a7.191 7.191 0 0 0 5.581-11.727 1.4 1.4 0 0 1 .092-1.875l.78-.777h-2.5a.325.325 0 0 0-.325.325V4.17a.666.666 0 0 1 .841 1.023l-.256.267-.005.005a1.117 1.117 0 0 1-1.906-.789V1.658A1.656 1.656 0 0 1 12.942 0h3.018a1.117 1.117 0 0 1 .789 1.906L15.6 3.053a.068.068 0 0 0 0 .091 8.522 8.522 0 0 1-6.611 13.9zm-2.749-.485a1.645 1.645 0 0 0 .485-1.172v-3.018a1.117 1.117 0 0 0-1.906-.789l-.005.005-.261.267a.666.666 0 0 0 .841 1.023v2.513a.325.325 0 0 1-.325.325h-2.5l.78-.777a1.4 1.4 0 0 0 .093-1.875 7.191 7.191 0 0 1 5.58-11.729h.012A.666.666 0 0 0 9.036 0h-.014a8.522 8.522 0 0 0-6.611 13.9.068.068 0 0 1 0 .091L1.26 15.137a1.117 1.117 0 0 0 .79 1.906h3.018a1.646 1.646 0 0 0 1.171-.485zm0 0"
                                  data-name="125-refresh" transform="translate(-.5)"/>
                        </svg>
                    </div>
                </div>
                <div id="select-receive" class="top-menu-exchange-box-cryptoselect receive">
                    <div>
                        <img id="selector-receive-currency-image" src="img/eth.svg"/>
                        <p id="selector-receive-currency-name">Ethereum</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10.2 6.417">
                        <path id="_131-down-chevron" fill="#555"
                              d="M5.106 6.419a1.189 1.189 0 0 1-.835-.34L.359 2.237a1.2 1.2 0 0 1 0-1.706L.545.346a1.2 1.2 0 0 1 1.69.013L5.11 3.281 7.969.385a1.2 1.2 0 0 1 1.7-.008l.181.182a1.2 1.2 0 0 1-.008 1.7L8.567 3.518a.4.4 0 0 1-.56-.567L9.283 1.69a.4.4 0 0 0 0-.567L9.1.941a.4.4 0 0 0-.567 0l-3.14 3.188a.4.4 0 0 1-.284.119.4.4 0 0 1-.284-.119L1.667.918a.4.4 0 0 0-.563 0L.916 1.1a.4.4 0 0 0 0 .569L4.828 5.51a.4.4 0 0 0 .557 0l1.189-1.165a.4.4 0 0 1 .557.57L5.943 6.077a1.189 1.189 0 0 1-.835.342zm0 0"
                              data-name="131-down-chevron" transform="translate(0 -.002)"/>
                    </svg>
                    $crypto_receive
                </div>
            </div>
            <div class="top-menu-exchange-box-sep"></div>
            <div id="box-value" class="top-menu-exchange-box-crypto-box">
                <p class="top-menu-exchange-box-cryptoresult-title">You send</p>
                <div id="value-send" class="top-menu-exchange-box-cryptoresult send">
                    <input id="amount-send" type="text" value="0.32"/>
                    <p id="send-currency">BTC</p>
                </div>
                <p class="top-menu-exchange-box-cryptoresult-title">You receive</p>
                <div id="value-receive" class="top-menu-exchange-box-cryptoresult receive">
                    <input id="amount-receive" type="text" value="0.1"/>
                    <p id="receive-currency">ETH</p>
                </div>
            </div>
        </div>
        <button id="main-ex-one-submit" class="top-mneu-exhcnage-button">Next</button>
    </div>
</div>
<div class="main-row">
    <div class="main-item">
        <div class="main-title">
            <p>prices</p>
            <a href="main-all-currencies.php">+ More</a>
        </div>
        $main_prices
    </div>
    <div class="main-item">
        <div class="main-title">
            <p>transactions</p>
            <a>+ More</a>
        </div>
        <div class="main-transactions">
        $trans
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
<script src="js/main.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
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