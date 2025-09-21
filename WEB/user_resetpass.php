<?php 
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if (isset($_POST['submit'])){ 
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $new_password = sha1($new_password); //Băm mật khẩu mới thành SHA1 Hash để lưu vào csdl

    //Kiểm tra mã xác minh và mật khẩu mới
    $select_token = $conn->prepare('SELECT * FROM `users` WHERE reset_token = ? AND reset_expire > NOW()');
    $select_token->execute([$token]);
    $row = $select_token->fetch(PDO::FETCH_ASSOC);

    if($select_token->rowCount() > 0) {
        //Cập nhật mật khẩu mới vào csdl và xóa mã xác minh
        $update_user = $conn->prepare('UPDATE `users` SET password= ?, reset_token= NULL, reset_expire = NULL WHERE reset_token = ?');
        $update_user->execute([$new_password,$token]);
        $message[] = 'Mật khẩu đã được thay đổi thành công, bạn có thể thử đăng nhập!';
    } else {
        $message[] = 'Mã xác minh không hợp lệ hoặc đã hết hạn!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quên mật khẩu:</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">
   <form action="" method="post">
      <h3>Đặt lại mật khẩu</h3>
      <input type="text" name="token" required placeholder="Mã xác minh" maxlength="64" class="box">
      <input type="password" name="new_password" required placeholder="Mật khẩu mới" maxlength="20" class="box">
      <input type="submit" value="Cập nhật mật khẩu" class="btn" name="submit">
   </form>
</section>




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
