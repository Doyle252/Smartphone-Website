<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   $anHien = $_POST['anHien'];

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'Tên sản phẩm đã tồn tại!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03,anHien) VALUES(?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $image_01, $image_02, $image_03, $anHien]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'Kích thước hình ảnh quá lớn!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'Sản phẩm đã được thêm vào!';
         }

      }

   }  

};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];

   // Check if the product exists in any order's total_products column
   $check_order = $conn->prepare("SELECT EXISTS (SELECT 1 FROM `orders` WHERE FIND_IN_SET((SELECT name FROM `products` WHERE id = ?), order_items)) as in_orders");
   $check_order->execute([$delete_id]);
   $in_orders = $check_order->fetchColumn();

   if($in_orders){
      $message[] = 'Không thể xóa sản phẩm này vì nó có trong một đơn hàng!';
   } else {
      // Fetch and delete product images
      $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $delete_product_image->execute([$delete_id]);
      $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);

      unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
      unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
      unlink('../uploaded_img/'.$fetch_delete_image['image_03']);

      // Delete the product
      $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
      $delete_product->execute([$delete_id]);

      // Delete related cart and wishlist entries
      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
      $delete_cart->execute([$delete_id]);

      $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
      $delete_wishlist->execute([$delete_id]);

      $message[] = 'Sản phẩm đã bị xóa!';
      header('location:products.php');
      exit();
   }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   <link rel="stylesheet" href="../css/admin_filter.css">

   <style>
     
      
      

   </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>Tên sản phẩm</span>
            <input type="text" class="box" required maxlength="100" placeholder="Nhập tên sản phẩm" name="name">
         </div>
         <div class="inputBox">
            <span>Giá sản phẩm</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="Nhập giá sản phẩm" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
        <div class="inputBox">
            <span>Ảnh 1</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Ảnh 2</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>Ảnh 3</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>Thông tin sản phẩm</span>
            <textarea name="details" placeholder="Nhập thông tin sản phẩm" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
         <div class="inputBox radio-group">
            <span>Ẩn Hiện:</span>
               <input id="an" name="anHien" type="radio" value="0"/>
               <label for="an">Ẩn</label>

               <input id="hien" name="anHien" type="radio" value="1" checked/>
               <label for="hien">Hiện</label>

         </div>
      </div>
      
      <input type="submit" value="Thêm sản phẩm" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">
   <div class="box-container-admin">
   <h1 class="heading">Sản phẩm đã thêm</h1>
      <form action="" method="GET" class="filter-form">
         <select name="filter" id="" class="box">
            <option value="all" <?php if(isset($_GET['filter']) && $_GET['filter']=='all') {echo "selected";} ?>>Tất cả sản phẩm</option>
            <option value="hidden" <?php if(isset($_GET['filter']) && $_GET['filter']=='hidden') {echo "selected";}?>>Sản phẩm đang ẩn</option>
            <option value="visible" <?php if(isset($_GET['filter']) && $_GET['filter']=='visible') {echo "selected";}?>>Sản phẩm đang hiển thị</option>
            <option value="in_orders" <?php if(isset($_GET['filter']) && $_GET['filter']=='in_orders') {echo "selected";}?>>Sản phẩm đang ở trong đơn hàng</option>
         </select>
         <input type="submit" value="Lọc" class="btn" id="">
   </form>
   </div>
   <div class="box-container">
   <?php
      $filter = isset($_GET['filter']) ? $_GET['filter'] :'all'; //nếu như có get thì filter sẽ là cái đấy, còn nếu không mặc định là all
      $query = "SELECT p.*, EXISTS (SELECT 1 FROM `orders` WHERE FIND_IN_SET(p.name, order_items)) as in_orders FROM `products` p";

      if($filter == "hidden") {
         $query .= " WHERE p.anHien = 0";
      } elseif($filter == "visible") {
         $query .= " WHERE p.anHien = 1";
      } elseif($filter == "in_orders") {
         $query .= " WHERE EXISTS (SELECT 1 FROM `orders` WHERE FIND_IN_SET(p.name, order_items))";
      }
      $query .= " ORDER BY id desc";
      $select_products = $conn->prepare($query);
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price">$<span><?= $fetch_products['price']; ?></span></div>
      <div class="name">Trạng Thái: <span style="color:<?php if ($fetch_products['anHien'] == 1) {echo "green";} else {echo "red";} ?>"><?= $fetch_products['anHien'] ? "Đang Hiện" : "Đang Ẩn"; ?></span></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Cập nhật</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" 
            class="delete-btn" 
            onclick="return confirm('Xóa sản phẩm này?');"
            <?php if($fetch_products['in_orders']){ echo 'disabled'; echo ' style="pointer-events: none; opacity: 0.5;"'; } ?>
         >Xóa</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Chưa có sản phẩm được thêm vào!</p>';
      }
   ?>
   
   </div>

</section>








<script src="../js/admin_script.js"></script>
   
</body>
</html>