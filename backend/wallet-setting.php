<?php
{
    require_once "core.php";
    function get_header()
    {
        $res = <<<body
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    	<meta name="description" content="localhost/ExchangeWebsite/backend is the most simple,secure,reliable and trusted crypto exchanging online platform that providers best rate on the market price and with 1% service fee , Without any limitation or identity verification you can exchange your cryptocurrency fast and easily and support team is ready to get connected with you every time">
    <title>24change Wallet Setting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main-five.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>
body;
        return $res;
    }

    function get_body($trans)
    {
        $top = get_top_menu("setting");
        $bottom = get_bottom_menu("setting");
        return <<<body
<input id="wallet-edit-mod" type="hidden" value=""/>
<div class="body-darker"></div>
<div class="wallet-edit-box">
    <p class="wallet-edit-box-main-title">Edit your wallet</p>
    <p class="wallet-edit-box-row-title">Wallet name</p>
    <input id="edit-box-wallet-name" class="wallet-edit-box-row-input" type="text"/>
    <p class="wallet-edit-box-row-title">Wallet address</p>
    <input id="edit-box-wallet-address" class="wallet-edit-box-row-input wallet-edit-box-row-input-big" type="text"/>
    <div class="wallet-edit-box-button-row">
        <button id="wallet-edit-cancel">Cancel</button>
        <button id="wallet-edit-submit">Submit</button>
    </div>
</div>
<div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-menu">
            <a href="info-setting.php" class="top-menu-exchange-menu-item ">
                <p>Information</p>
            </a>
            <a href="wallet-setting.php" class="top-menu-exchange-menu-item top-menu-exchange-menu-item-active">
                <p>Wallets</p>
            </a>
            <a href="support.php" class="top-menu-exchange-menu-item ">
                <p>Support</p>
            </a>
        </div>
        <div class="top-menu-exchange-wallet-row">
$trans
            <button class="top-menu-exchange-wallet-button-add">Add</button>
        </div>
    </div>
</div>
$bottom
body;
    }

    function get_body_error()
    {
        $top = get_top_menu("setting");
        $bottom = get_bottom_menu("setting");
        return <<<body
<input id="wallet-edit-mod" type="hidden" value=""/>
<div class="body-darker"></div>
<div class="wallet-edit-box">
    <p class="wallet-edit-box-main-title">Edit your wallet</p>
    <p class="wallet-edit-box-row-title">Wallet name</p>
    <input id="edit-box-wallet-name" class="wallet-edit-box-row-input" type="text"/>
    <p class="wallet-edit-box-row-title">Wallet address</p>
    <input id="edit-box-wallet-address" class="wallet-edit-box-row-input wallet-edit-box-row-input-big" type="text"/>
    <div class="wallet-edit-box-button-row">
        <button id="wallet-edit-cancel">Cancel</button>
        <button id="wallet-edit-submit">Submit</button>
    </div>
</div>
<div class="top-menu">
$top
    <div class="top-menu-exchange">
        <div class="top-menu-exchange-menu">
            <a href="info-setting.php" class="top-menu-exchange-menu-item ">
                <p>Information</p>
            </a>
            <a href="wallet-setting" class="top-menu-exchange-menu-item top-menu-exchange-menu-item-active">
                <p>Wallets</p>
            </a>
                        <a href="support.php" class="top-menu-exchange-menu-item ">
                <p>Support</p>
            </a>
        </div>
        <div class="top-menu-exchange-wallet-row">
            <button class="top-menu-exchange-wallet-button-add">Add</button>
        </div>
    </div>
</div>
$bottom
body;
    }

    function get_footer()
    {
        return '<script src="js/jquery.min.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
<script src="js/wallets.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    if (isset($_COOKIE["cs_auth"])) {
        $cookie = $_COOKIE["cs_auth"];
        $res = check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"]);
        if ($res == "s") {
            $transactions = wallet_get($cookie, $_SERVER["REMOTE_ADDR"]);
            echo get_header();
            if ($transactions != "i") {
                $transitems = "";
                foreach ($transactions as $item) {
                    $transitems .= '<div class="top-menu-exchange-wallet-item">
                <p>' . $item["name"] . '</p>
                <p>Wallet adderess</p>
                <p>' . $item["address"] . '</p>
                <div class="wallet-edit-button">
                    <input type="hidden" value="' . $item["address"] . '"/>
                    <input type="hidden" value="' . $item["name"] . '"/>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.665" height="12.667" viewBox="0 0 12.665 12.667">
                        <path d="M12.231 1.918L10.747.434a1.487 1.487 0 0 0-2.1 0L1.264 7.818a.5.5 0 0 0-.084.106l-.006.01a.491.491 0 0 0-.044.112L.018 12.039a.495.495 0 0 0 .612.609l4-1.135a.5.5 0 0 0 .343-.348l.007-.027v-.011A1.8 1.8 0 0 0 4.642 9.6a1.694 1.694 0 0 0-.428-.387l4.372-4.386a.495.495 0 0 0-.7-.7L3.531 8.5a1.81 1.81 0 0 0-.432-.464 1.955 1.955 0 0 0-.417-.242l5.617-5.61 2.182 2.182-4.6 4.588a.495.495 0 1 0 .7.7l5.646-5.634a1.485 1.485 0 0 0 0-2.1zM2.817 9.45a.5.5 0 0 0 .495.495.68.68 0 0 1 .553.265.826.826 0 0 1 .171.442l-2.828.8.791-2.822a.985.985 0 0 1 .51.194.764.764 0 0 1 .313.627zm8.712-6.131l-.348.348-2.182-2.183.351-.351a.5.5 0 0 1 .7 0l1.484 1.484a.495.495 0 0 1 0 .7zm0 0"
                              data-name="083-edit"/>
                    </svg>
                </div>
            </div>';
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