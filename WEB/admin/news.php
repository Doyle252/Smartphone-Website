<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
    exit;
}

if (isset($_POST['add_news'])) {

    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $author = $_POST['author'];
    $author = filter_var($author, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    $link = $_POST['link'];
    $link = filter_var($link, FILTER_SANITIZE_STRING);

    $select_news = $conn->prepare("SELECT * FROM `news` WHERE title = ?");
    $select_news->execute([$title]);

    if ($select_news->rowCount() > 0) {
        $message[] = 'Tiêu đề tin tức đã tồn tại!';
    } else {
        $insert_news = $conn->prepare("INSERT INTO `news`(title, author, content, image, link) VALUES(?,?,?,?,?)");
        $insert_news->execute([$title, $author, $content, $image, $link]);

        if ($insert_news) {
            if ($image_size > 2000000) {
                $message[] = 'Kích thước hình ảnh quá lớn!';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Tin tức đã được thêm vào!';
            }
        }
    }
}

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_news_image = $conn->prepare("SELECT * FROM `news` WHERE new_id = ?");
    $delete_news_image->execute([$delete_id]);
    $fetch_delete_image = $delete_news_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image']);
    $delete_news = $conn->prepare("DELETE FROM `news` WHERE new_id = ?");
    $delete_news->execute([$delete_id]);
    header('location:news.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

    <h1 class="heading">Thêm tin tức</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="flex">
            <div class="inputBox">
                <span>Tiêu đề</span>
                <input type="text" class="box" required maxlength="255" placeholder="Nhập tiêu đề tin tức" name="title">
            </div>
            <div class="inputBox">
                <span>Tác giả</span>
                <input type="text" class="box" maxlength="255" placeholder="Nhập tên tác giả" name="author">
            </div>
            <div class="inputBox">
                <span>Ảnh</span>
                <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
            </div>
            <div class="inputBox">
                <span>Nội dung</span>
                <textarea name="content" placeholder="Nhập nội dung tin tức" class="box" required maxlength="5000" cols="30" rows="10"></textarea>
            </div>
            <div class="inputBox">
                <span>Liên kết</span>
                <input type="url" class="box" maxlength="255" placeholder="Nhập liên kết liên quan" name="link">
            </div>
        </div>

        <input type="submit" value="Thêm tin tức" class="btn" name="add_news">
    </form>

</section>

<section class="show-products">

    <h1 class="heading">Tin tức đã thêm</h1>

    <div class="box-container">

    <?php
        $select_news = $conn->prepare("SELECT * FROM `news`");
        $select_news->execute();
        if ($select_news->rowCount() > 0) {
            while ($fetch_news = $select_news->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <div class="box">
        <img src="../uploaded_img/<?= $fetch_news['image']; ?>" alt="">
        <div class="name"><?= $fetch_news['title']; ?></div>
        <div class="author">Tác giả: <span><?= $fetch_news['author']; ?></span></div>
        <div class="content"><span><?= substr($fetch_news['content'], 0, 100); ?>...</span></div>
        <div class="flex-btn">
            <a href="update_news.php?update=<?= $fetch_news['new_id']; ?>" class="option-btn">Cập nhật</a>
            <a href="news.php?delete=<?= $fetch_news['new_id']; ?>" class="delete-btn" onclick="return confirm('Xóa tin tức này?');">Xóa</a>
        </div>
    </div>
    <?php
            }
        } else {
            echo '<p class="empty">Chưa có tin tức được thêm vào!</p>';
        }
    ?>
    
    </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>
