<!DOCTYPE html>
<html lang="EN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <link rel="stylesheet" href="/css/style.css"> -->
</head>


<body class="md:bg-neutral-800 bg-neutral-900 flex items-center justify-center min-h-screen">
    <div class="container mx-auto items-center max-w-md">
        <div class="max-w-md mx-auto bg-neutral-900  rounded-xl px-10 py-10 max-w-lg">  
            <h3 class="text-center text-white text-2xl font-bold mb-6">Register</h3>
            <form id="registerForm">
                <div class="mb-4">
                    <input type="username" placeholder="Username" id="username" name="username" class="w-full p-2 border rounded-lg mt-1" required>
                </div>
                <div class="mb-4">
                    <input type="email" placeholder="Email" id="email" name="email" class="w-full p-2 border rounded-lg mt-1" required>
                </div>
                <div class="mb-4">
                    <input type="password" placeholder="Password" id="password" name="password"
                        class="w-full p-2 border rounded-lg mt-1" required>
                </div>
                <div class="mb-4">
                    <input type="password" placeholder="Confirm Password" id="confirm-password" name="confirm-password"
                        class="w-full p-2 border rounded-lg mt-1" required>
                </div>
                <div class="mb-8 text-center">
                    <input type="submit" value="Register"
                        class="w-1/2 bg-orange-500 text-neutral-800 font-semibold py-2 rounded cursor-pointer hover:bg-orange-400 hover:text-black rounded-lg">
                </div>
                <div class="text-center">
                    <a href="login.php" class="text-white ">Already Have an Account? <span class="text-orange-500 hover:underline">Login here</span></a>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).ready(function() {
    $("#registerForm").submit(function(event) {
      event.preventDefault(); // Prevent the default form submission

      // Collect form data
      var username = $("#username").val();
      var email = $("#email").val();
      var password = $("#password").val();
      var confirmPassword = $("#confirm-password").val();

      // Check if passwords match
      if (password !== confirmPassword) {
        alert("Passwords do not match!");
        return; // Stop the form from submitting
      }

      // Prepare data to send
      var formData = {
        username: username,
        email: email,
        password: password,
        register: true
      };

      console.log("Form Data:", formData); // Debugging log

      // Send form data via AJAX
      $.post("./database/request.php", formData, function(response) {
        console.log("Server Response:", response); // Debugging log

        // Handle the response
        if (response.trim() === "success") {
          window.location.href = "http://localhost/blog/login.php";
        } else {
          alert("Registration failed: " + response); // Log the response on failure
        }
      }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("AJAX Error:", textStatus, errorThrown); 
      });
    });
  });
</script>

</html>
