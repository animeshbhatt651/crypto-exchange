<?php
{
    require_once "config.php";
    $supported_cryptos =
        [
            "Bitcoin" => [
                "shortname" => "BTC",
                "image" => "btc.svg"
            ],
            "Ethereum" => [
                "shortname" => "ETH",
                "image" => "eth.svg"
            ],
            "Litecoin" => [
                "shortname" => "LTC",
                "image" => "ltc.svg"
            ],
            "USD Coin" => [
                "shortname" => "USDC",
                "image" => "usdc.svg"
            ],
            "Monero" => [
                "shortname" => "XMR",
                "image" => "xrp.svg"
            ],
            "Dash" => [
                "shortname" => "DASH",
                "image" => "dash.svg"
            ],
            "Ripple" => [
                "shortname" => "XRP",
                "image" => "xrp.svg"
            ],
            "TRON" => [
                "shortname" => "TRX",
                "image" => "trx.svg"
            ],
            "Binance Coin" => [
                "shortname" => "BNB",
                "image" => "bnb.svg"
            ],
            "Digibyte" => [
                "shortname" => "DGB",
                "image" => "dgb.svg"
            ],
            "Dogecoin" => [
                "shortname" => "DOGE",
                "image" => "doge.svg"
            ],
            "NEO" => [
                "shortname" => "NEO",
                "image" => "neo.svg"
            ],
            "Stellar" => [
                "shortname" => "XLM",
                "image" => "xlm.svg"
            ],
            "ZCash" => [
                "shortname" => "ZEC",
                "image" => "zec.svg"
            ],
            "PSVoucher" => [
                "shortname" => "PSV",
                "image" => "psv.png"
            ],
            "Perfect Money" => [
                "shortname" => "PM",
                "image" => "pmy.png"
            ],
            "Lisk" => [
                "shortname" => "LSK",
                "image" => "lsk.png"
            ],
        ];
    $mysqli_connecton = mysqli_connect(MYSQLI_HOST, MYSQLI_USER, MYSQLI_PASSWORD, MYSQLI_DATABASE);
    function create_access_token($access_needed = [])
    {
        global $mysqli_connecton;
        $tablename = "access_token_pool";
        again:
        $generated_access_token = md5(substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(ACCESS_TOKEN_LEN / strlen($x)))), 1, ACCESS_TOKEN_LEN));
        $query = 'SELECT * FROM `' . $tablename . '` WHERE `access_token`="' . $generated_access_token . '"';
        $query = mysqli_query($mysqli_connecton, $query);
        if (mysqli_num_rows($query) > 0) {
            goto again;
        } else {
            $expire_in = strtotime(date("Y/m/d H:i")) + ACCESS_TOKEN_EXPIRE * count($access_needed);
            $expire_in = date("Y/m/d H:i", $expire_in);
            $query = 'INSERT INTO `' . $tablename . '`(`access_token`, `expire_in`, `access_pages`) VALUES ("' . $generated_access_token . '","' . $expire_in . '","' . implode($access_needed, ",") . '")';
            mysqli_query($mysqli_connecton, $query);
            return $generated_access_token;
        }
    }

    function check_access_token($access_token, $access_need)
    {
        global $mysqli_connecton;
        $tablename = "access_token_pool";
        $query = 'SELECT * FROM `' . $tablename . '` WHERE `access_token`="' . $access_token . '" AND `access_pages`="' . implode($access_need, ",") . '"';
        $query = mysqli_query($mysqli_connecton, $query);
        if (mysqli_num_rows($query) > 0) {
            $expired_in_data = mysqli_fetch_array($query)["expire_in"];
            if ($expired_in_data == "expired") {
                return "e";
            } else {
                $expire_in = strtotime($expired_in_data);
                $now = strtotime(date("Y/m/d H:i"));
                if ($now >= $expire_in) {
                    $query = 'UPDATE `' . $tablename . '` SET `expire_in` = "expired" WHERE `access_token` = "' . $access_token . '"';
                    mysqli_query($mysqli_connecton, $query);
                    return "e";
                } else {
                    return "w";
                }
            }
        } else {
            return "e";
        }
    }

    function create_auth_login_cookie($email, $password, $ip)
    {
        $res = $email . "" . $password . "" . $ip;
        $res = md5(base64_encode($res));
        return $res;
    }

    function check_auth_login($email, $password, $access_token, $ref, $ip)
    {
        global $mysqli_connecton;
        if (check_access_token($access_token, $ref)) {
            if ($ref[0] == "login") {
                $email = strtolower($email);
                $query = 'SELECT * FROM `users_pool` WHERE `email`="' . $email . '" AND `password`="' . $password . '"';
                $query = mysqli_query($mysqli_connecton, $query);
                if (mysqli_num_rows($query) > 0) {
                    $hash = create_auth_login_cookie($email, $password, $ip);
                    $query = 'UPDATE `users_pool` SET `last_login`="' . $hash . '" WHERE `email`="' . $email . '" AND `password`="' . $password . '"';
                    mysqli_query($mysqli_connecton, $query);
                    return $hash;
                } else {
                    return "i";
                }
            } else {
                return "access";
            }
        } else {
            return "access";
        }
    }

    function check_auth_cookie($authcs, $ip, $full_info = false)
    {
        global $mysqli_connecton;
        if (check_data($authcs)) {
            $query = 'SELECT * FROM `users_pool` WHERE `last_login`="' . $authcs . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                $query = mysqli_fetch_array($query);
                $email = $query["email"];
                $password = $query["password"];
                if ($authcs == create_auth_login_cookie($email, $password, $ip)) {
                    if ($full_info) {
                        return $query;
                    } else {
                        return "s";
                    }
                } else {
                    return "i";
                }
            } else {
                return "i";
            }
        } else {
            return "rm";
        }
    }

    function auth_logout($authcookie, $ip)
    {
        global $mysqli_connecton;
        if (check_data($authcookie)) {
            $query = 'SELECT * FROM `users_pool` WHERE `last_login`="' . $authcookie . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                $user = mysqli_fetch_array($query);
                $checkcookie = create_auth_login_cookie($user["email"], $user["password"], $ip);
                if ($checkcookie == $authcookie) {
                    $query = 'DELETE FROM `users_pool` WHERE `last_login`="' . $authcookie . '"';
                    mysqli_query($mysqli_connecton, $query);
                    return "s";
                } else {
                    return "i";
                }
            } else {
                return "i";
            }
        } else {
            return "i";
        }
    }

    function auth_create_user($email, $password, $full_name, $access_token, $ref)
    {
        global $mysqli_connecton;
        if (check_access_token($access_token, $ref)) {
            if ($ref[0] == "signup") {
                $email = strtolower($email);
                $query = 'SELECT * FROM `users_pool` WHERE `email`="' . $email . '"';
                $query = mysqli_query($mysqli_connecton, $query);
                if (mysqli_num_rows($query) <= 0) {
                    $firstname = "";
                    $lastname = "";
                    $time = date("Y/m/d H:i:s");
                    $query = 'INSERT INTO `users_pool`(`email`, `password`, `first_name`, `last_name`, `join_time`, `transactions_count`, `last_login`) VALUES ("' . $email . '","' . $password . '","' . $firstname . '","' . $lastname . '","' . $time . '","0","")';
                    mysqli_query($mysqli_connecton, $query);
                    return "s";
                } else {
                    return "a";
                }
            } else {
                return "access";
            }
        } else {
            return "access";
        }
    }

    function check_data($data)
    {
        if (preg_match('%[/-\/-"-\'-(-)]%', $data)) {
            return false;
        } else {
            if (strpos($data, "/") !== false) {
                return false;
            } else {
                return true;
            }
        }
    }

    function bill_get_lastid()
    {
        global $mysqli_connecton;
        $query = 'SELECT * FROM `bills_pool`';
        $query = mysqli_query($mysqli_connecton, $query);
        $arr = [];
        if (mysqli_num_rows($query) > 0) {
            while (($row = $query->fetch_assoc()) != null) {
                $arr[] = $row["bill_id"];
            }
            arsort($arr);
            $id = $arr[count($arr) - 1] + 1;
            return $id;
        } else {
            return 1001;
        }
    }

    function create_bill($from, $to, $fromamount, $toamount, $ip, $cookie)
    {
        global $mysqli_connecton;
        $otp = rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9) . "" . rand(0, 9);
        $id = bill_get_lastid();
        $email = check_auth_cookie($cookie, $ip, true)["email"];
        $time = date("Y/m/d H:i:s");
        $query = 'INSERT INTO `bills_pool`(`from_sign`, `to_sign`, `from_amount`, `to_amount`, `created_time`, `owner_email`, `bill_id`, `ip_address`,`otp_code`) VALUES ("' . $from . '","' . $to . '","' . $fromamount . '","' . $toamount . '","' . $time . '","' . $email . '","' . $id . '","' . $ip . '","' . $otp . '")';
        mysqli_query($mysqli_connecton, $query);
        return $id;
    }

    function bill_get_info($billid, $cookie, $ip)
    {
        global $mysqli_connecton;
        $email = check_auth_cookie($cookie, $ip, true);
        if (is_array($email)) {
            $email = $email["email"];
            $query = 'SELECT * FROM `bills_pool` WHERE `owner_email`="' . $email . '" AND `bill_id`="' . $billid . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                return mysqli_fetch_array($query);
            } else {
                return "i";
            }
        } else {
            return "i";
        }
    }

    function transaction_add_new($billid, $cookie, $ip, $transactionurl, $wallet)
    {
        global $mysqli_connecton;
        $email = check_auth_cookie($cookie, $ip, true);
        if (is_array($email)) {
            $info = bill_get_info($billid, $cookie, $ip);
            if ($info != "i") {
                $email = $email["email"];
                $from_sign = $info["from_sign"];
                $to_sign = $info["to_sign"];
                $from_amount = $info["from_amount"];
                $to_amount = $info["to_amount"];
                $time = $info["created_time"];
                $datetime = New DateTime('now', new DateTimeZone("Asia/Tehran"));
                $text_for_admin = <<<body
New {$from_sign} transaction -  {$datetime->format("Y/m/d H:i:s")}
Sender : {$email}
Sent amount : $from_amount $from_sign
Received amount : $to_amount $to_sign
Creator ip : $ip
Transaction url : $transactionurl
User wallet : $wallet
body;
                $query = 'INSERT INTO `transactions`(`owner_email`, `url`, `from_sign`, `to_sign`, `from_amount`, `to_amount`, `wallet`,`bill_id`,`status`) VALUES ("' . $email . '","' . $transactionurl . '","' . $from_sign . '","' . $to_sign . '","' . $from_amount . '","' . $to_amount . '","' . $wallet . '","' . $billid . '","pending")';
                mysqli_query($mysqli_connecton, $query);
                return "s";

            } else {
                return "e";
            }
        } else {
            return "e";
        }
    }

    function transaction_get($cookie, $ip)
    {
        global $mysqli_connecton;
        $user = check_auth_cookie($cookie, $ip, true);
        if ($user != "i") {
            $user = $user["email"];
            $query = 'SELECT * FROM `transactions` WHERE `owner_email`="' . $user . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                $trans = [];
                while (($row = $query->fetch_assoc()) != null) {
                    $trans[] = $row;
                }
                return $trans;
            } else {
                return "i";
            }
        } else {
            return "i";
        }
    }

    function wallet_edit($old_address, $new_address, $new_name, $cookie, $ip)
    {
        global $mysqli_connecton;
        $email = check_auth_cookie($cookie, $ip, true);
        if ($email != "i") {
            $email = $email["email"];
            $query = 'SELECT * FROM `wallets_pool` WHERE `name`="' . $new_name . '" AND `owner_email`="' . $email . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) <= 0) {
                $query = 'UPDATE `wallets_pool` SET `address`="' . $new_address . '",`name`="' . $new_name . '" WHERE `owner_email`="' . $email . '" AND `address`="' . $old_address . '"';
                mysqli_query($mysqli_connecton, $query);
                return "s";
            } else {
                return "a";
            }
        } else {
            return "i";
        }
    }

    function wallet_add($new_address, $new_name, $cookie, $ip)
    {
        global $mysqli_connecton;
        $email = check_auth_cookie($cookie, $ip, true);
        if ($email != "i") {
            $email = $email["email"];
            $time = date("Y/m/d H:i:s");
            $query = 'SELECT * FROM `wallets_pool` WHERE `name`="' . $new_name . '" AND `owner_email`="' . $email . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) <= 0) {
                $query = 'INSERT INTO `wallets_pool`(`name`, `address`, `owner_email`, `created_time`) VALUES ("' . $new_name . '","' . $new_address . '","' . $email . '","' . $time . '")';
                mysqli_query($mysqli_connecton, $query);
                return "s";
            } else {
                return "a";
            }

        } else {
            return "i";
        }
    }

    function wallet_get($cookie, $ip)
    {
        global $mysqli_connecton;
        $user = check_auth_cookie($cookie, $ip, true);
        if ($user != "i") {
            $user = $user["email"];
            $query = 'SELECT * FROM `wallets_pool` WHERE `owner_email`="' . $user . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                $trans = [];
                while (($row = $query->fetch_assoc()) != null) {
                    $trans[] = $row;
                }
                return $trans;
            } else {
                return "i";
            }
        } else {
            return "i";
        }
    }

    function filter_password($password)
    {
        if (strlen($password) >= 6) {
            if (preg_match('/\d/', $password) && preg_match('/\D/', $password)) {
                return true;
            } else {
                return "password should contain letter and number";
            }
        } else {
            return "password lenght should contain 8 word or more";
        }
    }

    function set_new_password($email, $old_password, $new_password)
    {
        global $mysqli_connecton;
        $res = filter_password($new_password);
        if ($res) {
            $query = 'SELECT * FROM `users_pool` WHERE `email`="' . $email . '" AND `password`="' . $old_password . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                if (strtolower($old_password) != strtolower($new_password)) {
                    $query = 'UPDATE `users_pool` SET `password`="' . $new_password . '",`last_login`="" WHERE `email`="' . $email . '"';
                    mysqli_query($mysqli_connecton, $query);
                    return "password has been changed, please relogin";
                } else {
                    return "new password cannot be same as old one";
                }
            } else {
                return "old password is incorrect";
            }
        } else {
            return $res;
        }
    }

    function get_bottom_menu($active)
    {
        $res = "";
        switch ($active) {
            case "exchange":
                $res = <<<menu
<div class="bottom-menu">
    <a href="info-setting.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 15 15">
                <path id="_106-settings" fill="#919191"
                      d="M7.533 15h-.065a1.487 1.487 0 0 1-1.483-1.34v-.017a1.039 1.039 0 0 0-.639-.859l-.046-.018a1.044 1.044 0 0 0-1.066.147 1.483 1.483 0 0 1-2.007-.113l-.039-.04a1.494 1.494 0 0 1-.1-1.967 1.056 1.056 0 0 0 .151-1.068l-.027-.064a1.036 1.036 0 0 0-.858-.636h-.017A1.487 1.487 0 0 1 0 7.532v-.064a1.487 1.487 0 0 1 1.34-1.483h.017a1.04 1.04 0 0 0 .86-.639l.018-.046a1.042 1.042 0 0 0-.147-1.064l-.006-.008a1.487 1.487 0 0 1 .1-1.994l.047-.047a1.487 1.487 0 0 1 1.994-.1 1.047 1.047 0 0 0 1.077.148l.045-.019a1.042 1.042 0 0 0 .641-.86v-.017A1.487 1.487 0 0 1 7.468 0h.065a1.487 1.487 0 0 1 1.483 1.34 1.07 1.07 0 0 0 .656.882l.031.013a1.087 1.087 0 0 0 1.088-.135l.026-.02a1.493 1.493 0 0 1 1.969.123l.013.013a1.493 1.493 0 0 1 .123 1.969l-.02.026a1.087 1.087 0 0 0-.137 1.089l.008.019a1.084 1.084 0 0 0 .887.668A1.487 1.487 0 0 1 15 7.468v.065a1.487 1.487 0 0 1-1.34 1.483h-.017a1.036 1.036 0 0 0-.858.636l-.024.058a1.04 1.04 0 0 0 .155 1.061 1.487 1.487 0 0 1-.1 1.994l-.047.047a1.487 1.487 0 0 1-1.995.1l-.007-.005a1.043 1.043 0 0 0-1.067-.141l-.046.019a1.04 1.04 0 0 0-.639.859v.017A1.487 1.487 0 0 1 7.533 15zm-2.648-3.49a2.235 2.235 0 0 1 .868.176l.037.015a2.21 2.21 0 0 1 1.359 1.824v.017a.318.318 0 0 0 .317.287h.065a.318.318 0 0 0 .317-.287v-.017A2.21 2.21 0 0 1 9.211 11.7l.037-.015a2.213 2.213 0 0 1 2.259.315l.007.006a.318.318 0 0 0 .427-.022l.047-.047a.318.318 0 0 0 .023-.426 2.209 2.209 0 0 1-.326-2.258l.019-.046a2.207 2.207 0 0 1 1.824-1.358h.017a.318.318 0 0 0 .286-.317v-.064a.318.318 0 0 0-.287-.317 2.254 2.254 0 0 1-1.85-1.383l-.007-.015a2.26 2.26 0 0 1 .292-2.262L12 3.464a.32.32 0 0 0-.026-.421l-.013-.013a.319.319 0 0 0-.425-.03l-.026.02a2.261 2.261 0 0 1-2.262.291L9.223 3.3A2.241 2.241 0 0 1 7.85 1.459a.318.318 0 0 0-.317-.287h-.065a.318.318 0 0 0-.317.287v.017A2.212 2.212 0 0 1 5.788 3.3l-.035.015a2.216 2.216 0 0 1-2.263-.321.318.318 0 0 0-.427.022l-.047.047a.318.318 0 0 0-.022.427L3 3.494a2.212 2.212 0 0 1 .318 2.258l-.018.036a2.21 2.21 0 0 1-1.824 1.361h-.017a.318.318 0 0 0-.286.317v.065a.318.318 0 0 0 .287.317h.017A2.207 2.207 0 0 1 3.3 9.209l.021.05a2.227 2.227 0 0 1-.311 2.254.32.32 0 0 0 .021.421l.039.04a.317.317 0 0 0 .424.026 2.2 2.2 0 0 1 1.391-.494zm3.641-.769a.586.586 0 0 0-.354-1.117 2.224 2.224 0 1 1 1.465-1.5.586.586 0 0 0 1.125.329 3.4 3.4 0 1 0-2.236 2.285zm0 0"
                      data-name="106-settings"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Setting</p>
    </a>
    <a href="transactions.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20">
                <path id="_195-bar-chart-1" fill="#a7a7b9"
                      d="M19.219 16.914a.781.781 0 0 0 .781-.781V1.953A1.953 1.953 0 0 0 18.051 0h-1.375a1.953 1.953 0 0 0-1.949 1.953v6.016h-1.8a1.955 1.955 0 0 0-1.953 1.953v8.516H5.391V6.6c0-.04.009-.391.313-.391h1.487a.389.389 0 0 1 .387.391v9.531a.781.781 0 0 0 1.562 0V6.6a1.953 1.953 0 0 0-1.949-1.952H5.7A1.9 1.9 0 0 0 3.828 6.6v4.727H1.953A1.955 1.955 0 0 0 0 13.281v5.937A.781.781 0 0 0 .781 20h18.438a.781.781 0 1 0 0-1.562h-2.93V1.953a.389.389 0 0 1 .387-.391h1.375a.389.389 0 0 1 .387.391v14.18a.781.781 0 0 0 .781.781zM1.563 13.281a.391.391 0 0 1 .391-.391h1.874v5.547H1.563zm10.977 5.156V9.922a.391.391 0 0 1 .391-.391h1.8v8.906zm0 0"
                      data-name="195-bar-chart-1"/>
            </svg>

        </div>
        <p class="bottom-menu-item-title">Transactions</p>
    </a>
    <a href="main.php" class="bottom-menu-item bottom-menu-item-active">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16.12 19.999">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #4467ff
                        }
                    </style>
                </defs>
                <path id="Path_24"
                      d="M4.309 230.5a1.277 1.277 0 0 1-.868-.334L.556 227.5a1.671 1.671 0 0 1 0-2.49l2.885-2.669a1.3 1.3 0 0 1 1.343-.245 1.141 1.141 0 0 1 .757 1.054v2.519h9.949a.587.587 0 1 1 0 1.172H5.541a1.219 1.219 0 0 1-1.259-1.172v-2.453l-2.838 2.624a.556.556 0 0 0 0 .828l2.837 2.624v-.577a.631.631 0 0 1 1.259 0v.644a1.141 1.141 0 0 1-.757 1.054 1.317 1.317 0 0 1-.475.089zm0 0"
                      class="cls-1" data-name="Path 24" transform="translate(0 -210.502)"/>
                <path id="Path_25"
                      d="M11.811 8.494a1.317 1.317 0 0 1-.475-.089 1.141 1.141 0 0 1-.757-1.054v-.644a.631.631 0 0 1 1.259 0v.577l2.838-2.624a.556.556 0 0 0 0-.828l-2.838-2.624V3.66a1.219 1.219 0 0 1-1.259 1.172H.63A.609.609 0 0 1 0 4.246a.609.609 0 0 1 .63-.586h9.949V1.141a1.141 1.141 0 0 1 .757-1.054 1.3 1.3 0 0 1 1.343.245L15.563 3a1.671 1.671 0 0 1 0 2.49l-2.885 2.67a1.277 1.277 0 0 1-.868.334zm0 0"
                      class="cls-1" data-name="Path 25" transform="translate(0 .001)"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Exchange</p>
    </a>
        <a href="guide.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20.013">
                <path id="_071-lifesaver" fill="#a7a7b9" d="M19.691 6.053a10.1 10.1 0 0 0-.68-1.308l.042-.042a.781.781 0 0 0 0-1.105l-2.21-2.21a.781.781 0 0 0-1.105 0l-.058.058A9.973 9.973 0 0 0 6.551.817a10.116 10.116 0 0 0-1.259.65l-.052-.051a.781.781 0 0 0-1.105 0l-2.21 2.21a.781.781 0 0 0 0 1.105l.049.049a10.009 10.009 0 0 0-.009 10.437l-.013.013a.781.781 0 0 0 0 1.105l2.21 2.21a.781.781 0 0 0 1.105 0l.01-.01a9.967 9.967 0 0 0 9.178.659 10.127 10.127 0 0 0 1.308-.68.781.781 0 0 0 1.105 0l2.21-2.21a.781.781 0 0 0 0-1.105L15.7 11.824a5.508 5.508 0 0 0-.035-3.735l2.2-2.2a8.551 8.551 0 0 1 .386.784 8.4 8.4 0 0 1 .536 4.868.781.781 0 1 0 1.537.285 9.963 9.963 0 0 0-.637-5.77zM7.168 2.252a8.414 8.414 0 0 1 7.367.339L12.321 4.8a5.509 5.509 0 0 0-3.678.015L6.435 2.611q.357-.2.733-.358zm7.281 7.753a3.95 3.95 0 0 1-2.1 3.485.776.776 0 0 0-.211.1A3.946 3.946 0 1 1 14.446 10zM4.687 3.073l2.52 2.52A5.561 5.561 0 0 0 6.1 6.7L3.582 4.178zM2.75 13.34a8.4 8.4 0 0 1 .366-7.418l2.207 2.207a5.509 5.509 0 0 0-.006 3.735l-2.209 2.209c-.131-.238-.251-.483-.358-.733zm.86 2.442L6.091 13.3a5.552 5.552 0 0 0 1.1 1.107l-2.48 2.48zm10.228 1.976a8.408 8.408 0 0 1-7.417-.366l2.207-2.207a5.51 5.51 0 0 0 3.792-.015l2.2 2.2a8.55 8.55 0 0 1-.784.386zm3.586-2l-1.105 1.105-2.476-2.476a5.552 5.552 0 0 0 1.1-1.114zM13.766 5.57l2.524-2.524 1.11 1.105-2.519 2.514a5.556 5.556 0 0 0-1.115-1.095zm0 0" data-name="071-lifesaver" transform="translate(-.499 .001)"></path>
            </svg>
                    </div>
        <p class="bottom-menu-item-title">Guide</p>
    </a>

</div>
menu;
                break;
            case "transactions":
                $res = <<<menu
<div class="bottom-menu">
    <a href="info-setting.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 15 15">
                <path id="_106-settings" fill="#919191"
                      d="M7.533 15h-.065a1.487 1.487 0 0 1-1.483-1.34v-.017a1.039 1.039 0 0 0-.639-.859l-.046-.018a1.044 1.044 0 0 0-1.066.147 1.483 1.483 0 0 1-2.007-.113l-.039-.04a1.494 1.494 0 0 1-.1-1.967 1.056 1.056 0 0 0 .151-1.068l-.027-.064a1.036 1.036 0 0 0-.858-.636h-.017A1.487 1.487 0 0 1 0 7.532v-.064a1.487 1.487 0 0 1 1.34-1.483h.017a1.04 1.04 0 0 0 .86-.639l.018-.046a1.042 1.042 0 0 0-.147-1.064l-.006-.008a1.487 1.487 0 0 1 .1-1.994l.047-.047a1.487 1.487 0 0 1 1.994-.1 1.047 1.047 0 0 0 1.077.148l.045-.019a1.042 1.042 0 0 0 .641-.86v-.017A1.487 1.487 0 0 1 7.468 0h.065a1.487 1.487 0 0 1 1.483 1.34 1.07 1.07 0 0 0 .656.882l.031.013a1.087 1.087 0 0 0 1.088-.135l.026-.02a1.493 1.493 0 0 1 1.969.123l.013.013a1.493 1.493 0 0 1 .123 1.969l-.02.026a1.087 1.087 0 0 0-.137 1.089l.008.019a1.084 1.084 0 0 0 .887.668A1.487 1.487 0 0 1 15 7.468v.065a1.487 1.487 0 0 1-1.34 1.483h-.017a1.036 1.036 0 0 0-.858.636l-.024.058a1.04 1.04 0 0 0 .155 1.061 1.487 1.487 0 0 1-.1 1.994l-.047.047a1.487 1.487 0 0 1-1.995.1l-.007-.005a1.043 1.043 0 0 0-1.067-.141l-.046.019a1.04 1.04 0 0 0-.639.859v.017A1.487 1.487 0 0 1 7.533 15zm-2.648-3.49a2.235 2.235 0 0 1 .868.176l.037.015a2.21 2.21 0 0 1 1.359 1.824v.017a.318.318 0 0 0 .317.287h.065a.318.318 0 0 0 .317-.287v-.017A2.21 2.21 0 0 1 9.211 11.7l.037-.015a2.213 2.213 0 0 1 2.259.315l.007.006a.318.318 0 0 0 .427-.022l.047-.047a.318.318 0 0 0 .023-.426 2.209 2.209 0 0 1-.326-2.258l.019-.046a2.207 2.207 0 0 1 1.824-1.358h.017a.318.318 0 0 0 .286-.317v-.064a.318.318 0 0 0-.287-.317 2.254 2.254 0 0 1-1.85-1.383l-.007-.015a2.26 2.26 0 0 1 .292-2.262L12 3.464a.32.32 0 0 0-.026-.421l-.013-.013a.319.319 0 0 0-.425-.03l-.026.02a2.261 2.261 0 0 1-2.262.291L9.223 3.3A2.241 2.241 0 0 1 7.85 1.459a.318.318 0 0 0-.317-.287h-.065a.318.318 0 0 0-.317.287v.017A2.212 2.212 0 0 1 5.788 3.3l-.035.015a2.216 2.216 0 0 1-2.263-.321.318.318 0 0 0-.427.022l-.047.047a.318.318 0 0 0-.022.427L3 3.494a2.212 2.212 0 0 1 .318 2.258l-.018.036a2.21 2.21 0 0 1-1.824 1.361h-.017a.318.318 0 0 0-.286.317v.065a.318.318 0 0 0 .287.317h.017A2.207 2.207 0 0 1 3.3 9.209l.021.05a2.227 2.227 0 0 1-.311 2.254.32.32 0 0 0 .021.421l.039.04a.317.317 0 0 0 .424.026 2.2 2.2 0 0 1 1.391-.494zm3.641-.769a.586.586 0 0 0-.354-1.117 2.224 2.224 0 1 1 1.465-1.5.586.586 0 0 0 1.125.329 3.4 3.4 0 1 0-2.236 2.285zm0 0"
                      data-name="106-settings"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Setting</p>
    </a>
    <a href="transactions.php" class="bottom-menu-item bottom-menu-item-active">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20">
                <path id="_195-bar-chart-1" fill="#a7a7b9"
                      d="M19.219 16.914a.781.781 0 0 0 .781-.781V1.953A1.953 1.953 0 0 0 18.051 0h-1.375a1.953 1.953 0 0 0-1.949 1.953v6.016h-1.8a1.955 1.955 0 0 0-1.953 1.953v8.516H5.391V6.6c0-.04.009-.391.313-.391h1.487a.389.389 0 0 1 .387.391v9.531a.781.781 0 0 0 1.562 0V6.6a1.953 1.953 0 0 0-1.949-1.952H5.7A1.9 1.9 0 0 0 3.828 6.6v4.727H1.953A1.955 1.955 0 0 0 0 13.281v5.937A.781.781 0 0 0 .781 20h18.438a.781.781 0 1 0 0-1.562h-2.93V1.953a.389.389 0 0 1 .387-.391h1.375a.389.389 0 0 1 .387.391v14.18a.781.781 0 0 0 .781.781zM1.563 13.281a.391.391 0 0 1 .391-.391h1.874v5.547H1.563zm10.977 5.156V9.922a.391.391 0 0 1 .391-.391h1.8v8.906zm0 0"
                      data-name="195-bar-chart-1"/>
            </svg>

        </div>
        <p class="bottom-menu-item-title">Transactions</p>
    </a>
    <a href="main.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16.12 19.999">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #4467ff
                        }
                    </style>
                </defs>
                <path id="Path_24"
                      d="M4.309 230.5a1.277 1.277 0 0 1-.868-.334L.556 227.5a1.671 1.671 0 0 1 0-2.49l2.885-2.669a1.3 1.3 0 0 1 1.343-.245 1.141 1.141 0 0 1 .757 1.054v2.519h9.949a.587.587 0 1 1 0 1.172H5.541a1.219 1.219 0 0 1-1.259-1.172v-2.453l-2.838 2.624a.556.556 0 0 0 0 .828l2.837 2.624v-.577a.631.631 0 0 1 1.259 0v.644a1.141 1.141 0 0 1-.757 1.054 1.317 1.317 0 0 1-.475.089zm0 0"
                      class="cls-1" data-name="Path 24" transform="translate(0 -210.502)"/>
                <path id="Path_25"
                      d="M11.811 8.494a1.317 1.317 0 0 1-.475-.089 1.141 1.141 0 0 1-.757-1.054v-.644a.631.631 0 0 1 1.259 0v.577l2.838-2.624a.556.556 0 0 0 0-.828l-2.838-2.624V3.66a1.219 1.219 0 0 1-1.259 1.172H.63A.609.609 0 0 1 0 4.246a.609.609 0 0 1 .63-.586h9.949V1.141a1.141 1.141 0 0 1 .757-1.054 1.3 1.3 0 0 1 1.343.245L15.563 3a1.671 1.671 0 0 1 0 2.49l-2.885 2.67a1.277 1.277 0 0 1-.868.334zm0 0"
                      class="cls-1" data-name="Path 25" transform="translate(0 .001)"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Exchange</p>
    </a>
    <a href="guide.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20.013">
                <path id="_071-lifesaver" fill="#a7a7b9" d="M19.691 6.053a10.1 10.1 0 0 0-.68-1.308l.042-.042a.781.781 0 0 0 0-1.105l-2.21-2.21a.781.781 0 0 0-1.105 0l-.058.058A9.973 9.973 0 0 0 6.551.817a10.116 10.116 0 0 0-1.259.65l-.052-.051a.781.781 0 0 0-1.105 0l-2.21 2.21a.781.781 0 0 0 0 1.105l.049.049a10.009 10.009 0 0 0-.009 10.437l-.013.013a.781.781 0 0 0 0 1.105l2.21 2.21a.781.781 0 0 0 1.105 0l.01-.01a9.967 9.967 0 0 0 9.178.659 10.127 10.127 0 0 0 1.308-.68.781.781 0 0 0 1.105 0l2.21-2.21a.781.781 0 0 0 0-1.105L15.7 11.824a5.508 5.508 0 0 0-.035-3.735l2.2-2.2a8.551 8.551 0 0 1 .386.784 8.4 8.4 0 0 1 .536 4.868.781.781 0 1 0 1.537.285 9.963 9.963 0 0 0-.637-5.77zM7.168 2.252a8.414 8.414 0 0 1 7.367.339L12.321 4.8a5.509 5.509 0 0 0-3.678.015L6.435 2.611q.357-.2.733-.358zm7.281 7.753a3.95 3.95 0 0 1-2.1 3.485.776.776 0 0 0-.211.1A3.946 3.946 0 1 1 14.446 10zM4.687 3.073l2.52 2.52A5.561 5.561 0 0 0 6.1 6.7L3.582 4.178zM2.75 13.34a8.4 8.4 0 0 1 .366-7.418l2.207 2.207a5.509 5.509 0 0 0-.006 3.735l-2.209 2.209c-.131-.238-.251-.483-.358-.733zm.86 2.442L6.091 13.3a5.552 5.552 0 0 0 1.1 1.107l-2.48 2.48zm10.228 1.976a8.408 8.408 0 0 1-7.417-.366l2.207-2.207a5.51 5.51 0 0 0 3.792-.015l2.2 2.2a8.55 8.55 0 0 1-.784.386zm3.586-2l-1.105 1.105-2.476-2.476a5.552 5.552 0 0 0 1.1-1.114zM13.766 5.57l2.524-2.524 1.11 1.105-2.519 2.514a5.556 5.556 0 0 0-1.115-1.095zm0 0" data-name="071-lifesaver" transform="translate(-.499 .001)"></path>
            </svg>
                    </div>
        <p class="bottom-menu-item-title">Guide</p>
    </a>
</div>
menu;
                break;
            case "setting":
                $res = <<<menu
<div class="bottom-menu">
    <a href="info-setting.php" class="bottom-menu-item bottom-menu-item-active">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 15 15">
                <path id="_106-settings" fill="#919191"
                      d="M7.533 15h-.065a1.487 1.487 0 0 1-1.483-1.34v-.017a1.039 1.039 0 0 0-.639-.859l-.046-.018a1.044 1.044 0 0 0-1.066.147 1.483 1.483 0 0 1-2.007-.113l-.039-.04a1.494 1.494 0 0 1-.1-1.967 1.056 1.056 0 0 0 .151-1.068l-.027-.064a1.036 1.036 0 0 0-.858-.636h-.017A1.487 1.487 0 0 1 0 7.532v-.064a1.487 1.487 0 0 1 1.34-1.483h.017a1.04 1.04 0 0 0 .86-.639l.018-.046a1.042 1.042 0 0 0-.147-1.064l-.006-.008a1.487 1.487 0 0 1 .1-1.994l.047-.047a1.487 1.487 0 0 1 1.994-.1 1.047 1.047 0 0 0 1.077.148l.045-.019a1.042 1.042 0 0 0 .641-.86v-.017A1.487 1.487 0 0 1 7.468 0h.065a1.487 1.487 0 0 1 1.483 1.34 1.07 1.07 0 0 0 .656.882l.031.013a1.087 1.087 0 0 0 1.088-.135l.026-.02a1.493 1.493 0 0 1 1.969.123l.013.013a1.493 1.493 0 0 1 .123 1.969l-.02.026a1.087 1.087 0 0 0-.137 1.089l.008.019a1.084 1.084 0 0 0 .887.668A1.487 1.487 0 0 1 15 7.468v.065a1.487 1.487 0 0 1-1.34 1.483h-.017a1.036 1.036 0 0 0-.858.636l-.024.058a1.04 1.04 0 0 0 .155 1.061 1.487 1.487 0 0 1-.1 1.994l-.047.047a1.487 1.487 0 0 1-1.995.1l-.007-.005a1.043 1.043 0 0 0-1.067-.141l-.046.019a1.04 1.04 0 0 0-.639.859v.017A1.487 1.487 0 0 1 7.533 15zm-2.648-3.49a2.235 2.235 0 0 1 .868.176l.037.015a2.21 2.21 0 0 1 1.359 1.824v.017a.318.318 0 0 0 .317.287h.065a.318.318 0 0 0 .317-.287v-.017A2.21 2.21 0 0 1 9.211 11.7l.037-.015a2.213 2.213 0 0 1 2.259.315l.007.006a.318.318 0 0 0 .427-.022l.047-.047a.318.318 0 0 0 .023-.426 2.209 2.209 0 0 1-.326-2.258l.019-.046a2.207 2.207 0 0 1 1.824-1.358h.017a.318.318 0 0 0 .286-.317v-.064a.318.318 0 0 0-.287-.317 2.254 2.254 0 0 1-1.85-1.383l-.007-.015a2.26 2.26 0 0 1 .292-2.262L12 3.464a.32.32 0 0 0-.026-.421l-.013-.013a.319.319 0 0 0-.425-.03l-.026.02a2.261 2.261 0 0 1-2.262.291L9.223 3.3A2.241 2.241 0 0 1 7.85 1.459a.318.318 0 0 0-.317-.287h-.065a.318.318 0 0 0-.317.287v.017A2.212 2.212 0 0 1 5.788 3.3l-.035.015a2.216 2.216 0 0 1-2.263-.321.318.318 0 0 0-.427.022l-.047.047a.318.318 0 0 0-.022.427L3 3.494a2.212 2.212 0 0 1 .318 2.258l-.018.036a2.21 2.21 0 0 1-1.824 1.361h-.017a.318.318 0 0 0-.286.317v.065a.318.318 0 0 0 .287.317h.017A2.207 2.207 0 0 1 3.3 9.209l.021.05a2.227 2.227 0 0 1-.311 2.254.32.32 0 0 0 .021.421l.039.04a.317.317 0 0 0 .424.026 2.2 2.2 0 0 1 1.391-.494zm3.641-.769a.586.586 0 0 0-.354-1.117 2.224 2.224 0 1 1 1.465-1.5.586.586 0 0 0 1.125.329 3.4 3.4 0 1 0-2.236 2.285zm0 0"
                      data-name="106-settings"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Setting</p>
    </a>
    <a href="transactions.php" class="bottom-menu-item">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20">
                <path id="_195-bar-chart-1" fill="#a7a7b9"
                      d="M19.219 16.914a.781.781 0 0 0 .781-.781V1.953A1.953 1.953 0 0 0 18.051 0h-1.375a1.953 1.953 0 0 0-1.949 1.953v6.016h-1.8a1.955 1.955 0 0 0-1.953 1.953v8.516H5.391V6.6c0-.04.009-.391.313-.391h1.487a.389.389 0 0 1 .387.391v9.531a.781.781 0 0 0 1.562 0V6.6a1.953 1.953 0 0 0-1.949-1.952H5.7A1.9 1.9 0 0 0 3.828 6.6v4.727H1.953A1.955 1.955 0 0 0 0 13.281v5.937A.781.781 0 0 0 .781 20h18.438a.781.781 0 1 0 0-1.562h-2.93V1.953a.389.389 0 0 1 .387-.391h1.375a.389.389 0 0 1 .387.391v14.18a.781.781 0 0 0 .781.781zM1.563 13.281a.391.391 0 0 1 .391-.391h1.874v5.547H1.563zm10.977 5.156V9.922a.391.391 0 0 1 .391-.391h1.8v8.906zm0 0"
                      data-name="195-bar-chart-1"/>
            </svg>

        </div>
        <p class="bottom-menu-item-title">Transactions</p>
    </a>
    <a href="main.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16.12 19.999">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #4467ff
                        }
                    </style>
                </defs>
                <path id="Path_24"
                      d="M4.309 230.5a1.277 1.277 0 0 1-.868-.334L.556 227.5a1.671 1.671 0 0 1 0-2.49l2.885-2.669a1.3 1.3 0 0 1 1.343-.245 1.141 1.141 0 0 1 .757 1.054v2.519h9.949a.587.587 0 1 1 0 1.172H5.541a1.219 1.219 0 0 1-1.259-1.172v-2.453l-2.838 2.624a.556.556 0 0 0 0 .828l2.837 2.624v-.577a.631.631 0 0 1 1.259 0v.644a1.141 1.141 0 0 1-.757 1.054 1.317 1.317 0 0 1-.475.089zm0 0"
                      class="cls-1" data-name="Path 24" transform="translate(0 -210.502)"/>
                <path id="Path_25"
                      d="M11.811 8.494a1.317 1.317 0 0 1-.475-.089 1.141 1.141 0 0 1-.757-1.054v-.644a.631.631 0 0 1 1.259 0v.577l2.838-2.624a.556.556 0 0 0 0-.828l-2.838-2.624V3.66a1.219 1.219 0 0 1-1.259 1.172H.63A.609.609 0 0 1 0 4.246a.609.609 0 0 1 .63-.586h9.949V1.141a1.141 1.141 0 0 1 .757-1.054 1.3 1.3 0 0 1 1.343.245L15.563 3a1.671 1.671 0 0 1 0 2.49l-2.885 2.67a1.277 1.277 0 0 1-.868.334zm0 0"
                      class="cls-1" data-name="Path 25" transform="translate(0 .001)"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Exchange</p>
    </a>
    <a href="guide.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20.013">
                <path id="_071-lifesaver" fill="#a7a7b9" d="M19.691 6.053a10.1 10.1 0 0 0-.68-1.308l.042-.042a.781.781 0 0 0 0-1.105l-2.21-2.21a.781.781 0 0 0-1.105 0l-.058.058A9.973 9.973 0 0 0 6.551.817a10.116 10.116 0 0 0-1.259.65l-.052-.051a.781.781 0 0 0-1.105 0l-2.21 2.21a.781.781 0 0 0 0 1.105l.049.049a10.009 10.009 0 0 0-.009 10.437l-.013.013a.781.781 0 0 0 0 1.105l2.21 2.21a.781.781 0 0 0 1.105 0l.01-.01a9.967 9.967 0 0 0 9.178.659 10.127 10.127 0 0 0 1.308-.68.781.781 0 0 0 1.105 0l2.21-2.21a.781.781 0 0 0 0-1.105L15.7 11.824a5.508 5.508 0 0 0-.035-3.735l2.2-2.2a8.551 8.551 0 0 1 .386.784 8.4 8.4 0 0 1 .536 4.868.781.781 0 1 0 1.537.285 9.963 9.963 0 0 0-.637-5.77zM7.168 2.252a8.414 8.414 0 0 1 7.367.339L12.321 4.8a5.509 5.509 0 0 0-3.678.015L6.435 2.611q.357-.2.733-.358zm7.281 7.753a3.95 3.95 0 0 1-2.1 3.485.776.776 0 0 0-.211.1A3.946 3.946 0 1 1 14.446 10zM4.687 3.073l2.52 2.52A5.561 5.561 0 0 0 6.1 6.7L3.582 4.178zM2.75 13.34a8.4 8.4 0 0 1 .366-7.418l2.207 2.207a5.509 5.509 0 0 0-.006 3.735l-2.209 2.209c-.131-.238-.251-.483-.358-.733zm.86 2.442L6.091 13.3a5.552 5.552 0 0 0 1.1 1.107l-2.48 2.48zm10.228 1.976a8.408 8.408 0 0 1-7.417-.366l2.207-2.207a5.51 5.51 0 0 0 3.792-.015l2.2 2.2a8.55 8.55 0 0 1-.784.386zm3.586-2l-1.105 1.105-2.476-2.476a5.552 5.552 0 0 0 1.1-1.114zM13.766 5.57l2.524-2.524 1.11 1.105-2.519 2.514a5.556 5.556 0 0 0-1.115-1.095zm0 0" data-name="071-lifesaver" transform="translate(-.499 .001)"></path>
            </svg>
                    </div>
        <p class="bottom-menu-item-title">Guide</p>
    </a>
</div>
menu;
                break;
            case "guide":
                $res = <<<menu
<div class="bottom-menu">
    <a href="info-setting.php" class="bottom-menu-item">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 15 15">
                <path id="_106-settings" fill="#919191"
                      d="M7.533 15h-.065a1.487 1.487 0 0 1-1.483-1.34v-.017a1.039 1.039 0 0 0-.639-.859l-.046-.018a1.044 1.044 0 0 0-1.066.147 1.483 1.483 0 0 1-2.007-.113l-.039-.04a1.494 1.494 0 0 1-.1-1.967 1.056 1.056 0 0 0 .151-1.068l-.027-.064a1.036 1.036 0 0 0-.858-.636h-.017A1.487 1.487 0 0 1 0 7.532v-.064a1.487 1.487 0 0 1 1.34-1.483h.017a1.04 1.04 0 0 0 .86-.639l.018-.046a1.042 1.042 0 0 0-.147-1.064l-.006-.008a1.487 1.487 0 0 1 .1-1.994l.047-.047a1.487 1.487 0 0 1 1.994-.1 1.047 1.047 0 0 0 1.077.148l.045-.019a1.042 1.042 0 0 0 .641-.86v-.017A1.487 1.487 0 0 1 7.468 0h.065a1.487 1.487 0 0 1 1.483 1.34 1.07 1.07 0 0 0 .656.882l.031.013a1.087 1.087 0 0 0 1.088-.135l.026-.02a1.493 1.493 0 0 1 1.969.123l.013.013a1.493 1.493 0 0 1 .123 1.969l-.02.026a1.087 1.087 0 0 0-.137 1.089l.008.019a1.084 1.084 0 0 0 .887.668A1.487 1.487 0 0 1 15 7.468v.065a1.487 1.487 0 0 1-1.34 1.483h-.017a1.036 1.036 0 0 0-.858.636l-.024.058a1.04 1.04 0 0 0 .155 1.061 1.487 1.487 0 0 1-.1 1.994l-.047.047a1.487 1.487 0 0 1-1.995.1l-.007-.005a1.043 1.043 0 0 0-1.067-.141l-.046.019a1.04 1.04 0 0 0-.639.859v.017A1.487 1.487 0 0 1 7.533 15zm-2.648-3.49a2.235 2.235 0 0 1 .868.176l.037.015a2.21 2.21 0 0 1 1.359 1.824v.017a.318.318 0 0 0 .317.287h.065a.318.318 0 0 0 .317-.287v-.017A2.21 2.21 0 0 1 9.211 11.7l.037-.015a2.213 2.213 0 0 1 2.259.315l.007.006a.318.318 0 0 0 .427-.022l.047-.047a.318.318 0 0 0 .023-.426 2.209 2.209 0 0 1-.326-2.258l.019-.046a2.207 2.207 0 0 1 1.824-1.358h.017a.318.318 0 0 0 .286-.317v-.064a.318.318 0 0 0-.287-.317 2.254 2.254 0 0 1-1.85-1.383l-.007-.015a2.26 2.26 0 0 1 .292-2.262L12 3.464a.32.32 0 0 0-.026-.421l-.013-.013a.319.319 0 0 0-.425-.03l-.026.02a2.261 2.261 0 0 1-2.262.291L9.223 3.3A2.241 2.241 0 0 1 7.85 1.459a.318.318 0 0 0-.317-.287h-.065a.318.318 0 0 0-.317.287v.017A2.212 2.212 0 0 1 5.788 3.3l-.035.015a2.216 2.216 0 0 1-2.263-.321.318.318 0 0 0-.427.022l-.047.047a.318.318 0 0 0-.022.427L3 3.494a2.212 2.212 0 0 1 .318 2.258l-.018.036a2.21 2.21 0 0 1-1.824 1.361h-.017a.318.318 0 0 0-.286.317v.065a.318.318 0 0 0 .287.317h.017A2.207 2.207 0 0 1 3.3 9.209l.021.05a2.227 2.227 0 0 1-.311 2.254.32.32 0 0 0 .021.421l.039.04a.317.317 0 0 0 .424.026 2.2 2.2 0 0 1 1.391-.494zm3.641-.769a.586.586 0 0 0-.354-1.117 2.224 2.224 0 1 1 1.465-1.5.586.586 0 0 0 1.125.329 3.4 3.4 0 1 0-2.236 2.285zm0 0"
                      data-name="106-settings"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Setting</p>
    </a>
    <a href="transactions.php" class="bottom-menu-item">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20">
                <path id="_195-bar-chart-1" fill="#a7a7b9"
                      d="M19.219 16.914a.781.781 0 0 0 .781-.781V1.953A1.953 1.953 0 0 0 18.051 0h-1.375a1.953 1.953 0 0 0-1.949 1.953v6.016h-1.8a1.955 1.955 0 0 0-1.953 1.953v8.516H5.391V6.6c0-.04.009-.391.313-.391h1.487a.389.389 0 0 1 .387.391v9.531a.781.781 0 0 0 1.562 0V6.6a1.953 1.953 0 0 0-1.949-1.952H5.7A1.9 1.9 0 0 0 3.828 6.6v4.727H1.953A1.955 1.955 0 0 0 0 13.281v5.937A.781.781 0 0 0 .781 20h18.438a.781.781 0 1 0 0-1.562h-2.93V1.953a.389.389 0 0 1 .387-.391h1.375a.389.389 0 0 1 .387.391v14.18a.781.781 0 0 0 .781.781zM1.563 13.281a.391.391 0 0 1 .391-.391h1.874v5.547H1.563zm10.977 5.156V9.922a.391.391 0 0 1 .391-.391h1.8v8.906zm0 0"
                      data-name="195-bar-chart-1"/>
            </svg>

        </div>
        <p class="bottom-menu-item-title">Transactions</p>
    </a>
    <a href="main.php" class="bottom-menu-item ">
        <div class="bottom-menu-item-image">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 16.12 19.999">
                <defs>
                    <style>
                        .cls-1 {
                            fill: #4467ff
                        }
                    </style>
                </defs>
                <path id="Path_24"
                      d="M4.309 230.5a1.277 1.277 0 0 1-.868-.334L.556 227.5a1.671 1.671 0 0 1 0-2.49l2.885-2.669a1.3 1.3 0 0 1 1.343-.245 1.141 1.141 0 0 1 .757 1.054v2.519h9.949a.587.587 0 1 1 0 1.172H5.541a1.219 1.219 0 0 1-1.259-1.172v-2.453l-2.838 2.624a.556.556 0 0 0 0 .828l2.837 2.624v-.577a.631.631 0 0 1 1.259 0v.644a1.141 1.141 0 0 1-.757 1.054 1.317 1.317 0 0 1-.475.089zm0 0"
                      class="cls-1" data-name="Path 24" transform="translate(0 -210.502)"/>
                <path id="Path_25"
                      d="M11.811 8.494a1.317 1.317 0 0 1-.475-.089 1.141 1.141 0 0 1-.757-1.054v-.644a.631.631 0 0 1 1.259 0v.577l2.838-2.624a.556.556 0 0 0 0-.828l-2.838-2.624V3.66a1.219 1.219 0 0 1-1.259 1.172H.63A.609.609 0 0 1 0 4.246a.609.609 0 0 1 .63-.586h9.949V1.141a1.141 1.141 0 0 1 .757-1.054 1.3 1.3 0 0 1 1.343.245L15.563 3a1.671 1.671 0 0 1 0 2.49l-2.885 2.67a1.277 1.277 0 0 1-.868.334zm0 0"
                      class="cls-1" data-name="Path 25" transform="translate(0 .001)"/>
            </svg>
        </div>
        <p class="bottom-menu-item-title">Exchange</p>
    </a>
    <a href="guide.php" class="bottom-menu-item bottom-menu-item-active">
        <div class="bottom-menu-item-image">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" viewBox="0 0 20 20.013">
                <path id="_071-lifesaver" fill="#a7a7b9" d="M19.691 6.053a10.1 10.1 0 0 0-.68-1.308l.042-.042a.781.781 0 0 0 0-1.105l-2.21-2.21a.781.781 0 0 0-1.105 0l-.058.058A9.973 9.973 0 0 0 6.551.817a10.116 10.116 0 0 0-1.259.65l-.052-.051a.781.781 0 0 0-1.105 0l-2.21 2.21a.781.781 0 0 0 0 1.105l.049.049a10.009 10.009 0 0 0-.009 10.437l-.013.013a.781.781 0 0 0 0 1.105l2.21 2.21a.781.781 0 0 0 1.105 0l.01-.01a9.967 9.967 0 0 0 9.178.659 10.127 10.127 0 0 0 1.308-.68.781.781 0 0 0 1.105 0l2.21-2.21a.781.781 0 0 0 0-1.105L15.7 11.824a5.508 5.508 0 0 0-.035-3.735l2.2-2.2a8.551 8.551 0 0 1 .386.784 8.4 8.4 0 0 1 .536 4.868.781.781 0 1 0 1.537.285 9.963 9.963 0 0 0-.637-5.77zM7.168 2.252a8.414 8.414 0 0 1 7.367.339L12.321 4.8a5.509 5.509 0 0 0-3.678.015L6.435 2.611q.357-.2.733-.358zm7.281 7.753a3.95 3.95 0 0 1-2.1 3.485.776.776 0 0 0-.211.1A3.946 3.946 0 1 1 14.446 10zM4.687 3.073l2.52 2.52A5.561 5.561 0 0 0 6.1 6.7L3.582 4.178zM2.75 13.34a8.4 8.4 0 0 1 .366-7.418l2.207 2.207a5.509 5.509 0 0 0-.006 3.735l-2.209 2.209c-.131-.238-.251-.483-.358-.733zm.86 2.442L6.091 13.3a5.552 5.552 0 0 0 1.1 1.107l-2.48 2.48zm10.228 1.976a8.408 8.408 0 0 1-7.417-.366l2.207-2.207a5.51 5.51 0 0 0 3.792-.015l2.2 2.2a8.55 8.55 0 0 1-.784.386zm3.586-2l-1.105 1.105-2.476-2.476a5.552 5.552 0 0 0 1.1-1.114zM13.766 5.57l2.524-2.524 1.11 1.105-2.519 2.514a5.556 5.556 0 0 0-1.115-1.095zm0 0" data-name="071-lifesaver" transform="translate(-.499 .001)"></path>
            </svg>
                    </div>
        <p class="bottom-menu-item-title">Guide</p>
    </a>
</div>
menu;
                break;
        }
        return $res;
    }

    function get_top_menu($active)
    {
        $res = "";
        switch ($active) {
            case "exchange":
                $res = <<<menu
        <div class="top-menu-tools-ref">
            <a href="main.php" class="top-menu-tools-ref-item top-menu-tools-ref-item-active">Exchange</a>
            <a href="transactions.php" class="top-menu-tools-ref-item ">Transactions</a>
            <a href="info-setting.php" class="top-menu-tools-ref-item ">Setting</a>
            <a href="guide.php" class="top-menu-tools-ref-item">Guide</a>
        </div>
menu;
                break;
            case "transactions":
                $res = <<<menu
        <div class="top-menu-tools-ref">
            <a href="main.php" class="top-menu-tools-ref-item ">Exchange</a>
            <a href="transactions.php" class="top-menu-tools-ref-item top-menu-tools-ref-item-active">Transactions</a>
            <a href="info-setting.php" class="top-menu-tools-ref-item ">Setting</a>
            <a href="guide.php" class="top-menu-tools-ref-item">Guide</a>
        </div>
menu;
                break;
            case "setting":
                $res = <<<menu
        <div class="top-menu-tools-ref">
            <a href="main.php" class="top-menu-tools-ref-item ">Exchange</a>
            <a href="transactions.php" class="top-menu-tools-ref-item ">Transactions</a>
            <a href="info-setting.php" class="top-menu-tools-ref-item top-menu-tools-ref-item-active">Setting</a>
            <a href="guide.php" class="top-menu-tools-ref-item">Guide</a>
        </div>
menu;
                break;
            case "guide":
                $res = <<<menu
        <div class="top-menu-tools-ref">
            <a href="main.php" class="top-menu-tools-ref-item ">Exchange</a>
            <a href="transactions.php" class="top-menu-tools-ref-item ">Transactions</a>
            <a href="info-setting.php" class="top-menu-tools-ref-item">Setting</a>
            <a href="guide.php" class="top-menu-tools-ref-item top-menu-tools-ref-item-active">Guide</a>
        </div>
menu;
                break;
        }
        $base = <<<body
    <div class="top-menu-tools">
        <p class="top-menu-tools-title">24 <span>Change</span></p>
        $res
        <p class="top-menu-tools-settingbutton">Logout</p>
    </div>
body;
        return $base;
    }

    function get_new_crypto($name, $shortname, $image, $active = false)
    {
        if ($active)
            $active = "active";
        else
            $active = "";
        return <<<body
<div id="item-receive-$shortname" class="section-top-exchange-row-cryptos-list-item receive $active">
                            <div>
                                <img src="img/$image" alt="$shortname"/>
                                <p class="section-top-exchange-row-cryptos-list-item-name">$name</p>
                            </div>
                            <p class="section-top-exchange-row-cryptos-list-item-sign">$shortname</p>
</div>
body;

    }

    function get_cryptos($send = false)
    {
        global $supported_cryptos;
        $array = [];
        foreach ($supported_cryptos as $key => $item) {
            if (count($array) == 0)
                $array[] = get_new_crypto($key, $item["shortname"], $item["image"], true);
            else
                $array[] = get_new_crypto($key, $item["shortname"], $item["image"], false);
        }
        $res = implode($array);
        $res = '
                    <div id="box-receive" class="section-top-exchange-row-cryptos-list">
                        <input id="crypto-select-search-receive" class="section-top-exchange-search"
                               placeholder="Search..."/>
                               ' . $res . '
                    </div>
                    ';
        if ($send) {
            $res = str_replace("box-receive", "box-send", $res);
            $res = str_replace("receive", "send", $res);
        }
        return $res;
    }

    function get_new_main_price($name, $shortname, $image)
    {
        $shortname = strtolower($shortname);
        $res = <<<body
            <div class="main-prices-item" id="main-price-$shortname">
                <img src="img/$image" alt="$shortname"/>
                <p>$name</p>
                <p id="$shortname-price">Updating</p>
                <p id="$shortname-percent">-</p>
            </div>
body;
        return $res;

    }

    function get_main_prices()
    {
        global $supported_cryptos;
        $array = [];
        foreach ($supported_cryptos as $key => $item) {
            $array[] = get_new_main_price($key, $item["shortname"], $item["image"]);
        }
        $res = implode($array);
        return '<div class="main-prices">' . $res . '</div>';
    }

    function all_currencies_get_new($name, $shortname, $image)
    {
        $main = <<<body
<img src="img/$image" alt="$shortname"/>
<p>$name</p>
<p class="price-table" id="all-$shortname-price">Updating $</p>
<p class="percent-table" id="all-$shortname-percent">Updating</p>
body;
        return $main;

    }

    function all_currencies_get()
    {
        $res = '';
        global $supported_cryptos;
        $array = [];
        foreach ($supported_cryptos as $key => $item) {
            $array[] = all_currencies_get_new($key, $item["shortname"], $item["image"]);
        }
        $sub = array_chunk($array, 2);
        foreach ($sub as $item) {
            $imp = implode($item);
            $res .= <<<body
                <div class="top-menu-exchange-table-item">
                $imp
                </div>
body;
        }
        return $res;
    }

    function get_ticket_new($subject, $text, $type, $time, $answer, $status, $priority)
    {
        $text = substr($text, 0, 30) . " ...";
        $main = <<<body
      <div class="top-menu-exchange-table-item">
                    <p class="top-menu-exchange-table-item-ansstat">$status</p>
                    <p class="top-menu-exchange-table-item-type">$type</p>
                    <p class="top-menu-exchange-table-item-subject">$subject</p>
                    <p class="top-menu-exchange-table-item-priority">$priority</p>
                    <p class="top-menu-exchange-table-item-text">$text</p>
                    <p class="top-menu-exchange-table-item-time"><span class="tikformob">&#10003;&#10003;</span>$time
                    </p>
                </div>
body;
        if ($answer != "There is no answer") {
            $main .= <<<body
                <div class="top-menu-exchange-table-hidden">
                $answer
                </div>
body;
        }
        return $main;
    }

    function get_tickets($cookie, $ip)
    {
        global $mysqli_connecton;
        $email = check_auth_cookie($cookie, $ip, true);
        if ($email != "i") {
            $email = $email["email"];
            $query = 'SELECT * FROM `tickets_pool` WHERE `owner_email`="' . $email . '"';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                $tickets = [];
                while (($row = $query->fetch_assoc()) != null) {
                    $tickets[] = $row;
                }
                $arr = [];
                foreach ($tickets as $ticket) {
                    $arr[] = get_ticket_new($ticket["subject"], $ticket["text"], $ticket["type"], $ticket["time"], $ticket["answer"], $ticket["status"], $ticket["priority"]);
                }
                return implode($arr);
            } else {
                return "n";
            }
        } else {
            return "i";
        }
    }

    function send_ticket($cookie, $ip, $subject, $priority, $type, $text)
    {
        global $mysqli_connecton;
        $email = check_auth_cookie($cookie, $ip, true);
        if ($email != "i") {
            $email = $email["email"];
            $time = date("H:i");
            $answer = "There is no answer";
            $query = 'INSERT INTO `tickets_pool`(`subject`, `status`, `type`, `priority`, `text`, `time`, `answer`, `owner_email`) VALUES ("' . $subject . '","Pending","' . $type . '","' . $priority . '","' . $text . '","' . $time . '","' . $answer . '","' . $email . '")';
            mysqli_query($mysqli_connecton, $query);
            return "s";
        } else {
            return "i";
        }
    }

    function send_reset_pass_url($email)
    {
        global $mysqli_connecton;
        $vrkey = create_auth_login_cookie($email, "", "");
        $query = 'SELECT * FROM `users_pool` WHERE `email`="' . $email . '"';
        $query = mysqli_query($mysqli_connecton, $query);
        if (mysqli_num_rows($query) > 0) {
            $query = 'INSERT INTO `reset_pool`(`owner_email`, `vr_key`) VALUES ("' . $email . '","' . $vrkey . '")';
            mysqli_query($mysqli_connecton, $query);
        }

    }

    function validate_vrkey($vrkey)
    {
        global $mysqli_connecton;
        $query = 'SELECT * FROM `reset_pool` WHERE `vr_key`="' . $vrkey . '"';
        $query = mysqli_query($mysqli_connecton, $query);
        if (mysqli_num_rows($query) > 0) {
            return mysqli_fetch_array($query);
        } else {
            return "i";
        }
    }

    function set_new_password_reset($email, $new_password)
    {
        global $mysqli_connecton;
        $res = filter_password($new_password);
        if ($res) {
            $query = 'SELECT * FROM `users_pool` WHERE `email`="' . $email . '" ';
            $query = mysqli_query($mysqli_connecton, $query);
            if (mysqli_num_rows($query) > 0) {
                $query = 'UPDATE `users_pool` SET `password`="' . $new_password . '",`last_login`="" WHERE `email`="' . $email . '"';
                mysqli_query($mysqli_connecton, $query);
                $query = 'DELETE  FROM `reset_pool` WHERE `owner_email`="' . $email . '"';
                mysqli_query($mysqli_connecton, $query);
                return "password has been changed, please relogin";
            } else {
                return "there is no account with email $email";
            }
        } else {
            return $res;
        }
    }

    function index_get_prices_each($shortname)
    {
        $shortname = strtolower($shortname);
        $res = <<<body
<input class="main-prices-item" id="$shortname-price" type="hidden"/>
body;
        return $res;
    }

    function index_get_prices()
    {
        global $supported_cryptos;
        $array = [];
        foreach ($supported_cryptos as $key => $item) {
            $array[] = index_get_prices_each($item["shortname"]);
        }
        $res = implode($array);
        return $res;

    }

    function main_get_transactions_each($arr)
    {
        $base = <<<body
            <div class="main-transactions-item {$arr["status"]}">
                <div class="main-transactions-item-image"></div>
                <div class="main-transactions-item-detail">
                    <div class="main-transactions-item-detail-row">
                        <p>Send</p>
                        <p>{$arr["from_amount"]}</p>
                        <p>{$arr["from_sign"]}</p>
                    </div>
                    <div class="main-transactions-item-detail-row">
                        <p>Receive</p>
                        <p>{$arr["to_amount"]}</p>
                        <p>{$arr["to_sign"]}</p>
                    </div>
                </div>
                <button class="main-transaction-item-button"></button>
            </div>
body;
        return $base;

    }

    function main_get_transactions()
    {
        global $mysqli_connecton;
        $query = 'SELECT * FROM `transactions` WHERE `status`="pending" OR `status`="confirm"';
        $query = mysqli_query($mysqli_connecton, $query);
        if (mysqli_num_rows($query) > 0) {
            $arr = [];
            while (($row = $query->fetch_assoc()) != null) {
                $arr[] = main_get_transactions_each($row);
            }
            return $arr;
        } else {
            return "i";
        }
    }

    function get_main_index_uniimages()
    {
        global $supported_cryptos;
        $newarr = $supported_cryptos;
        shuffle($newarr);
        $res = array_chunk($newarr, 8);
        $source = '';
        foreach ($res[0] as $key => $value) {
            $source .= <<<body
<img src="img/{$value["image"]}" alt="$key"/>
body;

        }
        return $source;
    }
}
?>