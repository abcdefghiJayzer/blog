<?php
session_start(); 

require 'database/google-callback.php';
require 'database/facebook-callback.php';

?>



<!DOCTYPE html>
<html lang="EN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/style.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>

<body class="bg-neutral-800 md:bg-neutral-900 flex items-center justify-center min-h-screen">
    <div class="container mx-auto max-w-xl">
        <div class="max-w-md bg-neutral-800 mx-auto rounded-xl px-10 py-10">
            <a href="index.php">
                <svg class="h-8 w-8 text-gray-200" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <path d="M9 13l-4 -4l4 -4m-4 4h11a4 4 0 0 1 0 8h-1" />
                </svg>
            </a>
            <h3 class="text-center text-white text-2xl font-bold mb-6">Login</h3>
            <form id="loginForm" class="max-w-sm">
                <div class="mb-4">
                    <input type="text" placeholder="Username or Email" id="userInput" name="userInput" class="w-full p-2 border rounded-lg mt-1">
                </div>
                <div class="mb-8">
                    <input type="password" placeholder="Password" id="password" name="password" class="w-full p-2 border rounded-lg mt-1" required>
                </div>
                <div class="text-center">
                    <input type="submit" value="Login" class="rounded-lg w-full bg-orange-500 text-neutral-800 font-semibold py-2 cursor-pointer hover:bg-orange-400 hover:text-black">
                </div>

                <div class="text-center my-4 ">
                    <span class="text-neutral-100">or Log in with</span>
                </div>

                <div class="flex flex-row mb-8 text-center gap-x-3">

                    <a href="<?php echo $google_client->createAuthUrl(); ?>" class="bg-yellow-500 py-2 w-full rounded-xl cursor-pointer hover:bg-yellow-400 font-semibold"><i class='fab fa-google pr-5'></i>Google</a>

                    <a href="<?php echo $login_url ?>" class="bg-blue-500 w-full py-2 rounded-xl cursor-pointer hover:bg-blue-400 font-semibold"><i class="fab fa-facebook-f pr-5"></i>Facebook

                    </a>

                </div>

                <div class="text-center">
                    <a href="register.php" class="text-white">No Account Yet? <span class="text-orange-500 hover:underline">Register here</span></a>
                </div>
            </form>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        $("#loginForm").submit(function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Collect form data
            var userInput = $("#userInput").val();
            var password = $("#password").val();

            // Prepare data to send
            var formData = {
                userInput: userInput,
                password: password,
                login: true
            };

            // Send form data via AJAX
            $.post("./database/request.php", formData, function(response) {
                if (response.trim() === "success") {
                    window.location.href = "index.php"; // Redirect on success
                } else {
                    alert(response); // Show error message
                    window.location.href = "login.php"; // Reload the login page
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown); // Debugging log
            });
        });
    });
</script>

</html>