<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

if (isset($_POST['update'])) {

    $news_id = $_POST['new_id'];
    $title = $_POST['title'];
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    $content = $_POST['content'];
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    $link = $_POST['link'];

    // Cập nhật thông tin tin tức
    $update_news = $conn->prepare("UPDATE `news` SET title = ?, content = ?, link = ? WHERE new_id = ?");
    $update_news->execute([$title, $content, $link, $news_id]);

    $message[] = 'Tin tức đã được cập nhật thành công!';

    $old_image = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Kích thước hình ảnh quá lớn!';
        } else {
            $update_image = $conn->prepare("UPDATE `news` SET image = ? WHERE new_id = ?");
            $update_image->execute([$image, $news_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            unlink('../uploaded_img/' . $old_image);
            $message[] = 'Ảnh đã được cập nhật thành công!';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật tin tức</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

    <h1 class="heading">Cập nhật tin tức</h1>

    <?php
    $update_id = $_GET['update'];
    $select_news = $conn->prepare("SELECT * FROM `news` WHERE new_id = ?");
    $select_news->execute([$update_id]);
    if ($select_news->rowCount() > 0) {
        while ($fetch_news = $select_news->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="new_id" value="<?= $fetch_news['new_id']; ?>">
        <input type="hidden" name="old_image" value="<?= $fetch_news['image']; ?>">
        <div class="image-container">
            <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_news['image']; ?>" alt="">
            </div>
        </div>
        <span>Tác giả</span>
        <input type="text" name="author" required class="box" maxlength="1000" placeholder="Nhập tiêu đề tin tức" value="<?= $fetch_news['author']; ?>">
        <span>Tiêu đề</span>
        <input type="text" name="title" required class="box" maxlength="1000" placeholder="Nhập tiêu đề tin tức" value="<?= $fetch_news['title']; ?>">
        <span>Nội dung</span>
        <textarea name="content" class="box" required cols="30" rows="10" placeholder="Nhập nội dung tin tức"><?= $fetch_news['content']; ?></textarea>
        <span>Link liên quan</span>
        <textarea name="link" class="box" required cols="30" rows="10" placeholder="Nhập tin liên quan"><?= $fetch_news['link']; ?></textarea>
        <span>Ảnh</span>
        <input type="file" name="image" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
        <div class="flex-btn">
            <input type="submit" name="update" class="btn" value="Cập nhật">
            <a href="news.php" class="option-btn">Trở lại</a>
        </div>
    </form>
    <?php
        }
    } else {
        echo '<p class="empty">Không tìm thấy tin tức!</p>';
    }
    ?>

</section>

<script src="../js/admin_script.js"></script>

</body>
</html>
