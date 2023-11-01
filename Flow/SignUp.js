const body = document.body;
const form = document.getElementById("form");
const inputboxes = document.querySelectorAll(".input-box");
const inputs = document.querySelectorAll(".input-box input");
const labels = document.querySelectorAll(".input-box label");
const error_messages = document.querySelectorAll(".error");
const password_strength_display = document.getElementById("password-strength-validation-box");
const password_validations = document.querySelectorAll(".password-validations");
const password_strength_meter_fill = document.getElementById("password-strength-meter-filler");
const consecutive_characters_error = document.getElementById("password-validation-consecutive-characters-error");
const captcha_code = document.getElementById("captcha-code");
const submit_button = document.getElementById("form-submit-button");
const loading_indicator = document.getElementById("submit-loader");
let password_confirmation_status = false;

// Main()
document.addEventListener("DOMContentLoaded", function () {
  inputs.forEach((input, input_index) => {
    // Label -> Placeholder Movement
    input.addEventListener("focus", function () {

      // Name Label Change
      if (labels[input_index].id === "name-label") {
        labels[input_index].textContent = "Name";
      }

      // Email Label Change
      if (labels[input_index].id === "medixid-label") {
        labels[input_index].textContent = "name@example.com";
      }

      // Password Strength Validation
      if (input.id === "password-input") {
        password_strength_display.classList.remove("hide");
      }

      // Captcha Error Message Display Handling
      if (labels[input_index].id === "captcha-answer-label") {
        error_messages[input_index].classList.add("hide");
        inputboxes[input_index].classList.remove("box-error");
      }
    });

    // Placeholder -> Label Movement
    input.addEventListener("blur", function () {
      if (input.value === "") {

        // Name Label Change
        if (labels[input_index].id === "name-label") {
          labels[input_index].textContent = "What should we call you?";
        }

        // Email Label Change
        if (labels[input_index].id === "medixid-label") {
          labels[input_index].textContent = "Email";
        }
      }
      // Password Strength Validation
      if (input.id === "password-input") {
        password_strength_display.classList.add("hide");
      }
    });

    // Password Visibility Toggle
    if (
      input.id === "password-input" ||
      input.id === "password-confirmation-input"
    ) {
      const password_visibility_toggle = document.getElementById(
        input.id + "-visibility-toggle"
      );
      password_visibility_toggle.addEventListener("click", function () {
        password_visibility(input, password_visibility_toggle);
      });
    }

    // Name Validation
    if (input.id === "name-input") {
      input.addEventListener("input", function() {
        name_status = validate_name(input, input_index);
      })
    }

    // Email Validation
    if (input.id === "medixid-input") {
      input.addEventListener("blur", () => {
        validate_medixid(input, input_index)
          .then((result) => {
            medixid_status = result;
          })
          .catch((error) => {
            console.error("Error during email validation:", error);
          });
      });
    }

    // Password Validation
    if (input.id === "password-input") {
      input.addEventListener("input", function() {
        password_validation_status = calculate_password_strength(input.value);
        if (password_validation_status === "false"){
          inputboxes[input_index].classList.add("box-error");
        }
        else{
          inputboxes[input_index].classList.remove("box-error");
        }
      })
    }

    // Password Confirmation Validation
    if (input.id === "password-confirmation-input") {
      input.addEventListener("keyup", function() {
        if (input.value === document.getElementById("password-input").value){
          inputboxes[input_index].classList.remove("box-error");
          error_messages[input_index].classList.add("hide");
          password_confirmation_status = true;
        }
        else{
          inputboxes[input_index].classList.add("box-error");
          error_messages[input_index].classList.remove("hide");
          password_confirmation_status = false;
        }
      })
    }

    // Password confirm validation for password input field
    if (input.id === "password-input") {
      input.addEventListener("change", function() {
        if (input.value === document.getElementById("password-confirmation-input").value){
          inputboxes[input_index+1].classList.remove("box-error");
          error_messages[input_index+1].classList.add("hide");
          password_confirmation_status = true;
        }
        else{
          inputboxes[input_index+1].classList.add("box-error");
          error_messages[input_index+1].classList.remove("hide");
          password_confirmation_status = false;
        }
      })
    }

  });
  
  // Validate the entire form data brfore submitting
  form.addEventListener("submit", function (event) {  
    event.preventDefault(); // Prevent form submission
    // Validate all fields
    if (medixid_status === "true" && name_status === "true" && document.getElementById("captcha-answer-input").value != '' && password_validation_status === "true" && password_confirmation_status) {
      submit_button.classList.add("hide");
      loading_indicator.classList.remove("hide");
      validate_captcha(form);
    }
  });

  // Reload Captcha Image
  captcha_code.addEventListener("click", function () {
    reload_captcha_image();
    error_messages[4].classList.add("hide");
  });
});

// Function to validate captcha
function validate_captcha(form) {
  var user_captcha_answer = document.getElementById("captcha-answer-input").value;
  const captcha_validation_endpoint = "PHP Modules/CaptchaAnswer.php"; 

  // Perform AJAX request to validate the captcha
  var xhr = new XMLHttpRequest();
  xhr.open("POST", captcha_validation_endpoint, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response.success) {
        // Captcha validation successful
        form.submit();
      } else {
        // Captcha validation failed
        submit_button.classList.remove("hide");
        loading_indicator.classList.add("hide");
        reload_captcha_image();
        inputboxes[4].classList.add("box-error");
        error_messages[4].classList.remove("hide");
      }
    }
  };
  xhr.send("captcha_answer=" + encodeURIComponent(user_captcha_answer));
}