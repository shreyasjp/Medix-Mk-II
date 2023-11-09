<?php
require_once 'PHP Modules/Connect.php';
start_session();
if (!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}
/*if (!isset($_SESSION['MedProID'])){
    header('Location: MedProVerify.php');
    exit();
}*/

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
  <title>Home • Medix</title>
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
  <link rel="stylesheet" type="text/css" href="Design/Checkmark.css" />
  <link rel="stylesheet" type="text/css" href="Design/NavBar.css" />
  <link rel="stylesheet" type="text/css" href="Design/Upload.css" />
  <link rel="stylesheet" type="text/css" href="Design/MedProUpload.css" />
  <link rel="stylesheet" type="text/css" href="Design/Profile.css" />
  <link rel="stylesheet" type="text/css" href="Design/PatientManage.css" />
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

      <div class="nav-links">
        <a href="javascript:void(0);" onclick="showSection('profile',this)" class='active-text'>Home</a>
        <a href="javascript:void(0);" onclick="showSection('upload',this)">Upload Patient Document</a>
        <a href="javascript:void(0);" onclick="showSection('manage',this)">Manage Patients</a>
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
  <div id="container" class="hide">
  <section id="profile" class="sections">
      <div id="profile-content" class="section-content">
        <div id="left-panel">
          <div id="dp-box">
            <img id="dp" src="<?php echo $profilePic; ?>">
          </div>
          <div id="name-box">
            <h1 id="name">
              <?php echo $name; ?>
            </h1>
            <h3 id="email">
              <?php echo $medixID; ?>
              </h2>
              <button id="patient-id" onclick="copyToClipboard(this);"><span id="real-content"><?php echo $patientID?><span class="patient-id-icon"><img
                src="Data/Icons/Copy.png"></span></span><span class="filter-active hide" id="copied-message">Copied to clipboard</span></button>
          </div>
          <div id="profile-link">
            <a class="profile-link active-text" id="profile-info-link" href="javascript:void(0);" onclick="showSubSection('profile', 'profile-info', this)">Personal Information</a>
            <a class="profile-link" id="profile-security-link" href="javascript:void(0);" onclick="showSubSection('profile', 'profile-security', this)">Sign-In and Security</a>
            <a class="profile-link" id="profile-edit-link" href="javascript:void(0);" onclick="showSubSection('profile', 'profile-edit', this)">Edit Info</a>
            <a class="profile-link" id="profile-privacy-link" href="javascript:void(0);" onclick="showSubSection('profile', 'profile-privacy', this)">Privacy</a>
          </div>
        </div>
        <div id="right-panel">
            <div id="profile-header">
              <h1 id="profile-heading">Personal Information</h1>
              <p id="profile-desc">Manage your personal infromation including your credentials.</p>
            </div>
            <div id="info-box-container">
              <button id="age-box" class="info-box">
                <h3 id="age-heading" class="info-title">Age<span class="info-icons"><img
                      src="Data/Icons/Age.png"></span></h3>
                <p id="age" class="info-value">
                  <?php echo $age; ?>
                </p>
              </button>
              <button id="gender-box" class="info-box">
                <h3 id="gender-heading" class="info-title">Gender<span class="info-icons"><img
                      src="Data/Icons/Gender.png"></span></h3>
                <p id="gender" class="info-value">
                  <?php echo $gender; ?>
                </p>
              </button>
              <button id="height-box" class="info-box">
                <h3 id="height-heading" class="info-title">Height<span class="info-icons"><img
                      src="Data/Icons/Height.png"></span></h3>
                <p id="height" class="info-value">
                  <?php echo $height; ?> cm
                </p>
              </button>
              <button id="weight-box" class="info-box">
                <h3 id="weight-heading" class="info-title">Weight<span class="info-icons"><img
                      src="Data/Icons/Weight.png"></span></h3>
                <p id="weight" class="info-value">
                  <?php echo $weight; ?> Kg
                </p>
                <button id="blood-group-box" class="info-box">
                  <h3 id="blood-group-heading" class="info-title">Blood Group<span class="info-icons"><img
                        src="Data/Icons/BloodGroup.png"></span></h3>
                  <p id="blood-group" class="info-value">
                    <?php echo $bloodGroup; ?>
                  </p>
                </button>
            </div>
          </section>
  <section id="upload" class="sections hide">
      <div id="upload-section-container">
        <div id="upload-header">
          <h1>Upload Patient Documents</h1>
          <p>Securely upload patient documents to their Medix IDs</p>
        </div>
        <form id="patient-info-form" method="post">
        <div id="upload-id-box" class="input-box">
            <label for="upload-document-id-input" id="name-label">Medix ID or Patient ID</label>
            <input type="text" name="patient-id" id="upload-document-id-input" maxlength="50" spellcheck="false"
              autocomplete="off" aria-autocomplete="off" aria-required="true" required />
          </div>
          <div id="patient-info-display" class="hide">
            <h3 id="patient-name-display"></h3>
            <div id="patient-info-display-sub">
            <p id="patient-age-display"></p>
            <p id="patient-gender-display"></p>
            </div>
          </div>
          <p class="error hide" id="patient-id-error">
            <span class="error-symbol">🛈</span> Enter a valid Patient ID or Medix ID.
          </p>
          <input type="submit" class="submit" id="patient-info-form-submit-button" value="Find patient" />
          <img id="patient-info-submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
        </form>
        <form id="upload-form" action="upload.php" method="POST" enctype="multipart/form-data" class="hide">
          <div id="upload-name-box" class="input-box">
            <label for="upload-document-name-input" id="name-label">Document Name (without extension)</label>
            <input type="text" name="document-name" id="upload-document-name-input" maxlength="50" spellcheck="false"
              autocomplete="off" aria-autocomplete="off" aria-required="true" required />
          </div>
          <p class="error hide" id="upload-name-error">
            <span class="error-symbol">🛈</span> Enter a valid name without letters
            or special characters.
          </p>
          <!-- Type input field -->
          <div id="upload-doctype-box" class="dropdown input-box">
            <input type="text" required class="dropdown_input" id="upload-doctype-input" name="document-type"
              spellcheck="false" autocapitalize="off" autocomplete="off" aria-autocomplete="list" />
            <label for="upload-doctype-input">Document Type</label>
            <ul id="upload-doctype-list" class="dropdown-list">
              <li>Medical History Record</li>
              <li>Patient Information</li>
              <li>Discharge Summary</li>
              <li>Medical Test Report</li>
              <li>Prescription</li>
              <li>Medical Imagery</li>
              <li>Procedure Report</li>
              <li>Medical Certificate</li>
              <li>Operative Report</li>
              <li>Other</li>
              <li>Unknown</li>
            </ul>
          </div>
          <p id="upload-doctype-error" class="error hide">
            <span class="error-symbol">🛈</span> Choose a valid Document Type.
          </p>
          <!-- File Type input field -->
          <div id="upload-filetype-box" class="dropdown input-box">
            <input type="text" required class="dropdown_input" id="upload-filetype-input" name="file-type"
              spellcheck="false" autocapitalize="off" autocomplete="off" aria-autocomplete="list" />
            <label for="upload-filetype-input">File Type</label>
            <ul id="upload-filetype-list" class="dropdown-list">
              <li>Text</li>
              <li>Image</li>
              <li>Document</li>
              <li>Video</li>
              <li>Other</li>
              <li>Unknown</li>
            </ul>
          </div>
          <p id="upload-filetype-error" class="error hide">
            <span class="error-symbol">🛈</span> Choose a valid File Type.
          </p>
          <!-- Description input field -->
          <div id="upload-description-box" class="input-box">
            <label for="upload-description-input" id="upload-description-label">Description</label>
            <textarea name="document-description" id="upload-description-input" maxlength="150" cols="50"
              rows="3"></textarea>
          </div>
          <p id="upload-description-error" class="error  hide">
            <span class="error-symbol">🛈</span> Enter a valid height without letters
            or special characters.
          </p>
          <div class="uploadbox">
            <input type="file" required name="Image" id="upload-image"
              accept=".jpg, .jpeg, .png, .bmp, .gif, .tiff, .dng, .raw, .pdf, .doc, .docx, .txt, .rtf, .csv, .xml, .html, .mp4, .avi, .mov, .mwv, .flv, .wav, .zip, .rar, .7z, .dcm, .nii, .img, .hdr, .mnc" />
            <label for="upload-image" id="upload-Upload">Click to upload or Drag and Drop you file here</label>
          </div>
          <p class="hide" id="upload-Message"></p>
          <div id="upload-previewContainer" class="hide">
            <p></p>
          </div>
          <button id="cancel-upload" onclick="cancelUpload();">Cancel <span class="cancel-icon"><img
                      src="Data/Icons/Exit.png"></span>
          </button>
          <input type="submit" class="submit" id="upload-form-submit-button" value="Continue" />
          <img id="upload-submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
          <p class="message hide" id="upload-status">Document uploaded to Medix.</p>
        </form>
      </div>
    </section>
    <section id="manage" class="sections hide">
      <?php
      require_once 'PHP Modules/Connect.php';
      // Start the session
      start_session();
      $NoDocs = false;

      // Retrieve session variables
      $mx_id = $_SESSION['id']; // Replace 'username' with the actual variable name you stored
      
      $sql = "SELECT * FROM `medix-sharing` WHERE doc_mx_id = :medixId";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':medixId', $mx_id);
      $stmt->execute();
      $docs = $stmt->fetchAll();

      if (empty($docs)) {
        $NoDocs = true;
        $NoDocsJSON = json_encode($NoDocs);
        echo "<script>var NoDocs = $NoDocsJSON;</script>";
      }
      ?>
      <div id="manage-container" class="">
        <div id="manage-header">
          <h1 id="manage-title">Manage Patients</h1>
          <p id="manage-desc">Effortlessly Access Your Patient History</p>
        </div>
          
        <div id="manage-filters-container">

        <p id="doctype-male-filter" class="gender-filter">
            <span class="filter-icons"><img src="Data/Icons/Male.png"></span>Male
          </p>
          <p id="filetype-female-filter" class="gender-filter">
            <span class="filter-icons"><img src="Data/Icons/Female.png"></span>Female
          </p>

        
          <input type="text" id="search-input" class="apple-placeholder" placeholder='Search'>

    
          <select id="sort-files" class="apple-placeholder">
            <option value="Default">Sort</option>
            <option value="NameAscending">Sort by Name (a-z)</option>
            <option value="NameDescending">Sort by Name (z-a)</option>
            <option value="Oldest">Sort by Patient ID (Ascending)</option>
            <option value="Newest">Sort by Patient ID (Descending)</option>
          </select>

          <button id="Filter-preview" onclick="FilterPreview();" class="apple-button"><span class="filter-icons"><img
              src="Data/Icons/Filter.png"></span>Filter by age group</button>

          <div id="manage-filters" class="hide">


          <p id="filetype-infants-filter" class="age-filter">
            </span>Infants
          </p>
          <p id="filetype-child-filter" class="age-filter">
            Children
          </p>
          <p id="filetype-adolescents-filter" class="age-filter">
            Adolescents
          </p>
          <p id="filetype-adults-filter" class="age-filter">
            Adults
          </p>
          <p id="filetype-elders-filter" class="age-filter">
            Elderly
          </p>
          </div>
        </div>




      <div id="docs-container">
        <?php if ($NoDocs) {
          echo "<p>There are no patients yet.</p>";
        }
        foreach ($docs as $doc): ?>
          <?php



          

          $sql = "SELECT * FROM `medix-users` WHERE mx_id = :medixId";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':medixId', $doc['mx_id']);
          $stmt->execute();
          $users = $stmt->fetch();

          $sql = "SELECT * FROM `medix-user-profile` WHERE mx_id = :medixId";
          $stmt = $conn->prepare($sql);
          $stmt->bindParam(':medixId', $doc['mx_id']);
          $stmt->execute();
          $userProfile = $stmt->fetch();
          
          $userGender = $userProfile['gender'];
          $profilePicLocation = 'Medix MK II/'.$userProfile['profile_pic_location'];
          $userProfilePic = isset($userProfile['profile_pic_location']) ? "Medix Mk II/".$userProfile['profile_pic_location'] : ($userGender == 'Male' ? 'Data/Icons/ProfileMale.png' : 'Data/Icons/ProfileFemale.png');
          ?>
          <a target="_blank" href="<?php echo "PatientDetails.php?pid=MXP" . $doc['mx_id']; ?>" 
          data-name="<?php echo $users['name']; ?>"
              data-medixID="<?php echo $users['email']; ?>" 
              data-age="<?php echo $userProfile['age']; ?>"
              data-height="<?php echo $userProfile['height']; ?>" 
              data-weight="<?php echo $userProfile['weight']; ?>"
              data-path="<?php echo $userProfile['profile_pic_location']; ?>" 
              data-gender="<?php echo $userProfile['gender']; ?>"
              data-ageGroup="<?php echo getAgeGroup($userProfile['age']); ?>"
              data-bloodGroup="<?php echo $userProfile['blood_group']; ?>"
              data-ID="<?php echo $users['mx_id']; ?>"
              >
              <div class="doc-icon">
                <?php echo '<img id="file-type-symbol" src="' . $profilePicLocation . '">'; ?>
              </div>
              <div class="doc-info">
                <p class="doc-info-titles doc-name">
                <?php echo $users['name'];
                ?><button id="patient-id" class=""><?php echo 'MXP'.$users['mx_id']; ?></button>
              </p>
              <p class="doc-info-titles doc-type">
                <?php echo strtolower($users['email']); ?>
              </p>
              
              <div id="patient-sub-info">
              
              <p class="doc-info-titles doc-file-type">
                <?php echo $userProfile['gender'];?>
              </p>
              <p class="doc-info-titles doc-upload-date" >
                Age: <?php echo $userProfile['age']; ?>
              </p>
              
        </div>
        
            </div>
          </a>
        <?php
        endforeach;
        ?>
      </div>


      </div>
    </section>
  </div>
<script type="text/javascript" src="Flow/Session.js"></script>
<script type="text/javascript" src="Flow/ThemeSelector.js"></script>
<script type="text/javascript" src="Flow/InputLabelHandling.js"></script>
<script type="text/javascript" src="Flow/MedProUpload.js"></script>
<script type="text/javascript" src="Flow/NavBar.js"></script>
  <script type="text/javascript" src="Flow/Home.js"></script>
  <script type="text/javascript" src="Flow/PatientManage.js"></script>
  <script type="text/javascript" src="Flow/Profile.js"></script>
</body>
</html>

