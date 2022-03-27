<?php
{
    require_once "core.php";
    $data = file_get_contents("php://input");
    $data = json_decode($data, true);
    if (isset($data["command"])) {
        $command = $data["command"];
        switch ($command) {
            case "generate_access_token":
                if (isset($_GET["ref"])) {
                    $access = [$_GET["ref"]];
                    if (count($access) > 0) {
                        $checkaccess = implode($access);
                        if (check_data($checkaccess)) {
                            $access_token = create_access_token($access);
                            $arr = [
                                "status" => true,
                                "token" => $access_token
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
                            "error" => "zero access"
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
            case "create_user":
                if (isset($data["email"]) && isset($data["password"]) && isset($data["access_token"])) {
                    $email = $data["email"];
                    $password = $data["password"];
                    $access_token = $data["access_token"];
                    if (check_data($email) && check_data($password) && check_data($access_token)) {
                        if (isset($_GET["ref"])) {
                            $ref = $_GET["ref"];
                            if (check_data($ref)) {
                                $res = auth_create_user($email, $password, "", $access_token, [$ref]);
                                if ($res == "s") {
                                    $arr = [
                                        "status" => true
                                    ];
                                    die(json_encode($arr));
                                } else if ($res == "access") {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid access token"
                                    ];
                                    die(json_encode($arr));
                                } else {
                                    $arr = [
                                        "status" => false,
                                        "error" => "email already exists"
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
                            "error" => "invalid data"
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
                break;
            case "check_credentials":
                if (isset($data["email"]) && isset($data["password"]) && isset($data["access_token"])) {
                    $email = $data["email"];
                    $password = $data["password"];
                    $access_token = $data["access_token"];
                    if (check_data($email) && check_data($password) && check_data($access_token)) {
                        if (isset($_GET["ref"])) {
                            $ref = $_GET["ref"];
                            if (check_data($ref)) {
                                $res = check_auth_login($email, $password, $access_token, [$ref], $_SERVER["REMOTE_ADDR"]);
                                if ($res == "access") {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid access token"
                                    ];
                                    die(json_encode($arr));
                                } else if ($res == "i") {
                                    $arr = [
                                        "status" => false,
                                        "error" => "invalid credentials"
                                    ];
                                    die(json_encode($arr));
                                } else {
                                    $arr = [
                                        "status" => true,
                                    ];
                                    setcookie("cs_auth", $res, time() + 3600);
                                    die(json_encode($arr));
                                }
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
                                "error" => "invalid parameters"
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
                } else {
                    $arr = [
                        "status" => false,
                        "error" => "invalid request"
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
    } else if (isset($_GET["command"])) {
        $command = $_GET["command"];
        switch ($command) {
            case "validate-auth":
                if (isset($_COOKIE["cs_auth"])) {
                    $cookie = $_COOKIE["cs_auth"];
                    if (check_auth_cookie($cookie, $_SERVER["REMOTE_ADDR"]) === "s") {
                        $arr = [
                            "status" => true,
                        ];
                        die(json_encode($arr));
                    } else {
                        setcookie("cs_auth", "", time() - 3600);
                        $arr = [
                            "status" => false,
                        ];
                        die(json_encode($arr));
                    }
                } else {
                    $arr = [
                        "status" => false,
                    ];
                    die(json_encode($arr));
                    break;
                }
                break;
            case "logout":
                if (isset($_COOKIE["cs_auth"])) {
                    $cookie = $_COOKIE["cs_auth"];
                    setcookie("cs_auth", "", time() - 3600);
                    auth_logout($cookie, $_SERVER["REMOTE_ADDR"]);
                    $arr = [
                        "status" => true,
                    ];
                    die(json_encode($arr));
                } else {
                    $arr = [
                        "status" => false,
                    ];
                    die(json_encode($arr));
                    break;
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
            "error" => "invalid input"
        ];
        die(json_encode($arr));
    }
}
?>