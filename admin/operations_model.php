<?php
//CHECK IF SESSION IS STARTED
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define('admin_url', 'includes/operations.php?action=');

define('delete_url', 'includes/delete.php?id=');
define('file_url', 'http://localhost:5000/uploads/');
define('placeholder', file_url . 'placeholder.png');

require 'database.php';

//display all errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE);


function connect()
{
    return mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
}

function select_rows($sql)
{
    $conn = connect();
    $result = mysqli_query($conn, $sql);
    $rows = [];
    if ($result) {
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $rows;
}

function update_row($data, $table, $id, $id_name = "id")
{
    $conn = connect();
    $sql = "UPDATE $table SET ";
    $i = 0;
    foreach ($data as $key => $value) {
        $sql .= "$key = '$value'";
        $i++;
        if ($i < count($data)) {
            $sql .= ", ";
        }
    }
    $sql .= " WHERE $id_name = '$id'";

    $result = mysqli_query($conn, $sql);
    return $result;
}

function insert_rows($table_name, $data)
{
    // Get the database connection
    $conn = connect();

    // Extract column names and values from the data array
    $columns = implode(", ", array_keys($data));
    $values = "'" . implode("', '", array_map(function ($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $data)) . "'";

    // Construct the SQL query
    $sql = "INSERT INTO $table_name ($columns) VALUES ($values)";

    // Execute the query
    $success = $conn->query($sql) === true;

    $conn->close();
    return $success;
}

function delete_row($table, $id, $id_name = "id")
{
    $conn = connect();
    $sql = "DELETE FROM $table WHERE $id_name = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        return true;
    } else {
        return false;
    }
}



function formatDate($dateTimeString)
{
    // Convert the date and time string to a Unix timestamp
    $timestamp = strtotime($dateTimeString);

    // Format the date and time as desired (e.g., "Wednesday 12th 1990, 6:00pm")
    $formattedDate = date('l jS Y, g:ia', $timestamp);

    // Handle adding "th", "st", "nd", or "rd" to the day
    $day = date('j', $timestamp);
    if ($day == 1 || $day == 21 || $day == 31) {
        $formattedDate = str_replace('1st', '1st', $formattedDate);
    } elseif ($day == 2 || $day == 22) {
        $formattedDate = str_replace('2nd', '2nd', $formattedDate);
    } elseif ($day == 3 || $day == 23) {
        $formattedDate = str_replace('3rd', '3rd', $formattedDate);
    } else {
        $formattedDate = str_replace('th', 'th', $formattedDate);
    }

    return $formattedDate;
}



/**
 * Display a Bootstrap notification at the top of the page.
 *
 * @param string|array $message The message to display in the notification. Can be a string or an array of messages.
 * @param string $type The type of the notification (success, error, info, warning).
 */
function displayNotification($message, $type)
{
    $_SESSION['notification'] = [
        'message' => $message,
        'type' => $type
    ];
}


/**
 * Redirect to the given URL.
 *
 * @param string $url The URL to redirect to.
 */
function redirect($url = "../registration.php")
{
    echo "<script>window.location.href = '$url';</script>";
    exit();
}

function checkRequiredFields($data, $requiredFields)
{
    $missingFields = array();
    foreach ($requiredFields as $field) {
        if (!array_key_exists($field, $data) || $data[$field] == "") {
            array_push($missingFields, $field);
        }
    }
    $missingCount = count($missingFields);
    if ($missingCount > 0) {
        $errorMessage = "Missing value" . ($missingCount > 1 ? "s " : " ");
        $errorMessage .= implode(", ", array_slice($missingFields, 0, -1));
        if ($missingCount >= 2) {
            $errorMessage .= ", and ";
        } else {
            $errorMessage .= "";
        }
        $errorMessage .= end($missingFields);
        return $errorMessage;
    }
    return [];
}

function formGroup($label, $value, $name, $type = "text", $required = true, $readonly = false)
{
    return '
	<div class="form-group row">
		<label for="' . $name . '" class="col-sm-2 col-form-label">' . $label . '</label>
		<div class="col-sm-10">
			<input type="' . $type . '" class="form-control" name="' . $name . '" id="' . $name . '" placeholder="' . $label . '" value="' . $value . '" ' . ($required ? "required" : "") . '' . ($readonly ? " readonly" : "") . '>
		</div>
	</div>
	';
}

function security($name)
{
    $conn = connect();
    $value = trim($_POST[$name]);

    if ($name == 'email') {
        $email = filter_var($value, FILTER_SANITIZE_EMAIL);
        $value = filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    $value = escape($value);

    return mysqli_real_escape_string($conn, $value);
}

function escape($string)
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function msg($success, $code, $message, $data = [])
{
    http_response_code($code);
    echo json_encode(array('success' => $success, 'code' => $code, 'message' => $message, 'data' => $data));
    exit;
}

function isJson($string)
{
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

function getRequestBody()
{
    $requestData = [];
    $requestBody = file_get_contents('php://input');
    // Check if the request body contains JSON data
    if (!empty($requestBody) && isJson($requestBody)) {
        $requestData = json_decode($requestBody, true);
    } elseif (!empty($requestBody) && !isJson($requestBody)) {
        $requestData = $_POST;
    } else {
        $requestData = [];
    }
    return $requestData;
}

function generateResetToken()
{
    $length = 6;
    $characters = '0123456789';
    $token = '';

    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $token;
}


function strip_id_string($string)
{
    $s = explode(" ", $string);
    return $s[1];
}


function compressImage($source, $destination, $filename, $extention)
{
    $imgInfo = getimagesize($source);
    $dataMine = $imgInfo['mime'];

    switch ($dataMine) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/jpg':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    imagejpeg($image, $destination);

    // final Return compressed image
    return $filename . "." . $extention;
}

function encryptString($string, $action, $encryptedIP = '')
{
    $flag['2nd-encrypt-key'] = "2nd-encrypt-key";
    $flag['2nd-encrypt-secret'] = "2nd-encrypt-secret";

    $output = false;
    $extraKey = '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';

    $encrypt_method = "AES-256-CBC";
    $secret_key = $flag['2nd-encrypt-key'] . $encryptedIP . '-' . $extraKey;
    $secret_iv = $flag['2nd-encrypt-secret'] . $encryptedIP . '-' . $extraKey;

    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output;

    if ($action == 'encrypt') {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        //replace equal signs with char that hopefully won't show up
        $output = str_replace('=', '[equal]', $output);
    } elseif ($action == 'decrypt') {
        //put back equal signs where your custom var is
        $setString = str_replace('[equal]', '=', $string);
        $output = openssl_decrypt(base64_decode($setString), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

function crypt_id($string, $get_ip = '', $action = 'encrypt')
{
    return encryptString($string, $action, $get_ip);
}

$get_ip = encryptString(get_ip(), 'encrypt');

function encrypt($id)
{
    global $get_ip;
    return crypt_id($id, $get_ip);
}

function decrypt($encrypt_id)
{
    global $get_ip;
    return crypt_id($encrypt_id, $get_ip, 'decrypt');
}




function get_ip()
{
    // if (isset($_SERVER['HTTP_CLIENT_IP'])) {
    //     return $_SERVER['HTTP_CLIENT_IP'];
    // } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    //     return $_SERVER['HTTP_X_FORWARDED_FOR'];
    // } else {
    //     return $_SERVER['REMOTE_ADDR'];
    // }
    return 1;
}
