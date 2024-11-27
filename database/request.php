<?php


require "db.php";
$mydb = new myDB();

if (isset($_POST['adminlogin'])) {
    $userInput = $_POST['userInput'];
    $password = $_POST['password'];

    // Fetch user from the database using username
    $stmt = $mydb->getConnection()->prepare("SELECT * FROM admin WHERE username = ?");
    $stmt->bind_param("s", $userInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username']; // Save the username in the session
            echo "success";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
    $stmt->close();
}

if (isset($_POST['addblog'])) {
    $author = $_POST['author'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "../images/";
        $target_file = $target_dir . basename($image);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO blog (author, title, category, content, image, datetime) VALUES (?, ?, ?, ?, ?, NOW())";
                $stmt = $mydb->getConnection()->prepare($sql);
                $stmt->bind_param("sssss", $author, $title, $category, $content, $image);

                if ($stmt->execute()) {
                    echo "success";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "Image file not set or there was an error uploading.";
    }
}

if(isset($_POST['get_blog'])){
    $datas = [];
    $mydb->getblog();
    while($row= $mydb->res->fetch_assoc()){
        array_push($datas,$row);
    }
    echo json_encode($datas);
}

if(isset($_POST['get_post'])){
    $datas = [];
    $sql = "SELECT COUNT(*) AS post_count FROM blog";
    $stmt = $mydb->getConnection()->query($sql);

    if($row = $stmt->fetch_assoc()){
        $datas[] = $row; 
    }

    echo json_encode($datas);
}



if (isset($_POST['updateblog'])) {
    $ID = $_POST['id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $content = $_POST['content'];
    
    $mydb = new myDB;
    $conn = $mydb->getConnection();

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $target_dir = "../images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image = null;
    }

    // Prepare the SQL update statement
    $sql = "UPDATE blog SET title=?, category=?, content=?, updatetime=NOW()";
    $params = [$title, $category, $content];

    if ($image !== null) {
        $sql .= ", image=?";
        $params[] = $image;
    }

    $sql .= " WHERE id=?";
    $params[] = $ID;

    $stmt = $conn->prepare($sql);
    $types = str_repeat('s', count($params)-1) . 'i';
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }

    $stmt->close();
}

if (isset($_POST['sort_blog'])) {
    $sort_by = $_POST['sort-by'];
    $category = $_POST['category'];
    $search = $_POST['title'];
  
    $allowed_sort_columns = ['title', 'category', 'content', 'datetime', 'popularity'];
    $allowed_sort_orders = ['ASC', 'DESC'];

    list($column, $order) = explode(' ', $sort_by);

    if (!in_array($column, $allowed_sort_columns) || !in_array($order, $allowed_sort_orders)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid sort parameters.']);
        exit;
    }

    $datas = [];
    $sql = "SELECT * FROM blog";
    $params = [];
    $types = "";

    if (!is_null($search) && $search !== '') {
        $sql .= " WHERE (title LIKE ? OR content LIKE ?)";
        $search_param = "%$search%";
        $params[] = &$search_param;
        $params[] = &$search_param;
        $types .= "ss";
    }

    if ($category !== '*') {
        $sql .= (!empty($types) ? " AND" : " WHERE") . " category LIKE ?";
        $category_param = "%$category%";
        $params[] = &$category_param;
        $types .= "s";
    }

    $sql .= " ORDER BY $column $order";
    $stmt = $mydb->getConnection()->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    if ($stmt === false) {
        echo json_encode(['status' => 'error', 'message' => $mydb->getConnection()->error]);
        exit;
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        array_push($datas, $row);
    }

    echo json_encode($datas);
    exit;
}


if(isset($_POST['load_blog'])){
    $title = $_POST['title'];
    $datas = [];
    
    $sql = "SELECT * FROM blog WHERE title = ?";
    $stmt = $mydb->getConnection()->prepare($sql);
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $datas[] = $row;
    }

    echo json_encode($datas);
}


if(isset($_POST['load_comment'])){
    $title = $_POST['title'];
    $datas = [];
    
    $sql = "SELECT * from comments join blog on blog.id=comments.post_id
 WHERE title = ?";
    $stmt = $mydb->getConnection()->prepare($sql);
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $datas[] = $row;
    }

    echo json_encode($datas);
}


if(isset($_GET['delete'])){
    $ID = $_GET['delete'];
    $mydb->delete('blog',$ID);
    unset($_GET['delete']);
    header("location: ../");
}


if (isset($_POST['login'])) {
    $userInput = $_POST['userInput'];
    $password = $_POST['password'];

    // Fetch user from the database using email or username
    $stmt = $mydb->getConnection()->prepare("SELECT * FROM user WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $userInput, $userInput);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username']; // Save the username in the session
            echo "success";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username or email.";
    }
    $stmt->close();
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $datas = [
        'username' => $username,
        'password' => $hashed_password,
        'email' => $email
    ];

    $mydb->registerUser('user', $datas);
    
    echo "success";
    exit(); 
}

if (isset($_POST['add_comments'])) {
    
    // Collect data
    $postId = $_POST['post_id'];
    $text = $_POST['text'];
    $username = $_POST['username'];

    // Insert comment into the database
    $sql = "INSERT INTO comments (username, post_id, commentdate, text) VALUES (?, ?, NOW(), ?)";
    $stmt = $mydb->getConnection()->prepare($sql);

    if ($stmt === false) {
        echo 'Prepare failed: ' . $mydb->getConnection()->error;
        exit();
    }

    $stmt->bind_param("sis", $username, $postId, $text);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'Error: ' . $stmt->error;
    }
    $stmt->close();
}

if (isset($_POST['toggle_like'])) {
        $postId = $_POST['post_id'];
        $liked = $_POST['liked'] === 'true';

        // Update like count in the database
        if ($liked) {
            $sql = "UPDATE blog SET likes = likes - 1 WHERE id = ?";
        } else {
            $sql = "UPDATE blog SET likes = likes + 1 WHERE id = ?";
        }

        $stmt = $mydb->getConnection()->prepare($sql);
        if ($stmt === false) {
            echo 'Prepare failed: ' . $mydb->getConnection()->error;
            return;
        }

        $stmt->bind_param("i", $postId);
        
        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
        return;
    }