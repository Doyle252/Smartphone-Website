<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Quick View</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/quick_view.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="quick-view orders products shopping-cart">

   <h3 class="heading">Xem sản phẩm</h3>

   <div class="cart-container box-container">
      <div class="box">
         <table class="cart-table">
            <thead>
               <tr>
                  <th><span>Sản phẩm</span></th>
                  <th><span>Tên sản phẩm</span></th>
                  <th><span>Giá sản phẩm</span></th>
                  <th><span>Số lượng</span></th>
                  <th><span>Tổng</span></th>
               </tr>
            </thead>
            <tbody>
               <?php
                  $grand_total = 0;
                  $order_id = $_GET['order_id'];

                  // Fetch order items and item amounts from the order
                  $fetch_order_details = $conn->prepare('SELECT order_items, item_amounts FROM `orders` WHERE id = ?');
                  $fetch_order_details->execute([$order_id]);
                  $order_details = $fetch_order_details->fetch(PDO::FETCH_ASSOC);

                  if ($order_details) {
                     $order_items = explode(',', $order_details['order_items']);
                     $amounts_array = explode(',', $order_details['item_amounts']);

                     // Remove any empty elements and ensure arrays match in length
                     $order_items = array_filter($order_items);
                     $amounts_array = array_filter($amounts_array, 'is_numeric');
                     $amounts_array = array_map('intval', $amounts_array);
                  }

                  if(count($order_items) === count($amounts_array)) {
                     foreach($order_items as $index => $item_name) {
                        $fetch_product = $conn->prepare('SELECT * FROM `products` WHERE name = ?');
                        $fetch_product->execute([$item_name]);
                        $fetch_order = $fetch_product->fetch(PDO::FETCH_ASSOC);

                        if($fetch_order) {
                           $quantity = $amounts_array[$index]; // Match quantity with product
                           $sub_total = $fetch_order['price'] * $quantity;
                           $grand_total += $sub_total;
               ?>
               <tr>
                  <td>
                     <a href="quick_view.php?pid=<?= $fetch_order['id']; ?>">
                     <img style="width: 200px; height:200px;" src="uploaded_img/<?= $fetch_order['image_01']; ?>" alt="">  </a> 
                  </td>
                  <td><p><span><?= $fetch_order['name']; ?></span></p></td>
                  <td><p><span>$<?= $fetch_order['price']; ?></span></p></td>
                  <td><p><span><?= $quantity; ?></span></p></td>
                  <td><p><span>$<?= $sub_total; ?></span></p></td>
               </tr>
               <?php
                        }
                     }
                  } else {
                     echo '<tr><td colspan="5"><p class="empty">Không có sản phẩm nào trong đơn hàng</p></td></tr>';
                  }
               ?>
            </tbody>
         </table>
      </div>
   </div>
   
   <div class="cart-total">
      <p>Tổng : <span>$<?= $grand_total; ?></span></p>
      <a href="home.php" class="option-btn">Tiếp tục mua sắm</a>
      <a href="orders.php" class="btn">Trở về</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
