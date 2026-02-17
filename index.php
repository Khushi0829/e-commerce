<?php
// ✅ load DB connection
require_once __DIR__ . '/config/db.php';

// ✅ load header (BASE_URL etc)
require_once __DIR__ . '/includes/header.php';
?>

<!doctype html>
<html lang="en">

<head>
    <title>Home</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">


    <!-- Style CSS -->

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/master.css">
</head>

<body>

 <hr style="margin: 2px;">

    <main>

        <!-- Categories -->

        <section class="home-categories">
            <div class="container-fluid">
                <div class="row category-scroll">


                    <div class="col-lg-2 col-sm-2">
                        <div class="category-item bg-green" data-aos="fade-up" data-aos-delay="0">
                            <div class="img-base">
                                <img src="assets/images/5f2ee7f883cdb774.webp" alt="Mobile">
                            </div>
                            <p> Mobiles & Tablets</p>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2">
                        <div class="category-item has-dropdown bg-cream" data-aos="fade-up" data-aos-delay="100">
                            <div class="img-base">
                                <img src="assets/images/ff559cb9d803d424.webp" alt="Fashion">
                            </div>
                            <span class="category-open">Fashion <i class="arrow fa-solid fa-angle-down"></i></span>

                            <!-- MEGA MENU -->
                            <div class="mega-menu">
                                <!-- LEFT LIST -->
                                <div class="menu-left">
                                    <a href="#" class="menu-item active" data-target="men-top">Men's Top Wear</a> <br>
                                    <a href="#" class="menu-item" data-target="men-bottom">Men's Bottom Wear</a> <br>
                                    <a href="#" class="menu-item" data-target="women-ethnic">Women Ethnic</a> <br>
                                    <a href="#" class="menu-item" data-target="men-footwear">Men Footwear</a> <br>
                                </div>

                                <!-- Right List -->
                                <div class="menu-right">
                                    <div class="submenu active" id="men-top">
                                        <h6>More in Men's Top Wear</h6>
                                        <a href="#">All</a>
                                        <a href="#">T-Shirts</a>
                                        <a href="#">Casual Shirts</a>
                                        <a href="#">Formal Shirts</a>
                                    </div>

                                    <div class="submenu" id="men-bottom">
                                        <h6>More in Men's Bottom Wear</h6>
                                        <a href="#">Jeans</a>
                                        <a href="#">Trousers</a>
                                        <a href="#">Track Pants</a>
                                    </div>


                                    <div class="submenu" id="women-ethnic">
                                        <h6>Women Ethnic</h6>
                                        <a href="#">Sarees</a>
                                        <a href="#">Kurtas</a>
                                        <a href="#">Lehenga</a>
                                    </div>

                                    <div class="submenu" id="men-footwear">
                                        <h6>Men Footwear</h6>
                                        <a href="#">Sports Shoes</a>
                                        <a href="#">Casual Shoes</a>
                                        <a href="#">Sandals</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-sm-2">
                        <div class="category-item has-dropdown bg-yellow" data-aos="fade-up" data-aos-delay="200">
                            <div class="img-base">
                                <img src="assets/images/af646c36d74c4be9.webp" alt="Electronics">
                            </div>
                            <span class="category-open">Electronics <i class="arrow fa-solid fa-angle-down"></i></span>

                            <!-- MEGA MENU -->
                            <div class="mega-menu">
                                <!-- LEFT LIST -->
                                <div class="menu-left">
                                    <a href="#" class="menu-item active" data-target="audio">Audio</a> <br>
                                    <a href="#" class="menu-item" data-target="camera">Cameras & Accessories</a> <br>
                                    <a href="#" class="menu-item" data-target="gaming">Gaming</a> <br>
                                    <a href="#" class="menu-item" data-target="laptop">Laptop Accessories</a> <br>
                                    <a href="#" class="menu-item" data-target="mobile">Mobile Accessory</a> <br>
                                    <a href="#" class="menu-item" data-target="powerbank">Powerbank</a> <br>
                                </div>

                                <!-- Right List -->
                                <div class="menu-right">
                                    <div class="submenu active" id="audio">
                                        <h6>More in Audio</h6>
                                        <a href="#">All</a>
                                        <a href="#">Bluetooth headphones</a>
                                        <a href="#">Bluetooth Speakers</a>
                                        <a href="#">Wired headphones</a>
                                    </div>

                                    <div class="submenu" id="camera">
                                        <h6>More in cameras</h6>
                                        <a href="#">Point & Shoot</a>
                                        <a href="#">Camcorders</a>
                                        <a href="#">DSLRs</a>
                                    </div>


                                    <div class="submenu" id="gaming">
                                        <h6>Gaming</h6>
                                        <a href="#">Gaming Consoles</a>
                                        <a href="#">Gaming Mouse</a>
                                        <a href="#">Other Gaming Accessories</a>
                                    </div>

                                    <div class="submenu" id="laptop">
                                        <h6>Laptop Accessories</h6>
                                        <a href="#">Mouse</a>
                                        <a href="#">Laptop Keyboards</a>
                                        <a href="#">Laptop Battery</a>
                                    </div>

                                    <div class="submenu" id="mobile">
                                        <h6>Mobile Accessory</h6>
                                        <a href="#">Plain Cases</a>
                                        <a href="#">Camera Lens Protectors</a>
                                        <a href="#">Tablet Accessories</a>
                                    </div>

                                    <div class="submenu" id="powerbank">
                                        <h6>More in Powerbanks</h6>
                                        <a href="#">All</a>
                                        <a href="#">Powerbanks</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2">
                        <div class="category-item bg-pink" data-aos="fade-up" data-aos-delay="300">
                            <div class="img-base">
                                <img src="assets/images/e90944802d996756.webp" alt="TVs">
                            </div>
                            <span>TVs & Appliances</span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2">
                        <div class="category-item has-dropdown shift-left  bg-blue" data-aos="fade-up"
                            data-aos-delay="400">
                            <div class="img-base">
                                <img src="assets/images/1788f177649e6991.webp" alt="Home">
                            </div>
                            <span class="category-open">Home & Furniture <i
                                    class="arrow fa-solid fa-angle-down"></i></span>

                            <!-- MEGA MENU -->
                            <div class="mega-menu">
                                <!-- LEFT LIST -->
                                <div class="menu-left">
                                    <a href="#" class="menu-item active" data-target="furnishings">Home Furnishings</a>
                                    <br>
                                    <a href="#" class="menu-item" data-target="room-furniture">Living Room Furniture</a>
                                    <br>
                                    <a href="#" class="menu-item" data-target="bed-furniture">Bedroom Furniture</a> <br>
                                    <a href="#" class="menu-item" data-target="home-decor">Home Decor</a>
                                </div>

                                <!-- Right List -->
                                <div class="menu-right">
                                    <div class="submenu active" id="furnishings">
                                        <h6>More in Home Furnishings</h6>
                                        <a href="#">All</a>
                                        <a href="#">Bed Linens</a>
                                        <a href="#">Blankets</a>
                                        <a href="#">Cushions & Pillows</a>
                                    </div>

                                    <div class="submenu" id="room-furniture">
                                        <h6>More in Living Room Furniture</h6>
                                        <a href="#">Sofas Sets & Sectionals</a>
                                        <a href="#">TV Units</a>
                                        <a href="#">Dining Sets</a>
                                    </div>


                                    <div class="submenu" id="bed-furniture">
                                        <h6>Bedroom Furniture</h6>
                                        <a href="#">Mattresses</a>
                                        <a href="#">Wardrobes</a>
                                        <a href="#">Bar Stools</a>
                                    </div>

                                    <div class="submenu" id="home-decor">
                                        <h6>Home Decor</h6>
                                        <a href="#">All</a>
                                        <a href="#">Lightings, Stickers & Wallpapers</a>
                                        <a href="#">Paintings & Posters</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-2">
                        <div class="category-item has-dropdown shift-left bg-green" data-aos="fade-up"
                            data-aos-delay="500">
                            <div class="img-base">
                                <img src="assets/images/b3020c99672953b9.webp" alt="food">
                            </div>
                            <span class="category-open">Beauty, Food <i class="arrow fa-solid fa-angle-down"></i></span>

                            <!-- MEGA MENU -->
                            <div class="mega-menu">
                                <!-- LEFT LIST -->
                                <div class="menu-left">
                                    <a href="#" class="menu-item active" data-target="furnishings">Home Furnishings</a>
                                    <br>
                                    <a href="#" class="menu-item" data-target="room-furniture">Living Room Furniture</a>
                                    <br>
                                    <a href="#" class="menu-item" data-target="bed-furniture">Bedroom Furniture</a> <br>
                                    <a href="#" class="menu-item" data-target="home-decor">Home Decor</a>
                                </div>

                                <!-- Right List -->
                                <div class="menu-right">
                                    <div class="submenu active" id="furnishings">
                                        <h6>More in Home Furnishings</h6>
                                        <a href="#">All</a>
                                        <a href="#">Bed Linens</a>
                                        <a href="#">Blankets</a>
                                        <a href="#">Cushions & Pillows</a>
                                    </div>

                                    <div class="submenu" id="room-furniture">
                                        <h6>More in Living Room Furniture</h6>
                                        <a href="#">Sofas Sets & Sectionals</a>
                                        <a href="#">TV Units</a>
                                        <a href="#">Dining Sets</a>
                                    </div>


                                    <div class="submenu" id="bed-furniture">
                                        <h6>Food & Drinks</h6>
                                        <a href="#">Mattresses</a>
                                        <a href="#">Wardrobes</a>
                                        <a href="#">Bar Stools</a>
                                    </div>

                                    <div class="submenu" id="nutrition">
                                        <h6>Nutrition & Health Care</h6>
                                        <a href="#">All</a>
                                        <a href="#">Masks</a>
                                        <a href="#">Ayurvedic Supplements</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Slide Show -->

        <section class="slide-section section-margin" data-aos="fade-up">
            <div class="slideshow-container">

                <div class="mySlides fade">
                    <!-- <div class="numbertext">1 / 3</div> -->
                    <img src="assets/images/1338bd4fc60390d8.webp" style="width:100%">
                    <!-- <div class="text">Caption Text</div> -->
                </div>

                <div class="mySlides fade">
                    <!-- <div class="numbertext">2 / 3</div> -->
                    <img src="assets/images/66faf3950cda0b7a.webp" style="width:100%">
                    <!-- <div class="text">Caption Two</div> -->
                </div>

                <div class="mySlides fade">
                    <!-- <div class="numbertext">3 / 3</div> -->
                    <img src="assets/images/b9423f4fafdeff72.webp" style="width:100%">
                    <!-- <div class="text">Caption Three</div> -->
                </div>

                <a class="prev" onclick="plusSlides(-1)"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                <a class="next" onclick="plusSlides(1)"><i class="fa fa-angle-right" aria-hidden="true"></i></a>

            </div>

            <div class="dots" style="text-align:center">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </section>


        <section class="section-margin">
            <div class="sale-img" data-aos="fade-up">
                <img src="assets/images/1f13bb1a7a222368.webp" alt="">
            </div>
        </section>

        <!-- Deals Section -->

        <section class="deals-section">
            <!-- <h2>Top Deals</h2> -->

            <div class="deals-wrapper">
                <button class="arrow left" onclick="scrollDeals(-1)"><i class="fa fa-angle-left"
                        aria-hidden="true"></i></button>

                <div class="deals-row hide-scrollbar" id="dealsRow"  data-aos="fade-up" data-aos-delay="100">
                    <div class="deal-card" >
                        <img src="assets/images/i9-pro-max-fhd-1080p-e03i31-10-e03i31-led-projector-egate-original-imahgxvbyhh7uejw.webp"
                            alt="">
                        <p>Projectors <br>
                            from <i class="inr fa fa-inr" aria-hidden="true"></i> 6990</p>
                    </div>

                    <div class="deal-card">
                        <img src="assets/images/srs-xb23-sony-original-imaftk66vjxp86h5.webp" alt="">
                        <p>Speaker <br>
                            from <i class="inr fa fa-inr" aria-hidden="true"></i> 499</p>
                        </p>
                    </div>

                    <div class="deal-card">
                        <img src="assets/images/-original-imahf4rbgwtzquxh.webp" alt="">
                        <p>Monitors <br>
                            from <i class="inr fa fa-inr" aria-hidden="true"></i> 6599</p>
                    </div>

                    <div class="deal-card">
                        <img src="assets/images/-original-imahathge2dfftdg.webp" alt="">
                        <p>Monitors <br>
                            from <i class="inr fa fa-inr" aria-hidden="true"></i> 8579</p>
                    </div>

                    <div class="deal-card">
                        <img src="assets/images/4k-video-compact-cameras-with-16x-digital-zoom-anti-shake-2-original-imahgpuhpgzamna2.webp"
                            alt="">
                        <p>Cameras <br> Buy now!</p>
                    </div>

                    <div class="deal-card">
                        <img src="assets/images/-original-imagxrhetgfuebnn.webp" alt="">
                        <p>Smart Watches <br>
                            from <i class="inr fa fa-inr" aria-hidden="true"></i> 1399</p>
                    </div>

                </div>
                <button class="arrow right" onclick="scrollDeals(1)"><i class="fa fa-angle-right"
                        aria-hidden="true"></i></button>
            </div>

            <div class="deals-right">
                <img src="assets/images/download.jfif">
            </div>
        </section>


        <!-- ---------------New Year Essential------------ -->

        <section class="fk-section section-margin">

            <!-- LEFT SIDE -->
            <div class="fk-left"  data-aos="fade-up" data-aos-delay="100">
                <div class="fk-header">
                    <h2>New Year Essentials</h2>
                    <button class="fk-arrow"><a href="<?= BASE_URL ?>/pages/products.php"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </button>
                </div>

                <div class="fk-cards">
                    <div class="fk-card">
                        <img src="assets/images/-original-imahftfbus65gm5c.webp">
                        <p>Pendants & Lockets</p>
                        <span>Min. 70% Off</span>
                    </div>

                    <div class="fk-card">
                        <img src="assets/images/-original-imahgtgf2rpq48hm.webp">
                        <p>Suitcases</p>
                        <span>Min. 70% Off</span>
                    </div>

                    <div class="fk-card">
                        <img
                            src="assets/images/53-travel-for-outdoor-sport-hikiing-bag-30-smartlook-75-26-5-original-imahgz6mgjg6uqs4.webp">
                        <p>Laptop Bags</p>
                        <span>Min. 50% Off</span>
                    </div>

                    <div class="fk-card">
                        <img
                            src="assets/images/3-2-new-sling-bag-anti-theft-usb-crossbody-backpack-waterproof-original-imahgwk2xngrcjjr.webp">
                        <p>Backpacks</p>
                        <span>Min. 50% Off</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="fk-right"  data-aos="fade-up" data-aos-delay="200">
                <img src="assets/images/ChatGPT Image Jan 13, 2026, 02_59_16 PM.png">
                <div class="fk-text">
                    <h1>Top Selling Smartphones</h1>
                    <p>Latest Technology, Best Brands</p>
                </div>

                <!-- From Uiverse.io by vinodjangid07 -->
                <button class="button">
                    <a href="<?= BASE_URL?>/pages/products.php">
                        <svg class="svgIcon" viewBox="0 0 512 512" height="1em" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm50.7-186.9L162.4 380.6c-19.4 7.5-38.5-11.6-31-31l55.5-144.3c3.3-8.5 9.9-15.1 18.4-18.4l144.3-55.5c19.4-7.5 38.5 11.6 31 31L325.1 306.7c-3.2 8.5-9.9 15.1-18.4 18.4zM288 256a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z">
                        </path>
                    </svg>
                    Explore Now
                    </a>
                </button>

            </div>

        </section>

        <!------------- Our Story Section-------------- -->

        <section class="story-section spacing section-margin">
            <div class="story-wrapper">
                <div class="container-fluid">
                    <div class="row g-4">
                        <div class="col-lg-5 col-sm-12 col-12">
                            <div class="story-card" data-aos="fade-up">
                                <h4> Our Story</h4>
                                <p>We started with a simple idea — to make quality products accessible to everyone.
                                    Driven by innovation and powered by passion, we focus on delivering value, trust,
                                    and a seamless
                                    experience. Every step we take is guided by our commitment to excellence and
                                    customer satisfaction.
                                </p>
                            </div>

                            <div class="story-card highlight" data-aos="fade-up" data-aos-delay="100">
                                <h4>Exclusive Deals</h4>
                                <p>Discover top products at unbeatable prices. Curated offers, limited stock, and
                                    exciting
                                    discounts—only for you.
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-7 col-sm-12 col-12">
                            <div class="story-card large" data-aos="fade-up" data-aos-delay="200">
                                <h4>WHY CHOOSE US</h4>
                                <p>We are committed to delivering more than just products—we deliver quality, value, and
                                    trust. Every
                                    item
                                    on our platform is carefully selected to meet high standards of performance and
                                    reliability,
                                    ensuring
                                    you receive only the best. Our goal is to make your shopping experience smooth,
                                    secure, and
                                    enjoyable
                                    from start to finish. <br>

                                    Customer satisfaction is at the heart of everything we do. From easy navigation and
                                    secure payment
                                    options to fast delivery and hassle-free returns, we focus on convenience at every
                                    step. Our
                                    dedicated
                                    support team is always ready to assist you, ensuring quick resolution of any queries
                                    or concerns. <br>

                                    We continuously update our collection to keep up with the latest trends and customer
                                    needs. Whether
                                    you’re looking for everyday essentials or exclusive deals, you’ll always find
                                    something worth
                                    buying.
                                    With a commitment to reliability, affordability, and exceptional service, we aim to
                                    build
                                    long-lasting
                                    relationships with our customers.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include "includes/footer.php"; ?>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <!-- --------------AOS JS---------- -->

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 500,
            easing: 'ease-out-cubic',
            once: true,          // animation runs once
            offset: 120          // triggers slightly before visible
        });
    </script>


    <!-- script js -->
    <script src="assets/js/script.js"> </script>




</body>

</html>