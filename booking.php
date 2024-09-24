<?php
session_start();
error_reporting(0);
include('db/config.php');

if (isset($_POST['submit'])) {
    $pid = intval($_GET['pkgid']);
    $recommendedPlaceId = intval($_POST['recommended_place_id']); // Get the recommended place ID
    $bname = $_POST['fullname'];
    $bemail = $_POST['email'];
    $bmobile = $_POST['mobile'];
    $bnameoncard = $_POST['nameoncard'];
    $bcard_number = $_POST['card_number'];
    $bexpire_month = $_POST['expire_month'];
    $bexpire_year = $_POST['expire_year'];
    $bcvv = $_POST['cvv'];
    $bcountry = $_POST['country'];
    $bstreet_1 = $_POST['street_1'];
    $bstreet_2 = $_POST['street_2'];
    $bcity = $_POST['city'];
    $bstate = $_POST['state'];
    $bpincode = $_POST['pincode'];
    $badditional_information = $_POST['additional_information'];
    $status = 0;

    // Insert into booking table
    $sql = "INSERT INTO booking (PackageId, RecommendedPlaceId, FirstName, Email, Phone, NameOnCard, CardNumber, ExpMonth, ExpYear, CVV, Country, StreetLine1, StreetLine2, City, State, Pincode, Additional_Information, Status) 
            VALUES ('$pid', '$recommendedPlaceId', '$bname', '$bemail', '$bmobile', '$bnameoncard', '$bcard_number', '$bexpire_month', '$bexpire_year', '$bcvv', '$bcountry', '$bstreet_1', '$bstreet_2', '$bcity', '$bstate', '$bpincode', '$badditional_information', '$status')";

    if ($conn->query($sql) === TRUE) {
        $lastInsertId = $conn->insert_id;
        if ($lastInsertId) {
            echo "<script>
                    alert('Booking Successful 😊');
                    window.location.href='confirmation.php?bid=$lastInsertId&pkgid=" . htmlentities($pid) . "';
                  </script>";         
        } else {
            $error = "Something went wrong. Please try again";
        }
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<?php include 'include/header.php'; ?>
<body>
   <div id="page" class="page">
      <?php include 'include/navbar.php'; ?>
      <main id="content" class="site-main">
         <section class="booking-inner-page">
            <div class="inner-banner-wrap">
               <div class="inner-baner-container" style="background-image: url(assets/images/home.jpg);">
                  <div class="container">
                     <div class="inner-banner-content">
                        <h1 class="page-title">Booking</h1>
                     </div>
                  </div>
               </div>
            </div>
            
            <div class="booking-section">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-8 right-sidebar">
                        <div class="booking-form-wrap">
                           <form method="POST" action="">
                              <div class="booking-content">
                                 <div class="form-title">
                                    <span>1</span>
                                    <h3>Your Details</h3>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Full Name*</label>
                                          <input type="text" class="form-control" name="fullname" id="fullname" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <?php
                                       $id = $_SESSION['id'];
                                       $sql = "SELECT email FROM users WHERE id = $id";
                                       $query = $dbh->prepare($sql);
                                       $query->execute();
                                       $results = $query->fetchAll(PDO::FETCH_OBJ);
                                       if ($query->rowCount() > 0) {
                                           foreach ($results as $result) {
                                       ?>
                                       <div class="form-group">
                                          <label>Email*</label>
                                          <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlentities($result->email); ?>" readonly>
                                       </div>
                                       <?php } } ?>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Phone*</label>
                                          <input type="text" class="form-control" name="mobile" id="mobile" required>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="booking-content">
                                 <div class="form-title">
                                    <span>2</span>
                                    <h3>Payment Information</h3>
                                 </div>
                                 <div class="row">
                                    <div class="col-12">
                                       <div class="form-group">
                                          <label>Name on card*</label>
                                          <input type="text" class="form-control" name="nameoncard" id="nameoncard" required>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="row align-items-center">
                                          <div class="col-sm-6">
                                             <div class="form-group">
                                                <label>Card number*</label>
                                                <input type="text" name="card_number" id="card_number" class="form-control" minlength="16" maxlength="16" required>
                                             </div>
                                          </div>
                                          <div class="col-sm-6">
                                             <img src="assets/images/cards.png" alt="Cards">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-12">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label>Expiration date*</label>
                                                <div class="row">
                                                   <div class="col-md-6">
                                                      <input type="text" name="expire_month" id="expire_month" class="form-control" placeholder="MM" minlength="1" maxlength="2" required>
                                                   </div>
                                                   <div class="col-md-6">
                                                      <input type="number" name="expire_year" id="expire_year" class="form-control" placeholder="Year" min="2023" max="3000" required>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-md-6">
                                             <div class="form-group">
                                                <label>Security code*</label>
                                                <div class="row">
                                                   <div class="col-4">
                                                      <div class="form-group">
                                                         <input type="text" name="cvv" id="cvv" class="form-control" placeholder="CCV" minlength="3" maxlength="3" required>
                                                      </div>
                                                   </div>
                                                   <div class="col-8">
                                                      <img src="assets/images/icon_ccv.gif" alt="ccv"><small>Last 3 digits</small>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <div class="booking-content">
                                 <div class="form-title">
                                    <span>3</span>
                                    <h3>Billing Address</h3>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-12">
                                       <div class="form-group">
                                          <label>Country*</label>
                                          <select name="country" id="country" required>
                                             <option value="" selected="">Select your country</option>
                                             <option value="Europe">Europe</option>
                                             <option value="United States">United States</option>
                                             <option value="Asia">Asia</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Street Line 1*</label>
                                          <input type="text" class="form-control" name="street_1" id="street_1" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Street Line 2</label>
                                          <input type="text" class="form-control" name="street_2" id="street_2">
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>City*</label>
                                          <input type="text" class="form-control" name="city" id="city" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>State*</label>
                                          <input type="text" class="form-control" name="state" id="state" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-group">
                                          <label>Pincode*</label>
                                          <input type="text" class="form-control" name="pincode" id="pincode" required>
                                       </div>
                                    </div>
                                    <div class="col-sm-12">
                                       <div class="form-group">
                                          <label>Additional Information</label>
                                          <textarea class="form-control" name="additional_information" id="additional_information"></textarea>
                                       </div>
                                    </div>
                                 </div>
                              </div>

                              <!-- Hidden field to store recommended place ID -->
                              <input type="hidden" name="recommended_place_id" value="<?php echo htmlentities($recommendedPlaceId); ?>">

                              <div class="form-group">
                                 <button type="submit" class="btn btn-primary" name="submit">Book Now</button>
                              </div>
                           </form>
                        </div>
                     </div>

                     <div class="col-lg-4">
                        <div class="sidebar">
                           <div class="recommended-places">
                              <h4>Recommended Places</h4>
                              <ul>
                                 <?php
                                 // Fetch recommended places from the database
                                 $recommendedQuery = "SELECT * FROM recommended_places WHERE PackageId = '$pid'";
                                 $recommendedResult = $conn->query($recommendedQuery);
                                 while ($place = $recommendedResult->fetch_assoc()) {
                                     echo '<li>' . $place['PlaceName'] . '</li>';
                                 }
                                 ?>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </main>
      <?php include 'include/footer.php'; ?>
   </div>
   <script src="assets/js/jquery.min.js"></script>
   <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
