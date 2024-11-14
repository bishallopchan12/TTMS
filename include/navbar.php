<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include 'db/config.php'
?>
<header id="masthead" class="site-header">
   <!-- header html start -->
   <div class="top-header">
      <div class="container">
         <div class="top-header-inner">
            <div class="header-contact text-left">
               <a href="telto:9818676198">
                  <i aria-hidden="true" class="icon icon-phone-call2"></i>
                  <div class="header-contact-details d-none d-sm-block">
                     <span class="contact-label">For Further Inquires :</span>
                     <h5 class="header-contact-no">+977-9818676198</h5>
                  </div>
               </a>
            </div>
            <div class="site-logo text-center">
               <h1 class="site-title">
                  <a href="index.php">
                     <img src="assets/images/site-logo.png" alt="Logo">
                  </a>
               </h1>
            </div>
            <!-- Place this where you want the search icon to appear -->
<!-- Place this where you want the search icon to appear -->
<a href="recommend/content.php" style="
    display: flex; 
    justify-content: center; 
    align-items: center; 
    width: 60px; 
    height: 60px; 
    border: 2px solid #007bff; 
    border-radius: 50%; 
    background-color: white; 
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
    transition: background-color 0.3s, transform 0.3s; 
    text-decoration: none; /* Remove underline */
    color: #007bff; /* Icon color */
">

    <i class="fas fa-search" style="font-size: 24px;"></i> <!-- Font Awesome Search Icon -->
</a>

<style>
    /* Optional: Add hover effect using CSS */
    a:hover {
        background-color: #e9ecef; /* Light hover color */
        transform: scale(1.1); /* Slightly enlarge on hover */
    }
</style>

         </div>
     </div>
   </div>
   <div class="bottom-header">
      <div class="container">
         <div class="bottom-header-inner d-flex justify-content-between align-items-center">
            <div class="header-social social-icon">
               <ul>
                  <li>
                     <a href="https://www.facebook.com/" target="_blank">
                        <i class="fab fa-facebook-f" aria-hidden="true"></i>
                     </a>
                  </li>
                  <li>
                     <a href="https://www.twitter.com/" target="_blank">
                        <i class="fab fa-twitter" aria-hidden="true"></i>
                     </a>
                  </li>
                  <li>
                     <a href="https://www.youtube.com/" target="_blank">
                        <i class="fab fa-youtube" aria-hidden="true"></i>
                     </a>
                  </li>
               </ul>
            </div>
            <div class="navigation-container d-none d-lg-block">
               <nav id="navigation" class="navigation">
                  <ul>
                     <li>
                        <a href="index.php">Home</a>
                     </li>
                     <li>
                        <a href="about.php">About us</a>
                     </li>
                     <li>
                        <a href="destination.php">Destination</a>
                     </li>
                     <li class="menu-item-has-children">
                        <a href="index.php">packages</a>
                        <ul>
                           <li>
                              <a href="package.php">Packages</a>
                           </li>
                           <li>
                              <a href="package-offer.php">Package offer</a>
                           </li>
                        </ul>
                     </li>
                     <li class="menu-item-has-children">
                        <a href="index.php">Pages</a>
                        <ul>

                           <li>
                              <a href="service.php">Service</a>
                           </li>
                           <li>
                              <a href="policy.php">Privacy Policy</a>
                           </li>
                           <li>
                              <a href="term.php">Term & Conditions</a>
                           </li>
                           <li>
                              <a href="faq.php">Faq Page</a>
                           </li>

                        </ul>
                     </li>
                     <li>
                        <a href="contact.php">contact us</a>
                     </li>
                     <li>
                        <a href="Feedback.php">feedback</a>
                     </li>
                     <li>
    <a href="./utils/nearest_places.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.206 1.206l4.1 4.1a1 1 0 0 0 1.415-1.415l-4.1-4.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
        </svg>
    </a>
</li>

                  </ul>
               </nav>
            </div>
            <div class="header-btn">


               <?php

               if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
                  $id = $_SESSION['id'];

                  echo '<a href="profile.php?pid=' . $id . '"class="round-btn">Your Profile</a>'; // display the current user's email



               } else {
                  echo '<a href="./sign-in.php" class="round-btn">Sign in</a>'; // display a "Sign in" link if no user is logged in
               }
               ?>

            </div>
         </div>
      </div>
   </div>
   <div class="mobile-menu-container"></div>
</header>