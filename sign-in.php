<?php
session_start();
error_reporting(0);
include('admin/includes/config.php');
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $newpassword = $_POST['newpassword'];
    $sql = "SELECT email FROM users WHERE email=:email";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $con = "update users set password=:newpassword where email=:email";
        $chngpwd1 = $dbh->prepare($con);
        $chngpwd1->bindParam(':email', $email, PDO::PARAM_STR);
        $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
        $chngpwd1->execute();
        echo "<script>
      alert('Password Changed Successfully 😊');
      window.location.href='sign-in.php';
      </script>";
    } else {
        echo "<script>
      alert('Email Id Is Invalid 😒');
      window.location.href='sign-in.php';
      </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>B&B Tour and Travels Pvt. Ltd.</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            position: relative;
            overflow-x: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /* Particle Background */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('assets/images/himal.jpg') no-repeat center center/cover;
            opacity: 0.15;
            z-index: -2;
            transform: translateY(0);
            transition: transform 0.1s ease;
        }

        body.scrolled::before {
            transform: translateY(calc(var(--scroll) * -0.2px));
        }

        .site-logo {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: none;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 30px;
            z-index: 0;
        }

        .site-title a {
            font-size: 3rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            background: linear-gradient(45deg, #ff6f61, #ffeb3b, #ff6f61);
            background-size: 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 3px 10px rgba(0, 0, 0, 0.4);
            animation: gradientShift 6s infinite linear;
            transition: transform 0.3s ease;
        }

        .site-title a:hover {
            transform: scale(1.05);
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        .container {
            position: relative;
            max-width: 420px;
            width: 100%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            z-index: 1;
            perspective: 1000px;
            transform-style: preserve-3d;
            transition: all 0.5s ease;
        }

        .container:hover {
            transform: translateY(-8px) rotateX(5deg);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .container .registration {
            display: none;
        }

        #check:checked ~ .registration {
            display: block;
        }

        #check:checked ~ .login {
            display: none;
        }

        #check {
            display: none;
        }

        .container .form {
            padding: 3rem;
            position: relative;
        }

        .form::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 30%, rgba(255, 111, 97, 0.2), transparent 70%);
            z-index: -1;
        }

        .form header {
            font-size: 2.5rem;
            font-weight: 800;
            text-align: center;
            margin-bottom: 2.5rem;
            color: #1e3c72;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .form header::after {
            content: "";
            display: block;
            width: 80px;
            height: 5px;
            background: linear-gradient(to right, #ff6f61, #ffeb3b);
            margin: 0.75rem auto;
            border-radius: 3px;
        }

        .form input {
            width: 100%;
            padding: 14px 18px;
            font-size: 1.1rem;
            margin-bottom: 1.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            outline: none;
            background: rgba(255, 255, 255, 0.7);
            transition: all 0.4s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form input:focus {
            border-color: #ff6f61;
            box-shadow: 0 0 0 4px rgba(255, 111, 97, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #fff;
            transform: translateY(-2px);
        }

        .form a {
            font-size: 1rem;
            color: #ff6f61;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 1.25rem;
            transition: all 0.3s ease;
        }

        .form a:hover {
            color: #ffeb3b;
            text-decoration: underline;
            transform: translateX(3px);
        }

        .signup {
            font-size: 1rem;
            text-align: center;
            color: #1e3c72;
        }

        .signup label {
            color: #ff6f61;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .signup label:hover {
            color: #ffeb3b;
            text-decoration: underline;
            transform: translateX(3px);
        }

        button {
            border-radius: 12px;
            border: none;
            background: linear-gradient(90deg, #ff6f61, #ffeb3b, #ff6f61);
            background-size: 200%;
            color: #fff;
            font-size: 1.1rem;
            font-weight: 700;
            padding: 14px 50px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            transition: all 0.4s ease;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            animation: buttonGlow 3s infinite ease-in-out;
        }

        @keyframes buttonGlow {
            0%, 100% { box-shadow: 0 6px 20px rgba(255, 111, 97, 0.3); }
            50% { box-shadow: 0 6px 30px rgba(255, 235, 59, 0.5); }
        }

        button:hover {
            background-position: 100%;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        button:active {
            transform: scale(0.95);
        }

        /* Popup Styles */
        .popup {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
        }

        .popup-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            margin: 8% auto;
            padding: 35px;
            max-width: 420px;
            border-radius: 25px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
            position: relative;
            animation: slideIn 0.6s ease;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .popup-content:hover {
            transform: rotateX(5deg);
        }

        @keyframes slideIn {
            from { transform: translateY(-60px) rotateX(-10deg); opacity: 0; }
            to { transform: translateY(0) rotateX(0); opacity: 1; }
        }

        .close {
            color: #ff6f61;
            float: right;
            font-size: 32px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .close:hover,
        .close:focus {
            color: #ffeb3b;
            transform: rotate(180deg) scale(1.1);
        }

        .popup-content h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3c72;
            text-align: center;
            margin-bottom: 2rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .popup-content h2::after {
            content: "";
            display: block;
            width: 50px;
            height: 4px;
            background: linear-gradient(to right, #ff6f61, #ffeb3b);
            margin: 0.75rem auto;
            border-radius: 3px;
        }

        .popup-content form {
            margin-top: 1.5rem;
        }

        .popup-content input[type="email"],
        .popup-content input[type="password"] {
            width: 100%;
            padding: 14px 18px;
            margin-bottom: 1.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.7);
            outline: none;
            transition: all 0.4s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .popup-content input[type="email"]:focus,
        .popup-content input[type="password"]:focus {
            border-color: #ff6f61;
            box-shadow: 0 0 0 4px rgba(255, 111, 97, 0.15), 0 4px 12px rgba(0, 0, 0, 0.1);
            background: #fff;
            transform: translateY(-2px);
        }

        .popup-content input[type="submit"] {
            width: 100%;
            padding: 14px;
            border: none;
            background: linear-gradient(90deg, #ff6f61, #ffeb3b, #ff6f61);
            background-size: 200%;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            animation: buttonGlow 3s infinite ease-in-out;
        }

        .popup-content input[type="submit"]:hover {
            background-position: 100%;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                padding: 1.5rem;
            }

            .form header {
                font-size: 2rem;
            }

            .form input {
                padding: 12px;
                font-size: 1rem;
            }

            button {
                padding: 12px;
                font-size: 1rem;
            }

            .site-title a {
                font-size: 2rem;
            }

            .popup-content {
                max-width: 90%;
                padding: 25px;
            }

            .popup-content h2 {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <!-- Particle Background -->
    <div id="particles-js"></div>

    <!-- Log In Form Section -->
    <section>
        <div class="site-logo">
            <h1 class="site-title">
                <a href="index.php">B&B Tour and Travels</a>
            </h1>
        </div>
        <div class="container">
            <input type="checkbox" id="check">
            <div class="login form">
                <header>Log In</header>
                <form action="process.php" method="POST">
                    <input name="email" type="email" placeholder="Email" required />
                    <input name="password" type="password" placeholder="Password" required />
                    <a style="cursor:pointer;" onclick="openPopup()">Forgot password?</a><br>
                    <button name="login">Log In</button>
                </form>
                <div class="signup">
                    <span class="signup">Don't have an account?
                        <label for="check">Signup</label>
                    </span>
                </div>
            </div>
            <div class="registration form">
                <header>Sign Up</header>
                <form action="process.php" method="POST">
                    <input type="text" name="name" placeholder="Name" required />
                    <input type="email" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required />
                    <input type="password" name="cpassword" placeholder="Confirm Password" required />
                    <button name="signup">Sign Up</button>
                </form>
                <div class="signup">
                    <span class="signup">Already have an account?
                        <label for="check">Login</label>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Forgot Password Popup -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">×</span>
            <h2>Forgot Password</h2>
            <form method="POST" action="">
                <input type="email" name="email" class="form-control" id="email" placeholder="Reg Email id" required>
                <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="New Password" required>
                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required>
                <input type="submit" value="Submit" name="submit">
            </form>
        </div>
    </div>

    <!-- Include Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    <script>
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 80, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": ["#ff6f61", "#ffeb3b"] },
                "shape": { "type": "circle", "stroke": { "width": 0, "color": "#000000" } },
                "opacity": { "value": 0.5, "random": true, "anim": { "enable": false } },
                "size": { "value": 3, "random": true, "anim": { "enable": false } },
                "line_linked": { "enable": true, "distance": 150, "color": "#ffffff", "opacity": 0.3, "width": 1 },
                "move": { "enable": true, "speed": 2, "direction": "none", "random": false, "straight": false, "out_mode": "out" }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": { "onhover": { "enable": true, "mode": "repulse" }, "onclick": { "enable": true, "mode": "push" }, "resize": true },
                "modes": { "repulse": { "distance": 100, "duration": 0.4 }, "push": { "particles_nb": 4 } }
            },
            "retina_detect": true
        });

        window.addEventListener("scroll", () => {
            const scroll = window.scrollY;
            document.body.style.setProperty("--scroll", scroll);
            document.body.classList.add("scrolled");
        });

        function openPopup() {
            document.getElementById("popup").style.display = "block";
        }

        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
</body>
</html>