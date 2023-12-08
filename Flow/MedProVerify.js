const body = document.body;
const form = document.getElementById("form");
const inputboxes = document.querySelectorAll(".input-box");
const inputs = document.querySelectorAll(".input-box input");
const role_input = document.getElementById("role-input-box");
const role_text = document.getElementById('role-input');
const textarea = document.getElementById("comment-input");
const textAreaLabel = document.getElementById("comment-label");
const labels = document.querySelectorAll(".input-box label");
const error_messages = document.querySelectorAll(".error");
const submit_button = document.getElementById("form-submit-button");
const loading_indicator = document.getElementById("submit-loader");
let upload_status;

// Main()
document.addEventListener("DOMContentLoaded", function () {
  inputs.forEach((input, input_index) => {
    // Label -> Placeholder Movement

    if(input.id === "role-dropdown-input")
    {
        input.addEventListener("input", function(){
            let selectedRoleValue = this.value
            if(selectedRoleValue === "Other")
            {
                role_input.classList.remove("hide");
                role_text.required = true;
            }
            else
            {
                role_input.classList.add("hide");
                role_text.required = false;
                role_text.value = input.value;
            }
        })
    }

    // Name Validation
    if (input.id === "org-name-input") {
        input.addEventListener("input", function() {
          name_status = validate_name(input, input_index);
        })
    }
    // Email Validation
    if (input.id === "city-input") {
      zip_status = 'true';
      input.addEventListener("change", function () {
        zip_status = validateIndianPinCode(input, input_index);
      });
    }
    //Phone validation
    if (input.id === "phone-input") {
        phone_status = 'true';
        input.addEventListener("blur", function () {
          phone_status = validate_phone(input, input_index);
        });
      }
  });
  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission
    // Validate all fields
    if (upload_status && name_status === 'true' && zip_status === 'true' && phone_status === 'true') {
      submit_button.classList.add("hide");
      loading_indicator.classList.remove("hide");
      sendData(); // Allow form submission
    }
  });  
});

document.addEventListener("DOMContentLoaded", function () {
  const input = document.getElementById("role-dropdown-input");
  const label = document.querySelector("#role-dropdown-box label");
  const dropdownList = document.getElementById("role-list");
  const listItems = document.querySelectorAll("#role-list li");

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
      if(item.textContent === "Other")
      {
        role_input.classList.remove("hide");
        role_text.required = true;
      }
      else
      {
        role_input.classList.add("hide");
        role_text.required = false;
        role_text.value = input.value;
      }
      dropdownList.style.display = "none";
    });
  });

  input.addEventListener("blur", function () {
    const selectedItem = Array.from(listItems).find(
      (item) => item.textContent === input.value
    );
    if (!selectedItem) {
      input.value = "";
      role_input.classList.add("hide");
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("image");
    const Message = document.getElementById("Message");
    const box = document.querySelector(".uploadbox");
    const previewContainer = document.querySelector("#previewContainer");
    const previewContainerText = document.querySelector("#previewContainer p");
    upload_status = false;
  
    imageInput.addEventListener("change", handleImageUpload);
  
    function handleImageUpload(event) {
      const file = event.target.files[0];
  
      if (file) {
        // Check if the uploaded file is an image or PDF
        const acceptedTypes = ["image/jpeg", "image/png", "application/pdf"];
        const type = file.type;
  
        if (acceptedTypes.includes(type)) {
          // Reset error and success messages
          Message.classList.add('hide');
          previewContainer.classList.remove('hide');
          previewContainerText.textContent = file.name;
          box.classList.remove("box-error");
          $('#upload-msg').addClass('hide');
          upload_status = true;
        } else {
          previewContainer.classList.add('hide');
          Message.classList.remove('hide');
          Message.classList.add('error');
          Message.textContent = "Please upload a valid image or PDF file.";
          box.classList.add("box-error");
          $('#upload-msg').removeClass('hide');
          upload_status = false;
        }
      } else {
        previewContainer.classList.add('hide');
        Message.classList.remove('hide');
        Message.classList.add('error');
        Message.textContent = "No files uploaded.";
        box.classList.add("box-error");
        $('#upload-msg').removeClass('hide');
        upload_status = false;
      }
    }
  
    // Handle drag and drop at the document level
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
        box.classList.add("box-error");
        upload_status = false;
        return;
      }
  
      imageInput.files = event.dataTransfer.files;
      handleImageUpload(event);
    });
  });
  

// Function to validate name
function validate_name(input, index) {
    const name = input.value.trim();
  
    // Regular expression pattern for email validation
    const namePattern = /^[a-zA-Z][a-zA-Z .]*$/;
  
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

  function validate_phone(input, index) {
    const phone = input.value.trim();
  
    // Regular expression pattern for email validation
    const phonePattern = /^(?:\+?([0-9]{1,3}) ?)?([0-9]{10})$/;
  
    if (phone.length === 0) {
      // Name field is empty
      status = true;
      $('#phone-msg').removeClass('hide');
      inputboxes[index].classList.remove("box-error");
      error_messages[index].classList.add("hide");
    } else {
      if (phonePattern.test(phone)) {
        // Valid Name
        status = true;
        $('#phone-msg').addClass('hide');
        inputboxes[index].classList.remove("box-error");
        error_messages[index].classList.add("hide");
      } else {
        // Invalid Name
        status = false;
        $('#phone-msg').addClass('hide');
        inputboxes[index].classList.add("box-error");
        error_messages[index].classList.remove("hide");
      }
    }
    return status;
  }

  function validateIndianPinCode(input, index) {
    const pincode = input.value.trim();
  
    // Regular expression pattern for Indian PIN code (6 digits)
    const pincodePattern = /^[1-9][0-9]{5}$/;
  
    if (pincode.length === 0) {
      // PIN code field is empty
      status = true;
      $('#city-msg').removeClass('hide');
      inputboxes[index].classList.remove("box-error");
      error_messages[index].classList.add("hide");
    } else {
      if (pincodePattern.test(pincode)) {
        // Valid Indian PIN code
        $('#city-msg').addClass('hide');
        status = true;
        inputboxes[index].classList.remove("box-error");
        error_messages[index].classList.add("hide");
      } else {
        // Invalid Indian PIN code
        status = false;
        $('#city-msg').addClass('hide');
        inputboxes[index].classList.add("box-error");
        error_messages[index].classList.remove("hide");
      }
    }
    return status;
  }

  function sendData() {
    const form = document.getElementById("form");
    const role = document.getElementById('role-input').value;
    const orgName = document.getElementById('org-name-input').value;
    const city = document.getElementById('city-input').value;
    const phone = document.getElementById('phone-input').value;
    const fileInput = document.getElementById('image');
  
    const formData = new FormData();
    formData.append('role', role);
    formData.append('organization', orgName);
    if (city.length == 6){
      formData.append('city', city);
    }
    if (phone.length >= 10){
      formData.append('phone', phone);
    }
    formData.append('file', fileInput.files[0]);
  
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP Modules/CreateMedPro.php', true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            displayMessage('The details you entered have been saved. Please hold on till we verify the details to access your MedPro dashboard.', 'success');
            document.getElementById('form').reset();
            document.querySelectorAll(".input-box label").forEach((label)=>{
              label.classList.remove("active");
            })
            setTimeout(()=>{
              document.getElementById("upload-status").classList.add("hide");
            },2000)
            setTimeout(()=>{
              window.location.href = 'home.php';
            },1000)
        } else {
            displayMessage('There was an error. Please try again later.', 'error');
            document.querySelector('#upload-form input').addEventListener("focus", function(){
              document.getElementById("upload-status").classList.add("hide");
            })
  
        }
        document.querySelector("#previewContainer").classList.add("hide");
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