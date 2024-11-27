<?php
  if (session_status() == PHP_SESSION_NONE) {
    session_start();  // Start session
}

?>

<!DOCTYPE html>
<html lang="EN">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Meow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />

    <!-- <script src="/admin/script.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
  </head>

  <body class="bg-neutral-800">
    <nav class="bg-neutral-900 sticky top-0 z-[99999]">
      <div
        class="container mx-auto flex justify-between items-center p-4 max-w-screen-lg"
      >
      <a href="index.php" class="text-white font-bold text-xl lg:text-left w-full"
          >LinkTechTalk</a
        >
        <div class="lg:flex items-center space-x-8 font-semibold">
          <!-- isset blah blah mo nalang -->
          <?php echo isset($_SESSION['username']) ?

           '<div class="relative inline-block text-left">
               <button
                class="flex items-center text-white"
                onclick="toggleUserMenu(event)"
              >
                <i class="fas fa-user fa-lg hover:text-orange-400"></i>
                <h1 class="block px-4 py-2 text-white-400 rounded-md hover:text-orange-400">
                '.$_SESSION['username'].'
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
          ';?>
        </div>
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

      <div
        id="mobileMenu"
        class="hidden bg-neutral-900 p-4 lg:hidden shadow-lg font-semibold"
      >
        <a
          href=""
          class="block text-white hover:text-neutral-400 py-2"
          >Logout</a
        >
      </div>
    </nav>




    <section class="max-w-screen-md mx-auto p-2 md:p-2">
      <div class="mt-2 md:mt-10">
        <div id="image_placeholder" class="relative w-full aspect-[7/8] sm:aspect-[16/9]">
          <!-- image here -->
        </div>

        <div class="pt-2">
          <!-- <button
            id="heart-button"
            class="text-white text-xl"
            onclick="toggleHeart()"
          >
            <i id="heart-icon" class="fas fa-heart text-orange-400 text-xl"></i>
          </button> -->
        </div>

        <div id="category_placeholder" class="flex items-center justify-start mt-0 pb-3 flex-wrap">
   
        </div>

        <div id="title_author_date" class="mt-0">
          <!-- title -->
        </div>

        <div id="content_placeholder" class="py-10 text-sm md:text-lg text-justify indent-10 md:indent-20 text-neutral-200">
          <!-- content here -->
        </div>
        
        <div id="likes_placeholder" class="mt-0">
          <!-- like -->
        </div>
      </div>

      <div>
        <div class="w-full bg-neutral-800 rounded-lg p-6 my-4">
          <h3 class="font-bold text-white">Discussion</h3>

            <div class="flex flex-col">
              <div id="comments" class="rounded-md p-3 my-3 bg-neutral-700 overflow-auto">
                <!-- comments here! -->
              </div>
            </div>
          
          <form id="addCommentForm">
            <div class="w-full my-2">
              <textarea
                class="bg-neutral-700 rounded border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-500 text-white focus:outline-none focus:bg-neutral-600"
                name="text"
                placeholder="Type Your Comment"
                required
              ></textarea>
            </div>

            <div id="hidden_input">
              <input type="hidden" id="blogId" name="blogId" value="${data['id']}">
            </div>
            <?php isset($_SESSION['username']) ? 
           `<input type="hidden" id="username" name="username" value="`.$_SESSION['username'].`">`
          :`<div>`;?>
            
            <div class="w-full flex justify-end">
              <input
                type="submit"
                class="px-2.5 py-1.5 rounded-md text-white text-sm bg-indigo-500"
                value="Post Comment"
              />
            </div>
          </form>
        </div>
      </div>
    </section>
  </body>

  <script type="text/javascript">
  
  $(document).ready(function() {
    var currentUrl = window.location.href;
    var queryString = currentUrl.split('?')[1];

    if (queryString) {
      var params = new URLSearchParams(queryString);
      var title = decodeURIComponent(params.get('title'));

      getblog(title);
      getcomments(title);
      console.log(title);

      var username = "<?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?>";
      if (!username) {
        $('#addcomment').prop('disabled', true);
      }

      $("#addCommentForm").submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        if (!username) {
          alert("Please log in first!");
          return; // Stop the form from submitting
        }

        var formData = {
          'post_id': $("#blogId").val(),
          'text': $("textarea[name=text]").val(),
          'username': username,
          "add_comments": true
        };

        console.log("Form Data:", formData); // Debugging log

        $.ajax({
          type: "POST",
          url: "./database/request.php",
          data: formData,
          success: function(response) {
            console.log("Server Response:", response); // Debugging log
            if (response.trim() === "success") {
              alert("Comment posted successfully!");
              $("textarea[name=text]").val(''); // Clear the textarea
              getblog(title); // Refresh blog content
              getcomments(title); // Refresh comments
            } else {
              alert("Failed to post comment: " + response); // Log the response on failure
            }
          },
          error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText); // Debugging log for AJAX error
          }
        });
      });

      $(document).on('click', '#likeButton', function() {
      if (!username) {
        alert("Please log in first!");
        return; // Stop if user is not logged in
      }

      var postId = $(this).data('post-id');
      var liked = $(this).data('liked') === 'true';
      var $button = $(this); // Reference to the button clicked
      var $likeCount = $("#likeCount");

      $.ajax({
        type: "POST",
        url: "./database/request.php",
        data: {
          'post_id': postId,
          'toggle_like': true,
          'liked': liked
        },
        success: function(response) {
          if (response.trim() === "success") {
            var likeCount = parseInt($likeCount.text().trim());
            likeCount = isNaN(likeCount) ? 0 : likeCount; // Ensure likeCount is a number

            if (liked) {
              $likeCount.text(likeCount - 1);
              $button.data('liked', 'false').text('Like');
            } else {
              $likeCount.text(likeCount + 1);
              $button.data('liked', 'true').text('Unlike');
            }
            } else {
              alert("Failed to toggle like: " + response);
            }
          },
          error: function(xhr, status, error) {
            console.error("Error:", xhr.responseText);
          }
        });
      });
    }
  });


  function getblog(title){
    $.ajax({
      url: "./database/request.php",
      method: "POST",
      data: {
        'title': title,
        "load_blog": true,
      },
      success: function(result) {
        // console.log("AJAX request successful!");
        // console.log(result);

        try {
          var datas = JSON.parse(result);
          // console.log(datas); // Log the parsed result to verify it's an array

          var hidden_id = ``;
          var image = ``;
          var content = ``;
          var title_author_date = ``;
          var category = ``;
          var likes = ``;

          // Check if there are any results
          if (datas.length > 0) {
            datas.forEach(function(data) {
              image += `
                   <img
                      src="images/${data['image']}"
                      alt="Chocolate Cake"
                      class="absolute inset-0 w-full h-full object-cover rounded-xl"
                    />`;
              content += `${data['content']}`;
              title_author_date  += `
                    <h1 class="font-bold text-3xl md:text-4xl text-white">
                      ${data['title']}
                    </h1>
                    <h2 id="author&date" class="font-semibold text-sm text-neutral-500">
                      Uploaded by ${data['author']} ${data['datetime']} 
                    </h2>`
              ;
              category += `
                    <h2
                     class="bg-neutral-200 text-black text-sm rounded-md px-2 py-1 mt-2 mr-2"
                      >
                        ${data['category']}
                    </h2>
              `
              ;
              hidden_id += `
                    <input type="hidden" id="blogId" name="blogId" value="${data['id']}">
                    <input type="hidden" id="title" name="title" value="${data['title']}">
                    `
              ;
              likes += `
                    <button id="likeButton" data-post-id="${data['id']}" data-liked="false" class="px-2.5 py-1.5 rounded-md text-white text-sm bg-indigo-500">Like</button>
                    <span id="likeCount" class="text-white ml-2">${data['likes']}</span>

              `
            ;
            });
          }
          $('#image_placeholder').html(image);
          $('#content_placeholder').html(content);
          $('#title_author_date').html(title_author_date );
          $('#category_placeholder').html(category);
          $('#hidden_input').html(hidden_id);
          $('#likes_placeholder').html(likes);
        } catch (e) {
          console.error("Parsing error:", e);
          console.error("Response received:", result);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus, errorThrown);
        console.error(jqXHR.responseText);
      }
    });
  }

  function getcomments(title) {
  $.ajax({
    url: "./database/request.php",
    method: "POST",
    data: {
      'title': title,
      "load_comment": true,
    },
    success: function(result) {
      try {
        var datas = JSON.parse(result);
        var comment = ``;

        // Check if there are any results
        if (datas.length > 0) {
          datas.forEach(function(data) {
            comment += `
              <div class="flex gap-3 items-center">
                <img
                  src="https://cdn-icons-png.freepik.com/512/12467/12467867.png"
                  class="object-cover w-12 h-12 rounded-md border-2 border-white shadow-emerald-400"
                />
                <div class="grid grid-rows-2">
                  <div class="row-span-1">
                    <h3 class="font-bold text-white">${data['username']}</h3>
                  </div>
                  <div class="row-span-1">
                    <h3 class="text-sm font-bold text-white">${data['commentdate']}</h3>
                  </div>
                </div>
              </div>
              <p class="text-gray-300 mt-2">${data['text']}</p>`;
          });
        } else {
          comment = `<p class="text-gray-500 mt-2">No comments yet. Be the first to comment!</p>`;
        }

        $('#comments').html(comment);
      } catch (e) {
        console.error("Parsing error:", e);
        console.error("Response received:", result);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error('Error: ' + textStatus, errorThrown);
      console.error(jqXHR.responseText);
    }
  });
}

  </script>
</html>
