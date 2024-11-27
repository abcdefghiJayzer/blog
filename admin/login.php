<!DOCTYPE html>
<html lang="EN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body class="bg-neutral-800 md:bg-neutral-900 flex items-center justify-center min-h-screen">

    <div class="container  mx-auto max-w-xl">
        <div class="max-w-md bg-neutral-800 mx-auto rounded-xl px-10 py-10 max-w-lg">
            <h3 class="text-center text-white text-2xl font-bold mb-6">Admin Login</h3>
            <form id="loginForm" class="max-w-sm">
                <div class="mb-4">
                    <input type="text" placeholder="Username" id="userInput" name="userInput" class="w-full p-2 border rounded-lg mt-1">
                    <small id="emailError" style="color: red; display: none;">Please include '@' in the email address.</small>
                </div>
                <div class="mb-4">
                    <input type="password" placeholder="Password" id="password" name="password"
                        class="w-full p-2 border  rounded-lg mt-1">
                </div>
                <div class="mb-8 text-center ">
                    <input type="submit" value="Login"
                        class="rounded-lg w-1/2 bg-orange-500 text-neutral-800 font-semibold py-2 rounded cursor-pointer hover:bg-orange-400 hover:text-black">
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
            adminlogin: true
        };

        console.log("Form Data:", formData); // Debugging log

        // Send form data via AJAX
        $.post("../database/request.php", formData, function(response) {
            console.log("Server Response:", response); // Debugging log
            // Handle the response
            if (response.trim() === "success") {
                window.location.href = "index.php"; // Redirect to user/index.php on success
            } else {
                alert(response); // Display the error message
                window.location.href = "login.php"; // Redirect back to login.php on failure
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown); // Debugging log for AJAX error
        });
    });
});
</script>
</html>
