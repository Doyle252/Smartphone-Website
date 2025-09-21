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
   <title>Trang chủ</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

     <!-- Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.min.css
">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div class="home-bg">

<section class="home">

   <div class="swiper home-slider">
   
   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images\home-img-13.png" alt="">
         </div>
         <div class="content">
            <span>"Hiệu năng mạnh mẽ, xử lý mượt mà mọi tác vụ."</span>
            <h3>Redmi S20 FE 5G</h3>
            <a href="shop.php" class="btn">mua ngay</a>
         </div>
      </div>


      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/iphoneslide.png" alt="">
         </div>
         <div class="content">
            <span>"Camera chụp hình sắc nét, bắt trọn mọi khoảnh khắc."</span>
            <h3>Iphone 15 Pro Max</h3>
            <a href="shop.php" class="btn">mua ngay</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/samsungslide.png" alt="">
         </div>
         <div class="content">
            <span>"Dung lượng pin lớn, sử dụng suốt ngày dài."</span>
            <h3>Samsung Galaxy Z Fold6</h3>
            <a href="shop.php" class="btn">mua ngay</a>
         </div>
      </div>

      <div class="swiper-slide slide">
         <div class="image">
            <img src="images/opposlide.png" alt="">
         </div>
         <div class="content">
            <span>"Thiết kế tinh tế với màn hình tràn viền."</span>
            <h3>Oppo N4 FLIP</h3>
            <a href="shop.php" class="btn">mua ngay</a>
         </div>
      </div>

   </div>

      <div class="swiper-pagination"></div>

   </div>

</section>

</div>

<section class="category">

   <h1 class="heading">Các hãng điện thoại</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=Iphone" class="swiper-slide slide">
      <img src="images/apple.png" alt="">
      <h3>Apple</h3>
   </a>


   <a href="category.php?category=Samsung" class="swiper-slide slide">
      <img src="images/samsung.png" alt="">
      <h3>Samsung</h3>
   </a>
   

   <a href="category.php?category=Xiaomi" class="swiper-slide slide">
      <img src="images/xiaomi.png" alt="">
      <h3>Xiaomi</h3>
   </a>

   <a href="category.php?category=Oppo" class="swiper-slide slide">
      <img src="images/oppo.png" alt="">
      <h3>Oppo</h3>
   </a>

   <a href="category.php?category=Realme" class="swiper-slide slide">
      <img src="images/realme.png" alt="">
      <h3>Realme</h3>
   </a>

   <a href="category.php?category=Lenovo" class="swiper-slide slide">
      <img src="images/lenovo.png" alt="">
      <h3>Lenovo</h3>
   </a>

   <a href="category.php?category=Asus" class="swiper-slide slide">
      <img src="images/asus.png" alt="">
      <h3>Asus</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>

<section class="home-products">

   <h1 class="heading">Sản phẩm mới nhất</h1>

   <div class="swiper products-slider">

   <div class="swiper-wrapper">

   <?php
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE anHien=1 LIMIT 6"); 
     $select_products->execute();
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="swiper-slide slide">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
      <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
      <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_product['name']; ?></div>
      <div class="flex">
         <div class="price"><span>$</span><?= $fetch_product['price']; ?><span></span></div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="Thêm vào giỏ hàng" class="btn" name="add_to_cart"> 
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
   }
   ?>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>
<!-- /arrow/ -->
<div class="back-to-top">
    <a href="#top">
        <i class="fas fa-arrow-up"></i>
    </a>
    <a href="#bottom">
        <i class="fas fa-arrow-down"></i>
    </a>
</div>



<?php include 'tintuc.php'; ?>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>


var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
   autoplay: {
         delay: 3000,
         disableOnInteraction: false,
      },

});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>
<script src="js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
   const swiper = new Swiper(".home-swiper", {
      autoplay: {
         delay: 2000,
         disableOnInteraction: false,
      },


  loop: true,


  pagination: {
    el: '.swiper-pagination',
  },


  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

});
 
</script>
</body>
</html>