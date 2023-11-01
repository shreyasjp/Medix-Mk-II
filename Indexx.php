<?php 
require 'PHP Modules/AuthCheck.php';
start_session();
if(!isset($_SESSION['failCount'])){
  $_SESSION['failCount'] = 0;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Medix</title>
    <meta
      id="viewport"
      name="viewport"
      content="width=device-width, initial-scale=1, minimum-scale=1, viewport-fit=cover"
    />
    <meta
      http-equiv="refresh"
      content="0.25;url=<?php echo $location;?>"
    />
    <link rel="preload" as="image" href="Data/Animations/SpinnerMedium.svg">
    <link rel="preload" href="Data/Fonts/GothamLight.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="Data/Fonts/GothamMedium.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="Data/Fonts/GothamBold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" as="image" href="Data/Favicon/android-chrome-384x384.png">
    <link rel="stylesheet" type="text/css" href="Design/Basic.css" />
    <link rel="stylesheet" type="text/css" href="Design/ColorScheme.css" />
    <link rel="stylesheet" type="text/css" href="Design/SplashScreen.css" />
    <link
      rel="apple-touch-icon"
      sizes="180x180"
      href="Data/Favicon/apple-touch-icon.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="32x32"
      href="Data/Favicon/favicon-32x32.png"
    />
    <link
      rel="icon"
      type="image/png"
      sizes="16x16"
      href="Data/Favicon/favicon-16x16.png"
    />
    <link rel="manifest" href="Data/Favicon/site.webmanifest" />
    <link
      rel="mask-icon"
      href="Data/Favicon/safari-pinned-tab.svg"
      color="#212121"
    />
    <meta name="msapplication-TileColor" content="#000000" />
    <meta name="theme-color" content="#000000" />
  </head>
  <body class="light">
    <img id="page-loader" src="Data/Animations/SpinnerMedium.svg">
    <div id="container" class="hide">
      <img id="medix-logo" src="Data\Favicon\android-chrome-384x384.png"/>
      <div id="footer">
        <p>MEDIX • 2023</p>
      </div>
    </div>
  </body>
  <script type="text/javascript" src="Flow/ThemeSelector.js"></script>
</html>
<?php  exit(); ?>