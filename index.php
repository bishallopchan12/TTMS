<!-- <?php
session_start();
error_reporting(0);
include('include/config.php');
?> -->


<!doctype html>
<html lang="en">
<?php include 'include/header.php'; ?>

<body class="home">

   <div id="page" class="page">
      <!-- site header html start  -->
      <?php include 'include/navbar.php'; ?>
      <!-- site header html end  -->
      <main id="content" class="site-main">
         <!-- ***home banner html start form here*** -->
         <section class="home-banner-section home-banner-slider">
            <div class="home-banner d-flex flex-wrap align-items-center" style="background-image: url(assets/images/gosaikunda.jpg);">
               <div class="overlay"></div>
               <div class="container">
                  <div class="banner-content text-center">
                     <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                           <h2 class="banner-title">JOURNEY TO EXPLORE NEPAL's BEAUTY</h2>
                           <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods, learn new customs, and see things you've never seen before.</p>
                           <div class="banner-btn">
                              <a href="about.php" class="round-btn">LEARN MORE</a>
                              <a href="./package.php" class="outline-btn outline-btn-white">BOOK NOW</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="home-banner d-flex flex-wrap align-items-center" style="background-image: url(trekking.jpg);">
               <div class="overlay"></div>
               <div class="container">
                  <div class="banner-content text-center">
                     <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                           <h2 class="banner-title">BEAUTIFUL PLACE TO VISIT</h2>
                           <p>Travelling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods, learn new customs, and see things you've never seen before.</p>
                           <div class="banner-btn">
                              <a href="about.php" class="round-btn">LEARN MORE</a>
                              <a href="booking.php" class="outline-btn outline-btn-white">BOOK NOW</a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ***home banner html end here*** -->
         
         
        
                <?php  include './utils/route_optimizer.php';?>
                <?php
// /another-directory/index.php

// Include the fetch_packages.php from the other directory
include './recommend/index.php';
?>

         <!-- ***Home destination html start from here*** -->
         <section class="home-destination">
            <div class="container">

               <div class="row">
                  <div class="col-lg-8 offset-lg-2 text-sm-center">
                     <div class="section-heading">
                        <h5 class="sub-title">UNCOVER PLACE</h5>
                        <h2 class="section-title">POPULAR DESTINATION</h2>
                        <p>Lumbini, the birthplace of Buddha, is a major pilgrimage site with the sacred Mayadevi Temple, ancient ruins, and international monasteries. Its serene atmosphere makes it ideal for meditation and spiritual reflection.</p>
                     </div>
                  </div>
               </div>
               <div class="destination-section">
                  <div class="row">
                     <?php $sql = "SELECT * from tbldestination order by rand() limit 3";
                     $query = $dbh->prepare($sql);
                     $query->execute();
                     $results = $query->fetchAll(PDO::FETCH_OBJ);
                     $cnt = 1;
                     if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                           //   print_r($result); 
                     ?>
                           <div class="col-lg-4 col-md-6">

                              <article class="destination-item" style="background-image: url(admin/destinationimages/<?php echo htmlentities($result->DestinationImage); ?>);">
                                 <div class="destination-content" style="background-color: rgba(255, 255, 255, 0.5);" >
                                    <!-- <div class="rating-start-wrap">
                                       <div class="rating-start">
                                          <span style="width: 100%"></span>
                                       </div>
                                    </div> -->
                                    <span class="cat-link">
                                       <a href="destination.php?pkgid=<?php echo htmlentities($result->DestinationId); ?>">
                                          <?php echo htmlentities($result->DestinationLocation); ?></a>
                                    </span>
                                    <h3>
                                       <a href="popular-destination-details.php?pkgid=<?php echo htmlentities($result->DestinationId); ?>">
                                          <?php echo htmlentities($result->DestinationName); ?></a>
                                    </h3>
                                    <p> <?php echo substr($result->DestinationDetails, 0, 50); ?></p>
                                 </div>
                              </article>


                           </div>
                     <?php }
                     } ?>
                     <div class="section-btn-wrap text-center">
                        <a href="destination.php" class="round-btn">More Destination</a>
                     </div>
                  </div>
         </section>
       

<!-- Add any other HTML or content you want here -->

         <!-- ***Home destination html end here*** -->
         <!-- ***Home package html start from here*** -->
         <section class="home-package">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 offset-lg-2 text-sm-center">
                     <div class="section-heading">
                        <h5 class="sub-title">POPULAR PACKAGES</h5>
                        <h2 class="section-title">CHECKOUT OUR PACKAGES</h2>
                        <p>you're looking for, such as the destination, travel dates, budget, and any specific preferences you have, I can try to provide you with some general advice or recommendations.</p>
                     </div>
                  </div>
               </div>
               <div class="package-section">
                  <?php $sql = "SELECT * from tbltourpackages order by rand() limit 3";
                  $query = $dbh->prepare($sql);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  $cnt = 1;
                  if ($query->rowCount() > 0) {
                     foreach ($results as $result) {
                        //   print_r($result); 
                  ?>
                        <article class="package-item">
                           <figure class="package-image" style="background-image: url(admin/packageimages/<?php echo htmlentities($result->PackageImage); ?>);"></figure>
                           <div class="package-content">
                              <h3>
                                 <a href="package-detail.php?pkgid=<?php echo htmlentities($result->PackageId); ?>">
                                    <?php echo htmlentities($result->PackageName); ?>
                                 </a>
                              </h3>
                              <p> <?php echo substr($result->PackageDetails, 0, 250); ?></p>
                           </div>
                           <div class="package-price">
                              <div class="review-area">
                                 <span class="review-text"></span>
                                 <div class="rating-start-wrap d-inline-block">
                                    <!-- <div class="rating-start">
                                       <span style="width: 80%"></span>
                                    </div> -->
                                 </div>
                              </div>
                              <h6 class="price-list">
                                 <span>Rs<?php echo htmlentities($result->PackagePrice); ?></span>
                                 / per person
                              </h6>
                              <a href="package-detail.php?pkgid=<?php echo htmlentities($result->PackageId); ?>" class="outline-btn outline-btn-white">Details</a>
                           </div>
                        </article>
                  <?php }
                  } ?>
                  <div class="section-btn-wrap text-center">
                     <a href="package.php" class="round-btn">VIEW ALL PACKAGES</a>
                  </div>
               </div>
            </div>
         </section>
         <!-- ***Home package html end here*** -->
         <!-- ***Home callback html start from here*** -->
         <section class="home-callback bg-img-fullcallback" style="background-image: url(assets/images/himal.jpg);">
            <div class="overlay"></div>
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 offset-lg-2 text-center">
                     <div class="callback-content">
                        <div class="video-button">
                           <a id="video-container" data-fancybox="video-gallery" href="https://youtu.be/4OiXfDdbtnM?si=2HxJR-p0PDFqISB6">
                              <i class="fas fa-play"></i>
                           </a>
                        </div>
                        <h2 class="section-title">ARE YOU READY TO TRAVEL? REMEMBER US !!</h2>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods, learn new customs, and see things you've never seen before.</p>
                        <div class="callback-btn">
                           <a href="package.php" class="round-btn">View Packages</a>
                           <a href="about.php" class="outline-btn outline-btn-white">Learn More</a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- ***Home callback html end here*** -->
         <!-- ***Home counter html start from here*** -->
        
         <!-- ***Home counter html end here*** -->
         <!-- ***Home offer html start from here*** -->
         <section class="home-offer">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 offset-lg-2 text-sm-center">
                     <div class="section-heading">
                        <h5 class="sub-title">OFFER & DISCOUNT</h5>
                        <h2 class="section-title">OUR SPECIAL PACKAGES</h2>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods, learn new customs, and see things you've never seen before.</p>
                     </div>
                  </div>
               </div>
               <div class="offer-section">
                  <div class="row gx-5">
                     <?php $sql = "SELECT * from packageoffer order by rand() limit 2";
                     $query = $dbh->prepare($sql);
                     $query->execute();
                     $results = $query->fetchAll(PDO::FETCH_OBJ);
                     $cnt = 1;
                     if ($query->rowCount() > 0) {
                        foreach ($results as $result) {
                           //   print_r($result); 
                     ?>
                           <div class="col-md-6">
                              <article class="offer-item" style="background-image: url(admin/offerimages/<?php echo htmlentities($result->OfferImage); ?>);">
                                 <div class="offer-badge">
                                    UPTO <span><?php echo htmlentities($result->PercentageOff); ?></span> off
                                 </div>
                                 <div class="offer-content">
                                    <div class="package-meta">
                                       <ul>
                                          <li>
                                             <i class="fas fa-map-marker-alt"></i>
                                             <?php echo htmlentities($result->OfferLocation); ?>
                                          </li>
                                       </ul>
                                    </div>
                                    <h3>
                                       <a href="package-offer-details.php?pkgid=<?php echo htmlentities($result->OfferId); ?>">
                                          <?php echo htmlentities($result->OfferName); ?></a>
                                    </h3>
                                    <p>
                                       <?php echo substr($result->OfferDetails, 0, 50); ?>
                                    </p>
                                    <div class="price-list">
                                       Price:
                                       <del>Rs<?php echo htmlentities($result->ActualPrice); ?></del>
                                       <ins>Rs<?php echo htmlentities($result->OfferPrice); ?></ins>
                                    </div>
                                    <a href="package-offer-details.php?pkgid=<?php echo htmlentities($result->OfferId); ?>" class="round-btn">Details</a>
                                 </div>
                              </article>
                           </div>
                     <?php }
                     } ?>
                  </div>
                  <div class="section-btn-wrap text-center">
                     <a href="package-offer.php" class="round-btn">VIEW ALL PACKAGES</a>
                  </div>
               </div>
            </div>
         </section>
         <!-- ***Home offer html end here*** -->

         <!-- ***Home client html start from here*** -->
         <section class="home-client client-section" style="background-image: url(assets/images/sange.jpg);">
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-lg-6">
                     <div class="client-content">
                        <h5 class="sub-title">DISCOUNT OFFER</h5>
                        <?php if ($_SESSION['email']) { ?>
                        <h2 class="section-title">GET SPECIAL DISCOUNT !</h2>
                        <?php } else { ?>
                           <h2 class="section-title">GET SPECIAL DISCOUNT ON SIGN UP !</h2>
                           <?php } ?>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods, learn new customs, and see things you've never seen before.</p>
                        <!-- <a href="./booking.php" class="round-btn">Book Now</a> -->
                        <?php if ($_SESSION['email']) { ?>
                                          <a href="package-offer.php" class="round-btn">Get Offers</a>
                                       <?php } else { ?>
                                          <a href="sign-in.php" class="round-btn">Book now</a>
                                       <?php } ?>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="client-logo">
                        <ul>
                           <li>
                              <img src="assets/images/soltee.png" alt="">
                           </li>
                           <li>
                              <img src="assets/images/hyatt.png" alt="">
                           </li>
                           <li>
                              <img src="assets/images/pokhara.png" alt="">
                           </li>
                           <li>
                              <img src="assets/images/yak.png" alt="">
                           </li>
                           <li>
                              <img src="assets/images/raddison.png" alt="">
                           </li>
                           <li>
                              <img src="assets/images/landmark.png" alt="">
                           </li>
                        </ul>
                     </div>
                  </div>
               </div>
            </div>
            <div class="overlay"></div>
         </section>
         <!-- ***Home client html end here*** -->
         <!-- ***Home testimonial html start from here*** -->
         <!-- <section class="home-testimonial">
            <div class="container">
               <div class="row">
                  <div class="col-lg-8 offset-lg-2 text-center">
                     <div class="section-heading">
                        <h5 class="sub-title">CLIENT'S REVIEWS</h5>
                        <h2 class="section-title">TRAVELLER'S TESTIMONIAL</h2>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods, learn new customs, and see things you've never seen before.</p>
                     </div>
                  </div>
               </div>
               <div class="testimonial-section testimonial-slider">
                  <div class="testimonial-item">
                     <div class="testimonial-content">
                        <div class="rating-start-wrap">
                           <div class="rating-start">
                              <span style="width: 80%"></span>
                           </div>
                        </div>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods.</p>
                        <div class="author-content">
                           <figure class="testimonial-img">
                              <img src="assets/images/user-img.png" alt="">
                           </figure>
                           <div class="author-name">
                              <h5>Bishant Tamang</h5>
                              <span>B&B Tours and Travels Pvt. Ltd.</span>
                           </div>
                        </div>
                        <div class="testimonial-icon">
                           <i aria-hidden="true" class="fas fa-quote-left"></i>
                        </div>
                     </div>
                  </div>
                  <div class="testimonial-item">
                     <div class="testimonial-content">
                        <div class="rating-start-wrap">
                           <div class="rating-start">
                              <span style="width: 80%"></span>
                           </div>
                        </div>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods.</p>
                        <div class="author-content">
                           <figure class="testimonial-img">
                              <img src="assets/images/trek2.jpg" alt="">
                           </figure>
                           <div class="author-name">
                              <h5>Samba Dorje Lama</h5>
                              <span>B&B Tours and Travels Pvt. Ltd.</span>
                           </div>
                        </div>
                        <div class="testimonial-icon">
                           <i aria-hidden="true" class="fas fa-quote-left"></i>
                        </div>
                     </div>
                  </div>
                  <div class="testimonial-item">
                     <div class="testimonial-content">
                        <div class="rating-start-wrap">
                           <div class="rating-start">
                              <span style="width: 80%"></span>
                           </div>
                        </div>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods.</p>
                        <div class="author-content">
                           <figure class="testimonial-img">
                              <img src="assets/images/dad.jpg" alt="">
                           </figure>
                           <div class="author-name">
                              <h5>Santa Bahadur Lama</h5>
                              <span>B&B Tours and Travels Pvt. Ltd.</span>
                           </div>
                        </div>
                        <div class="testimonial-icon">
                           <i aria-hidden="true" class="fas fa-quote-left"></i>
                        </div>
                     </div>
                  </div>
                  <div class="testimonial-item">
                     <div class="testimonial-content">
                        <div class="rating-start-wrap">
                           <div class="rating-start">
                              <span style="width: 80%"></span>
                           </div>
                        </div>
                        <p>Traveling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods.</p>
                        <div class="author-content">
                           <figure class="testimonial-img">
                              <img src="assets/images/bipin.jpg" alt="">
                           </figure>
                           <div class="author-name">
                              <h5>Biraj Lama</h5>
                              <span>B&B Travel And Tours Pvt. Ltd.</span>
                           </div>
                        </div>
                        <div class="testimonial-icon">
                           <i aria-hidden="true" class="fas fa-quote-left"></i>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section> -->
         <!-- ***Home testimonial html end here*** -->
         <!-- ***Home callback html start from here*** -->
         <section class="home-callback bg-color-callback primary-bg">
            <div class="container">
               <div class="row align-items-center">
                  <div class="col-md-8">
                     <h5 class="sub-title">CALL TO ACTION</h5>
                     <h2 class="section-title">READY FOR UNFORGATABLE TRAVEL. REMEMBER US!</h2>
                     <p>Travelling allows you to experience different parts of the world and immerse yourself in new cultures. You can try new foods.</p>
                  </div>
                  <div class="col-md-4 text-md-end">
                     <a href="contact.php" class="outline-btn outline-btn-white">Contact Us !</a>
                  </div>
               </div>
            </div>
         </section>
         <!-- ***Home callback html end here*** -->
      </main>
      <!-- ***site footer html start form here*** -->
      <?php include 'include/footer.php'; ?>
      <a id="backTotop" href="#" class="to-top-icon">
         <i class="fas fa-chevron-up"></i>
      </a>
      <!-- ***custom search field html*** -->
      <?php include 'include/custom_search.php'; ?>

   </div>
   <?php
   include 'include/javascript.php';
   ?>

<!-- Chatbot HTML -->
<div id="chatbot-container" class="chatbot-container">
   <div class="chatbot-header">
      <div class="chatbot-title">
         <img src="./assets/images/site-logo.png" alt="B&B Travels Logo" class="chatbot-logo" onerror="this.src='https://via.placeholder.com/40?text=B&B';">
         <span>Travel Buddy</span>
      </div>
      <div class="chatbot-actions">
         <button id="chatbot-voice" class="chatbot-action-btn" title="Voice Input" onclick="toggleVoice()">🎙️</button>
         <button id="chatbot-reset" class="chatbot-action-btn" title="Reset Chat" onclick="resetChat()">🔄</button>
         <button id="chatbot-close" class="chatbot-close-btn" onclick="toggleChatbot()">✖</button>
      </div>
   </div>
   <div id="chatbot-messages" class="chatbot-messages"></div>
   <div id="chatbot-typing" class="chatbot-typing"><span class="dot"></span><span class="dot"></span><span class="dot"></span></div>
   <div class="chatbot-input-container">
      <input type="text" id="chatbot-input" placeholder="Ask me about Nepal..." onkeypress="if(event.key === 'Enter') sendMessage();">
      <button onclick="sendMessage()" class="chatbot-send-btn"><i class="fas fa-paper-plane"></i></button>
   </div>
   <div class="chatbot-quick-actions">
      <button onclick="sendQuickMessage('list packages')">Packages</button>
      <button onclick="sendQuickMessage('list destinations')">Destinations</button>
      <button onclick="sendQuickMessage('special offers')">Offers</button>
   </div>
</div>
<button id="chatbot-toggle" class="chatbot-toggle-btn">
   <svg width="65" height="65" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <!-- Background Circle -->
      <circle cx="50" cy="50" r="50" fill="#1e3a8a"/>
      <!-- Mountain Peaks -->
      <path d="M20 80 L40 60 L60 80 L80 60 L100 80" fill="white" stroke="#3b82f6" stroke-width="2"/>
      <!-- B&B Travels Text -->
      <text x="50" y="40" font-family="Arial" font-size="14" font-weight="bold" fill="white" text-anchor="middle">B&B Travels</text>
      <!-- Slogan -->
      <text x="50" y="90" font-family="Arial" font-size="8" fill="#3b82f6" text-anchor="middle">
         <textPath href="#sloganPath">Explore Nepal’s Beauty</textPath>
      </text>
      <!-- Path for curved slogan -->
      <path id="sloganPath" d="M20 85 A30 30 0 0 1 80 85" fill="none"/>
   </svg>
</button>

<!-- Updated Chatbot CSS -->
<style>
   .chatbot-container {
      position: fixed;
      bottom: 90px;
      right: 20px;
      width: 420px;
      max-height: 80vh;
      background: linear-gradient(135deg, #f5f7fa, #e4e9f0);
      border-radius: 20px;
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.2);
      display: flex;
      flex-direction: column;
      z-index: 1000;
      overflow: hidden;
      transition: transform 0.4s ease, opacity 0.4s ease;
      transform: translateY(20px);
      opacity: 0;
      font-family: 'Arial', sans-serif;
   }

   .chatbot-container.show {
      transform: translateY(0);
      opacity: 1;
   }

   @media (max-width: 480px) {
      .chatbot-container {
         width: 90vw;
         bottom: 80px;
         right: 5vw;
         max-height: 70vh;
      }
   }

   .chatbot-header {
      background: linear-gradient(90deg, #1e3a8a, #3b82f6);
      color: #fff;
      padding: 18px 25px;
      border-radius: 20px 20px 0 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
   }

   .chatbot-title {
      display: flex;
      align-items: center;
      font-size: 1.4rem;
      font-weight: 700;
      letter-spacing: 1px;
   }

   .chatbot-logo {
      width: 45px;
      height: 45px;
      margin-right: 15px;
      border-radius: 50%;
      border: 3px solid #fff;
      transition: transform 0.3s ease;
   }

   .chatbot-logo:hover {
      transform: rotate(360deg);
   }

   .chatbot-actions {
      display: flex;
      gap: 15px;
   }

   .chatbot-action-btn, .chatbot-close-btn {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: #fff;
      font-size: 1.1rem;
      padding: 8px;
      border-radius: 50%;
      cursor: pointer;
      transition: all 0.3s ease;
   }

   .chatbot-action-btn:hover, .chatbot-close-btn:hover {
      background: rgba(255, 255, 255, 0.4);
      transform: rotate(90deg);
   }

   .chatbot-action-btn.listening {
      background: #f97316;
      color: #fff;
      animation: pulse 1.2s infinite;
   }

   @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.15); }
      100% { transform: scale(1); }
   }

   .chatbot-messages {
      flex-grow: 1;
      padding: 25px;
      overflow-y: auto;
      background: #f8fafc;
      font-size: 1.1rem;
      line-height: 1.7;
   }

   .message {
      display: flex;
      margin-bottom: 20px;
      align-items: flex-start;
      animation: fadeIn 0.4s ease;
   }

   @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
   }

   .user-message {
      justify-content: flex-end;
   }

   .bot-message .message-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 12px;
      background: url('./assets/images/site-logo.png') center/cover;
      border: 2px solid #3b82f6;
   }

   .user-message .message-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-left: 12px;
      background: url('https://via.placeholder.com/40?text=U') center/cover;
      border: 2px solid #f97316;
   }

   .message-content {
      padding: 15px 20px;
      border-radius: 15px;
      max-width: 70%;
      background: #fff;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
   }

   .message-content:hover {
      transform: translateY(-5px);
   }

   .user-message .message-content {
      background: #f97316;
      color: #fff;
   }

   .message-time {
      font-size: 0.85rem;
      color: #666;
      margin-top: 8px;
      text-align: right;
   }

   .chatbot-typing {
      padding: 15px;
      display: none;
      justify-content: center;
      gap: 10px;
   }

   .dot {
      width: 10px;
      height: 10px;
      background: #3b82f6;
      border-radius: 50%;
      animation: bounce 1.5s infinite;
   }

   .dot:nth-child(2) { animation-delay: 0.3s; }
   .dot:nth-child(3) { animation-delay: 0.6s; }

   @keyframes bounce {
      0%, 80%, 100% { transform: translateY(0); }
      40% { transform: translateY(-10px); }
   }

   .chatbot-input-container {
      padding: 20px;
      background: #fff;
      border-top: 1px solid #e5e7eb;
      display: flex;
      align-items: center;
      gap: 15px;
   }

   #chatbot-input {
      flex-grow: 1;
      padding: 12px 20px;
      border: 1px solid #d1d5db;
      border-radius: 25px;
      outline: none;
      font-size: 1rem;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
   }

   #chatbot-input:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
   }

   .chatbot-send-btn {
      padding: 12px 20px;
      background: #3b82f6;
      color: #fff;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.3s ease;
   }

   .chatbot-send-btn:hover {
      background: #1e3a8a;
      transform: scale(1.1);
   }

   .chatbot-quick-actions {
      padding: 15px;
      background: #f8fafc;
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      justify-content: center;
   }

   .chatbot-quick-actions button {
      padding: 10px 20px;
      background: #fff;
      border: 2px solid #3b82f6;
      border-radius: 20px;
      color: #3b82f6;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
   }

   .chatbot-quick-actions button:hover {
      background: #3b82f6;
      color: #fff;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
   }

   .chatbot-toggle-btn {
      position: fixed;
      bottom: 20px;
      right: 20px;
      width: 65px;
      height: 65px;
      background: none;
      border: none;
      cursor: pointer;
      z-index: 1000;
      box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
      transition: transform 0.4s ease;
   }

   .chatbot-toggle-btn:hover {
      transform: rotate(360deg);
   }

   .chatbot-toggle-btn svg {
      width: 100%;
      height: 100%;
   }
</style>

<!-- Chatbot JavaScript (Unchanged) -->
<script>
   let context = {};
   let sessionId = null;
   let isListening = false;
   const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
   const recognition = SpeechRecognition ? new SpeechRecognition() : null;

   if (recognition) {
      recognition.continuous = false;
      recognition.lang = 'en-US';
      recognition.interimResults = false;
      recognition.onstart = () => {
         document.getElementById('chatbot-voice').classList.add('listening');
      };
      recognition.onresult = (event) => {
         const transcript = event.results[0][0].transcript.trim();
         document.getElementById('chatbot-input').value = transcript;
         sendMessage();
      };
      recognition.onend = () => {
         isListening = false;
         document.getElementById('chatbot-voice').classList.remove('listening');
      };
      recognition.onerror = (event) => {
         alert(`Voice error: ${event.error}. Please try again.`);
         isListening = false;
         document.getElementById('chatbot-voice').classList.remove('listening');
      };
   } else {
      document.getElementById('chatbot-voice').style.display = 'none';
   }

   function toggleChatbot() {
      const container = document.getElementById('chatbot-container');
      const toggleBtn = document.getElementById('chatbot-toggle');
      if (container.style.display === 'none' || !container.style.display) {
         container.style.display = 'flex';
         container.classList.add('show');
         toggleBtn.style.display = 'none';
         showWelcomeMessage();
      } else {
         container.classList.remove('show');
         setTimeout(() => {
            container.style.display = 'none';
            toggleBtn.style.display = 'block';
         }, 300);
      }
   }

   function toggleVoice() {
      if (!recognition) {
         alert('Voice input not supported. Use Chrome/Edge.');
         return;
      }
      if (isListening) {
         recognition.stop();
      } else {
         try {
            recognition.start();
            isListening = true;
         } catch (e) {
            alert('Failed to start voice input. Check microphone.');
         }
      }
   }

   function sendMessage() {
      const input = document.getElementById('chatbot-input');
      const messages = document.getElementById('chatbot-messages');
      const typing = document.getElementById('chatbot-typing');
      const userMessage = input.value.trim();
      if (!userMessage) return;

      const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
      messages.innerHTML += `
         <div class="message user-message">
            <div class="message-content">${userMessage}</div>
            <div class="message-avatar"></div>
            <div class="message-time">${time}</div>
         </div>`;
      input.value = '';
      messages.scrollTop = messages.scrollHeight;
      typing.style.display = 'flex';

      fetch('http://localhost:5000/chatbot', {
         method: 'POST',
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify({ message: userMessage, context: context, session_id: sessionId }),
         credentials: 'include'
      })
      .then(response => response.json())
      .then(data => {
         typing.style.display = 'none';
         const botTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
         messages.innerHTML += `
            <div class="message bot-message">
               <div class="message-avatar"></div>
               <div class="message-content">${data.response.replace(/\n/g, '<br>')}</div>
               <div class="message-time">${botTime}</div>
            </div>`;
         context = data.context;
         sessionId = data.session_id;
         messages.scrollTop = messages.scrollHeight;
      })
      .catch(error => {
         typing.style.display = 'none';
         messages.innerHTML += `
            <div class="message bot-message">
               <div class="message-avatar"></div>
               <div class="message-content">Oops! Something went wrong. Try again!</div>
               <div class="message-time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>
            </div>`;
         messages.scrollTop = messages.scrollHeight;
      });
   }

   function sendQuickMessage(message) {
      document.getElementById('chatbot-input').value = message;
      sendMessage();
   }

   function resetChat() {
      document.getElementById('chatbot-messages').innerHTML = '';
      context = {};
      sessionId = null;
      showWelcomeMessage();
   }

   function showWelcomeMessage() {
      const messages = document.getElementById('chatbot-messages');
      if (!messages.innerHTML) {
         const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
         messages.innerHTML = `
            <div class="message bot-message">
               <div class="message-avatar"></div>
               <div class="message-content">🌄 Namaste! I’m Travel Buddy—ready to explore Nepal with you!</div>
               <div class="message-time">${time}</div>
            </div>`;
      }
   }

   document.getElementById('chatbot-toggle').addEventListener('click', toggleChatbot);
</script>
</body>

</html>