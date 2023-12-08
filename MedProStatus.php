<?php
require_once 'PHP Modules/Connect.php';
start_session();

if (!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}

if (isset($_SESSION['MedProID'])){
  header('Location: MedPro.php');
  exit();
}

$id = $_SESSION['id'];

$query = "SELECT * FROM `medix-users` WHERE mx_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$medixID = $row['email'];
$name = $row['name'];

$query = "SELECT * FROM `medix-medical-personnel` WHERE mx_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
if ($stmt->rowCount() <= 0){
    header('Location: MedProVerify.php');
    exit();
}
else{
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $role = $row['role'];
    $city = $row['city'];
    $org = $row['organization'];
    $proof = $row['document-location'];
    $status = $row['verification_status'];
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>Verification Pending</title>
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
  <link rel="stylesheet" type="text/css" href="Design/PasswordFields.css" />
  <link rel="stylesheet" type="text/css" href="Design/Messages.css" />
  <link rel="stylesheet" type="text/css" href="Design/NavBar.css" />
  <link rel="stylesheet" type="text/css" href="Design/MedProStatus.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="Data/Favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="Data/Favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="Data/Favicon/favicon-16x16.png" />
  <link rel="manifest" href="Data/Favicon/site.webmanifest" />
  <link rel="mask-icon" href="Data/Favicon/safari-pinned-tab.svg" color="#212121" />
  <meta name="msapplication-TileColor" content="#000000" />
  <meta name="theme-color" content="#000000" />
</head>

<body class="light">
    <img id="page-loader" class="hide" src="Data/Animations/SpinnerMedium.svg">
    <nav class="hide">
    <div class="nav-content">
      <a href="home.php" class="logo">
        <svg id="brand-logo" width="24" height="24" display="block">
          <image width="24" height="24" href="Data/MEDiqo.png">
        </svg>
      </a>

      <div class="nav-icon">
        <div class="bar one"></div>
        <div class="bar two"></div>
      </div>

      <div class="nav-links" style="justify-content: end; gap: 20px;">
        <a href="home.php">Home</a>
        <p id='bar'>|</p>
        <a href="PHP Modules/SignOut.php">Sign Out</a>
      </div>

      <svg class="search-icon" viewBox="0 0 3.7041668 11.641667" height="44" width="14">
        <g transform="matrix(0.97865947,0,0,0.97865947,-18.209185,-74.390797)">
          <path
            d="m 19.070369,80.532362 c -0.618144,0.618143 -0.619255,1.62581 -7.32e-4,2.244333 0.570867,0.570865 1.473777,0.613735 2.095614,0.131181 l 0.945308,0.945309 0.280633,-0.280633 -0.945308,-0.945309 c 0.482552,-0.621838 0.439684,-1.524746 -0.131182,-2.095613 -0.618523,-0.618523 -1.62619,-0.617413 -2.244333,7.32e-4 z m 0.280632,0.280632 c 0.466517,-0.466515 1.216631,-0.467898 1.683433,-0.0011 0.466802,0.466801 0.466882,1.218378 3.64e-4,1.684894 -0.466512,0.466513 -1.21809,0.466436 -1.684892,-3.67e-4 -0.466803,-0.466801 -0.465418,-1.216918 0.0011,-1.683432 z"
            fill="#27b3d6" />
        </g>
      </svg>
    </div>
  </nav>
    <div id="container" class='hide'>
        <div id="med-pro-info-header">
            <h1><?php echo $name; ?></h1>
            <h3><?php echo $medixID; ?></h2>
        </div>
        <div id="med-pro-info">
            <div class="med-pro-info" id="med-pro-info-role">
                <h2>Role<span class="info-icons"><img
                      src="Data/Icons/Doctor.png"></span></h2>
                <h3><?php echo $role; ?></h3>
            </div>
            <div class="med-pro-info" id="med-pro-info-org">
                <h2>Organization<span class="info-icons"><img
                      src="Data/Icons/Organization.png"></span></h2>
                <h3><?php echo $org; ?></h3>
            </div>
            <div class="med-pro-info <?php echo !intval($row['city'])?'hide':''; ?>" id="med-pro-info-city">
                <h2>ZIP Code<span class="info-icons"><img
                      src="Data/Icons/Location.png"></span></h2>
                <h3><?php echo $city; ?></h3>
            </div>
            <div class="med-pro-info <?php echo !intval($row['phone'])?'hide':''; ?>" id="med-pro-info-phone">
                <h2>Phone Number<span class="info-icons"><img
                      src="Data/Icons/Phone.png"></span></h2>
                <h3><?php echo $row['phone']; ?></h3>
            </div>
        </div>
        <h2 id="disp-btn" onclick="if ($('#overlay').hasClass('hide')){$('#overlay').removeClass('hide');}else{$('#overlay').addClass('hide')}" >View Uploaded ID</h2>
        <div id="overlay" class="hide">
            <div id="med-pro-proof">
                <iframe id="proof-display" class="" src="<?php echo 'Medix/'.$proof; ?>" frameborder="0"></iframe>
                <button id="close-button" onclick="$('#overlay').addClass('hide');"><span class="info-icons"><img src="Data/Icons/Exit.png"></span></button>
            </div>
        </div>
    </div>
    <noscript>
        <div style="box-sizing: bordeborder-box; text-align: center; margin: 30px; padding: 20px; background-color: #ffdcdc; border: 1px solid red; border-radius: 5px;">
            <p>This website requires JavaScript to function. Please enable JavaScript in your browser settings to view this page.</p>
        </div>
    </noscript>
    <script type="text/javascript">document.getElementById('page-loader').classList.remove('hide');</script>
    <script type="text/javascript" src="Flow/ThemeSelector.js"></script>
</body>
</html>
