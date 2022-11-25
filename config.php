<?php
require_once 'vendor/autoload.php';

$clientid = "54716391191-9vsi7ueuk8n0uhhkpvce9318s0fagooe.apps.googleusercontent.com";
$clientSecret = "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";
$redirectUri = "http://localhost/LoginSignup/dashboard.php";

// Creating client

$client = new Google\Client();
$client->setClientId($clientid);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope('profile');
$client->addScope('email');