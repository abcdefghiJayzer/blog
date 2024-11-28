<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'vendor/autoload.php';
require_once 'db.php';

$data = new myDB();
$conn = $data->getConnection();

$fb = new Facebook\Facebook([
    'app_id' => '561554559929843',
    'app_secret' => '813dec5de5b705c6d821757346b870cf',
    'default_graph_version' => 'v14.0',
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'public_profile'];
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

            $res = $fb->get("/me?fields=id,first_name,last_name,email");
            $user = $res->getGraphUser();

            $first_name = $user['first_name'];
            $email = $user['email'];

            $_SESSION['username'] = $first_name;
            $_SESSION['facebook_user_email'] = $email;

            // Check if the user already exists
            $checkUserSql = "SELECT id FROM user WHERE email = ?";
            $stmt = $conn->prepare($checkUserSql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $stmt->close();

                $insertSql = "INSERT INTO user (username, email) VALUES (?, ?)";
                $insertStmt = $conn->prepare($insertSql);
                $insertStmt->bind_param("ss", $first_name, $email);

                if ($insertStmt->execute()) {
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error inserting user: " . $insertStmt->error;
                }
                $insertStmt->close();
            } else {
                header("Location: index.php");
                exit();
            }

            $stmt->close();
        } else {
            header("Location: " . $login_url);
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
