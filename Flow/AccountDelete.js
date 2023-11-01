const deleteform = document.getElementById("delete-form");
const deleteinputboxes = document.querySelectorAll("#delete-form .input-box");
const deleteinputs = document.querySelectorAll("#delete-form .input-box input");
const deletelabels = document.querySelectorAll("#delete-form .input-box label");
const deleteerrormessages = document.querySelectorAll("#delete-form .error");
const delete_button = document.getElementById("delete-account-button");
const delete_loading_indicator = document.getElementById("delete-submit-loader");

delete_button.addEventListener("click", function(event){
    event.preventDefault();
    let validated = true;
    deleteinputs.forEach((input, input_index) => {
        if (input.value == "") {
            validated = false;
            deleteerrormessages[input_index].classList.remove("hide");
            deleteinputboxes[input_index].classList.add("box-error");
        }
    });
    if (validated) {
        delete_button.classList.add("hide");
        delete_loading_indicator.classList.remove("hide");
        VerifyCredentialsDelete(document.getElementById("delete-password-input").value);
    }
});

document.addEventListener("DOMContentLoaded", function () {
    deleteinputs.forEach((input, input_index) => {
      input.addEventListener("focus", function () {
          deleteerrormessages[input_index].classList.add("hide");
          deleteinputboxes[input_index].classList.remove("box-error");
      });
    });
    });

function VerifyCredentialsDelete(password){
    const login_endpoint = "PHP Modules/PasswordCheck.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", login_endpoint, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          confirmDelete();
        } else {
          delete_loading_indicator.classList.add("hide");
          delete_button.classList.remove("hide");
          deleteinputboxes[0].classList.add("box-error");
          deleteerrormessages[0].classList.remove("hide");
        }
      }
    };
    xhr.send("&password=" + encodeURIComponent(password));
  }
function confirmDelete(){
    if (document.getElementById('delete-confirm-input').value == "deletemymedixid"){
        deleteAccount();
    }
    else{
        delete_button.classList.remove("hide");
        delete_loading_indicator.classList.add("hide");
        deleteinputboxes[1].classList.add("box-error");
        deleteerrormessages[1].classList.remove("hide");
    }
}
function deleteAccount(){
    const delete_endpoint = "PHP Modules/DeleteAccount.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", delete_endpoint, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
          window.location.href = "index.php";
        } else {
          delete_button.classList.remove("hide");
          delete_loading_indicator.classList.add("hide");
          deleteerrormessages[2].classList.remove("hide");
        }
      }
    };
    xhr.send();
}

