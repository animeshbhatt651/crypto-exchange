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
    <title>24 change - Best CryptoCurrency exchange platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="css/style.css?v=' . strtotime(date("Y/m/d H:i:s")) . '"/>
</head>
<body>';
    }

    function get_body()
    {
        $send = get_cryptos(true);
        $receive = get_cryptos();
        $prices = index_get_prices();
        $uni1 = get_main_index_uniimages();
        $uni2 = get_main_index_uniimages();
        $uni3 = get_main_index_uniimages();
        return <<<body
$prices
<input id="currency-send" type="hidden" value="BTC"/>
<input id="currency-receive" type="hidden" name="currency-receive" value="ETH"/>

<div class="section-top">
    <div class="section-top-tools">
        <p class="section-top-tools-title">24 <span>Change</span></p>
        <div class="section-top-tools-buttonrow">
            <a href="login.php" class="section-top-tools-login">Login</a>
            <a href="signup.php" class="section-top-tools-signup">Free signup</a>
        </div>
    </div>
        <p class="section-top-title">24Exchange is the most Simple, Fast, Secure and Reliable crypto exchange platform !</p>
    <div class="section-top-exchange">
        <div class="section-top-exchange-parent">
            <div id="section-send" class="section-top-exchange-send">
                <div class="section-top-exchange-row">
                    <p>You send</p>
                    <div id="toggle-send" class="section-top-exchange-row-cryptos">
                        <span id="selector-send-currency-name">BITCOIN</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="7.469" height="4.27" viewBox="0 0 7.469 4.27">
                            <path id="Icon_ionic-ios-arrow-forward" data-name="Icon ionic-ios-arrow-forward"
                                  d="M2.983,3.736.157,6.56a.531.531,0,0,0,0,.754.538.538,0,0,0,.756,0l3.2-3.2a.533.533,0,0,0,.016-.736L.915.156A.534.534,0,0,0,.159.909Z"
                                  transform="translate(7.469) rotate(90)" fill="#a7a7b9"/>
                        </svg>
                    </div>
                    $send
                </div>
                <div class="section-top-exchange-value">
                    <input value="0.32" maxlength="14" id="amount-send" type="text"
                           class="section-top-exchange-value-amount"/>
                    <div id="send-currency" class="section-top-exchange-value-currency">BTC</div>
                </div>
            </div>
            <div class="section-top-exchange-buttonreverse">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="17.011" height="17.044" viewBox="0 0 17.011 17.044">
                        <path id="_125-refresh" fill="#052e67"
                              d="M8.989 17.044h-.014a.666.666 0 0 1 0-1.332h.012a7.191 7.191 0 0 0 5.581-11.727 1.4 1.4 0 0 1 .092-1.875l.78-.777h-2.5a.325.325 0 0 0-.325.325V4.17a.666.666 0 0 1 .841 1.023l-.256.267-.005.005a1.117 1.117 0 0 1-1.906-.789V1.658A1.656 1.656 0 0 1 12.942 0h3.018a1.117 1.117 0 0 1 .789 1.906L15.6 3.053a.068.068 0 0 0 0 .091 8.522 8.522 0 0 1-6.611 13.9zm-2.749-.485a1.645 1.645 0 0 0 .485-1.172v-3.018a1.117 1.117 0 0 0-1.906-.789l-.005.005-.261.267a.666.666 0 0 0 .841 1.023v2.513a.325.325 0 0 1-.325.325h-2.5l.78-.777a1.4 1.4 0 0 0 .093-1.875 7.191 7.191 0 0 1 5.58-11.729h.012A.666.666 0 0 0 9.036 0h-.014a8.522 8.522 0 0 0-6.611 13.9.068.068 0 0 1 0 .091L1.26 15.137a1.117 1.117 0 0 0 .79 1.906h3.018a1.646 1.646 0 0 0 1.171-.485zm0 0"
                              data-name="125-refresh" transform="translate(-.5)"/>
                    </svg>
                </div>
            </div>
            <div id="section-receive" class="section-top-exchange-receive">
                <div class="section-top-exchange-row">
                    <p>You receive</p>
                    <div id="toggle-receive" class="section-top-exchange-row-cryptos">
                        <span id="selector-receive-currency-name">Ethereum</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="7.469" height="4.27" viewBox="0 0 7.469 4.27">
                            <path id="Icon_ionic-ios-arrow-forward" data-name="Icon ionic-ios-arrow-forward"
                                  d="M2.983,3.736.157,6.56a.531.531,0,0,0,0,.754.538.538,0,0,0,.756,0l3.2-3.2a.533.533,0,0,0,.016-.736L.915.156A.534.534,0,0,0,.159.909Z"
                                  transform="translate(7.469) rotate(90)" fill="#a7a7b9"/>
                        </svg>
                    </div>
                    $receive
                </div>
                <div class="section-top-exchange-value">
                    <input value="0.0" maxlength="14" id="amount-receive" type="text"
                           class="section-top-exchange-value-amount"
                           disabled/>
                    <div id="receive-currency" class="section-top-exchange-value-currency">ETH</div>
                </div>
            </div>
        </div>
        <button class="section-top-exchange-button">Exchange now</button>
    </div>
    <br>
    <div class="section-top-logo-box">LOGO</div>
        <div class="section-top-universeowner">
        <div class="section-top-universeone">
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            $uni1
        </div>
        <div class="section-top-universetwo">
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            $uni2
        </div>
        <div class="section-top-universethree">
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            <div class="section-top-universe-dot"></div>
            $uni3
        </div>
    </div>
</div>
<div class="section-main">
    <div class="section-main-textarea">
        <p class="section-main-textarea-title">Why Choosing 24change ?</p>
        <div class="section-main-textarea-item">
            <p class="section-main-textarea-item-num">01</p>
            <div class="section-main-textarea-item-box">
                <p>24/7 Live Support</p>
                <p>Our support team is ready to get connected with you every time and help you as soon as possible.</p>
            </div>
        </div>
        <div class="section-main-textarea-item">
            <p class="section-main-textarea-item-num">02</p>
            <div class="section-main-textarea-item-box">
                <p>Simple & Easy</p>
                <p>Our platform was designed simply and easily for user usage with the best rates on the markets !</p>
            </div>
        </div>
        <div class="section-main-textarea-item">
            <p class="section-main-textarea-item-num">03</p>
            <div class="section-main-textarea-item-box">
                <p>No Limitation</p>
                <p> You can exchange your cryptocurrency up to $50,000 without any limit and identity verification !</p>
            </div>
        </div>
    </div>
    <img src="img/Exchange-vector.png" alt="none"/>
    <div class="section-main-card">
        <div>
            <p>localhost/ExchangeWebsite/backend Copyright © 2017 | All Right Reserved.</p>
            <p></p>
            <a href="#" class="section-main-card-div-button">Login</a>
        </div>
    </div>
</div>
<div class="section-bottom">
    <div class="section-bottom-siteinfo">
        <p class="section-top-tools-title">24 <span>Change</span></p>
        <p>Changelly is an instant cryptocurrency exchange that allows you to exchange crypto fast. The service provides the best crypto-to-crypto rates and supports over 50 cryptocurrencies available for exchange</p>
    </div>
    <div class="section-bottom-links-parent">
        <div class="section-bottom-links">
            <div class="section-bottom-links-item">
                            <a href="#">About us</a>
                <a href="guide.php">How it works</a>
                <a href="support.php">Support</a>
            </div>

        </div>
        <div class="section-bottom-links">
                        <div class="section-bottom-links-item">
                            <a href="#">Exchange pairs</a>
                <a href="main.php">BTC to ETH</a>
                <a href="main.php">LTC to BTC</a>
                <a href="main.php">XRP to EOS</a>
                <a href="main.php">XMR to XRP</a>
            </div>
        </div>
    </div>
    <div class="section-bottom-sep"></div>
    <div class="section-bottom-currencies">
        <p>Available currencies</p>
        <div class="section-bottom-currencies-box">
            <div class="section-bottom-currencies-item">
                <svg xmlns="http://www.w3.org/2000/svg" id="_001-bitcoin" width="15" height="15" data-name="001-bitcoin"
                     viewBox="0 0 15 15">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #a7a7b9
                            }
                        </style>
                    </defs>
                    <circle id="Ellipse_74" cx="7.5" cy="7.5" r="7.5" class="cls-1" data-name="Ellipse 74"/>
                    <path id="Path_1424" d="M36.448 47.457a7.516 7.516 0 0 1-11.108 9.367 7.5 7.5 0 1 0 11.108-9.367z"
                          class="cls-1" data-name="Path 1424" transform="translate(-24.598 -46.067)"/>
                    <circle id="Ellipse_75" cx="6.531" cy="6.531" r="6.531" class="cls-1" data-name="Ellipse 75"
                            transform="translate(.969 .969)"/>
                    <path id="Path_1425" fill="#052e67"
                          d="M140.6 111.935a1.658 1.658 0 0 0-.533-2.9l-.163-.045.136-.519a.437.437 0 0 0-.3-.537.427.427 0 0 0-.521.314l-.136.519-.9-.246.136-.519a.437.437 0 0 0-.3-.537.427.427 0 0 0-.521.314l-.136.519-1.16-.317a.427.427 0 0 0-.521.314.437.437 0 0 0 .3.537l.665.182-1.054 4.007-.665-.182a.427.427 0 0 0-.521.314.437.437 0 0 0 .3.537l1.16.317-.116.441a.437.437 0 0 0 .3.537.427.427 0 0 0 .521-.314l.116-.441.9.246-.116.441a.437.437 0 0 0 .3.537.427.427 0 0 0 .521-.314l.116-.441.514.141a1.712 1.712 0 0 0 2.093-1.243 1.781 1.781 0 0 0-.415-1.662zm-.757-2.052a.767.767 0 0 1 .533.935.75.75 0 0 1-.92.538l-1.425-.389-.954-.261.387-1.472zm-.7 4.1l-2.729-.745.443-1.684.954.261 1.425.389.351.1a.876.876 0 0 1 .609 1.068.857.857 0 0 1-1.054.615z"
                          data-name="Path 1425" transform="translate(-130.457 -104.299)"/>
                    <path id="Path_1426" d="M94.116 110.432a7.52 7.52 0 0 1-9.981 8.424 6.531 6.531 0 1 0 9.981-8.424z"
                          class="cls-1" data-name="Path 1426" transform="translate(-81.67 -107.197)"/>
                </svg>
                <p>BITCOIN</p>
            </div>
            <div class="section-bottom-currencies-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #a7a7b9
                            }
                        </style>
                    </defs>
                    <g id="_004-Litecoin" data-name="004-Litecoin" transform="translate(-.172)">
                        <circle id="Ellipse_76" cx="7.5" cy="7.5" r="7.5" class="cls-1" data-name="Ellipse 76"
                                transform="translate(.172)"/>
                        <path id="Path_1427" d="M53.022 28.429a7.5 7.5 0 0 1-9.668 10.844 7.5 7.5 0 1 0 9.668-10.844z"
                              class="cls-1" data-name="Path 1427" transform="translate(-42.084 -27.596)"/>
                        <circle id="Ellipse_77" cx="6.531" cy="6.531" r="6.531" class="cls-1" data-name="Ellipse 77"
                                transform="translate(.969 .969)"/>
                        <path id="Path_1428"
                              d="M115.043 88.547a7.5 7.5 0 0 1-8.695 9.746 6.531 6.531 0 1 0 8.695-9.746z" class="cls-1"
                              data-name="Path 1428" transform="translate(-103.232 -85.953)"/>
                        <path id="Path_1429" fill="#052e67"
                              d="M175.453 137.688h-2.685l.529-1.94 1.223-.378a.451.451 0 1 0-.267-.862l-.674.208.781-2.862a.452.452 0 0 0-.873-.237l-.932 3.416-1.312.405a.451.451 0 1 0 .267.862l.763-.236-.534 1.956a.452.452 0 0 0 .436.57h3.276a.451.451 0 1 0 0-.9z"
                              data-name="Path 1429" transform="translate(-165.918 -127.433)"/>
                    </g>
                </svg>
                <p>LITECOIN</p>
            </div>
            <div class="section-bottom-currencies-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #a7a7b9
                            }
                        </style>
                    </defs>
                    <g id="_016-doge" data-name="016-doge" transform="translate(.019)">
                        <circle id="Ellipse_69" cx="7.5" cy="7.5" r="7.5" class="cls-1" data-name="Ellipse 69"
                                transform="translate(-.019)"/>
                        <path id="Path_55" d="M54.25 27.084a7.287 7.287 0 0 1-9.27 10.64 7.286 7.286 0 1 0 9.27-10.64z"
                              class="cls-1" data-name="Path 55" transform="translate(-43.7 -26.313)"/>
                        <circle id="Ellipse_70" cx="6.344" cy="6.344" r="6.344" class="cls-1" data-name="Ellipse 70"
                                transform="translate(.942 .942)"/>
                        <path id="Path_56" fill="#052e67"
                              d="M145.887 150.47a3.2 3.2 0 0 0-.7-1.89 2.973 2.973 0 0 0-2.334-1.092l-1.86.007a.463.463 0 0 0-.461.465l.008 2.1a.057.057 0 0 1-.057.057h-.763a.472.472 0 0 0-.474.442.463.463 0 0 0 .464.484h.776a.057.057 0 0 1 .057.057l.008 2.1a.463.463 0 0 0 .465.461l1.858-.007a2.973 2.973 0 0 0 2.325-1.108 3.222 3.222 0 0 0 .688-2.076zm-1.42 1.513a2.04 2.04 0 0 1-1.6.752h-1.338a.057.057 0 0 1-.057-.057l-.006-1.584a.057.057 0 0 1 .057-.057h1.382a.472.472 0 0 0 .474-.442.463.463 0 0 0-.464-.484l-1.4.005a.057.057 0 0 1-.057-.057l-.006-1.584a.057.057 0 0 1 .057-.057h1.34a2.041 2.041 0 0 1 1.605.741 2.251 2.251 0 0 1 .008 2.828z"
                              data-name="Path 56" transform="translate(-135.28 -143.291)"/>
                        <path id="Path_57"
                              d="M116.536 86.791a7.291 7.291 0 0 1-8.336 9.564 6.344 6.344 0 1 0 8.336-9.564z"
                              class="cls-1" data-name="Path 57" transform="translate(-105.121 -84.321)"/>
                    </g>
                </svg>
                <p>DOGECOIN</p>
            </div>
            <div class="section-bottom-currencies-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="15.488" height="15" viewBox="0 0 15.488 15">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #a7a7b9
                            }

                            .cls-2 {
                                fill: #052e67
                            }
                        </style>
                    </defs>
                    <g id="_019-ethereum" data-name="019-ethereum" transform="translate(.488)">
                        <circle id="Ellipse_80" cx="7.5" cy="7.5" r="7.5" class="cls-1" data-name="Ellipse 80"
                                transform="translate(-.488)"/>
                        <path id="Path_1434" d="M57.09 25.208a7.5 7.5 0 0 1-9.351 11.124 7.5 7.5 0 1 0 9.351-11.124z"
                              class="cls-1" data-name="Path 1434" transform="translate(-46.34 -24.469)"/>
                        <circle id="Ellipse_81" cx="6.531" cy="6.531" r="6.531" class="cls-1" data-name="Ellipse 81"
                                transform="translate(.969 .969)"/>
                        <path id="Path_1435"
                              d="M119.949 84.641a7.5 7.5 0 0 1-8.409 9.994 6.531 6.531 0 1 0 8.409-9.994z" class="cls-1"
                              data-name="Path 1435" transform="translate(-108.272 -82.161)"/>
                        <g id="Group_396" data-name="Group 396" transform="translate(5.293 3.54)">
                            <path id="Path_1436"
                                  d="M182.773 120.865l-2.106 3.4a.088.088 0 0 0 .028.121l2.149 1.357a.088.088 0 0 0 .095 0l2.09-1.356a.088.088 0 0 0 .027-.12l-2.133-3.4a.088.088 0 0 0-.15-.002z"
                                  class="cls-2" data-name="Path 1436" transform="translate(-180.653 -120.824)"/>
                            <path id="Path_1437"
                                  d="M189.484 290.236l1.846-1.148a.088.088 0 0 1 .12.123l-1.86 2.826a.088.088 0 0 1-.145 0l-2.013-2.809a.088.088 0 0 1 .117-.126l1.842 1.132a.088.088 0 0 0 .093.002z"
                                  class="cls-2" data-name="Path 1437" transform="translate(-187.217 -284.144)"/>
                        </g>
                    </g>
                </svg>
                <p>ETHEREUM</p>
            </div>
        </div>
        <a href="main-all-currencies.php" class="section-bottom-all-coins">
            <p>All Coins</p>
            <svg xmlns="http://www.w3.org/2000/svg" width="11.6" height="10.939" viewBox="0 0 11.6 10.939">
                <path id="Icon_ionic-md-arrow-round-forward" data-name="Icon ionic-md-arrow-round-forward"
                      d="M12.377,16.96l4.551-4.416a1,1,0,0,0,.3-.738v-.013a1,1,0,0,0-.3-.738L12.377,6.639a.974.974,0,0,0-1.424,0,1.09,1.09,0,0,0,0,1.49l2.735,2.617H6.637a1.056,1.056,0,0,0,0,2.109h7.052L10.95,15.471a1.09,1.09,0,0,0,0,1.49A.978.978,0,0,0,12.377,16.96Z"
                      transform="translate(-5.625 -6.33)" fill="#a7a7b9"/>
            </svg>
        </a>
    </div>
    <div class="section-bottom-sep"></div>
    <p>© 2020 All Rights Reserved</p>
</div>
body;
    }

    function get_footer()
    {
        return '<script src="js/jquery.min.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
<script src="js/index.js?v=' . strtotime(date("Y/m/d H:i:s")) . '"></script>
</body>
</html>';
    }

    echo get_header();
    echo get_body();
    echo get_footer();
}
?>