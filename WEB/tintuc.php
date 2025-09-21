<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;700&display=swap" rel="stylesheet" />

  <link rel="shortcut icon" href="./images/favicon.ico" type="image/x-icon" />


  <!-- Carousel -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.core.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/css/glide.theme.min.css
">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="stylesheet" href="./css/news.css">

</head>
<body>
 
    <!-- Facility Section -->
    <section class="facility__section section" id="facility">
      <div class="container">
        <div class="facility__contianer" data-aos="fade-up" data-aos-duration="1200">
          <div class="facility__box">
            <div class="facility-img__container">
              <svg>
                <use xlink:href="./images/sprite.svg#icon-airplane"></use>
              </svg>
            </div>
            <p>GIAO HÀNG TOÀN QUỐC</p>
          </div>

          <div class="facility__box">
            <div class="facility-img__container">
              <svg>
                <use xlink:href="./images/sprite.svg#icon-credit-card-alt"></use>
              </svg>
            </div>
            <p>100% HOÀN TIỀN</p>
          </div>

          <div class="facility__box">
            <div class="facility-img__container">
              <svg>
                <use xlink:href="./images/sprite.svg#icon-credit-card"></use>
              </svg>
            </div>
            <p>NHIỀU PHƯƠNG THỨC THANH TOÁN</p>
          </div>

          <div class="facility__box">
            <div class="facility-img__container">
              <svg>
                <use xlink:href="./images/sprite.svg#icon-headphones"></use>
              </svg>
            </div>
            <p>HỖ TRỢ 24/7</p>
          </div>
        </div>
      </div>
    </section>
    </div>

    <!-- Testimonial Section -->
    <section class="section testimonial home" id="testimonial">
      <div class="testimonial__container">
        <div class="glide" id="glide_4">
          <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="./images/Steve Jobs.jpg" alt="profile">
                  </div>
                  <p>"Chất lượng quan trọng hơn số lượng. Một lần home-run còn hơn hai lần double"</p>
                  <div class="client__info">
                    <h3>Steve Jobs</h3>
                    <span>Cựu CEO của Apple</span>
                  </div>
                </div>
              </li>
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="./images/Bill Gates.jpg" alt="profile">
                  </div>
                  <p>"Cuộc sống vốn không công bằng, hãy làm quen với điều đó"</p>
                  <div class="client__info">
                    <h3>John Smith</h3>
                    <span>Cực CEO của Microsoft</span>
                  </div>
                </div>
              </li>
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="./images/Jeff Bezos.jpg" alt="profile">
                  </div>
                  <p>"Nếu không chịu được những lời chỉ trích thì đừng hòng làm gì mới hay thú vị"</p>
                  <div class="client__info">
                    <h3>Jeff Bezos</h3>
                    <span>Nhà sáng lập Amazon</span>
                  </div>
                </div>

              </li>
              <li class="glide__slide">
                <div class="testimonial__box">
                  <div class="client__image">
                    <img src="./images/Warren Buffett.jpg" alt="">
                  </div>
                  <p>“Cơ hội không đến thường xuyên.Khi cơn mưa vàng rớt xuống, hãy lấy xô ra để hứng chứ đừng dựng một con đê để chắn nó.”</p>
                  <div class="client__info">
                    <h3>Warren Buffett</h3>
                    <span>CEO của Berkshire Hathaway.</span>
                  </div>
                </div>
              </li>
            </ul>
          </div>

          <div class="glide__bullets" data-glide-el="controls[nav]">
            <button class="glide__bullet" data-glide-dir="=0"></button>
            <button class="glide__bullet" data-glide-dir="=1"></button>
            <button class="glide__bullet" data-glide-dir="=2"></button>
            <button class="glide__bullet" data-glide-dir="=3"></button>
          </div>
        </div>
      </div>
    </section>

<section class="home-products">

    <h1 class="heading">Tin tức mới nhất</h1>

    <div class="swiper products-slider">

        <div class="swiper-wrapper">

            <?php
            $select_news = $conn->prepare("SELECT * FROM `news` LIMIT 5"); 
            $select_news->execute();
            if($select_news->rowCount() > 0){
                while($fetch_news = $select_news->fetch(PDO::FETCH_ASSOC)){
            ?>
            <div class="swiper-slide slide">
                <div class="new__card">
                    <div class="card__header">
                        <img src="uploaded_img/<?= $fetch_news['image']; ?>" alt="">
                    </div>
                    <div class="card__footer">
                        <h3><?= $fetch_news['title']; ?></h3>
                        <span><?= $fetch_news['author']; ?></span>
                        <p><?= $fetch_news['content']; ?></p>
                        <a href="<?= $fetch_news['link']; ?>"><button>Đọc thêm</button></a>
                    </div>
                </div>
            </div>
            <?php
                }
            }else{
                echo '<p class="empty">Chưa có tin tức nào được thêm vào!</p>';
            }
            ?>

        </div>

        <div class="swiper-pagination"></div>

    </div>

</section>

 <!-- Glide Carousel Script -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.4.1/glide.min.js"></script>
 <!-- Animate On Scroll -->
 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
 <!-- custom -->
 <script src="./js/slider.js"></script>
</body>

</html>