const body = document.body;
const form = document.getElementById("upload-form");
const inputboxes = document.querySelectorAll("#upload .input-box");
const inputs = document.querySelectorAll("#upload .input-box input");
const textarea = document.getElementById("upload-description-input");
const labels = document.querySelectorAll("#upload .input-box label");
const error_messages = document.querySelectorAll("#upload .error");
const submit_button = document.getElementById("upload-form-submit-button");
const loading_indicator = document.getElementById("upload-submit-loader");
let upload_status;

// Main()
document.addEventListener("DOMContentLoaded", function () {
  inputs.forEach((input, input_index) => {

    // Name Validation
    if (input.id === "upload-document-name-input") {
      input.addEventListener("input", function() {
        name_status = validate_name(input, input_index);
      })
    }

    // Placeholder -> Label Movement
  });
  textarea.addEventListener('focus', function(){
    labels[3].classList.add("active");
  })
  textarea.addEventListener('blur', function(){
    if(textarea.value === ""){
    labels[3].classList.remove("active");
    }
  })
  form.addEventListener("submit", function (event) {  
    event.preventDefault(); // Prevent form submission
    // Validate all fields
    if (name_status === "true" && document.getElementById("upload-doctype-input").value != '' && document.getElementById("upload-filetype-input").value != '' && upload_status === true) {
        submit_button.classList.add("hide");
        loading_indicator.classList.remove("hide");
        uploadDocument();
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("upload-doctype-input");
  const label = document.querySelector("#upload-doctype-box label");
  const dropdownList = document.getElementById("upload-doctype-list");
  const listItems = document.querySelectorAll("#upload-doctype-list li");

  function filterDropdownItems(searchString) {
    const regex = new RegExp(searchString, "i");

    listItems.forEach((item) => {
      const listItemText = item.textContent;
      if (searchString === "" || regex.test(listItemText)) {
        item.style.display = "block";
      } else {
        item.style.display = "none";
      }
    });

    const matchingItems = Array.from(listItems).some((item) => {
      return item.style.display === "block";
    });

    if (matchingItems) {
      dropdownList.style.display = "block";
    } else {
      dropdownList.style.display = "none";
    }
  }

  input.addEventListener("focus", function () {
    filterDropdownItems(input.value);
  });

  input.addEventListener("input", function () {
    filterDropdownItems(input.value);
  });

  document.addEventListener("click", function (event) {
    if (!input.contains(event.target) && !dropdownList.contains(event.target)) {
      dropdownList.style.display = "none";
    }
  });  

  listItems.forEach((item) => {
    item.addEventListener("click", function () {
      input.value = item.textContent;
      label.classList.add("active");
      dropdownList.style.display = "none";
    });
  });

  input.addEventListener("blur", function () {
    const selectedItem = Array.from(listItems).find(
      (item) => item.textContent === input.value
    );
    if (!selectedItem) {
      input.value = "";
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("upload-filetype-input");
  const label = document.querySelector("#upload-filetype-box label");
  const dropdownList = document.getElementById("upload-filetype-list");
  const listItems = document.querySelectorAll("#upload-filetype-list li");

  function filterDropdownItems(searchString) {
    const regex = new RegExp(searchString, "i");

    listItems.forEach((item) => {
      const listItemText = item.textContent;
      if (searchString === "" || regex.test(listItemText)) {
        item.style.display = "block";
      } else {
        item.style.display = "none";
      }
    });

    const matchingItems = Array.from(listItems).some((item) => {
      return item.style.display === "block";
    });

    if (matchingItems) {
      dropdownList.style.display = "block";
    } else {
      dropdownList.style.display = "none";
    }
  }

  input.addEventListener("focus", function () {
    filterDropdownItems(input.value);
  });

  input.addEventListener("input", function () {
    filterDropdownItems(input.value);
  });

  document.addEventListener("click", function (event) {
    if (!input.contains(event.target) && !dropdownList.contains(event.target)) {
      dropdownList.style.display = "none";
    }
  });  

  listItems.forEach((item) => {
    item.addEventListener("click", function () {
      input.value = item.textContent;
      label.classList.add("active");
      dropdownList.style.display = "none";
    });
  });

  input.addEventListener("blur", function () {
    const selectedItem = Array.from(listItems).find(
      (item) => item.textContent === input.value
    );
    if (!selectedItem) {
      input.value = "";
    }
  });
});

// Function to validate name
function validate_name(input, index) {
  const name = input.value.trim();

  // Regular expression pattern for email validation
  const namePattern = /^[A-Za-z0-9\s#_-]+$/;

  if (name.length === 0) {
    // Name field is empty
    status = false;
    inputboxes[index].classList.remove("box-error");
    error_messages[index].classList.add("hide");
  } else {
    if (namePattern.test(name)) {
      // Valid Name
      status = true;
      inputboxes[index].classList.remove("box-error");
      error_messages[index].classList.add("hide");
    } else {
      // Invalid Name
      status = false;
      inputboxes[index].classList.add("box-error");
      error_messages[index].classList.remove("hide");
    }
  }
  return status;
}

document.addEventListener("DOMContentLoaded", function () {
  const imageInput = document.getElementById("upload-image");
  const Message = document.getElementById("upload-Message");
  const box = document.querySelector("#upload .uploadbox");
  const previewContainer = document.querySelector("#upload-previewContainer");
  const previewContainerText = document.querySelector("#upload-previewContainer p");

  imageInput.addEventListener("change", handleImageUpload);

  function handleImageUpload(event) {
    const file = event.target.files[0];

    if (file) {
      // Define an array of allowed file extensions
      const allowedFileExtensions = [
        // Images
        "jpg",
        "jpeg",
        "png",
        "bmp",
        "gif",
        "tiff",
        "dng",
        "raw",

        // Documents
        "pdf",
        "doc",
        "docx",
        "txt",
        "rtf",
        "csv",
        "xml",
        "html",

        // Video
        "mp4",
        "avi",
        "mov",
        "flv",

        // Other
        "zip",
        "rar",
        "7z",

        // Medical formats
        "dcm",
        "nii",
        "img",
        "hdr",
        "mnc",
      ];

      // Get the file extension
      const fileExtension = file.name.split('.').pop().toLowerCase();

      // Check if the file extension is in the allowed list
      if (allowedFileExtensions.includes(fileExtension)) {
        // Reset error and success messages
        Message.classList.add('hide');
        previewContainer.classList.remove('hide');
        box.classList.remove("box-error");
        previewContainerText.textContent = file.name;
        upload_status = true;
      } else {
        previewContainer.classList.add('hide');
        Message.classList.remove('hide');
        Message.classList.add('error');
        Message.textContent = "The selected file format is not supported.";
        box.classList.add("box-error");
        upload_status = false;
      }
    } else {
      previewContainer.classList.add('hide');
      Message.classList.remove('hide');
      Message.classList.add('error');
      Message.textContent = "No files uploaded.";
      box.classList.add("box-error");
      upload_status = false;
    }
  }

  // Handle drag and drop at document level
  document.addEventListener("dragover", (event) => {
    event.preventDefault();
    event.stopPropagation();
    event.target.classList.add("dragover");
  });

  document.addEventListener("dragleave", (event) => {
    event.preventDefault();
    event.stopPropagation();
    event.target.classList.remove("dragover");
  });

  document.addEventListener("drop", (event) => {
    event.preventDefault();
    event.stopPropagation();
    event.target.classList.remove("dragover");

    // Check if the drop occurred inside the image input div
    if (event.target !== imageInput) {
      previewContainer.classList.add('hide');
      Message.classList.remove('hide');
      Message.classList.add('error');
      Message.textContent = "Drop your files in the space provided.";
      box.classList.add("box-error")
      upload_status=false;
      return;
    }

    imageInput.files = event.dataTransfer.files;
    handleImageUpload(event);
  });
});

function uploadDocument() {
  const form = document.getElementById("upload-form");
  const documentName = document.getElementById('upload-document-name-input').value;
  const documentType = document.getElementById('upload-doctype-input').value;
  const fileType = document.getElementById('upload-filetype-input').value;
  const documentDescription = document.getElementById('upload-description-input').value;
  const fileInput = document.getElementById('upload-image');

  const formData = new FormData();
  formData.append('document-name', documentName);
  formData.append('document-type', documentType);
  formData.append('file-type', fileType);
  formData.append('document-description', documentDescription);
  formData.append('file', fileInput.files[0]);

  const xhr = new XMLHttpRequest();
  xhr.open('POST', 'PHP Modules/DocumentUpload.php', true);
  xhr.onload = function () {
      if (xhr.status === 200) {
          displayMessage("Document securely uploaded to Medix.", 'success');
          document.getElementById('upload-form').reset();
          document.querySelectorAll("#upload .input-box label").forEach((label)=>{
            label.classList.remove("active");
          })
          setTimeout(()=>{
            document.getElementById("upload-status").classList.add("hide");
          },2000)
      } else {
          displayMessage("Document upload failed.", 'error');
          document.querySelector('#upload-form input').addEventListener("focus", function(){
            document.getElementById("upload-status").classList.add("hide");
          })

      }
      document.querySelector("#upload-previewContainer").classList.add("hide");
  };
  xhr.send(formData);
}

function displayMessage(message, type) {
  const responseDiv = document.getElementById('upload-status');
  submit_button.classList.remove("hide");
  loading_indicator.classList.add("hide");
  responseDiv.classList.remove("error");
  responseDiv.classList.add("message");
  responseDiv.textContent = message;
  if(type=="error"){
    responseDiv.classList.remove("message");
    responseDiv.classList.add("error");
  }
  responseDiv.classList.remove("hide");
}
