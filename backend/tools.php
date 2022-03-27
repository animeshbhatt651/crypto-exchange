<?php
{
    require_once "core.php";
    function get_price($crypto)
    {
        if ($crypto == "PSVUSDT" || $crypto == "PMUSDT") {
            $arr = [
                "status" => true,
                "percent" => round(1, 2),
                "lastPrice" => round(1, 3)
            ];
            return $arr;
        } else {
            $source = file_get_contents("https://www.binance.com/api/v3/ticker/24hr?symbol=" . $crypto);
            if (strpos($source, "lastPrice") !== false) {
                $source = json_decode($source, true);
                return $source["lastPrice"];
            } else {
                return "";
            }
        }

    }

    function recalucate_price($from, $to, $fromamount)
    {
        $pricefrom = floatval(get_price(strtoupper($from) . "USDT"));
        $priceto = floatval(get_price(strtoupper($to) . "USDT"));
        $finalprice = (floatval($fromamount) * $pricefrom) / $priceto;
        $finalprice = round($finalprice, 5);
        return $finalprice;
    }

    if (isset($_COOKIE["cs_auth"])) {
        $cookie = $_COOKIE["cs_auth"];
        if (check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"]) === "s") {
            if (isset($_GET["command"])) {
                $command = $_GET["command"];
                if (check_data($command)) {
                    switch ($command) {
                        case "get_crypto_price":
                            if (isset($_GET["crypto"])) {
                                $crypto = strtoupper($_GET["crypto"]);
                                if (check_data($crypto)) {

                                    if ($crypto == "PSVUSDT" || $crypto == "PMUSDT") {
                                        $arr = [
                                            "status" => true,
                                            "percent" => round(1, 2),
                                            "price" => round(1, 3)
                                        ];
                                        die(json_encode($arr));
                                    } else {
                                        $res = file_get_contents("https://www.binance.com/api/v3/ticker/24hr?symbol=" . $crypto);
                                        if (strpos($res, "symbol") !== false) {
                                            $res = json_decode($res, true);
                                            $arr = [
                                                "status" => true,
                                                "percent" => round($res["priceChangePercent"], 2),
                                                "price" => round($res["lastPrice"], 3)
                                            ];
                                            die(json_encode($arr));
                                        } else {
                                            $arr = [
                                                "status" => false,
                                                "error" => "bad result"
                                            ];
                                            die(json_encode($arr));
                                        }
                                    }
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid input"
                                    ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid parameters"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "get_wallet_address":
                            if (isset($_GET["crypto"]) && isset($_GET["providor"])) {
                                $crypto = $_GET["crypto"];
                                $providor = $_GET["providor"];
                                if (check_data($crypto) && check_data($providor)) {
                                    switch ($crypto) {
                                        case "BTC":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "3HRLiE8En1ephbKJjsmWkn3UMCLfDmF51A"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "ETH":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "0x215cbee0d45b204c85a9aee1854cb95134dd2a3d"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "XRP":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "rGT84ryubURwFMmiJChRbWUg9iQY18VGuQ"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "LTC":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "LeEtWGMaLhq7PsRzcgJDrg72x7kCbJaBqT"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "BNB":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "bnb18ajhl2q9xaf4ve0nklyudem5c5ufn3ugpuhgea"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "DGB":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "DSJHSfkMxn7PzgPS6dskRnCNwbWhDw4ZZo"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "DOGE":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "DRXS1yeDXwATMrTG1FYjgKeKziQvrWvAvb"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "EOS":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "5464498126827230"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "NEO":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "AeCDJgBohM7wk8hgumeqQmuCEFzkYTaoSW"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "TRX":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "TChUGX19ZsFKfrycibxAJvaFRJR9tZf2w7"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "USDC":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "0x215cbee0d45b204c85a9aee1854cb95134dd2a3d"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "XLM":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "GAN5X2FUP2PCQITFAZE2CB5PBTGVZKVJLUDVTRRRV7PTZYQWYD4CRP65|MEMO:1657571394476389"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "ZEC":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "t1JSC4ryAYSLPEh7D4pcUTujMAmBZHoJ3TJ"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "PSV":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "enter your code"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "PM":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "U26848479"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "LSK":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "10822564856160416219L"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "XMR":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "89Qetp7UMMtjkCVdvrLwteFkFzYStDmpo5Y5p413m3fhXxG3wq2PKeJYXp5pDRQKZJTB1FeFLXUdQ26b4fNofFbcCwySRZd"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "DASH":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "XeVALcixjKQXnrKATwfvvs7f5pYztmHe2R"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        case "XEM":
                                            switch ($providor) {
                                                default:
                                                    $arr = [
                                                        "status" => true,
                                                        "wallet" => "NA2KC36U4YIHDVMBEKGGFWBGOIVJMB5XAM7X2ETI|712452847935"
                                                    ];
                                                    die(json_encode($arr));
                                                    break;
                                            }
                                            break;
                                        default:
                                            $arr = [
                                                "status" => false,
                                                "error" => "unsupported crypto"
                                            ];
                                            die(json_encode($arr));
                                            break;
                                    }
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid input"
                                    ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid parameters"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "create_bill":
                            if (isset($_GET["from"], $_GET["to"], $_GET["fromamount"], $_GET["toamount"])) {
                                foreach ($_GET as $item) {
                                    if (!check_data($item)) {
                                        $arr = [
                                            "status" => false,
                                            "error" => "invalid input"
                                        ];
                                        die(json_encode($arr));
                                        break;
                                    }
                                }
                                $to = $_GET["to"];
                                $from = $_GET["from"];
                                $fromamount = $_GET["fromamount"];
                                $toamount = recalucate_price($from, $to, $fromamount);
                                if ($toamount > 0) {
                                    $bill = create_bill($from, $to, $fromamount, $toamount, $_SERVER["REMOTE_ADDR"], $cookie);
                                    $arr = [
                                        "status" => true,
                                        "id" => $bill
                                    ];
                                    die(json_encode($arr));
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid input"
                                    ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid parameters"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "submit_bill":
                            $data = file_get_contents("php://input");
                            if (strpos($data, "bill_id") !== false) {
                                $data = json_decode($data, true);
                                if (isset($data["wallet"], $data["bill_id"])) {
                                    if (check_data($data["wallet"]) && check_data($data["bill_id"])) {
                                        $wallet = $data["wallet"];
                                        $url = $data["transaction_url"];
                                        $bill = $data["bill_id"];
                                        $billinfo = bill_get_info($bill, $cookie, $_SERVER["REMOTE_ADDR"]);
                                        if ($billinfo != "i") {
                                            $res = transaction_add_new($bill, $cookie, $_SERVER["REMOTE_ADDR"], $url, $wallet);
                                            if ($res == "s") {
                                                $arr = [
                                                    "status" => true,
                                                ];
                                                die(json_encode($arr));
                                            } else {
                                                $arr = [
                                                    "status" => false,
                                                    "error" => "try again"
                                                ];
                                                die(json_encode($arr));
                                            }
                                        } else {
                                            $arr = [
                                                "status" => false,
                                                "error" => "invalid billid"
                                            ];
                                            die(json_encode($arr));
                                        }
                                    } else {
                                        $arr = [
                                            "status" => false,
                                            "error" => "invalid input"
                                        ];
                                        die(json_encode($arr));
                                    }
                                } else if (isset($data["otp_code"], $data["bill_id"])) {
                                    $otp_code = $data["otp_code"];
                                    $bill_id = $data["bill_id"];
                                    if (check_data($otp_code) && check_data($bill_id)) {
                                        $res = bill_get_info($bill_id, $cookie, $_SERVER["REMOTE_ADDR"]);
                                        if ($res != "i") {
                                            if ($res["otp_code"] == $otp_code) {
                                                $arr = [
                                                    "status" => true,
                                                ];
                                                die(json_encode($arr));
                                            } else {
                                                $arr = [
                                                    "status" => false,
                                                    "error" => "invalid code"
                                                ];
                                                die(json_encode($arr));
                                            }
                                        } else {
                                            $arr = [
                                                "status" => false,
                                                "error" => "invalid bill id (you might be a robot)"
                                            ];
                                            die(json_encode($arr));
                                        }
                                    } else {
                                        $arr = [
                                            "status" => false,
                                            "error" => "invalid input"
                                        ];
                                        die(json_encode($arr));
                                    }
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid parameters"
                                    ];
                                    die(json_encode($arr));
                                }

                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid parameters"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "wallet_edit":
                            $data = file_get_contents("php://input");
                            if (strpos($data, "old_address") !== false) {
                                $data = json_decode($data, true);
                                if (isset($data["old_address"], $data["new_address"], $data["new_name"])) {
                                    foreach ($data as $item) {
                                        if (!check_data($item)) {
                                            $arr = [
                                                "status" => false,
                                                "error" => "invalid input"
                                            ];
                                            die(json_encode($arr));
                                            break;
                                        }
                                    }
                                    $old_address = $data["old_address"];
                                    $new_address = $data["new_address"];
                                    $new_name = $data["new_name"];
                                    $res = wallet_edit($old_address, $new_address, $new_name, $cookie, $_SERVER["REMOTE_ADDR"]);
                                    if ($res == "s") {
                                        $arr = [
                                            "status" => true,
                                        ];
                                        die(json_encode($arr));
                                    } else if ($res == "a") {
                                        $arr = [
                                            "status" => false,
                                            "error" => "another wallet with same name already exists"
                                        ];
                                        die(json_encode($arr));
                                    } else {
                                        setcookie("cs_auth", "", time() - 3600);
                                        $arr = [
                                            "status" => false,
                                            "error" => "auth required"
                                        ];
                                        die(json_encode($arr));
                                    }
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid parameters"
                                    ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid parameters"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "wallet_add":
                            $data = file_get_contents("php://input");
                            if (strpos($data, "new_address") !== false) {
                                $data = json_decode($data, true);
                                if (isset($data["new_address"], $data["new_name"])) {
                                    foreach ($data as $item) {
                                        if (!check_data($item)) {
                                            $arr = [
                                                "status" => false,
                                                "error" => "invalid input"
                                            ];
                                            die(json_encode($arr));
                                            break;
                                        }
                                    }
                                    $new_address = $data["new_address"];
                                    $new_name = $data["new_name"];
                                    $res = wallet_add($new_address, $new_name, $cookie, $_SERVER["REMOTE_ADDR"]);
                                    if ($res == "s") {
                                        $arr = [
                                            "status" => true,
                                        ];
                                        die(json_encode($arr));
                                    } else if ($res == "a") {
                                        $arr = [
                                            "status" => false,
                                            "error" => "another wallet with same name already exists"
                                        ];
                                        die(json_encode($arr));
                                    } else {
                                        setcookie("cs_auth", "", time() - 3600);
                                        $arr = [
                                            "status" => false,
                                            "error" => "auth required"
                                        ];
                                        die(json_encode($arr));
                                    }
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid parameters"
                                    ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid parameters"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "change_password":
                            $data = file_get_contents("php://input");
                            if (strpos($data, "old_password") !== false) {
                                $data = json_decode($data, true);
                                if (isset($data["old_password"], $data["new_password"], $data["confirm_password"])) {
                                    foreach ($data as $item) {
                                        if (!check_data($item)) {
                                            $arr =
                                                [
                                                    "status" => false,
                                                    "error" => "invalid input"
                                                ];
                                            die(json_encode($arr));
                                            break;
                                        }
                                    }
                                    $old_password = $data["old_password"];
                                    $new_password = $data["new_password"];
                                    $confirm_password = $data["confirm_password"];
                                    $email = check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"], true);
                                    if ($email != "i") {
                                        $email = $email["email"];
                                        if ($confirm_password == $new_password) {
                                            $res = set_new_password($email, $old_password, $new_password);
                                            if (strpos($res, "relogin") !== false) {
                                                setcookie("cs_auth", "", time() - 3600);
                                                $arr =
                                                    [
                                                        "status" => true,
                                                    ];
                                                die(json_encode($arr));
                                            } else {
                                                $arr =
                                                    [
                                                        "status" => false,
                                                        "error" => $res
                                                    ];
                                                die(json_encode($arr));
                                            }
                                        } else {
                                            $arr =
                                                [
                                                    "status" => false,
                                                    "error" => "incorrect confirm password"
                                                ];
                                            die(json_encode($arr));
                                        }
                                    } else {
                                        setcookie("cs_auth", "", time() - 3600);
                                        $arr =
                                            [
                                                "status" => false,
                                                "error" => "auth required"
                                            ];
                                        die(json_encode($arr));
                                    }
                                } else {
                                    $arr =
                                        [
                                            "status" => false,
                                            "error" => "invalid parameters"
                                        ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr =
                                    [
                                        "status" => false,
                                        "error" => "invalid parameters"
                                    ];
                                die(json_encode($arr));
                            }
                            break;
                        case "send_ticket":
                            $data = file_get_contents("php://input");
                            if (strpos($data, "subject") !== false) {
                                $data = json_decode($data, true);
                                if (isset($data["subject"], $data["section"], $data["priority"], $data["text"])) {
                                    $arr_valid_priority =
                                        [
                                            "High",
                                            "Medium",
                                            "Low"
                                        ];
                                    $arr_valid_section =
                                        [
                                            "Technical",
                                            "Transactions",
                                            "NeedHelp",
                                            "Feedback",
                                            "Other"
                                        ];
                                    $subject = $data["subject"];
                                    $section = $data["section"];
                                    $priority = $data["priority"];
                                    $text = $data["text"];
                                    if (in_array($section, $arr_valid_section) && in_array($priority, $arr_valid_priority)) {
                                        $res = send_ticket($cookie, $_SERVER["REMOTE_ADDR"], $subject, $priority, $section, $text);
                                        if ($res == "s") {
                                            $arr = ["status" => true];
                                            die(json_encode($arr));
                                        } else {
                                            $arr = ["status" => false, "error" => "unexpected error"];
                                            die(json_encode($arr));
                                        }
                                    } else {
                                        $arr = ["status" => false, "error" => "invalid input"];
                                        die(json_encode($arr));
                                    }
                                } else {
                                    $arr = ["status" => false, "error" => "invalid parameters"];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = ["status" => false, "error" => "invalid parameters"];
                                die(json_encode($arr));
                            }
                            break;
                        default:
                            $arr = [
                                "status" => false,
                                "error" => "invalid command"
                            ];
                            die(json_encode($arr));
                            break;
                    }
                } else {
                    $arr = [
                        "status" => false,
                        "error" => "invalid command"
                    ];
                    die(json_encode($arr));
                }
            } else {
                $arr = [
                    "status" => false,
                    "error" => "invalid request"
                ];
                die(json_encode($arr));
            }
        } else {
            setcookie("cs_auth", "", time() - 3600);
            $arr = [
                "status" => false,
                "error" => "auth required"
            ];
            die(json_encode($arr));
        }
    } else {
        setcookie("cs_auth", "", time() - 3600);
        if (isset($_GET["main"])) {
            if (isset($_GET["command"])) {
                $command = $_GET["command"];
                if (check_data($command)) {
                    switch ($command) {
                        case "get_crypto_price":
                            if (isset($_GET["crypto"])) {
                                $crypto = strtoupper($_GET["crypto"]);
                                if (check_data($crypto)) {
                                    if ($crypto == "PSVUSDT" || $crypto == "PMUSDT") {
                                        $arr = [
                                            "status" => true,
                                            "percent" => round(1, 2),
                                            "price" => round(1, 3)
                                        ];
                                        die(json_encode($arr));
                                    } else {
                                        $res = file_get_contents("https://www.binance.com/api/v3/ticker/24hr?symbol=" . $crypto);
                                        if (strpos($res, "symbol") !== false) {
                                            $res = json_decode($res, true);
                                            $arr = [
                                                "status" => true,
                                                "percent" => round($res["priceChangePercent"], 2),
                                                "price" => round($res["lastPrice"], 3)
                                            ];
                                            die(json_encode($arr));
                                        } else {
                                            $arr = [
                                                "status" => false,
                                                "error" => "bad result"
                                            ];
                                            die(json_encode($arr));
                                        }
                                    }
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid input"
                                    ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid parameters"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "reset_password":
                            $data = file_get_contents("php://input");
                            if (strpos($data, "email") !== false) {
                                $data = json_decode($data, true);
                                if (isset($data["email"])) {
                                    $email = $data["email"];
                                    send_reset_pass_url($email);
                                    $arr = [
                                        "status" => true,
                                    ];
                                    die(json_encode($arr));
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid data"
                                    ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr = [
                                    "status" => false,
                                    "error" => "invalid data"
                                ];
                                die(json_encode($arr));
                            }
                            break;
                        case "reset_change_password":
                            $data = file_get_contents("php://input");
                            if (strpos($data, "new_password") !== false) {
                                $data = json_decode($data, true);
                                if (isset($data["new_password"], $data["confirm_password"])) {
                                    foreach ($data as $item) {
                                        if (!check_data($item)) {
                                            $arr =
                                                [
                                                    "status" => false,
                                                    "error" => "invalid input"
                                                ];
                                            die(json_encode($arr));
                                            break;
                                        }
                                    }
                                    $new_password = $data["new_password"];
                                    $confirm_password = $data["confirm_password"];
                                    $vrkey = $data["vrkey"];
                                    $email = validate_vrkey($vrkey);
                                    if ($email != "i") {
                                        $email = $email["owner_email"];
                                        if ($confirm_password == $new_password) {
                                            $res = set_new_password_reset($email, $new_password);
                                            if (strpos($res, "relogin") !== false) {
                                                $arr =
                                                    [
                                                        "status" => true,
                                                    ];
                                                die(json_encode($arr));
                                            } else {
                                                $arr =
                                                    [
                                                        "status" => false,
                                                        "error" => $res
                                                    ];
                                                die(json_encode($arr));
                                            }
                                        } else {
                                            $arr =
                                                [
                                                    "status" => false,
                                                    "error" => "incorrect confirm password"
                                                ];
                                            die(json_encode($arr));
                                        }
                                    } else {
                                        setcookie("cs_auth", "", time() - 3600);
                                        $arr =
                                            [
                                                "status" => false,
                                                "error" => "invalid email"
                                            ];
                                        die(json_encode($arr));
                                    }
                                } else {
                                    $arr =
                                        [
                                            "status" => false,
                                            "error" => "invalid parameters"
                                        ];
                                    die(json_encode($arr));
                                }
                            } else {
                                $arr =
                                    [
                                        "status" => false,
                                        "error" => "invalid parameters"
                                    ];
                                die(json_encode($arr));
                            }
                            break;
                        default:
                            $arr = [
                                "status" => false,
                                "error" => "invalid command"
                            ];
                            die(json_encode($arr));
                            break;
                    }
                } else {
                    $arr = [
                        "status" => false,
                        "error" => "invalid command"
                    ];
                    die(json_encode($arr));
                }
            } else {
                $arr = [
                    "status" => false,
                    "error" => "invalid request"
                ];
                die(json_encode($arr));
            }
        } else {
            $arr = [
                "status" => false,
                "error" => "auth required"
            ];
            die(json_encode($arr));
        }
    }
}
?>