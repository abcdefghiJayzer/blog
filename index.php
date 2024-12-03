<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();  // Start session
}


require 'database/facebook-callback.php';

?>



<!DOCTYPE html>
<html lang="EN">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>LinkTechTalk</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <!-- <script src="./admin/script.js"></script> -->
  <!-- <link rel="stylesheet" href="./css/style.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


</head>

<body class="bg-neutral-800">

 

    <nav class="bg-neutral-900 sticky top-0 z-[99999]">
      <div
        class="container mx-auto flex justify-between items-center p-4 max-w-screen-lg">
        <a href="index.php" class="text-white font-bold text-xl lg:text-left w-full">LinkTechTalk</a>
        <div class="lg:flex items-center space-x-8 font-semibold">
      
          <?php echo isset($_SESSION['username']) ?
            '<div class="relative inline-block text-left">
                  <button
                    class="flex items-center text-white"
                    onclick="toggleUserMenu(event)"
                  >
                    <i class="fas fa-user fa-lg hover:text-orange-400"></i>
                    <h1 class="block px-4 py-2 text-white-400 rounded-md hover:text-orange-400">
                    ' . $_SESSION['username'] . '
                    </h1>
                      <a
                      href="./database/logout.php?user=1"
                      class="block px-4 py-2 text-red-400 rounded-md hover:bg-neutral-300"
                      >Logout</a
                    >
                  </button>
                  <div
                    class="user-menu hidden absolute left-0 mt-6 z-20 w-48 bg-white rounded-md shadow-2xl"
                  >
                    <a
                      href="../database/logout.php?user=1"
                      class="block px-4 py-2 text-red-400 rounded-md hover:bg-neutral-300"
                      >Logout</a
                    >
                  </div>
              </div>'

            : '<div class="flex items-center space-x-4">
                <a href="login.php" class="text-white text-sm hover:text-neutral-400 w-10">Log In</a>
                <a href="register.php" class="text-white text-sm hover:text-neutral-400">Register</a>
              </div>
              '; ?>
        </div>
      </div>
      <div
        id="mobileSearchBar"
        class="hidden bg-neutral-900 pt-0 p-4 lg:hidden">
        <input
          type="text"
          placeholder="Search..."
          class="w-full p-2 rounded bg-neutral-600 text-white placeholder-neutral-400" />
      </div>

      <div
        id="mobileMenu"
        class="hidden bg-neutral-900 p-4 lg:hidden shadow-lg font-semibold">
        <a
          href=""
          class="block text-white hover:text-neutral-400 py-2">Logout </a>
      </div>
    </nav>


  <section
    class="h-screen md:bg-[url('./admin/img/hero-bg.png')] bg-[url('./admin/img/hero-bg-mobile.png')] bg-cover bg-center bg-neutral-950 relative bg-fixed">
    <div
      class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black to-transparent pointer-events-none"></div>
    <div class="flex items-center justify-center h-full">
      <h1 class="font-bold text-center text-6xl text-white">LinkTechTalk</h1>
    </div>
  </section>



  <section class="max-w-screen-lg mx-auto">
    <h1 class="text-center font-bold text-white text-4xl p-10 mt-4 uppercase">
      Blog
    </h1>

    <div
      class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 md:space-x-4 mx-6">
      <div
        class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4 w-full md:w-auto">
        <div class="flex flex-col md:flex-row md:items-center w-full">
          <label for="sort-by" class="text-white pb-2 md:pb-0">Sort By:</label>
          <select id="sort-by" class="bg-neutral-800 text-white border border-neutral-700 rounded p-2 md:mx-2">
            <option value="datetime DESC">Newest</option>
            <option value="datetime ASC">Oldest</option>
          </select>

        </div>

        <div class="flex flex-col md:flex-row md:items-center w-full">
          <label for="category" class="text-white pb-2 md:pb-0">Category:</label>
          <select
            id="category"
            class="bg-neutral-800 text-white border border-neutral-700 rounded p-2 md:mx-2">
            <option value="*">All</option>
            <option value="Software">Software</option>
            <option value="Hardware">Hardware</option>
            <option value="Internet of Things (IoT)">Internet of Things (IoT)</option>
            <option value="Cloud Computing">Cloud Computing</option>
            <option value="Artificial Intelligence (AI)">Artificial Intelligence (AI)</option>
          </select>
        </div>
      </div>

      <div class="w-full md:w-auto">
        <input
          id="searchInput"
          type="text"
          placeholder="Search..."
          class="bg-neutral-800 text-white border border-neutral-700 rounded p-2 mt-2 md:mt-0 w-full md:w-auto" />
      </div>
    </div>

    <!-- blog post cards!!!!!!!!!!!!!!!!!! -->
    <section
      id="cardlist"
      class="grid p-4 md:grid-cols-2 lg:grid-cols-3 mx-auto max-w-screen-lg">
    </section>
  </section>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function() {
    // Initial load
    loadblog();

    // Trigger search on input change
    $('#searchInput').on('keyup', function() {
      loadblog();
    });

    // Add event listeners for sort and category changes
    $('#sort-by, #category').on('change', function() {
      loadblog();
    });


    // Share event listener
    $('#cardlist').on('click', '#copyButton', function(e) {
      e.preventDefault();

      // Get the URL from the data attribute
      var userUrl = $(this).data('url');
      console.log("User URL: " + userUrl); // Log the URL to ensure it’s captured

      // Check if userUrl is valid
      if (!userUrl) {
        alert('URL not found!');
        return;
      }

      // Use Clipboard API to copy the URL
      navigator.clipboard.writeText(userUrl).then(function() {
        alert('URL copied to clipboard!');
      }).catch(function(error) {
        console.error('Failed to copy URL: ', error);
        alert('Failed to copy URL. Try again.');
      });
    });


  });

  function loadblog() {
    // console.log('Sending AJAX request to sort blog...');

    $.ajax({
      url: "./database/request.php",
      method: "POST",
      data: {
        'sort-by': $('#sort-by').val(),
        'category': $('#category').val(),
        'title': $('#searchInput').val(),
        "sort_blog": true,
      },
      success: function(result) {
        // console.log("AJAX request successful!");
        // console.log(result);

        try {
          var datas = JSON.parse(result);
          // console.log(datas); // Log the parsed result to verify it's an array

          var card = ``;

          // Check if there are any results
          if (datas.length > 0) {
            datas.forEach(function(data) {
              card += `
                  <div class="p-2 my-2 bg-neutral-900 max-w-xs shadow rounded-xl mx-auto">
                  <!-- food IMAGE -->
                  <img class="rounded-lg object-cover h-56 w-full" src="images/${data['image']}" />
                  <!-- title, description -->
                  <div class="p-4">
                    <div class="px-1">
                      <h1 class="text-2xl font-bold text-neutral-100 pb-2 hover:text-orange-400">
                        <a href='http://localhost/blog/blog.php?title=${data['title']}'>
                        ${data['title']}
                        </a>
                      </h1>
                      <h2 class="text-sm text-neutral-100 h-16 overflow-hidden line-clamp-3 text-ellipsis">
                        ${data['content']}
                      </h2>
                    </div>
                    <!-- Categories/flairs -->
                    <div class="flex items-center justify-start mt-2 pb-3 flex-wrap">
                      <h2 class="bg-orange-200 text-black text-sm rounded-md px-2 py-1 m-1">
                        ${data['category']}
                      </h2>
                    </div>
                    <div class="flex justify-between text-neutral-600">
                      <button id="heart-button" class="" disabled>
                        <i id="heart-icon" class="fas fa-heart text-orange-600"></i>
                        ${data['likes']}
                      </button>
                      <button id="copyButton" data-url="http://localhost/blog/blog.php?title=${data['title']}" class="hover:text-orange-500">
                        <i class="fa-solid fa-share-nodes fa-lg"></i>
                      </button>
                    </div>
                  </div>
                  </div>`;
            });
          } else {
            card = `
              <div class='col-span-3' style='height:400px;'>
              <h1 class='text-center text-gray-100 mt-20'>No match found!
              </h1>
              </div>
              `;
          }

          $('#cardlist').html(card);
        } catch (e) {
          // console.error("Parsing error:", e);
          // console.error("Response received:", result);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // console.error('Error: ' + textStatus, errorThrown);
        // console.error(jqXHR.responseText);
      }
    });
  }
</script>

