<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start session
}


require 'vendor/autoload.php';

$google_client = new Google_Client();

$google_client->setClientId("264358747303-r3fblrh28lk48e12vica65sth1j8mcvd.apps.googleusercontent.com");

$google_client->setClientSecret("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");

$google_client->setRedirectUri('http://localhost/blog/login.php');

$google_client->addScope('email');

$google_client->addScope('profile');

// Handle the OAuth flow after Google redirects back with a code
if (isset($_GET['code'])) {
    try {
        $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (isset($token['error'])) {
            throw new Exception('Token Error: ' . $token['error_description']);
        }

        $google_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        // Fetch user information
        $google_service = new Google_Service_Oauth2($google_client);
        $data = $google_service->userinfo->get();

        $_SESSION['username'] = $data->givenName ?? 'Guest';
        $_SESSION['userEmail'] = $data->email;

        header('Location: index.php');
        exit();
    } catch (Exception $e) {
        error_log($e->getMessage());
        echo '<p>Error: ' . $e->getMessage() . '</p>';
        exit();
    }
}


// Generate the Google login button if not already logged in
$login_button = '';
if (!isset($_SESSION['access_token'])) {
    $login_button = '<a href="' . htmlspecialchars($google_client->createAuthUrl()) . '" class="rounded-lg w-full bg-red-500 text-white font-semibold py-2 block text-center hover:bg-red-400">
        Login with Google
    </a>';
}

?>
