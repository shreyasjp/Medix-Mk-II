<head>
<script type="text/javascript" src="Flow/jQuery.js"></script>
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
</head>
<body class="light">
<div id="container">
<section id="manage">
    <?php
      require_once 'PHP Modules/Connect.php';
      // Start the session
      start_session();

      // Retrieve session variables
      $mx_id = $_SESSION['id']; // Replace 'username' with the actual variable name you stored

      $sql = "SELECT * FROM `medix-docs` WHERE owner = :medixId";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':medixId', $mx_id);
      $stmt->execute();
      $docs = $stmt->fetchAll();

      if (empty($docs)) {
        echo "No Docs";
        exit;
      }
    ?>
    <div id="manage-container">
      <h1 id="manage-title">Uploaded Documents</h1>
      <div id="manage-filters-container">
    <select id="document-type-filter" class="apple-placeholder">
        <option value="All">Document Type</option>
        <option value="Medical History Record">Medical History Record</option>
        <option value="Patient Information">Patient Information</option>
        <option value="Discharge Summary">Discharge Summary</option>
        <option value="Medical Test Report">Medical Test Report</option>
        <option value="Prescription">Prescription</option>
        <option value="Medical Imagery">Medical Imagery</option>
        <option value="Procedure Report">Procedure Report</option>
        <option value="Medical Certificate">Medical Certificate</option>
        <option value="Operative Report">Operative Report</option>
        <option value="Other">Other</option>
        <option value="Unknown">Unknown</option>
    </select>

    <select id="file-type-filter" class="apple-placeholder">
        <option value="All">File Type</option>
        <option value="Image">Image</option>
        <option value="Document">Document</option>
        <option value="Video">Video</option>
        <option value="Other">Other</option>
        <option value="Unknown">Unknown</option>
    </select>

    <select id="sort-files" class="apple-placeholder">
        <option value="Default">Sort</option>
        <option value="NameAscending">Sort by Name (a-z)</option>
        <option value="NameDescending">Sort by Name (z-a)</option>
        <option value="Newest">Sort by Newest</option>
        <option value="Oldest">Sort by Oldest</option>
    </select>

    <input type="text" id="search-input" class="apple-placeholder" placeholder='Search'>

    <button id="Verified-Filter" onclick="ValidateVerifiedFilter();" class="apple-button">Verified</button>
</div>


    <div id="docs-container">
      <?php foreach ($docs as $doc): ?>
        <?php 
        $path = $doc['file_path'];
        if (isset($iconLinks[$doc['file_extension']])) {
          $iconLink = $iconLinks[$doc['file_extension']];
        } else {
          $iconLink = 'Data/Icons/File.png';
        } 
        ?>
        <a href="<?php echo $path; ?>" download>
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
            <p class="doc-info-titles doc-type"><?php echo $doc['document_type']; ?></p>
            <p class="doc-info-titles doc-file-type hide"><?php echo $doc['file-type']; ?></p>
            <p class="doc-info-titles doc-upload-date hide"><?php echo $doc['upload_date']; ?></p>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    

  </div>
</section>
</div>
<script src="Flow/ThemeSelector.js"></script>
<script src="Flow/Manage.js"></script>
</body>
</html>