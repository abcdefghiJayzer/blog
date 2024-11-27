<?php

session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}
  require('../database/db.php'); 
  $ID = $_REQUEST['id']; 
  $mydb = new myDB; 
  $sql = "SELECT * FROM blog WHERE id=$ID"; 
  $result = $mydb->getConnection()->query($sql);

?>

<!DOCTYPE html>
<html lang="EN">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Edit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/admin/script.js"></script>
    <script>
      function toggleMobileMenu() {
        const menu = document.getElementById("hamburgerMenu");
        menu.classList.toggle("hidden");
      }

      function toggleUserMenu(event) {
        const userMenu = event.currentTarget.nextElementSibling;
        userMenu.classList.toggle("hidden");
      }
    </script>
        <script src="https://cdn.tiny.cloud/1/wqbzq0symmsqoc8a0ezxkfxqeg0njitzbpoh62rbv3epy1t2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
      tinymce.init({
        selector: '#content',
        plugins: 'lists link',
        toolbar: 'bold italic underline | bullist numlist | link',
        menubar: false,
        // Disable image and file uploads
        images_upload_handler: function(blobInfo, success, failure) {
          failure('Image uploads are disabled.');
        },
        setup: function(editor) {
          editor.on('init', function() {
            editor.getDoc().body.style.color = 'BLACK';
            <?php while ($row = mysqli_fetch_assoc($result)): ?>   
            editor.setContent(`<?= $row['content'] ?>`);
          });
        }
      });
    </script>

  </head>

  <body class="bg-neutral-800">
    <div>
      
          <nav class="md:hidden bg-neutral-900 sticky top-0 z-[99999]">
            <div
              class="container mx-auto flex justify-between items-center p-4 max-w-screen-lg"
            >
              <button class="text-white" onclick="toggleMobileMenu()">
                <i class="fas fa-bars fa-lg"></i>
              </button>
              <p
                class="text-white font-bold text-center text-xl lg:text-left w-full"
                >TECHina Mo</
              >
            </div>
            <div
              id="mobileSearchBar"
              class="hidden bg-neutral-900 pt-0 p-4 lg:hidden"
            >
              <input
                type="text"
                placeholder="Search..."
                class="w-full p-2 rounded bg-neutral-600 text-white placeholder-neutral-400"
              />
            </div>
          </nav>
          <!-- Mobile Menu -->
          <div
        id="hamburgerMenu"
        class="hidden bg-neutral-950 w-64 h-screen fixed top-0 left-0 shadow-lg"
      >
        <div class="container mx-auto p-4 pt-20">
          <h2 class="text-white font-bold text-xl mb-4"><?php echo $_SESSION['username']; ?></h2>
          <ul class="space-y-2">
            <li>
              <a
                href="index.php"
                class="block text-white hover:bg-neutral-700 p-2 rounded"
                >Dashboard</a
              >
            </li>
            <li>
              <a
                href="add.php"
                class="block text-white hover:bg-neutral-700 p-2 rounded"
                >Create</a
              >
            </li>
            <li>
              <a
                href="../database/logout.php?admin=true"
                class="block text-red-400 hover:bg-neutral-700 p-2 rounded"
                >Logout</a
              >
            </li>
          </ul>
        </div>
          </div>

          <div class="flex">
            <nav
              class="hidden md:block bg-neutral-900 sticky top-0 z-[99999] w-64 h-screen"
            >
              <div class="container mx-auto p-4 pt-10">
                <h2 class="text-white font-bold text-2xl mb-6"><?php echo $_SESSION['username']; ?></h2>
                <ul class="space-y-4 text-xl">
                  <li>
                    <a
                      href="index.php"
                      class="block text-white hover:bg-neutral-700 p-2 rounded"
                      >Dashboard</a
                    >
                  </li>
                  <li>
                    <a
                      href="add.php"
                      class="block text-white hover:bg-neutral-700 p-2 rounded"
                      >Create</a
                    >
                  </li>
                  <li>
                    <a
                      href="login.php"
                      class="block text-red-400 hover:bg-neutral-700 p-2 rounded"
                      >Logout</a
                    >
                  </li>
                </ul>
              </div>
            </nav>
      

        <main class="p-6 flex-1">
            
        <form id="blogForm" enctype="multipart/form-data">
            <div class="max-w-screen-xl mx-auto bg-neutral-900 p-6 rounded-md">
              <h1 class="text-center text-white text-2xl md:text-4xl font-bold pb-4">Create Blog</h1>
              <div class="mb-4">
                <label for="title" class="block text-white font-bold mb-2">Blog Title</label>
                <input type="text" id="title" name="title" class="w-full p-2 rounded bg-neutral-600 text-white placeholder-neutral-400" placeholder="<?= $row['title'] ?>" value="<?= $row['title'] ?>" required />
              </div>
              <input type="hidden" id="id" name="id" value="<?php echo $_GET['id']; ?>">
              <div class="mb-4">
                <label for="category" class="block text-white font-bold mb-2">Category</label>
                <select id="category" name="category" class="w-full p-2 rounded bg-neutral-600 text-white" required>
                  <option value="" disabled <?= empty($row['category']) ? 'selected' : '' ?>>Select a category</option>
                  <option value="Software" <?= $row['category'] == 'Software' ? 'selected' : '' ?>>Software</option>
                  <option value="Hardware" <?= $row['category'] == 'Hardware' ? 'selected' : '' ?>>Hardware</option>
                  <option value="Internet of Things (IoT)" <?= $row['category'] == 'Internet of Things (IoT)' ? 'selected' : '' ?>>Internet of Things (IoT)</option>
                  <option value="Cloud Computing" <?= $row['category'] == 'Cloud Computing' ? 'selected' : '' ?>>Cloud Computing</option>
                  <option value="Artificial Intelligence (AI)" <?= $row['category'] == 'Artificial Intelligence (AI)' ? 'selected' : '' ?>>Artificial Intelligence (AI)</option>
                </select>
              </div>
              <div class="mb-4">
                <label for="image" class="block text-white font-bold mb-2">Upload Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="w-full p-2 rounded bg-neutral-600 text-white" />
              </div>
              <div class="mb-4">
                <label for="content" class="block text-white font-bold mb-2">Content</label>
                <textarea id="content" name="content"></textarea>
              </div>
              <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded">Update Blog</button>
            </div>
          </form>
          <?php endwhile; ?>
        </main>
      </div>
    </div>
  </body>

<script type="text/javascript">
$(document).ready(function() {
  $(document).ready(function() {
  $('#blogForm').on('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission
    tinymce.triggerSave(); // Ensure TinyMCE content is in the textarea
    
    var formData = new FormData(this); // Create FormData object
    formData.append('updateblog', true); // Add 'updateblog' to FormData
    
    console.log(...formData); // Log the form data to the console
    
    $.ajax({
      url: '../database/request.php',
      type: 'POST',
      data: formData, // Send FormData directly
      contentType: false,
      processData: false,
      success: function(response) {
        console.log("AJAX request successful!");
        console.log(response);
        alert('Blog Updated!'); // Alert for user feedback
        window.location.href = 'index.php'; // Redirect after successful update
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus, errorThrown);
      }
    });
  });
  });
});


</script>
</html>
