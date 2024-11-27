$(document).ready(function() {

    // Trigger for delete
    $(document).on('click', '#deleteInput', function() {
      var value = $(this).val();
      $('#deleteModal').modal('show');
      $('#deleteModal').on('click', '#modalSureDelete', function() {
          $('#deleteModal').modal('hide');
          delete_blog(value);
      });
    });


  $('#blogForm').on('submit', function(e) {
    e.preventDefault(); // Prevent form from submitting the traditional way

    tinymce.triggerSave(); // Ensure TinyMCE content is saved to the textarea

    var formData = new FormData(this); // Create FormData object
    formData.append('addblog', true); // Add 'addblog' to FormData
    formData.append('author_id', 1); // Add 'author_id' to FormData

    $.ajax({
      url: '../database/request.php',
      type: 'POST',
      data: formData, // Send FormData directly
      contentType: false,
      processData: false,
      success: function(response) {
        console.log("AJAX request successful!");
        console.log(response);
        window.location.href = 'index.php';
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error('Error: ' + textStatus, errorThrown);
      }
    });
  });
});
  

function loadblog(){
  $.ajax({
      url:"../database/request.php",
      method:"POST",
      data:{
          "get_blog":true,
      },
      success:function(result){
          var tBody = ``;
          var card = ``;
          var datas =JSON.parse(result);
          datas.forEach(function(data){
              tBody += `<tr class="border-b border-neutral-700">`;
                  tBody +=`<td class="py-3 px-6">${data['title']}</td>`;
                  tBody +=`<td class="py-3 px-6"><img src="../images/${data['image']}" class="border-4 border-solid border-neutral-850 rounded-lg" width="150" height="100"></td>`;
                  tBody +=`<td class="py-3 px-6">${data['author']}</td>`;
                  tBody +=`<td class="py-3 px-6">${data['datetime']}</td>`;
                  tBody +=`<td  class="py-3 px-6 text-right">
                              <a
                                href="edit.php?id=${data['id']}"
                                class="bg-neutral-500 text-white px-4 py-2 rounded hover:bg-orange-600">
                                Update
                              </a>
                           </td>`;
                  tBody +=`<td  class="py-3 px-6 text-left">
                              <button
                                id="deleteInput"
                                value="${data['id']}"
                                class="bg-neutral-500 text-white px-4 py-2 rounded hover:bg-orange-600"
                                >Delete
                              </button>
                            </td>`;
              tBody += `</tr>`;
              card += `   <div class="bg-neutral-900 p-4 rounded-lg">
                <h3 class="text-white font-bold text-md">
                ${data['title']}
                </h3>
                <p class="text-neutral-400 pb-6">${data['author']} • ${data['datetime']}</p>
                <div class="text-right">
                  <a
                    href="edit.php?id=${data['id']}"
                    class="bg-neutral-500 text-white px-4 py-2 rounded hover:bg-orange-600"
                    >Update</a
                  >
                  <button
                    id="deleteInput"
                    value="${data['id']}"
                    class="bg-neutral-500 text-white px-4 py-2 rounded hover:bg-orange-600"
                    >Delete
                  </button>
                </div>
              </div> `;

          });
      $('#bloglist').html(tBody);
      $('#cardlist').html(card);
      },
      error:function(error){
          // alert("Something went wrong!");
      }
  })
}

function countpost() {
  $.ajax({
    url: "./database/request.php",
    method: "POST",
    data: { "get_post": true },
    success: function(result) {
      console.log("Raw result:", result); // Log raw result
      try {
        var data = JSON.parse(result);
        console.log("Parsed data:", data); // Log parsed data
        var postTotal = data[0]['post_count'];
        $('#totalPost').html(postTotal); // Update the HTML content
      } catch (e) {
        console.error("Parsing error:", e);
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX error:", xhr.responseText); // Log detailed error
    }
  });
}



function delete_blog(id=""){
  $.ajax({
      url:"../database/request.php",
      method:"get",
      data:{
          "delete":id,
      },
      success:function(response){
          loadblog();
          countpost();
      },
      error:function(error){
          alert("Something went wrong!");
          // console.log(error);
      }
  })
}