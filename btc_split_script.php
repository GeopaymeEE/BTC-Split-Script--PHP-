<?php
// Copyright 2014 @ Initscri @ BitcoinTalk.org
// Bitcoin Splitting Script
// Bounty Provided by cooldgamer @ BitcoinTalk.org
// Not for Resale!
// Please use the below settings to use this script.
// This script is a bit hacky, but works. My apologies.
// I (Initscri) am not responsible for any lost funds due to use of this
// Script. Please make sure everything is in order, and please TEST THE
// SCRIPT WITH A SMALLER AMOUNT BEFORE USING!

// ALL VALUES IN SATOSHI

// SECURITY SETTINGS
$callback_key = "RANDOMBUNCHOFCHARACTERSHEREusydiassadu"; // Type around 50 characters (letters and numbers), upper case and lower case.
// Your script callback URL will be http://yourhost.com/btc_split_script.php?callback_key=[the_key_set_above]

// TIME SETTINGS
date_default_timezone_set('America/Los_Angeles'); // change timezone for logs

// BLOCKCHAIN.INFO SETTINGS
$guid           = "your-blockchain.info-guid";
$firstpassword  = "";
$secondpassword = ""; // Passwords ^
$recipients     = array(
    "OneAddress" => 5.55, // 5.55%
    "SecondAddress" => 94.45 // Make sure your percentages MATCH 100%
);
// $custom_fee = 50000 // uncomment for custom fee.
// ^ 0.0005 in Bitcoin converted to satoshi.
// $note = ""; // uncomment for custom note.

// LOG SETTINGS
$log = "./bitcoin_log.txt"; // Make sure this file is created in the correct path.

// // // // // // // // // // // // // // // // // // //
// // //      DO NOT EDIT BELOW THIS LINE!      // // //
// // // // // // // // // // // // // // // // // // //

// Logging Function
function log_it($log, $line)
{
    $line_with_date = date('m/d/Y h:i:s a', time()) . " : " . $line . "\n";
    file_put_contents($log, $line_with_date, FILE_APPEND);
    return true;
}

$default_fee = 10000; // default fee of blockchain.info

if ($_GET['callback_key'] != $callback_key) {
    die('You do not have the correct permissions!');
} else {
    if ($_GET['test'] == true) {
        // testing callback
        echo "You're script callback is setup correctly! Great Job!";
        return "Works!";
    } else {
        if (!isset($custom_fee)) {
            $custom_fee = $default_fee;
        }
        // not testing.
        $transaction_hash = $_GET['transaction_hash'];
        $value_in_btc     = $_GET['value'];
        if ($value_in_btc > 0) {
            $feed_amount   = ($value_in_btc - $custom_fee);
            $address       = $_GET['address'];
            $input_address = $_GET['input_address'];
            log_it($log, "INFO: Transaction receieved from " . $address . " For " . $value_in_btc . " in BTC with the transaction hash: " . $transaction_hash);
            // Send
            $r_encoded       = "{";
            $recipient_count = count($recipients);
            $recipient_i     = 0;
            $log_message     = "SENT: Total of " . $value_in_btc . " to the addresses: ";
            foreach ($recipients as $k => $v) {
                $amount_for_addr = ($feed_amount * ($v / 100)); // value of transaction multiplied by percentage divided by 100.
                $r_encoded .= '"' . $k . '": ' . intval($amount_for_addr);
                $log_message .= $k . " with " . $v . "% of Bitcoins...";
                $recipient_i++;
                if ($recipient_count != $recipient_i) {
                    $r_encoded .= ','; // remove , on last json.
                    $log_message .= " and... ";
                }
            }
            $r_encoded .= "}";
            // encode $r_encoded
            $r_encoded_final = urlencode($r_encoded);
            // send
            $json_url        = "http://blockchain.info/merchant/$guid/sendmany?password=$firstpassword&second_password=$secondpassword&recipients=$r_encoded_final&from=$input_address&fee=$custom_fee";
            
            if (isset($note)) {
                $json_url .= "&note=" . $note;
            }
            
            $json_data = "";
            
            if (ini_get('allow_url_fopen')) {
                $json_data = file_get_contents($json_url);
            } else {
                
                function get_data($url)
                {
                    $ch      = curl_init();
                    $timeout = 50;
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                    $data = curl_exec($ch);
                    curl_close($ch);
                    return $data;
                }
                
                echo "Using curl instead!";
                $json_data = get_data($json_url);
            }
            
            $json_feed = json_decode($json_data);
            
            print_r($json_feed);
            
            $message = $json_feed->message;
            $txid    = $json_feed->tx_hash;
            $log_message .= '. The message :"' . $message . ' was returned with a txid of ' . $txid;
            log_it($log, $log_message);
            if (isset($txid) && isset($message)) {
                echo "Finished. Bitcoins Sent!";
            }
        } else {
            die("This is a sent transaction; Not a received one.");
        }
    }
}
?>
