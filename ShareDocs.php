<?php
$ID = $_GET['docID'];
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
  <link rel="stylesheet" type="text/css" href="Design/Messages.css" />
  <link rel="stylesheet" type="text/css" href="Design/Checkmark.css" />
  <link rel="stylesheet" type="text/css" href="Design/Upload.css" />
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
  <img id="page-loader" src="Data/Animations/SpinnerMedium.svg">
  <section id="sharing">
  <div id="container">
    <div id="sharing-header">
        <h1 id="sharing-title">Sharing</h1>
        <p id="sharing-desc">Share your document with other users.</p>
    </div>
        <form id="sharing-form" method="post">
            <div id="sharing-doctor-box" class="input-box">
            <label for="sharing-doctor-input" id="sharing-doctor-label">Medix ID</label>
            <input type="text" name="sharing-doctor" id="sharing-doctor-input" spellcheck="false"
                autocapitalize="off" autocomplete="off" aria-autocomplete="off" aria-required="true" required />
            </div>
            <p id="sharing-doctor-error" class="error  hide">
            <span class="error-symbol">🛈</span> Enter a valid email address.
            </p>
            <input type="submit"  id="sharing-form-submit-button" class="submit" value="Continue">
            <img id="sharing-submit-loader" class="hide" src="Data/Animations/SpinnerSmall.svg">
            <p id="sharing-doctor-error" style="text-align: center;" class="error  hide">
            <span class="error-symbol">🛈</span> We encountered an error while trying to share your document. Please
            try again later.
            </p>  
            <p id="sharing-doctor-success" style="text-align: center;" class="message  hide">
            Your document has been shared.
            </p>
            <input id="document" name="doc_id" type="hidden" value="<?php echo $ID; ?>">
        </form>
    </div>
    </section>
    <script type="text/javascript" src="Flow/Session.js"></script>
    <script type="text/javascript" src="Flow/ThemeSelector.js"></script>
    <script type="text/javascript" src="Flow/InputLabelHandling.js"></script>
    <script type="text/javascript" src="Flow/DocSharing.js"></script>
</body>
</html>