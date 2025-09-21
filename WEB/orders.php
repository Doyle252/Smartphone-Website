<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đơn hàng</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">Đặt hàng</h1>

   <div class="order-container box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Vui lòng đăng nhập để xem đơn hàng</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
         $select_orders->execute([$user_id]);


         if($select_orders->rowCount() > 0){
            echo '
            <div class="box">
               <table class="order-table">
                  <thead>
                     <tr>
                        <th><span>Sản phẩm đã đặt</span></th>
                        <th><span>Tổng</span></th>
                        <th><span>Trạng Thái</span></th>
                        <th><span>Địa chỉ giao hàng</span></th>
                        <th><span>Thông tin người mua</span></th>
                        <th>Chi tiết sản phẩm</th>
                     </tr>
                  </thead>
                  <tbody>';
               
               while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                  echo '
               <tr>
                  <td>
                     <div class="product-info">
                        <div>
                           <p><span>'.$fetch_orders['total_products'].'</span></p>
                        </div>
                     </div>
                  </td>
                  <td><span>$'.$fetch_orders['total_price'].'</span></td>
                  <td style="color:'.(($fetch_orders['payment_status'] == 'Đang xử lý') ? 'red' : (($fetch_orders['payment_status'] == 'Đã giao hàng') ? 'green' : 'orange')).'">'.$fetch_orders['payment_status'].'</td>
                  <td>
                     <p>Địa Chỉ:<span>'.$fetch_orders['address'].'</span></p>
                  </td>
                  <td>
                     <p>Họ và tên: <span>'.$fetch_orders['name'].'</span></p>
                     <p>Email:<span>'.$fetch_orders['email'].'</span></p>
                     <p>Số điện thoại:<span>'.$fetch_orders['number'].'</span></p>
                  </td>
                    <td>
                     <a href="order_details.php?order_id='.$fetch_orders['id'].'" class="btn">Xem</a>
                  </td>
            </tr>';
               }

               echo '
                  </tbody>
               </table>
            <div/>';
            
         }else{
            echo '<p class="empty">Chưa có đơn hàng nào được đặt!</p>';
         }
      }
   ?>

   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
