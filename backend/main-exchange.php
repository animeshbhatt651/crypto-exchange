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
    <title>24change exchanging</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
    <link rel="stylesheet" href="css/top-menu.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
    <link rel="stylesheet" href="css/style-main-two.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>';
    }

    function get_body($id, $from, $to, $fromamount, $toamount, $walletstr, $havewallet = "true")
    {
        $array_nourl = [
            "PSV"
        ];
        $top = get_top_menu("exchange");
        $bottom = get_bottom_menu("exchange");
        $ourwallettext = <<<body
        <p class="top-menu-exchange-col-title">Wallet address</p>
        <div class="top-menu-exchange-col-input-row">
            <div class="top-menu-exchange-col-input">
                <input id="our-wallet-address" value="rgsvawets5hbvted2hbg2RWAG2B5VrwsbvSCdwr5hsWBVWAGSBF6c" type="text"
                       readonly="true"/>
                <svg class="copy" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                    <path id="_070-polaroids" fill="#555"
                          d="M21.14 14.266a.859.859 0 0 0 .86-.86V6.875a3.441 3.441 0 0 0-3.437-3.437h-1.719A3.441 3.441 0 0 0 13.406 0H3.437A3.441 3.441 0 0 0 0 3.437v11.688a3.441 3.441 0 0 0 3.437 3.437h1.719A3.437 3.437 0 0 0 8.594 22h9.969A3.441 3.441 0 0 0 22 18.562V17.7a.859.859 0 0 0-.859-.859h-2.579a.859.859 0 0 0 0 1.719h1.719a1.721 1.721 0 0 1-1.719 1.719H8.594a1.718 1.718 0 0 1-1.719-1.719h6.531a3.441 3.441 0 0 0 3.437-3.437V5.156h1.719a1.721 1.721 0 0 1 1.719 1.719v6.531a.859.859 0 0 0 .859.86zm-7.734 2.578H3.437a1.721 1.721 0 0 1-1.719-1.719V3.437a1.721 1.721 0 0 1 1.719-1.718h9.969a1.721 1.721 0 0 1 1.719 1.719v9.969H4.3a.859.859 0 0 0 0 1.719h10.825a1.721 1.721 0 0 1-1.719 1.718zm0 0"
                          data-name="070-polaroids"/>
                </svg>
            </div>

            <button class="top-menu-exchange-col-input-copy copy">
                <p>Copy</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                    <path id="_070-polaroids" fill="#555"
                          d="M21.14 14.266a.859.859 0 0 0 .86-.86V6.875a3.441 3.441 0 0 0-3.437-3.437h-1.719A3.441 3.441 0 0 0 13.406 0H3.437A3.441 3.441 0 0 0 0 3.437v11.688a3.441 3.441 0 0 0 3.437 3.437h1.719A3.437 3.437 0 0 0 8.594 22h9.969A3.441 3.441 0 0 0 22 18.562V17.7a.859.859 0 0 0-.859-.859h-2.579a.859.859 0 0 0 0 1.719h1.719a1.721 1.721 0 0 1-1.719 1.719H8.594a1.718 1.718 0 0 1-1.719-1.719h6.531a3.441 3.441 0 0 0 3.437-3.437V5.156h1.719a1.721 1.721 0 0 1 1.719 1.719v6.531a.859.859 0 0 0 .859.86zm-7.734 2.578H3.437a1.721 1.721 0 0 1-1.719-1.719V3.437a1.721 1.721 0 0 1 1.719-1.718h9.969a1.721 1.721 0 0 1 1.719 1.719v9.969H4.3a.859.859 0 0 0 0 1.719h10.825a1.721 1.721 0 0 1-1.719 1.718zm0 0"
                          data-name="070-polaroids"/>
                </svg>
            </button>
        </div>
body;
        $sendinginfo = "Transaction url";
        $receivinginfo = "Your wallet";
        if (in_array($from, $array_nourl) && in_array($to, $array_nourl)) {
            $ourwallettext = "";
            $sendinginfo = "Code";
            $receivinginfo = "Your email";
        } else if (in_array($from, $array_nourl) && !in_array($to, $array_nourl)) {
            $ourwallettext = "";
            $sendinginfo = "Code";
        } else if (!in_array($from, $array_nourl) && in_array($to, $array_nourl)) {
            $receivinginfo = "Your email";
        }
        return <<<body
<input type="hidden" id="have-wl" value="$havewallet"/>
        <input type="hidden" id="exchange-bill-id" value="$id"/>
        <input type="hidden" id="exchange-from" value="$from"/>
        <input type="hidden" id="exchange-to" value="$to"/>
        <input type="hidden" id="exchange-fromamount" value="$fromamount"/>
        <input type="hidden" id="exchange-toamout" value="$toamount"/>
       <div class="body-darker"></div>
       <div class="otp-box">
    <p class="otp-title">Here is your one time password</p>
    <p class="otp-detail">Please check your email & enter code to
        validate your transaction</p>
    <div class="otp-input-row">
        <input class="otp-input-item" id="otp-input-1" maxlength="1" type="text"/>
        <input class="otp-input-item" id="otp-input-2" maxlength="1" type="text"/>
        <input class="otp-input-item" id="otp-input-3" maxlength="1" type="text"/>
        <input class="otp-input-item" id="otp-input-4" maxlength="1" type="text"/>
        <input class="otp-input-item" id="otp-input-5" maxlength="1" type="text"/>
    </div>
    <div class="otp-box-buttonrow">
        <button class="otp-box-buttonrow-back">Back</button>
        <button class="otp-box-buttonrow-yes">Done!</button>
    </div>
</div>
<div class="rating-pop">
    <div class="rating-pop-left">
        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit
            seeiusmod tempor incididunt consectetur adipiscing elit,
            sed</p>
        <label>
            <textarea></textarea>
        </label>
    </div>
    <div class="rating-pop-right">
        <div class="rating-pop-right-num">
            <p>4</p>
            <p>3</p>
            <p>2</p>
            <p>1</p>
        </div>
        <div class="rating-pop-right-ratebar">
            <div class="rating-pop-right-ratebar-content"></div>
        </div>
        <div class="rating-pop-right-shapebar">
            <svg class="svgemption sad" width="44px" height="44px" viewBox="0 0 44 44" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <g id="sad" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(0, 0)">
                    <circle id="body" fill="#E23D18" cx="22" cy="22" r="22"></circle>
                    <g id="face" transform="translate(13.000000, 20.000000)">
                        <g class="face">
                            <path d="M7,4 C7,5.1045695 7.8954305,6 9,6 C10.1045695,6 11,5.1045695 11,4" class="mouth"
                                  stroke="#2C0E0F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                  transform="translate(9.000000, 5.000000) rotate(-180.000000) translate(-9.000000, -5.000000) "></path>
                            <ellipse class="right-eye" fill="#2C0E0F" cx="16.0941176" cy="1.75609756" rx="1.90588235"
                                     ry="1.75609756"></ellipse>
                            <ellipse class="left-eye" fill="#2C0E0F" cx="1.90588235" cy="1.75609756" rx="1.90588235"
                                     ry="1.75609756"></ellipse>
                        </g>
                    </g>
                </g>
            </svg>
            <svg class="svgemption neutral" width="44px" height="44px" viewBox="0 0 44 44" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <g>
                    <circle id="body" fill="#F9AC1B" cx="22" cy="22" r="22"></circle>
                    <g class="face">
                        <g transform="translate(13.000000, 20.000000)" fill="#2C0E0F">
                            <g class="mouth">
                                <g transform="translate(9, 5)">
                                    <rect x="-2" y="0" width="4" height="2" rx="2"></rect>
                                </g>
                            </g>
                            <ellipse class="right-eye" cx="16.0941176" cy="1.75" rx="1.90588235" ry="1.75"></ellipse>
                            <ellipse class="left-eye" cx="1.90588235" cy="1.75" rx="1.90588235" ry="1.75"></ellipse>
                        </g>
                    </g>
                </g>
            </svg>
            <svg class="svgemption fine" width="44px" height="44px" viewBox="0 0 44 44" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <g id="fine-emotion" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="fine">
                        <circle id="body" fill="#1988E3" cx="22" cy="22" r="22"></circle>
                        <g class="matrix" transform="translate(22.000000, 32.000000)">
                            <g class="face-container">
                                <g class="face" transform="translate(-9, -12)">
                                    <g class="face-upAndDown">
                                        <g class="eyes">
                                            <ellipse class="right-eye" fill="#2C0E0F" cx="16.0941176" cy="1.75609756"
                                                     rx="1.90588235" ry="1.75609756"></ellipse>
                                            <ellipse class="left-eye" fill="#2C0E0F" cx="1.90588235" cy="1.75609756"
                                                     rx="1.90588235" ry="1.75609756"></ellipse>
                                        </g>
                                        <path d="M6.18823529,4.90499997 C6.18823529,5.95249999 7.48721095,7 9.08957864,7 C10.6919463,7 11.990922,5.95249999 11.990922,4.90499997"
                                              id="mouth" stroke="#2C0E0F" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </g>
                </g>
            </svg>
            <svg class="svgemption happy" width="44px" height="44px" viewBox="0 0 44 44" version="1.1"
                 xmlns="http://www.w3.org/2000/svg">
                <g id="Happy" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                   transform="translate(0, 0)">
                    <circle id="Body" fill="#248C37" cx="22" cy="22" r="22"></circle>
                    <g class="scaleFace">
                        <g class="face">
                            <ellipse id="Eye-right" fill="#2C0E0F" cx="29.0875" cy="21.75" rx="1.89926471"
                                     ry="1.75"></ellipse>
                            <ellipse id="Eye-left" fill="#2C0E0F" cx="14.8992647" cy="21.75" rx="1.89926471"
                                     ry="1.75"></ellipse>
                            <path d="M21.8941176,27.8819633 C24.8588235,27.8819632 25.4941176,25.5404999 25.4941176,24.5648901 C25.4941176,23.5892803 24.4352941,23.9795242 22.1058824,23.9795242 C19.7764706,23.9795242 18.2941176,23.5892803 18.2941176,24.5648901 C18.2941176,25.5404999 18.9294118,27.8819633 21.8941176,27.8819633 Z"
                                  id="Mouth" fill="#2C0E0F"></path>
                            <ellipse id="Tung" fill="#E23D18" cx="21.8941176" cy="26.4390244" rx="1.69411765"
                                     ry="0.780487805"></ellipse>
                        </g>
                    </g>
                </g>
            </svg>
        </div>
        <button class="rating-pop-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="6.55" height="10.411" viewBox="0 0 6.55 10.411">
                <path d="M6.55 5.199a1.214 1.214 0 0 1-.347.852l-3.921 3.993a1.22 1.22 0 0 1-1.742 0l-.189-.189a1.22 1.22 0 0 1 .013-1.726l2.983-2.934L.391 2.277A1.22 1.22 0 0 1 .383.543L.569.357a1.22 1.22 0 0 1 1.729.008l1.286 1.3a.407.407 0 0 1-.578.572L1.719.937a.407.407 0 0 0-.579 0l-.182.182a.407.407 0 0 0 0 .578l3.254 3.214a.407.407 0 0 1 .121.29.407.407 0 0 1-.121.29L.935 8.711a.407.407 0 0 0 0 .575l.189.192a.407.407 0 0 0 .581 0l3.917-3.995a.409.409 0 0 0 0-.568L4.433 3.701a.407.407 0 0 1 .581-.569l1.184 1.213a1.213 1.213 0 0 1 .349.853zm0 0"
                      data-name="131-down-chevron"/>
            </svg>
        </button>
    </div>
</div>
<div class="review-info-pop">
    <div class="review-info-pop-title">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="35.4" height="35.4" viewBox="0 0 35.4 35.4">
                <path d="M17.631 27.725a1.383 1.383 0 1 1 1.383-1.383 1.383 1.383 0 0 1-1.383 1.383zm1.383-6.225v-1.855a5.765 5.765 0 1 0-5.439-9.722 5.662 5.662 0 0 0-1.752 4.111 1.383 1.383 0 1 0 2.766 0 2.919 2.919 0 0 1 .9-2.119 3.059 3.059 0 0 1 2.258-.852 2.986 2.986 0 0 1 .547 5.908 2.585 2.585 0 0 0-2.05 2.537V21.5a1.383 1.383 0 1 0 2.766 0zm7.845 11.346a1.383 1.383 0 1 0-1.433-2.365 15.066 15.066 0 1 1 4.675-4.492 1.383 1.383 0 1 0 2.3 1.537A17.691 17.691 0 0 0 5.184 5.184a17.7 17.7 0 0 0 21.674 27.665zm0 0"
                      data-name="134-question"/>
            </svg>
        </div>
        <p>Reviewing your information :</p>
    </div>
    <div class="review-info-pop-box">
        <div class="review-info-pop-box-item">
            <p>Sending <span id="reveiw-pop-from-amount"></span> amount of <span id="reveiw-pop-from-sign"></span></p>
        </div>
        <div class="review-info-pop-box-item">
            <p>Reciving <span id="reveiw-pop-to-amount"></span> amount of <span id="reveiw-pop-to-sign"></span></p>
        </div>
        <div class="review-info-pop-box-item">
            <p id="review-transaction-url"></p>
        </div>
    </div>
    <div class="review-info-pop-button-row">
        <div class="review-info-pop-button-row-no">No, edit</div>
        <div class="review-info-pop-button-row-yes">Yes , i'm Sure</div>
    </div>
</div>
<div class="top-menu">
$top
    <div class="top-menu-exchange" style="display:none">
        <div class="top-menu-next-providor">
            <div class="top-menu-next-providor-title">
                <p>Wallet providor</p>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path id="_134-question" fill="#555"
                          d="M7.968 12.531a.625.625 0 1 1 .625-.625.625.625 0 0 1-.625.625zm.625-2.812v-.84a2.605 2.605 0 1 0-2.458-4.394 2.559 2.559 0 0 0-.792 1.858.625.625 0 1 0 1.25 0A1.319 1.319 0 0 1 7 5.385 1.383 1.383 0 0 1 8.022 5a1.35 1.35 0 0 1 .247 2.67 1.168 1.168 0 0 0-.927 1.147v.9a.625.625 0 1 0 1.25 0zm3.546 5.128a.625.625 0 1 0-.648-1.069 6.809 6.809 0 1 1 2.109-2.032.625.625 0 1 0 1.039.695 8 8 0 0 0-12.3-10.1 8 8 0 0 0 9.8 12.5zm0 0"
                          data-name="134-question" transform="translate(.001)"/>
                </svg>
            </div>
            <div class="top-menu-next-providor-walletbox">
                <div class="top-menu-next-providor-walletbox-item">
                    <img src="img/freewallet-logo.png"/>
                    <p>Free wallet</p>
                </div>
                <div class="top-menu-next-providor-walletbox-item">
                    <img src="img/Ledger.png"/>
                    <p>Ledger</p>
                </div>
                <div class="top-menu-next-providor-walletbox-item">
                    <img src="img/binance.png"/>
                    <p>Binance</p>
                </div>
                <div class="top-menu-next-providor-walletbox-item top-menu-next-providor-walletbox-item-active">
                    <img src="img/blockchain-logo.png"/>
                    <p>Blockchain</p>
                </div>
            </div>
        </div>
        <div class="top-menu-exchange-box-sep"></div>
        <div class="top-menu-next-providor-info">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="16.8" height="16.8" viewBox="0 0 16.8 16.8">
                    <path id="_133-warning" fill="#fe7536"
                          d="M9.023 12.469a.656.656 0 1 1-.656-.656.656.656 0 0 1 .656.656zm0-7.908a.656.656 0 1 0-1.313 0v5.611a.656.656 0 1 0 1.313 0zm5.316-2.1A8.4 8.4 0 0 0 2.46 14.34a8.4 8.4 0 0 0 10.286 1.25.656.656 0 1 0-.68-1.123 7.15 7.15 0 1 1 2.219-2.133.656.656 0 1 0 1.091.729 8.379 8.379 0 0 0-1.037-10.6zm0 0"
                          data-name="133-warning" transform="translate(.001)"/>
                </svg>

                <p class="top-menu-next-providor-info-title">Why you have to choose wallet provider ?</p>
            </div>
            <div class="top-menu-next-providor-info-item">
                <p>Lower-fee will be applied</p>
            </div>
            <div class="top-menu-next-providor-info-item">
                <p>Transcation will be confirmed faster</p>
            </div>
            <div class="top-menu-next-providor-info-item">
                <p>accuracy will be increased during the transaction.</p>
            </div>
        </div>
    </div>
    <div class="top-menu-exchange-col">
    $ourwallettext
        <p class="top-menu-exchange-col-title">$sendinginfo</p>
        <div class="top-menu-exchange-col-input-row">
            <input id="transaction-url" placeholder="Paste here" type="text"
                   class="top-menu-exchange-col-input-big"/>
        </div>
        <p class="top-menu-exchange-col-title">$receivinginfo</p>
        $walletstr
        <div id="main-ex-two-submit" class="top-menu-exchange-wallet-button-row">
            <button class="top-menu-exchange-wallet-button">Next</button>
        </div>
    </div>
</div>
$bottom
body;
    }

    function get_footer()
    {
        return '<script src="js/jquery.min.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
<script src="js/mainexchange.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    if (isset($_GET["access_token"])) {
        $access_token = $_GET["access_token"];
        if (check_data($access_token) && check_access_token($access_token, ["mainexchange"]) === "w") {
            if (isset($_COOKIE["cs_auth"])) {
                $cookie = $_COOKIE["cs_auth"];
                $res = check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"]);
                if ($res == "s") {
                    if (isset($_GET["id"])) {
                        $billid = $_GET["id"];
                        if (check_data($billid)) {
                            $info = bill_get_info($billid, $cookie, $_SERVER["REMOTE_ADDR"]);
                            if ($info != "i") {
                                $from = $info["from_sign"];
                                $to = $info["to_sign"];
                                $fromamount = $info["from_amount"];
                                $toamount = $info["to_amount"];
                                if (floatval($fromamount) > 0 && floatval($toamount) > 0) {
                                    if (check_data($fromamount) && check_data($to) && check_data($from) && check_data($toamount)) {
                                        $wallets = wallet_get($cookie, $_SERVER["REMOTE_ADDR"]);
                                        if ($wallets != "i") {
                                            $walletstr = "";
                                            foreach ($wallets as $item) {
                                                if (strlen($walletstr) <= 0) {
                                                    $walletstr .= ' <div class="top-menu-exchange-wallet-row-item top-menu-exchange-wallet-row-item-rad-active">
                <div class="top-menu-exchange-wallet-row-item-rad ">
                </div>
                <p>' . $item["name"] . '</p>
                <p>' . $item["address"] . '</p>
            </div>';
                                                } else {
                                                    $walletstr .= ' <div class="top-menu-exchange-wallet-row-item">
                <div class="top-menu-exchange-wallet-row-item-rad ">
                </div>
                <p>' . $item["name"] . '</p>
                <p>' . $item["address"] . '</p>
            </div>';
                                                }
                                            }
                                            $walletstr = <<<body
        <div class="top-menu-exchange-wallet-row">
        $walletstr
        </div>
body;
                                            echo get_header();
                                            echo get_body($billid, $from, $to, $fromamount, $toamount, $walletstr);
                                            echo get_footer();
                                        } else {
                                            $walletstr = <<<body
        <div class="top-menu-exchange-col-input-row">
            <input id="wallet-url" placeholder="Paste url here" type="text"
                   class="top-menu-exchange-col-input-big"/>
        </div>
body;
                                            echo get_header();
                                            echo get_body($billid, $from, $to, $fromamount, $toamount, $walletstr, true);
                                            echo get_footer();
                                        }

                                    } else {
                                        header("Location: main.php");
                                    }
                                } else {
                                    header("Location: main.php");
                                }
                            } else {
                                echo "i";
                                header("Location: main.php");
                            }
                        } else {
                            header("Location: main.php");
                        }
                    } else {
                        header("Location: main.php");
                    }
                } else {
                    setcookie("cs_auth", "", time() - 3600);
                    header("Location: main.php");
                }
            } else {
                header("Location: login.php");
            }
        } else {
            header("Location: main.php");
        }
    } else {
        header("Location: main.php");
    }
}
?>