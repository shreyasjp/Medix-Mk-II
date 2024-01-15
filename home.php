<?php
require_once 'PHP Modules/Connect.php';
start_session();
if (!isset($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}

$iconLinks = [
  "jpg" => "Data/Icons/JPEG-JPG.png",
  "jpeg" => "Data/Icons/JPEG-JPG.png",
  "png" => "Data/Icons/PNG.png",
  "bmp" => "Data/Icons/BMP.png",
  "gif" => "Data/Icons/GIF.png",
  "dng" => "Data/Icons/DNG.png",
  "raw" => "Data/Icons/RAW.png",
  "pdf" => "Data/Icons/PDF.png",
  "doc" => "Data/Icons/DOCX-DOC.png",
  "docx" => "Data/Icons/DOCX-DOC.png",
  "txt" => "Data/Icons/TXT.png",
  "csv" => "Data/Icons/CSV.png",
  "html" => "Data/Icons/HTML.png",
  "avi" => "Data/Icons/AVI.png",
  "mov" => "Data/Icons/MOV.png",
  "flv" => "Data/Icons/FLV.png",
  "zip" => "Data/Icons/ZIP.png",
  "rar" => "Data/Icons/RAR.png",
  "7z" => "Data/Icons/7Z.png",
  "hdr" => "Data/Icons/HDR.png"
];

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
  <link rel="stylesheet" type="text/css" href="Design/Home.css" />
  <link rel="stylesheet" type="text/css" href="Design/Profile.css" />
  <link rel="stylesheet" type="text/css" href="Design/ProfileSecurity.css" />
  <link rel="stylesheet" type="text/css" href="Design/Upload.css" />
  <link rel="stylesheet" type="text/css" href="Design/Manage.css" />
  <link rel="stylesheet" type="text/css" href="Design/Sharing.css" />
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

      <div class="nav-links">
        <a href="javascript:void(0);" onclick="showSection('profile',this)" class='active-text'>Home</a>
        <a href="javascript:void(0);" onclick="showSection('upload',this)">Upload</a>
        <a href="javascript:void(0);" onclick="showSection('manage',this)">Manage</a>
        <a href="javascript:void(0);" onclick="showSection('sharing',this)">Sharing</a>
        <a href="MedPro.php">MedPro</a>
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
            <!--<a class="profile-link" id="profile-edit-link" href="javascript:void(0);" onclick="showSubSection('profile', 'profile-edit', this)">Edit Info</a>
            <a class="profile-link" id="profile-privacy-link" href="javascript:void(0);" onclick="showSubSection('profile', 'profile-privacy', this)">Privacy</a>-->
          </div>
        </div>
        <div id="right-panel">
          <section id="profile-info" class="profile-sections">
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

          <section id="profile-security" class="profile-sections hide">
            <div id="profile-security-container">
            <div id="profile-security-header">
              <h1 id="profile-security-heading">Sign-In and Security</h1>
              <p id="profile-security-desc">Manage your sign-in and security settings.</p>
            </div>
            <div id="profile-security-content">
            <button id="change-password" class="active-text" onclick="changePasswordButton()">
  Change Password
</button>
<br>
<button id="delete-account" onclick="deleteAccountButton()">
  Delete your Medix id
</button>
              <form id="delete-form" class="forms hide" method="post">
                <h1 class="delete-sub-header">Confirm your password to get started.</h1>
                <div id="delete-password-box" class="input-box">
                  <label for="delete-password-input" id="delete-password-label">Password</label>
                  <input type="text" name="delete-password-confirm" id="delete-password-input" spellcheck="false"
                    autocapitalize="off" autocomplete="off" aria-autocomplete="off" aria-required="true" required />
                </div>
                <p id="delete-password-error" class="error  hide">
                  <span class="error-symbol">🛈</span> The password you entered is incorrect.Please double-check your
                  password.
                </p>
                <div id="delete-confirm-box" class="input-box">
                  <label for="delete-confirm-input" id="delete-confirm-label">Type 'deletemymedixid' to confrim</label>
                  <input type="text" id="delete-confirm-input" spellcheck="false" autocapitalize="off"
                    autocomplete="off" aria-autocomplete="off" aria-required="true" required />
                </div>
                <p id="delete-confirm-error" class="error  hide">
                  <span class="error-symbol">🛈</span> The entered text does'nt match.
                </p>
                <button id="delete-account-button">Continue</button>
                <img id="delete-submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
                <p id="delete-error" class="error  hide">
                  <span class="error-symbol">🛈</span>We encountered an error while trying to delete your Medix ID.
                  Please try again later.
                </p>
              </form>
              <form id="update-form" class="" method="post">
                <h1 class="update-sub-header">Confirm your password to get started.</h1>
                <div id="update-password-box" class="input-box">
                  <label for="update-password-input" id="update-password-label">Password</label>
                  <input type="text" id="update-password-input" spellcheck="false" autocapitalize="off"
                    autocomplete="off" aria-autocomplete="off" aria-required="true" required />
                </div>
                <p id="update-password-error" class="error  hide">
                  <span class="error-symbol">🛈</span> The password you entered is incorrect. Please double-check your
                  password.
                </p>
                <button id="update-account-button">Continue</button>
                <img id="update-submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
              </form>
              <form id="new-password-form" method="post" class="hide">
                <div class="input-box password" id="new-password-box">
                  <input type="password" name="password" id="new-password-input" spellcheck="false" autocapitalize="off"
                    autocomplete="off" aria-autocomplete="off" aria-required="true" required />
                  <label for="new-password-input" id="new-password-label">Password</label>
                  <p id="new-password-input-visibility-toggle" class="password-visibility-toggle">SHOW</p>
                </div>
                <div id="new-password-strength-validation-box" class="hide">
                  <p id="new-password-validation-heading" class="password-validation-heading">
                    Your password must have:
                  </p>
                  <p id="new-password-validation-charcount" class="password-validations">
                    8 or more characters
                  </p>
                  <p id="new-password-validation-case" class="password-validations">
                    upper and lowercase characters
                  </p>
                  <p id="new-password-validation-number" class="password-validations">
                    atleast one number
                  </p>
                  <p id="new-password-validation-specialchar" class="password-validations">
                    atleast one special character
                  </p>
                  <p id="new-password-validation-meter-heading" class="password-validation-heading">
                    Strength:
                  </p>
                  <div id="new-password-strength-meter">
                    <div id="new-password-strength-meter-filler" class="password-strength-meter-fill"></div>
                  </div>
                  <p id="new-password-validation-consecutive-characters-error" class="error hide">
                    <span class="error-symbol">🛈</span> Too many consecutive identical
                    characters.
                  </p>
                </div>
                <div class="input-box password" id="new-password-confirmation-box">
                  <input type="password" name="password-confimration" id="new-password-confirmation-input"
                    spellcheck="false" autocapitalize="off" autocomplete="off" aria-autocomplete="off"
                    aria-required="true" required />
                  <label for="new-password-confirmation-input" id="new-password-confirmation-label">Confirm
                    password</label>
                  <p id="new-password-confirmation-input-visibility-toggle" class="password-visibility-toggle">SHOW</p>
                </div>
                <p class="error hide" id="new-password-confirmation-error">
                  <span class="error-symbol">🛈</span> Passwords do not match.
                </p>
                <p class="error hide" id="new-password-repeat-error">
                  <span class="error-symbol">🛈</span> This password was used recently. Please choose a different password..
                </p>
                <button id="new-password-form-submit-button">Continue</button>
                <img id="new-password-submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
              </form>
              <script type="text/javascript" src="Flow/AccountDelete.js"></script>
              <script type="text/javascript" src="Flow/ChangePassword.js"></script>
              <script type="text/javascript" src="Flow/Validations.js"></script>
            </div>
          </section>
        </div>
      </div>
    </div>
    </section>

    <section id="profile-edit" class="hide profile-sections"></section>
    <section id="profile-privacy" class="hide profile-sections"></section>

    <section id="upload" class="sections hide">
      <div id="upload-section-container">
        <div id="upload-header">
          <h1>Upload Documents</h1>
          <p>Securely upload your document to Medix.</p>
        </div>
        <form id="upload-form" action="upload.php" method="POST" enctype="multipart/form-data">
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
      
      $sql = "SELECT * FROM `medix-docs` WHERE owner = :medixId";
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
          <h1 id="manage-title">Manage Documents</h1>
          <p id="manage-desc">Effortlessly Organize and Access Your Documents</p>
        </div>
          
        <div id="manage-filters-container">

          <button id="Verified-Filter"><span class="filter-icons"><img
                src="Data/Icons/Verified.png"></span>Verified</button>
          <p id="doctype-prescription-filter" class="doctype-filter">
            <span class="filter-icons"><img src="Data/Icons/Prescription.png"></span>Prescription
          </p>
          <p id="filetype-image-filter" class="file-type-filter">
            <span class="filter-icons"><img src="Data/Icons/Image.png"></span>Image
          </p>
          <p id="filetype-document-filter" class="file-type-filter">
            <span class="filter-icons"><img src="Data/Icons/Document.png"></span>Document
          </p>


          <input type="text" id="search-input" class="apple-placeholder" placeholder='Search'>


          <select id="sort-files" class="apple-placeholder">
            <option value="Default">Sort</option>
            <option value="NameAscending">Sort by Name (a-z)</option>
            <option value="NameDescending">Sort by Name (z-a)</option>
            <option value="Newest">Sort by Newest</option>
            <option value="Oldest">Sort by Oldest</option>
          </select>
        </div>
        <button id="Filter-preview" onclick="FilterPreview();" class="apple-button"><span class="filter-icons"><img
              src="Data/Icons/Filter.png"></span>Filters</button>



        <div id="manage-filters" class="hide">
          <p id="medical-history-record-filter" class="doctype-filter filter-text">
            Medical History Record
          </p>
          <p id="doctype-patient-information-filter" class="doctype-filter filter-text">
            Patient Information
          </p>
          <p id="doctype-discharge-summary-filter" class="doctype-filter filter-text">
            Discharge Summary
          </p>
          <p id="doctype-medical-test-report-filter" class="doctype-filter filter-text">
            Medical Test Report
          </p>
          <p id="doctype-medical-imagery-filter" class="doctype-filter filter-text">
            Medical Imagery
          </p>
          <p id="doctype-procedure-report-filter" class="doctype-filter filter-text">
            Procedure Report
          </p>
          <p id="doctype-medical-certificate-filter" class="doctype-filter filter-text">
            Medical Certificate
          </p>
          <p id="doctype-operative-report-filter" class="doctype-filter filter-text">
            Operative Report
          </p>
          <p id="doctype-other-filter" class="doctype-filter filter-text">
            Other Documents
          </p>
          <p id="filetype-text-filter" class="file-type-filter filter-text">
            Text
          </p>
          <p id="filetype-video-filter" class="file-type-filter filter-text">
            Video
          </p>
          <p id="filetype-other-filter" class="file-type-filter filter-text">
            Other Files
          </p>
        </div>
      </div>




      <div id="docs-container">
        <?php if ($NoDocs) {
          echo "<div style='display: flex; flex-direction: column; justify-content: center; align-items: center'>";
          echo "<p>There are no uploads.</p>";
          echo "<p>Can't find your document? Try refreshing the page.</p>";
          echo "</div>";
        }
        foreach ($docs as $doc): ?>
          <?php
          $path = $doc['file_path'];
          if (isset($iconLinks[$doc['file_extension']])) {
            $iconLink = $iconLinks[$doc['file_extension']];
          } else {
            $iconLink = 'Data/Icons/File.png';
          }
          ?>
          <a href="<?php echo "Medix MK II/" . $path; ?>" data-name="<?php echo $doc['document_name']; ?>"
            data-type="<?php echo $doc['document_type']; ?>" data-filetype="<?php echo $doc['file-type']; ?>"
            data-uploaddate="<?php echo $doc['upload_date']; ?>" data-verified="<?php echo $doc['is_verified']; ?>"
            data-path="<?php echo $path; ?>" data-description="<?php echo $doc['description']; ?>"
            data-icon="<?php echo $iconLink; ?>" data-id="<?php echo $doc['doc_id']; ?>">
            <div class="doc-icon">
              <?php echo '<img id="file-type-symbol" src="' . $iconLink . '">'; ?>
            </div>
            <div class="doc-info">
              <p class="doc-info-titles doc-name">
                <?php echo $doc['document_name'];
                if ($doc['is_verified']) {
                  echo '<span id="doc-verified-symbol-container"><img id="doc-verified-symbol" src="Data/Icons/Greentick.png"></span>';
                }
                ?>
              </p>
              <p class="doc-info-titles doc-type">
                <?php echo $doc['document_type']; ?>
              </p>
              <p class="doc-info-titles doc-file-type hide">
                <?php echo $doc['file-type']; ?>
              </p>
              <p class="doc-info-titles doc-upload-date hide">
                <?php echo $doc['upload_date']; ?>
              </p>
            </div>
          </a>
        <?php
        endforeach;
        ?>
      </div>

      <div id="doc-modal" class="modal hide">
  <div class="modal-content">
  <div class="expanded-doc-header">
    <img class="expanded-doc-icon" src=""/>
    <div class="expanded-doc-main-info">
    <h2 class="expanded-doc-name"></h2>
    <p class="expanded-doc-type"></p>
    </div>
    </div>
    <p class="expanded-doc-upload-date"></p>
    <p class="expanded-doc-description"></p>


    <iframe src="NoDisplay.html" frameborder="1" height="420" width="560" ></iframe>
<div class="expanded-buttons">
<button id="delete-doc-button"><span class="filter-icons"><img
                src="Data/Icons/Delete.png"></span></button>
<a href="" download><button id="download-doc-button" ><span class="filter-icons"><img src="Data/Icons/Download.png"></span></button></a>
<a href="" target="_blank" id="share-doc-button"><span class="filter-icons"><img src="Data/Icons/Share.png"></span></a>       
<button id="close-doc-button"><span class="filter-icons"><img src="Data/Icons/Exit.png"></span></button>         
<p class="error hide" id="delete-error">The file could'nt be deleted.</p>
</div>
  </div>
</div>


      </div>
    </section>
<section id="sharing" class="sections hide">
      <div id="sharing-container">
        <div id="sharing-header">
          <h1 id="sharing-title">Sharing</h1>
          <p id="sharing-desc">Share your data with your doctor.</p>
        </div>
            <form id="sharing-form" method="post">
              <div id="sharing-doctor-box" class="input-box">
                <label for="sharing-doctor-input" id="sharing-doctor-label">Doctor's Medix ID</label>
                <input type="text" name="sharing-doctor" id="sharing-doctor-input" spellcheck="false"
                  autocapitalize="off" autocomplete="off" aria-autocomplete="off" aria-required="true" required />
              </div>
              <p id="sharing-doctor-error" class="error  hide">
                <span class="error-symbol">🛈</span> Enter a valid email address.
              </p>

       <!-- Description input field -->
       <div id="sharing-doctor-message-box" class="input-box">
            <label for="sharing-doctor-message-input" id="sharing-doctor-message-label">Message</label>
            <textarea name="sharing-doctor-message" id="sharing-doctor-message-input" maxlength="150" cols="50"
              rows="3"></textarea>
          </div>
              <input type="submit"  id="sharing-form-submit-button" class="submit" value="Continue">
              <img id="sharing-submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
              <p id="sharing-doctor-error" class="error  hide">
                <span class="error-symbol">🛈</span> We encountered an error while trying to share your profile. Please
                try again later.
              </p>  
              <p id="sharing-doctor-success" style="text-align: center;" class="message  hide">
                Your profile has been shared with your doctor.
              </p>
            </form>
          </div>
</section>

  </div>
  <noscript>
    <div style="box-sizing: bordeborder-box; text-align: center; margin: 30px; padding: 20px; background-color: #ffdcdc; border: 1px solid red; border-radius: 5px;">
      <p>This website requires JavaScript to function. Please enable JavaScript in your browser settings to view this page.</p>
    </div>
  </noscript>
  <script type="text/javascript">document.getElementById('page-loader').classList.remove('hide');</script>
  <script type="text/javascript" src="Flow/Session.js"></script>
  <script type="text/javascript" src="Flow/ThemeSelector.js"></script>
  <script type="text/javascript" src="Flow/InputLabelHandling.js"></script>
  <script type="text/javascript" src="Flow/Upload.js"></script>
  <script type="text/javascript" src="Flow/NavBar.js"></script>
  <script type="text/javascript" src="Flow/Manage.js"></script>
  <script type="text/javascript" src="Flow/Home.js"></script>
  <script type="text/javascript" src="Flow/Sharing.js"></script>
</body>

</html>