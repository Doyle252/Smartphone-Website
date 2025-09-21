<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if(isset($_GET['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Giỏ hàng đã được cập nhật';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giỏ hàng</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="cart orders products shopping-cart">

   <h3 class="heading">Giỏ hàng</h3>

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
                  <th><span>Xóa</span></th>
               </tr>
            </thead>
            <tbody>
               <?php
                  $grand_total = 0;
                  $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                  $select_cart->execute([$user_id]);
                  if($select_cart->rowCount() > 0){
                     while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                        $sub_total = $fetch_cart['price'] * $fetch_cart['quantity'];
               ?>
               <tr>
                  <td>
                     <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>">
                     <img style="width: 200px; height:200px;" src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">  </a> 
                  </td>
                  <td><p><span><?= $fetch_cart['name']; ?></span></p></td>
                  <td><p><span>$<?= $fetch_cart['price']; ?></span></p></td>
                  <td>
                     <form action="" method="post" class="update-qty-form">
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        <input type="number" name="qty" class="qty larger-input" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" onkeypress="if(this.value.length == 2) return false;">
                        <button type="submit" class="fas fa-edit" name="update_qty"></button>
                     </form>
                  </td>
                  <td><p><span>$<?= $sub_total; ?></span></p></td>
                  <td>
                     <form action="" method="post">
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        <input type="submit" value="Xoá sản phẩm" onclick="return confirm('Bạn muốn xoá sản phẩm này?');" class="delete-btn" name="delete">
                     </form>
                  </td>
               </tr>
               <?php
                        $grand_total += $sub_total;
                     }
                  } else {
                     echo '<tr><td colspan="7"><p class="empty">Giỏ hàng đang trống</p></td></tr>';
                  }
               ?>
            </tbody>
         </table>
      </div>
   </div>



   
   <div class="cart-total">
      <p>Tổng : <span>$<?= $grand_total; ?></span></p>
      <a href="home.php" class="option-btn">Tiếp tục mua sắm</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('Bạn muốn xoá tất cả sản phẩm?');">Xoá tất cả sản phẩm</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Thanh toán</a>
   </div>

</section>





<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>