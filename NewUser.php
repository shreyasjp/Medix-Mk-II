<?php
require_once 'PHP Modules/Connect.php';
start_session();
if (!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Complete your profile • Medix</title>
  <meta id="viewport" name="viewport"
    content="width=device-width, initial-scale=1, minimum-scale=1, viewport-fit=cover" />
  <script type="text/javascript" src="Flow/jQuery.js"></script>
  <link rel="preload" href="Data/Fonts/GothamLight.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="Data/Fonts/GothamMedium.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" href="Data/Fonts/GothamBold.woff2" as="font" type="font/woff2" crossorigin>
  <link rel="preload" as="image" href="Data/Animations/SpinnerMedium.svg">
  <link rel="preload" as="image" href="Data/Animations/SpinnerSmall.svg">
  <link rel="stylesheet" href="Data/Fonts/FontAwesome.css" />
  <link rel="stylesheet" type="text/css" href="Design/Basic.css" />
  <link rel="stylesheet" type="text/css" href="Design/ColorScheme.css" />
  <link rel="stylesheet" type="text/css" href="Design/InputBox.css" />
  <link rel="stylesheet" type="text/css" href="Design/Messages.css" />
<link rel="stylesheet" type="text/css" href="Design/CreateProfile.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="Data/Favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="Data/Favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="Data/Favicon/favicon-16x16.png" />
  <link rel="manifest" href="Data/Favicon/site.webmanifest" />
  <link rel="mask-icon" href="Data/Favicon/safari-pinned-tab.svg" color="#212121" />
  <meta name="msapplication-TileColor" content="#000000" />
  <meta name="theme-color" content="#000000" />
</head>

  <!-- Page body -->

  <body class="light">
  <img id="page-loader" class="hide" src="Data/Animations/SpinnerMedium.svg">
    <!-- Display container -->
    <div id="container" class="hide">
      <!-- Page headings and redirection links -->
      <div id="header">
        <h1>Complete your Profile</h1>
      </div>
      <!-- Data collection form -->
      <form id="form" action="PHP Modules/CreateProfile.php" method="post" enctype="multipart/form-data">
        <!-- Age input field -->
        <div id="age-box" class="input-box">
          <label for="age-input" id="nage-label"
            >Age</label
          >
          <input
            type="text"
            name="age"
            id="age-input"
            spellcheck="false"
            autocomplete="off"
            aria-autocomplete="off"
            aria-required="true"
            required
          />
        </div>
        <p class="error hide" id="age-error">
          <span class="error-symbol">🛈</span> Enter a valid age without letters
          or special characters.
        </p>
        <!-- Height input field -->
        <div id="height-box" class="input-box">
          <label for="height-input" id="height-label">Height (cm)</label>
          <input
            type="text"
            name="height"
            id="height-input"
            spellcheck="false"
            autocapitalize="off"
            autocomplete="off"
            aria-autocomplete="off"
            aria-required="true"
            required
          />
        </div>
        <p id="height-error" class="error  hide">
          <span class="error-symbol">🛈</span> Enter a valid height without letters
          or special characters.
        </p>
        <!-- Weight input field -->
        <div id="weight-box" class="input-box">
            <label for="weight-input" id="weight-label">Weight (Kg)</label>
            <input
              type="text"
              name="weight"
              id="weight-input"
              spellcheck="false"
              autocapitalize="off"
              autocomplete="off"
              aria-autocomplete="off"
              aria-required="true"
              required
            />
          </div>
          <p id="weight-error" class="error  hide">
            <span class="error-symbol">🛈</span> Enter a valid weight without letters
            or special characters.
          </p>
          <!-- Blood Group input field -->
          <div id="blood-group-box" class="dropdown input-box">
            <input type="text" required id="blood-group-input" name="blood-group"spellcheck="false"
              autocapitalize="off" autocomplete="off" aria-autocomplete="list" />
            <label for="blood-group-input">Blood Group</label>
              <ul class="dropdown-list">
                <li>A+</li>
                <li>A-</li>
                <li>B+</li>
                <li>B-</li>
                <li>AB+</li>
                <li>AB-</li>
                <li>O+</li>
                <li>O-</li>
                <li>Special</li>
                <li>Unknown</li>
              </ul> 
          </div>
        <p id="blood-group-error" class="error hide">
            <span class="error-symbol">🛈</span> Choose a valid blood group.
        </p>
        <div id="gender-selector" class="">
            <input type="radio" id="male-button" name="gender" value="Male"/>
            <label id="male-label" for="male-button"><span class="gender-icons"><img src="Data/Icons/Male.png"></span>Male</label>
            <input type="radio" id="female-button" name="gender" value="Female"/>
            <label id="female-label" for="female-button"><span class="gender-icons"><img src="Data/Icons/Female.png"></span>Female</label>
        </div>
        <div class="uploadbox">
            <input type="file" name="Image" id="upload-image" accept=".jpg, .jpeg, .png, .gif, .svg" />
            <label for="upload-image" id="upload-Upload">Add your profile photo</label>
          </div>
          <p class="hide" id="upload-Message"></p>
          <div id="upload-previewContainer" class="hide">
            <p></p>
          </div>
        <input type="submit" id="form-submit-button" class="submit"  value="Continue" />
        <img id="submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
    </form>
    </div>
    <noscript>
        <div style="box-sizing: bordeborder-box; text-align: center; margin: 30px; padding: 20px; background-color: #ffdcdc; border: 1px solid red; border-radius: 5px;">
            <p>This website requires JavaScript to function. Please enable JavaScript in your browser settings to view this page.</p>
        </div>
    </noscript>
    <script type="text/javascript">document.getElementById('page-loader').classList.remove('hide');</script>
    <script src="Flow/InputLabelHandling.js"></script>
    <script src="Flow/ThemeSelector.js"></script>
    <script src="Flow/Createprofile.js"></script>
  </body>
</html>