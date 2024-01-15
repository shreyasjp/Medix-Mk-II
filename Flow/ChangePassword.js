const updateform = document.getElementById("update-form");
const updateinputboxes = document.querySelectorAll("#update-form .input-box");
const updateinputs = document.querySelectorAll("#update-form .input-box input");
const updatelabels = document.querySelectorAll("#update-form .input-box label");
const updateerrormessages = document.querySelectorAll("#update-form .error");
const update_button = document.getElementById("update-account-button");
const update_loading_indicator = document.getElementById("update-submit-loader");
const password_strength_display = document.getElementById("new-password-strength-validation-box");
const password_validations = document.querySelectorAll(".password-validations");
const password_strength_meter_fill = document.getElementById("new-password-strength-meter-filler");
const consecutive_characters_error = document.getElementById("new-password-validation-consecutive-characters-error");

update_button.addEventListener("click", function(event){
    event.preventDefault();
    update_button.classList.add("hide");
    update_loading_indicator.classList.remove("hide");
    VerifyCredentialsUpdate(document.getElementById("update-password-input").value);
});

document.addEventListener("DOMContentLoaded", function () {
    updateinputs.forEach((input, input_index) => {
      input.addEventListener("focus", function () {
          updateerrormessages[input_index].classList.add("hide");
          updateinputboxes[input_index].classList.remove("box-error");
      });
    });
    });

function VerifyCredentialsUpdate(password){
    const login_endpoint = "PHP Modules/PasswordCheck.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", login_endpoint, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          updateform.classList.add("hide");
          updateform.reset();
          update_loading_indicator.classList.add("hide");
          update_button.classList.remove("hide");
          $('#new-password-form').removeClass('hide');
        } else {
          update_loading_indicator.classList.add("hide");
          update_button.classList.remove("hide");
          updateinputboxes[0].classList.add("box-error");
          updateerrormessages[0].classList.remove("hide");
        }
      }
    };
    xhr.send("&password=" + encodeURIComponent(password));
  }

document.addEventListener('DOMContentLoaded', function(){
  const form = document.getElementById("new-password-form");
  const inputboxes = document.querySelectorAll(".input-box");
  const inputs = document.querySelectorAll(".input-box input");
  const labels = document.querySelectorAll(".input-box label");
  const error_messages = document.querySelectorAll(".error");
  const submit_button = document.getElementById("new-password-form-submit-button");
  const loading_indicator = document.getElementById("new-password-submit-loader");
  let password_confirmation_status = false;

  inputs.forEach((input, input_index) => {
    // Label -> Placeholder Movement
    input.addEventListener("focus", function () {

      // Password Strength Validation
      if (input.id === "new-password-input") {
        password_strength_display.classList.remove("hide");
        error_messages[6].classList.add("hide");
      }
    });

    // Placeholder -> Label Movement
    input.addEventListener("blur", function () {
      // Password Strength Validation
      if (input.id === "new-password-input") {
        password_strength_display.classList.add("hide");
      }
    });

    // Password Visibility Toggle
    if (
      input.id === "new-password-input" ||
      input.id === "new-password-confirmation-input"
    ) {
      const password_visibility_toggle = document.getElementById(
        input.id + "-visibility-toggle"
      );
      password_visibility_toggle.addEventListener("click", function () {
        password_visibility(input, password_visibility_toggle);
      });
    }

    // Password Validation
    if (input.id === "new-password-input") {
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
    if (input.id === "new-password-confirmation-input") {
      input.addEventListener("keyup", function() {
        if (input.value === document.getElementById("new-password-input").value){
          inputboxes[input_index].classList.remove("box-error");
          error_messages[input_index+1].classList.add("hide");
          password_confirmation_status = true;
        }
        else{
          inputboxes[input_index].classList.add("box-error");
          error_messages[input_index+1].classList.remove("hide");
          password_confirmation_status = false;
        }
      })
    }

    // Password confirm validation for password input field
    if (input.id === "new-password-input") {
      input.addEventListener("change", function() {
        if (input.value === document.getElementById("new-password-confirmation-input").value){
          inputboxes[input_index+1].classList.remove("box-error");
          error_messages[input_index+2].classList.add("hide");
          password_confirmation_status = true;
        }
        else{
          inputboxes[input_index+1].classList.add("box-error");
          error_messages[input_index+2].classList.remove("hide");
          password_confirmation_status = false;
        }
      })
    }

  });
  
  // Validate the entire form data brfore submitting
  form.addEventListener("submit", function (event) {  
    event.preventDefault(); // Prevent form submission
    // Validate all fields
    if (password_validation_status === "true" && password_confirmation_status) {
      submit_button.classList.add("hide");
      loading_indicator.classList.remove("hide");
      if(!UpdatePassword(document.getElementById("new-password-input").value)){
        error_messages[6].classList.remove("hide");
        submit_button.classList.remove("hide");
        loading_indicator.classList.add("hide");
        form.reset();
      }
    }
  });

})

function UpdatePassword(password) {
  const login_endpoint = "PHP Modules/UpdatePassword.php";
  var xhr = new XMLHttpRequest();
  xhr.open("POST", login_endpoint, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.sameAsBefore) {
          return false;
        } else if (response.success) {
          $('#new-password-form').addClass('hide');
          $('#new-password-repeat-error').addClass('hide');
          window.location.href = "index.php";
        } else {
          console.error("Unexpected response from server");
        }
      } else {
        console.error("Failed to make the request to the server");
      }
    }
  };

  xhr.send("password=" + encodeURIComponent(password));
}

