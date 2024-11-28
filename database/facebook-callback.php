<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start session
}

require_once 'vendor\autoload.php';  // This goes up one directory to the root where the vendor folder is located



$fb = new Facebook\Facebook([
    'app_id' => '561554559929843',
    'app_secret' => '813dec5de5b705c6d821757346b870cf',
    'default_graph_version' => 'v14.0',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'public_profile']; // Permissions you're requesting from the userz
$login_url = $helper->getLoginUrl('http://localhost/blog/', $permissions);


if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}

if (isset($_GET['code'])) {
    try {
        $accessToken = $helper->getAccessToken();

        if (isset($accessToken)) {
            $_SESSION['access_token'] = (string)$accessToken;
            $fb->setDefaultAccessToken($_SESSION['access_token']);

            // Fetch user details
            $res = $fb->get("/me?fields=id,first_name,last_name,email");
            $user = $res->getGraphUser();
            
            // Store user info in session
            $_SESSION['username'] = $user['first_name'];
            $_SESSION['facebook_user_email'] = $user['email'];

            // Redirect after login
            
            header("Location: index.php");
            exit();
        } else{
            $login_url = $helper->getLoginUrl('http://localhost/blog/', $permissions);
            header(header: "location: " . $login_url);
            exit();
        }
    } catch (Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    } catch (Exception $e) {
        echo 'General error: ' . $e->getMessage();
    }
}


?>
