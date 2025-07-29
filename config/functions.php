<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require __DIR__ . '/../vendor/autoload.php';

function getCoinMarketCapData()
{
    // This function fetches data from CoinMarketCap API
    // It is used in the view-user.php file to display cryptocurrency information
    $url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
    $parameters = [
        "start" => "1",
        "limit" => "200",
        "convert" => "USD"
    ];

    $headers = [
        'Accepts: application/json',
        'X-CMC_PRO_API_KEY: 213af157-0b63-416b-8cf7-66d85753c5fa'
    ];
    $qs = http_build_query($parameters); // query string encode the parameters
    $request = "{$url}?{$qs}"; // create the request URL


    $curl = curl_init(); // Get cURL resource
    // Set cURL options
    curl_setopt_array($curl, array(
        CURLOPT_URL => $request,            // set the request URL
        CURLOPT_HTTPHEADER => $headers,     // set the headers 
        CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
    ));

    $response = curl_exec($curl); // Send the request, save the response

    $res = json_decode($response, true); // print json decoded response

    curl_close($curl); // Close request
    return $res; // Return the decoded response

}

function sendMail($subject, $message, $to)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_CLIENT;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'mail.cryptup.top';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'cryptupt';                     //SMTP username
        $mail->Password = 'd[Yj1K80YE[nw2';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('cryptupt@cryptup.top', 'CryptUP');
        $mail->addAddress($to);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject; // Use the subject passed to the function
        $mail->Body = $message; // Use the message passed to the function
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true; // Return true if mail is sent successfully
    } catch (Exception $e) {
        return false;
    }
}


