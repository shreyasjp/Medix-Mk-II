<?php
require_once 'PHP Modules/Connect.php';
start_session();
if (!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}

function getAgeGroup($age) {
  if ($age <= 1) {
      return "Neonates";
  } elseif ($age <= 12) {
      return "Children";
  } elseif ($age <= 17) {
      return "Adolescents";
  } elseif ($age < 65) {
      return "Adults";
  } else {
      return "Elderly";
  }
}

$id = $_SESSION['id'];
$patientID = "MXP" . $id;
$query = "SELECT * FROM `medix-users` WHERE mx_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$medixID = $row['email'];
$name = $row['name'];

$query = "SELECT * FROM `medix-user-profile` WHERE mx_id = :id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
if ($stmt->rowCount() <= 0){
  header('Location: NewUser.php');
  exit();
}
else{
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
if(!$row['completion_status']){
  header('Location: NewUser.php');
  exit();
}
$age = $row['age'];
$gender = $row['gender'];
$height = $row['height'];
$weight = $row['weight'];
$bloodGroup = $row['blood_group'];

$profilePic = isset($row['profile_pic_location']) ? "Medix Mk II/".$row['profile_pic_location'] : ($gender == 'Male' ? 'Data/Icons/ProfileMale.png' : 'Data/Icons/ProfileFemale.png');

}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title>MedPro • Medix</title>
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
    <link rel="stylesheet" type="text/css" href="Design/MedProVerify.css" />
  <link rel="apple-touch-icon" sizes="180x180" href="Data/Favicon/apple-touch-icon.png" />
  <link rel="icon" type="image/png" sizes="32x32" href="Data/Favicon/favicon-32x32.png" />
  <link rel="icon" type="image/png" sizes="16x16" href="Data/Favicon/favicon-16x16.png" />
  <link rel="manifest" href="Data/Favicon/site.webmanifest" />
  <link rel="mask-icon" href="Data/Favicon/safari-pinned-tab.svg" color="#212121" />
  <meta name="msapplication-TileColor" content="#000000" />
  <meta name="theme-color" content="#000000" />
</head>

<body class="light">
  <img id="page-loader" src="Data/Animations/SpinnerMedium.svg">
  <div id="container" class='hide'>
      <!-- Page headings and redirection links -->
      <div id="header">
        <h1>Verify as a MedPro</h1>
      </div>
      <!-- Data collection form -->
      <form id="form" action="Docverifysubmit.php" method="POST" enctype="multipart/form-data">
        <!-- Role input field -->
        <div id="role-dropdown-box" class="dropdown input-box">
          <input type="text" required class="dropdown_input" id="role-dropdown-input" name="role"spellcheck="false"
            autocapitalize="off" autocomplete="off" aria-autocomplete="list" />
          <label for="role-dropdown-input">Role</label>
            <ul id="role-list" class="dropdown-list">
              <li>Medical Doctor</li>
              <li>Registered Nurse</li>
              <li>Medical Records Handler</li>
              <li>Pharmacist</li>
              <li>Radiologist</li>
              <li>Medical Laboratory Technician</li>
              <li>Medical Administrator</li>
              <li>Other</li>
            </ul> 
        </div>
      <p id="role-error" class="error hide">
          <span class="error-symbol">🛈</span> Choose a valid Role form the menu;
      </p>
      <!-- Role input field -->
      <div id="role-input-box" class="input-box hide">
        <label for="role-input" id="role-label"
          >Specify your role</label
        >
        <input
          type="text"
          name="role"
          id="role-input"
          maxlength="50"
          spellcheck="false"
          autocomplete="off"
          aria-autocomplete="off"
          aria-required="true"
        />
      </div>
      <p class="error hide" id="role-other-error">
        <span class="error-symbol">🛈</span> Enter a valid role without letters
        or special characters.
      </p>
      <div id="org-name-box" class="input-box">
              <label for="org-name-input" id="org-name-label"
                >Organization Name</label
              >
              <input
                type="text"
                name="name"
                id="org-name-input"
                spellcheck="false"
                autocomplete="off"
                aria-autocomplete="off"
                aria-required="true"
                required
              />
            </div>
            <p class="error hide" id="org-name-error">
              <span class="error-symbol">🛈</span> Enter a valid organization name without numbers
              or special characters.
            </p>
            <div id="city-box" class="input-box">
              <label for="city-input" id="city-label"
                >City (ZIP Code)</label
              >
              <input
                type="text"
                name="name"
                id="city-input"
                spellcheck="false"
                autocomplete="off"
                aria-autocomplete="off"
                aria-required="true"
                required
              />
            </div>
            <p class="error hide" id="city-error">
              <span class="error-symbol">🛈</span> Enter a valid ZIP code without letters
              or special characters.
            </p>
        <div class="uploadbox">
          <input type="file" accept=".jpeg, .png, .jpg, .pdf" required name="Image" id="image" />
          <label for="image" id="Upload">Click to upload or Drag and Drop you ID proof here</label>
        </div>
        <p class="hide" id="Message"></p>
        <div id="previewContainer" class="hide"><p></p></div>
        <input type='hidden' id="medixID" name='medixID' value='<?php echo $id; ?>'>
        <input type="submit" id="form-submit-button" class="submit" value="Continue" />
        <img id="submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
        <p class="message hide" style="text-align: center;" id="upload-status">Your request has been received. We will verify your request and update your status.</p>
    </form>
    </div>
    <script src="Flow/ThemeSelector.js"></script>
    <script src="Flow/InputLabelHandling.js"></script>
    <script src="Flow/MedProVerify.js"></script>
    </body> 
</html>