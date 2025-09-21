<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Bảng điều khiển</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <h1 class="heading">Bảng điều khiển</h1>

   <div class="box-container">

      <div class="box">
         <h3>Xin chào!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="update_profile.php" class="btn">Cập nhật hồ sơ</a>
      </div>

      <div class="box">
         <?php
            $total_pendings = 0;
            $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_pendings->execute(['Đang xử lý']);
            $number_of_pendings_order = $select_pendings->rowCount();
            if($select_pendings->rowCount() > 0){
               while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                  $total_pendings += $fetch_pendings['total_price'];
               }
            }
         ?>
         <h3><span>$</span><?= $total_pendings; ?><span></span></h3>
         <p>Đơn hàng đang chờ xử lý: <?php echo $number_of_pendings_order ?></p>
         <a href="placed_orders.php?filter=Đang+xử+lý" class="btn">Xem đơn hàng</a>
      </div>

      <div class="box">
         <?php 
         $total_shippings = 0;
         $select_shippings = $conn->prepare('SELECT * FROM `orders` WHERE payment_status = ?');
         $select_shippings->execute(['Đang vận chuyển']);
         $number_of_shippings_order = $select_shippings->rowCount();
         if($select_shippings->rowCount() > 0){
            while($fetch_shippings = $select_shippings->fetch(PDO::FETCH_ASSOC)){
               $total_shippings += $fetch_shippings['total_price'];
            }
         }
         ?>
         <h3><span>$</span><?= $total_shippings; ?></h3>
         <p>Số đơn đang vận chuyển: <?php echo $number_of_shippings_order ?></p>
         <a href="placed_orders.php?filter=Đang+vận+chuyển" class="btn">Xem đơn hàng</a>
      </div>

      <div class="box">
         <?php
            $total_completes = 0;
            $select_completes = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
            $select_completes->execute(['Đã giao hàng']);
            $number_of_completes_order = $select_completes->rowCount();
            if($select_completes->rowCount() > 0){
               while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
                  $total_completes += $fetch_completes['total_price'];
               }
            }
         ?>
         <h3><span>$</span><?= $total_completes; ?><span></span></h3>
         <p>Đơn hàng đã hoàn thành: <?php echo $number_of_completes_order ?></p>
         <a href="placed_orders.php?filter=Đã+giao+hàng" class="btn">Xem đơn hàng</a>
      </div>


      <div class="box">
         <?php
            $select_orders = $conn->prepare("SELECT * FROM `orders`");
            $select_orders->execute();
            $number_of_orders = $select_orders->rowCount()
         ?>
         <h3><?= $number_of_orders; ?></h3>
         <p>Tổng đơn hàng trên server</p>
         <a href="placed_orders.php" class="btn">Xem đơn hàng</a>
      </div>

      <div class="box">
         <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount()
         ?>
         <h3><?= $number_of_products; ?></h3>
         <p>Thêm sản phẩm</p>
         <a href="products.php" class="btn">Xem sản phẩm</a>
      </div>

      <div class="box">
         <?php
            $select_news = $conn->prepare("SELECT * FROM `news`");
            $select_news->execute();
            $number_of_news = $select_news->rowCount()
         ?>
         <h3><?= $number_of_news; ?></h3>
         <p>Thêm tin</p>
         <a href="news.php" class="btn">Xem tin hiện tại</a>
      </div>

      <div class="box">
         <?php
            $select_users = $conn->prepare("SELECT * FROM `users`");
            $select_users->execute();
            $number_of_users = $select_users->rowCount()
         ?>
         <h3><?= $number_of_users; ?></h3>
         <p>Người dùng</p>
         <a href="users_accounts.php" class="btn">Xem người dùng</a>
      </div>

      <div class="box">
         <?php
            $select_admins = $conn->prepare("SELECT * FROM `admins`");
            $select_admins->execute();
            $number_of_admins = $select_admins->rowCount()
         ?>
         <h3><?= $number_of_admins; ?></h3>
         <p>Admin</p>
         <a href="admin_accounts.php" class="btn">Xem admin</a>
      </div>

      

   </div>

</section>

<script src="../js/admin_script.js"></script>
   
</body>
</html>