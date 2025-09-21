<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_SESSION['message'])){
   $message[] = $_SESSION['message'];
}

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'Phường '. $_POST['flat'] .',Quận '. $_POST['street'] .', Thành Phố '. $_POST['city'] .', Đường '. $_POST['state'] .', Nước '. $_POST['country'] .' - '. $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $order_items = $_POST['order_items'];
   $total_price = $_POST['total_price'];
   $item_amounts = $_POST['item_amounts'];

   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   
   
   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, order_items, item_amounts) VALUES(?,?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $order_items, $item_amounts]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
      $select_user->execute([$email]);
      $row = $select_user->fetch(PDO::FETCH_ASSOC);

      if ($select_user->rowCount() > 0) {
         date_default_timezone_set('Asia/Ho_Chi_Minh'); // Set timezone về TPHCM
         $currentDateTime = date('Y-m-d H:i:s');

         // Gửi email xác nhận
         require_once "./lib/PHPMailer-master/src/PHPMailer.php"; // Đảm bảo bạn đã tải và cài đặt PHPMailer
         require_once "lib/PHPMailer-master/src/Exception.php";
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
               $mail->CharSet = "UTF-8";
               $mail->smtpConnect([ "ssl" => [
                  "verify_peer"=>false,
                  "verify_peer_name" => false,
                  "allow_self_signed" => true
                     ]
                  ]
            ); 
               // Người gửi
               $mail->setFrom('thainguyen2522004@gmail.com', 'SPhone is here to save the day');
               // Người nhận
               $mail->addAddress($email);
               // Nội dung email
               $mail->isHTML(true);
               $mail->Subject = 'Chi tiết đơn hàng của bạn!';
               $mail->Body    = "Xin chào, <br><br> Cảm ơn bạn đã mua hàng trên trang web của chúng tôi, đây là thông tin chi tiết về đơn hàng của bạn: <br><br> 
                  <p>Ngày đặt hàng: <span>$currentDateTime</span> </p>
                  <p>Họ và tên : <span>$name</span></p>
                  <p>Email : <span>$email</span></p>
                  <p>Số điện thoại : <span>$number</span></p>
                  <p>Địa chỉ : <span>$address</span></p>
                  <p>Phương thức thanh toán : <span>$method</span></p>
                  <p>Đơn hàng của bạn : <span>$total_products</span></p>
                  <p>Tổng : <span>$$total_price</span></p>
                  <p>Trạng thái: <span> Đang xử lý </span>  </p>
                  ";
      
               $mail->send();
               $message[] = 'Thông tin đơn hàng đã được gửi đến email đăng ký của bạn cũng như hiển thị trên trang web chúng tôi!';
         } catch (Exception $e) {
               $message[] = "Đơn hàng đã được đặt.  {$mail->ErrorInfo}";
         }
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
   <title>Thanh toán</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
      #errorMessages {
			margin: 10px 0px;
			background-repeat: no-repeat;
			background-position: 10px center;
         color: #D63301;
         font-size: 2.5rem;
         text-align: center;
      }
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="checkout-orders">

   <form id="checkoutForm" action="" method="POST">

   <h3>Sản phẩm đã mua</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $order_item[]= '';
         $item_amount[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               //
               $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
               $order_item[] = $fetch_cart['name'];
               $item_amount[] = $fetch_cart['quantity'];
               //
               $item_amounts = implode(',', $item_amount);
               $order_items = implode(',',$order_item);
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['name']; ?> <span>(<?= '$'.$fetch_cart['price'].' x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         }else{
            echo '<p class="empty">Giỏ hàng đang trống!</p>';
         }
      ?>
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="order_items" value="<?= $order_items; ?>">
         <input type="hidden" name="item_amounts" value="<?= $item_amounts; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total">Tổng : <span>$<?= $grand_total; ?></span></div>
      </div>

      <h3>Thanh toán</h3>
      <div id="errorMessages"></div>

      <div class="flex">
         <div class="inputBox">
            <span>Họ và tên :</span>
            <input type="text" name="name" placeholder="Tên của bạn" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>Số điện thoại :</span>
            <input type="number" id="number" name="number" placeholder="Số điện thoại" class="box" type="tel" required onkeypress="if(this.value.length == 10) return false;" />
            <!-- <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required> -->
         </div>
         <div class="inputBox">
            <span>Email :</span>
            <input type="email" id="email" name="email" placeholder="Địa chỉ email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Phương thức thanh toán :</span>
            <select name="method" class="box" required>
               <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
               <option value="Thẻ tín dụng">Thẻ tín dụng</option>
               <option value="Chuyển khoản">Chuyển khoản</option>
               <option value="Paytm">Paytm</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Địa chỉ nhà :</span>
            <input type="text" name="flat" placeholder="Số nhà" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Tên đường :</span>
            <input type="text" name="street" placeholder="Tên đường" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Thành phố :</span>
            <input type="text" name="city" placeholder="Thành phố" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Quận :</span>
            <input type="text" name="state" placeholder="Quận" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Nước :</span>
            <input type="text" name="country" placeholder="Tên nước" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>Mã bưu điện :</span>
            <input type="text" name="pin_code" placeholder="Mã bưu điện" class="box" maxlength="20" required>
         </div>
      </div>

      
      <input type="submit" id="submitBtn" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Thanh toán ngay">
      <a href="home.php" class="option-btn">Tiếp tục mua sắm</a>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="./js/script.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
   $(document).ready(function() {
   function validateFields() {
      let email = $('#email').val();
      let number = $('#number').val();
      let isValid = true;

      // Email validation
      if (email!="") { 
         if (!validateEmail(email)) {
            isValid = false;
            $('#email').addClass('error'); // Add error class
            $('#errorMessages').append('<p>Email không hợp lệ!</p>');
         } else {
            $('#email').removeClass('error'); // Remove error class
         }
      }

         // Phone number validation
      if (number!=""){
         if (!validatePhoneNumber(number)) {
            isValid = false;
            $('#number').addClass('error'); // Add error class
            $('#errorMessages').append('<p>Số điện thoại không hợp lệ!</p>');
         } else {
            $('#number').removeClass('error'); // Remove error class
         }
      }
         // Enable or disable submit button
         $('#submitBtn').prop('disabled', !isValid);
   }

   function validateEmail(email) {
      let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(email);
   }

   function validatePhoneNumber(number) {
      let phonePattern = /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/;
      return phonePattern.test(number);
   }


   // Attach the validate function to input events
   $('#email, #number').on('focusout', function() {
      $('#errorMessages').empty(); // Clear previous error messages
      validateFields();
   });

   // Initial validation check
   validateFields();
});



</script>

</body>
</html>
