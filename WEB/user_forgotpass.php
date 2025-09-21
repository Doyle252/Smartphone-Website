<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   
   if (filter_var($email, FILTER_VALIDATE_EMAIL)==false) {
    $message[] = 'Email không hợp lệ!';
    }
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   if ($select_user->rowCount() > 0) {
     // Tạo mã xác nhận ngẫu nhiên
     $reset_token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT); // Mã OTP ngẫu nhiên 6 chữ số

    //  $expire_time = date("Y-m-d H:i:s", strtotime("+1 hour")); // Hết hạn sau 1 giờ
 
     // Lưu mã này vào cơ sở dữ liệu
     $update_token = $conn->prepare("UPDATE `users` SET reset_token = ?, reset_expire = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email = ?");
     $update_token->execute([$reset_token, $email]);
 
     // Gửi email xác nhận
     require_once "./lib/PHPMailer-master/src/PHPMailer.php"; // Đảm bảo bạn đã tải và cài đặt PHPMailer
     require_once "lib/PHPMailer-master/src/Exception.php";
    //  require_once "PHPMailer-master/src/OAuth.php";
     require_once "lib/PHPMailer-master/src/SMTP.php";
 

     $mail = new PHPMailer\PHPMailer\PHPMailer(true);
     try {
         // Cấu hình máy chủ email của bạn
         $mail->SMTPDebug = 0;
         $mail->isSMTP();
         $mail->Host = 'smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = '2251120241@ut.edu.vn';
         $mail->Password = 'Sang@123';
         $mail->SMTPSecure = 'ssl';
         $mail->Port = 465;
         $mail -> CharSet = "UTF-8";
         $mail->smtpConnect([ "ssl" => [
            "verify_peer"=>false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
                ]
            ]
        ); 
         // Người gửi
         $mail->setFrom('Doanlt@gmail.com', 'SPhone is here to save the day');
         // Người nhận
         $mail->addAddress($email);
         // Nội dung email
         $mail->isHTML(true);
         $mail->Subject = 'Đặt lại mật khẩu của bạn';
         $mail->Body    = "Xin chào, <br><br> Bạn đã yêu cầu đặt lại mật khẩu. Vui lòng sử dụng mã xác minh dưới đây để đặt lại mật khẩu của bạn: <br><br> <b>$reset_token</b><br><br> Mã này sẽ hết hạn sau 1 giờ.";
 
         $mail->send();
         $message[] = 'Mã xác minh đã được gửi đến email của bạn!';
         header('Location: user_resetpass.php');
     } catch (Exception $e) {
         $message[] = "Email không thể gửi được. Lỗi: {$mail->ErrorInfo}";
     }
   } else {
    $message[] = "Email này không tồn tại!!";
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
      <h3>Bạn quên mật khẩu? Đã có SPhone:</h3>
      <input type="email" name="email" required placeholder="Email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Lấy Mã Xác Minh" class="btn" name="submit">
      <p>Bạn chưa có tài khoản?</p>
      <a href="user_register.php" class="option-btn">Đăng ký</a>
   </form>

</section>




<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
