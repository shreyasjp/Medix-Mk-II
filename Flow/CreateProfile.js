const body = document.body;
const form = document.getElementById("form");
const inputboxes = document.querySelectorAll(".input-box");
const inputs = document.querySelectorAll(".input-box input");
const labels = document.querySelectorAll(".input-box label");
const error_messages = document.querySelectorAll(".error");
const submit_button = document.getElementById("form-submit-button");

// Main()
document.addEventListener("DOMContentLoaded", function () {
  inputs.forEach((input, input_index) => {
    // Age Validation
    if (input.id === "age-input") {
      input.addEventListener("input", function () {
        age_status = validate_age(input, input_index);
      });
    }
    // Height Validation
    if (input.id === "height-input") {
      input.addEventListener("input", function () {
        height_status = validate_height(input, input_index);
      });
    }
    // Height Validation
    if (input.id === "weight-input") {
      input.addEventListener("input", function () {
        weight_status = validate_weight(input, input_index);
      });
    }
  });
  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission
  
    // Validate all fields
    if (age_status === "true" && height_status === "true" && document.getElementById("blood-group-input").value !== '' && weight_status === "true") {
      // Check if either male or female radio button is selected
      const maleButton = document.getElementById("male-button");
      const femaleButton = document.getElementById("female-button");
  
      if (maleButton.checked || femaleButton.checked) {
        form.submit(); // Submit the form if a gender option is selected
      }
    }
  });
});

// Function to validate name
function validate_age(input, index) {
  const age = input.value.trim();

  // Regular expression pattern for age validation
  const agePattern = /^[0-9]+$/;

  if (age.length === 0) {
    // Age field is empty
    status = false;
    inputboxes[index].classList.remove("box-error");
    error_messages[index].classList.add("hide");
  } else {
    if (agePattern.test(age) && parseInt(age) > 0 && parseInt(age) <= 135) {
      // Valid Age
      status = true;
      inputboxes[index].classList.remove("box-error");
      error_messages[index].classList.add("hide");
    } else {
      // Invalid Age
      status = false;
      inputboxes[index].classList.add("box-error");
      error_messages[index].classList.remove("hide");
    }
  }
  return status;
}

// Function to validate height
function validate_height(input, index) {
  const height = input.value.trim();

  // Regular expression pattern for Height validation
  const heightPattern = /^-?\d+(\.\d+)?$/;

  if (height.length === 0) {
    // Height field is empty
    status = false;
    inputboxes[index].classList.remove("box-error");
    error_messages[index].classList.add("hide");
  } else {
    if (
      heightPattern.test(height) &&
      parseInt(height) > 0 &&
      parseInt(height) <= 350
    ) {
      // Valid Height
      status = true;
      inputboxes[index].classList.remove("box-error");
      error_messages[index].classList.add("hide");
    } else {
      // Invalid Height
      status = false;
      inputboxes[index].classList.add("box-error");
      error_messages[index].classList.remove("hide");
    }
  }
  return status;
}

// Function to validate weight
function validate_weight(input, index) {
  const weight = input.value.trim();

  // Regular expression pattern for weight validation
  const weightPattern = /^-?\d+(\.\d+)?$/;

  if (weight.length === 0) {
    // Weight field is empty
    status = false;
    inputboxes[index].classList.remove("box-error");
    error_messages[index].classList.add("hide");
  } else {
    if (
      weightPattern.test(weight) &&
      parseInt(weight) > 0 &&
      parseInt(weight) <= 800
    ) {
      // Valid Weight
      status = true;
      inputboxes[index].classList.remove("box-error");
      error_messages[index].classList.add("hide");
    } else {
      // Invalid Weight
      status = false;
      inputboxes[index].classList.add("box-error");
      error_messages[index].classList.remove("hide");
    }
  }
  return status;
}

document.addEventListener("DOMContentLoaded", function () {
  const dropbox = document.getElementById("blood-group-box");
  const input = document.getElementById("blood-group-input");
  const label = document.querySelector(".dropdown label");
  const dropdownList = document.querySelector(".dropdown-list");
  const listItems = document.querySelectorAll(".dropdown-list li");

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
  const imageInput = document.getElementById("upload-image");
  const Message = document.getElementById("upload-Message");
  const box = document.querySelector(".uploadbox");
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
        "gif",
        "svg"
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