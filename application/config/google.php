<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
|  Google API Configuration
| -------------------------------------------------------------------
| 
| To get API details you have to create a Google Project
| at Google API Console (https://console.developers.google.com)
| 
|  client_id         string   Your Google API Client ID.
|  client_secret     string   Your Google API Client secret.
|  redirect_uri      string   URL to redirect back to after login.
|  application_name  string   Your Google application name.
|  api_key           string   Developer key.
|  scopes            string   Specify scopes
*/


$config['clientId'] = '745212489187-42jvnj23g07imlimqpvhe6aocrhhecm4.apps.googleusercontent.com'; //add your client id
$config['clientSecret'] = 'stGG2spMYGLngrk2DzB0NSil';
$config['redirectUri'] = 'http://localhost/sistemtest/login/googleOauth';
$config['apiKey'] = '';
$config['applicationName'] = 'Sistem Test';