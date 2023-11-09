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

$patientID = $_GET['pid'];

$id = intval(substr($patientID, 3));
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
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$age = $row['age'];
$gender = $row['gender'];
$height = $row['height'];
$weight = $row['weight'];
$bloodGroup = $row['blood_group'];

$profilePic = isset($row['profile_pic_location']) ? "Medix Mk II/".$row['profile_pic_location'] : ($gender == 'Male' ? 'Data/Icons/ProfileMale.png' : 'Data/Icons/ProfileFemale.png');


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <title><?php echo $name; ?></title>
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
  <link rel="stylesheet" type="text/css" href="Design/Messages.css" />
  <link rel="stylesheet" type="text/css" href="Design/PatientProfile.css" />
  <link rel="stylesheet" type="text/css" href="Design/PatientDocs.css" />
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
  <div id="container" class="hide">
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
        </div>
        <div id="right-panel">
            <div id="profile-header">
              <h1 id="profile-heading">Personal Information</h1>
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
      <?php
      require_once 'PHP Modules/Connect.php';
      // Start the session
      start_session();
      $NoDocs = false;

      // Retrieve session variables
      $mx_id = $id; // Replace 'username' with the actual variable name you stored
      
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
      <div id="manage-container" class="<?php echo $NoDocs?'hide':'';?>">
        <div id="manage-header">
          <h1 id="manage-title">Documents</h1>
        </div>
          
        <div id="manage-filters-container" class="<?php echo $NoDocs?'hide':'';?>">

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
        <button id="Filter-preview" class="<?php echo $NoDocs?'hide':'';?>" onclick="FilterPreview();" class="apple-button"><span class="filter-icons"><img
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




      <div id="docs-container" class="<?php echo $NoDocs?'hide':'';?>">
        <?php 
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
<a href="" download><button id="download-doc-button" ><span class="filter-icons"><img src="Data/Icons/Download.png"></span></button></a>
<button id="close-doc-button"><span class="filter-icons"><img src="Data/Icons/Exit.png"></span></button>
</div>
  </div>
</div>


      </div>
          </div>
<script type="text/javascript" src="Flow/Session.js"></script>
<script type="text/javascript" src="Flow/ThemeSelector.js"></script>
  <script type="text/javascript" src="Flow/Home.js"></script>
  <script type="text/javascript" src="Flow/Manage.js"></script>
</body>
</html>