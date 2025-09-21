<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'Trạng thái thanh toán đã được cập nhật!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đã đặt hàng</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   <link rel="stylesheet" href="../css/admin_filter.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="orders">
<div class="box-container-admin">
   <h1 class="heading">Danh sách đơn hàng</h1>
   <form action="" method="GET" class="filter-form">
         <select name="filter" id="" class="box">
            <option value="all" <?php if(isset($_GET['filter']) && $_GET['filter']=="all") {echo "selected";} ?>>Toàn bộ đơn hàng</option>
            <option value="Đang xử lý" <?php if(isset($_GET['filter']) && $_GET['filter']=="Đang xử lý") {echo "selected";} ?>>Đang xử lý</option>
            <option value="Đang vận chuyển" <?php if(isset($_GET['filter']) && $_GET['filter']=="Đang vận chuyển") {echo "selected";} ?>>Đang vận chuyển</option>
            <option value="Đã giao hàng" <?php if(isset($_GET['filter']) && $_GET['filter']=="Đã giao hàng") {echo "selected";} ?>>Đã giao hàng</option>
         </select>
         <input type="submit" value="Lọc" class="btn" id="">
   </form>
</div>
<div class="box-container">

   <?php
      $filter = isset($_GET["filter"]) ? $_GET["filter"] : "all";
      $query  = "SELECT * FROM `orders`";
      if ($filter != "all") {
          $query .= " WHERE payment_status = '$filter'";
      }
      $query .= " ORDER BY id DESC";
      $select_orders = $conn->prepare($query);
      $select_orders->execute();
      
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p> Đặt trên : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> Họ và tên : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> Số điện thoại : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> Địa chỉ : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> Tổng sản phẩm : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> Tổng thanh toán : <span>$<?= $fetch_orders['total_price']; ?></span> </p>
      <p> Phương thức thanh toán : <span><?= $fetch_orders['method']; ?></span> </p>
      
   <form action="" method="post">
   <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
   <select name="payment_status" class="select">
      <?php if($fetch_orders['payment_status'] == "Đang xử lý"): ?>
         <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
         <option value="Đang vận chuyển">Đang vận chuyển</option>
         <option value="Đã giao hàng">Đã giao hàng</option>
      <?php elseif($fetch_orders['payment_status'] == "Đang vận chuyển"): ?>
         <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
         <option value="Đã giao hàng">Đã giao hàng</option>
      <?php else: ?>
         <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
      <?php endif; ?>
   </select>
   <div class="flex-btn">
      <input type="submit" value="update" class="option-btn" name="update_payment" 
             <?php if ($fetch_orders['payment_status'] == "Đã giao hàng") { 
                echo 'disabled'; echo ' style="pointer-events: none; opacity: 0.5;"'; 
             } ?>>
      <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" 
         class="delete-btn" onclick="return confirm('Xoá đơn hàng này?');" 
         <?php if ($fetch_orders['payment_status'] != "Đang xử lý") { 
            echo 'disabled'; echo ' style="pointer-events: none; opacity: 0.5;"'; 
         }?>>Xoá</a>
   </div>
</form>

   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Chưa có đơn hàng nào được đặt!</p>';
      }
   ?>

</div>

</section>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>