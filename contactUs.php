<?php
$csv = fopen("contacts.csv", "r");
$headers = fgetcsv($csv); 
$data = fgetcsv($csv);
fclose($csv);

$phone = $data[0];
$resEmail = $data[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us | Lotus Fire</title>
  <link rel="stylesheet" href="css/contactUs.css" />
  <link rel="stylesheet" href="css/navbar.css" />
</head>
<body>
  <!-- Navigation Bar code copied from the NavBar&Footer html file-->
  <nav class="upnav">
    <div class="topnav">
      <div class="logo">
        <a href="home.html">Lotus Fire</a>
      </div>
      <ul>
        <li><button onclick="location.href = 'menu.php'">Menu</button></li>
        <li><button onclick="location.href='favourites.php'">Favourites</button></li>
        <li><button onclick="location.href='AboutUs.html'">About us</button></li>
        <li><button onclick="location.href='contactUs.php'">Contact Us</button></li>
      </ul>
    </div>
  </nav>

  <section id="contact" class="contact">
    <!-- Contact Us Section -->
    <h2>Contact us:</h2>
    <ul>
      <li>
        <img src="images/phone.png" alt="Small phone icon" />
        <p><a href="tel:<?= $phone ?>"><?= $phone ?></a></p>
      </li>
      <li>
        <img src="images/email.png" alt="Small letter icon" />
        <p><a href="mailto:<?= $resEmail ?>"><?= $resEmail ?></a></p>
      </li>
    </ul>
  </section>
  <section id="booking" class="booking">
    <h2>Book a Table</h2>
    <form action="bookingForm.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <input type="date" name="date" required />
        <input type="time" name="time" required />
        <button type="submit">Reserve Now</button>  
    </form>
  </section>

  <section id="query" class="contact-form">
    <h2>Ask a Query</h2>
    <form action="queryForm.php" method="POST">
        <input type="text" name="name" placeholder="Your Name" required />
        <input type="email" name="email" placeholder="Your Email" required />
        <textarea name="question" placeholder="Your Question" rows="5" required></textarea>
        <button type="submit">Submit Query</button>
      </form>
  </section>
  
  <section id="complaint" class="contact-form">
  <h2>File a Complaint</h2>
  <form action="complaintForm.php" method="POST">
    <input type="text" name="name" placeholder="Your Name" required />
    <input type="email" name="email" placeholder="Your Email" required />
    <textarea name="complaint" placeholder="Describe your issue" rows="5" required></textarea>
    <button type="submit">Submit Complaint</button>
  </form>
</section>

  
  
  <footer>
    <p>&copy; 2025 Lotus Fire Restaurant. All rights reserved.</p>
  </footer>
</body>
</html>
