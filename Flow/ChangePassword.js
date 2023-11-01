const updateform = document.getElementById("update-form");
const updateinputboxes = document.querySelectorAll("#update-form .input-box");
const updateinputs = document.querySelectorAll("#update-form .input-box input");
const updatelabels = document.querySelectorAll("#update-form .input-box label");
const updateerrormessages = document.querySelectorAll("#update-form .error");
const update_button = document.getElementById("update-account-button");
const update_loading_indicator = document.getElementById("update-submit-loader");

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
            console.log("Ggggg");
        } else {
          update_button.classList.remove("hide");
          update_loading_indicator.classList.add("hide");
          updateinputboxes[0].classList.add("box-error");
          updateerrormessages[0].classList.remove("hide");
        }
      }
    };
    xhr.send("&password=" + encodeURIComponent(password));
  }

