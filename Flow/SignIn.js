
GetSession('failCount')
.then(sessionVariable => {
    failCount = sessionVariable;
})
.catch(error => {
  failCount = 0;
});

function IconColor(){
    const isDarkMode = prefersDarkMode.matches;
    if (isDarkMode){
        document.getElementById("next-button").src="Data/Icons/NextWhite.png";
    }
    else{
        document.getElementById("next-button").src="Data/Icons/NextBlack.png";
    }
}
function Next(){
    document.getElementById('form').classList.remove('hide');
    document.getElementById('header').classList.add('hide')
    if (failCount>2){
        reload_captcha_image();
        document.getElementById('captcha-section').classList.remove('hide');
        document.getElementById('captcha-answer-input').ariaRequired = "true";
    }
}

IconColor();
prefersDarkMode.addEventListener("change", IconColor);

const body = document.body;
const form = document.getElementById("form");
const inputboxes = document.querySelectorAll(".input-box");
const inputs = document.querySelectorAll(".input-box input");
const labels = document.querySelectorAll(".input-box label");
const error_messages = document.querySelectorAll(".error");
const captcha_code = document.getElementById("captcha-code");
const submit_button = document.getElementById("form-submit-button");
const loading_indicator = document.getElementById("submit-loader");

// Main()
document.addEventListener("DOMContentLoaded", function () {
  inputs.forEach((input, input_index) => {
    // Label -> Placeholder Movement
    input.addEventListener("focus", function () {

      // Captcha Error Message Display Handling
      if (labels[input_index].id === "captcha-answer-label") {
        error_messages[input_index].classList.add("hide");
        inputboxes[input_index].classList.remove("box-error");
      }
    });

    // Password Visibility Toggle
    if (
      input.id === "password-input"
    ) {
      const password_visibility_toggle = document.getElementById(
        input.id + "-visibility-toggle"
      );
      password_visibility_toggle.addEventListener("click", function () {
        password_visibility(input, password_visibility_toggle);
      });
    }

    // Email Validation
    if (input.id === "medixid-input") {
      input.addEventListener("blur", () => {
        medixid_status = validate_medixid_pattern(input, input_index)
      });
    }

  });
  
  // Validate the entire form data brfore submitting
  form.addEventListener("submit", function (event) {  
    event.preventDefault(); // Prevent form submission
    // Validate all fields
    if (failCount>2){
      if (medixid_status === "true" && document.getElementById("password-input").value != '' && document.getElementById("captcha-answer-box").value != '') {
        submit_button.classList.add("hide");
        loading_indicator.classList.remove("hide");
        validate_captcha();
      }
    }
    else if (medixid_status === "true" && document.getElementById("password-input").value != '') {
      submit_button.classList.add("hide");
      loading_indicator.classList.remove("hide");
      VerifyCredentials(document.getElementById("medixid-input").value, document.getElementById("password-input").value, form);
    }
  });

  // Reload Captcha Image
  captcha_code.addEventListener("click", function () {
    reload_captcha_image();
    document.getElementById("captcha-error").classList.add("hide");
  });
});

// Function to validate email
function validate_medixid_pattern(input, index) {
    var medixid = input.value.trim();
  
    // Regular expression pattern for email validation
    const email_pattern =
      /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/;
  
    if (medixid.length === 0) {
      // The input field is empty
      medixid_status = false;
      inputboxes[index].classList.remove("box-error");
      error_messages[index].classList.add("hide");
    } else {
      if (email_pattern.test(medixid)) {
        // The email pattern is valid
            status = true;
            inputboxes[index].classList.remove("box-error");
            error_messages[index].classList.add("hide");
      } else {
        // The email pattern is invalid
        status = false;
        inputboxes[index].classList.add("box-error");
        error_messages[index].classList.remove("hide");
      }
    }
    return status;
  }

  // Function to validate captcha
function validate_captcha() {
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
          VerifyCredentials(document.getElementById("medixid-input").value, document.getElementById("password-input").value, form);
        } else {
          // Captcha validation failed
          submit_button.classList.remove("hide");
          loading_indicator.classList.add("hide");
          reload_captcha_image();
          inputboxes[2].classList.add("box-error");
          error_messages[2].classList.remove("hide");
        }
      }
    };
    xhr.send("captcha_answer=" + encodeURIComponent(user_captcha_answer));
  }

  function VerifyCredentials(medixID, password, form){
    const login_endpoint = "PHP Modules/Authentication.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", login_endpoint, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          form.submit();
        } else {
            reload_captcha_image();
            if (response.failCount > 2){
                document.getElementById("captcha-section").classList.remove("hide");
                document.getElementById('captcha-answer-input').ariaRequired = "true";
            }
          submit_button.classList.remove("hide");
          loading_indicator.classList.add("hide");
          inputboxes[1].classList.add("box-error");
          error_messages[1].classList.remove("hide");
        }
      }
    };
    xhr.send("medixid=" + encodeURIComponent(medixID) + "&password=" + encodeURIComponent(password));
  }