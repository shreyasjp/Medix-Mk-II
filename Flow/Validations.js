// Password Visibility Toggle Function
function password_visibility(input, toggle) {
    if (input.type === "password") {
      input.type = "text";
      toggle.textContent = "HIDE";
    } else {
      input.type = "password";
      toggle.textContent = "SHOW";
    }
  }
  
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
  
  // Function to validate email
  async function validate_medixid(input, index) {
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
        try {
          // Chacking availability of email
          const result = await medixid_availibility_check(medixid);
          if (result) {
            // Email does'nt exist in database
            status = true;
            inputboxes[index].classList.remove("box-error");
            error_messages[index].classList.add("hide");
          } else {
            // Email exists in database
            status = false;
            inputboxes[index].classList.add("box-error");
            error_messages[index].classList.remove("hide");
            error_messages[index].textContent =
              " This email address is not available. Choose a different address.";
          }
        } catch (error) {
          // Error occured while sending http request to backend
          console.error("Error checking email availability:", error);
          // Handle error as needed
        }
      } else {
        // The email pattern is invalid
        status = false;
        inputboxes[index].classList.add("box-error");
        error_messages[index].classList.remove("hide");
        error_messages[index].textContent =
          "Enter a valid email address to use as your Medix ID.";
      }
    }
    return status;
  }
  
  // Function to check email availability
  function medixid_availibility_check(medixid) {
    // Return a Promise that resolves or rejects based on the AJAX request
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.exists) {
              // Email exists in database
              resolve(false);
            } else {
              // Email doesn't exist in database
              resolve(true);
            }
          } else {
            // AJAX request failed
            console.error("AJAX request failed.");
            reject(new Error("AJAX request failed"));
          }
        }
      };
  
      xhr.open("POST", "PHP Modules/EmailCheck.php");
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send("email=" + encodeURIComponent(medixid));
    });
  }
  
  // Function to refresh the CAPTCHA image
  function reload_captcha_image() {
    // Set the CAPTCHA image source to the loading image
    captcha_code.src = "Data/Animations/SpinnerMedium.svg";
  
    // Fetch a new CAPTCHA image
    fetchNewCaptcha()
      .then((captchaImageSrc) => {
        // Create a new image element to load the new CAPTCHA image
        const newCaptchaImage = new Image();
  
        newCaptchaImage.onload = function () {
          // Once the new CAPTCHA image is fully loaded, replace the CAPTCHA image source
          captcha_code.src = newCaptchaImage.src;
  
          // Reset the CAPTCHA answer input and label
          document.getElementById("captcha-answer-input").value = "";
          document.getElementById("captcha-answer-label").classList.remove("active");
        };
  
        newCaptchaImage.src = captchaImageSrc;
      })
      .catch((error) => {
        console.error("Error generating CAPTCHA image: ", error);
        // In case of an error, you can handle it or simply keep showing the loading image
      });
  }
  
  // Function to fetch a new CAPTCHA image
  function fetchNewCaptcha() {
    const prefersDarkMode = window.matchMedia("(prefers-color-scheme: dark)");
    const isDarkMode = prefersDarkMode.matches;
    captcha_theme = isDarkMode ? "PHP Modules/DarkCaptcha.php" : "PHP Modules/Captcha.php";
    return fetch(captcha_theme)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Failed to generate CAPTCHA image.");
        }
        return response.url;
      });
  }
  
  // Function to validate passwords
  function calculate_password_strength(password) {
    //Regular expressions for checking password
    let password_strength_class;
    const consecutive_chars = /(.)\1{4,}/i ;
    const lower_case = /[a-z]/;
    const upper_case = /[A-Z]/;
    const numbers = /\d/;
    const symbol = /[!@#$%^&*(),.?":{}|<>]/;
  
    let password_score = 0;
  
    // Prevents password from having consecutive identical characters for security
    if (!consecutive_chars.test(password)) {
      consecutive_characters_error.classList.add("hide");
      password_strength_display.style.marginTop = "";
      //Checks if the password has atleast 8 characters
      if (password.length >= 8) {
        password_score++;
        password_validations[0].classList.add("condition-verified");
      }
      else{
        password_validations[0].classList.remove("condition-verified");
      }    
      if (password.length >= 15) {
        password_score++;
      }
      // Check if the password has an upper and lower case chaarcter
      if(lower_case.test(password) && upper_case.test(password)){
        password_score++;
        password_validations[1].classList.add("condition-verified");
      }
      else{
        password_validations[1].classList.remove("condition-verified");
      }
      if (lower_case.test(password)) {
        password_score++;
      }
    
      if (upper_case.test(password)) {
        password_score++;
      }
      // Checks if the password has a number
      if (numbers.test(password)) {
        password_score++;
        password_validations[2].classList.add("condition-verified");
      }
      else{
        password_validations[2].classList.remove("condition-verified");
      }
      // Checks if the password has a special character
      if (symbol.test(password)) {
        password_score++;
        password_validations[3].classList.add("condition-verified");
      }
      else{
        password_validations[3].classList.remove("condition-verified");
      }
      if(password.length >=8 && lower_case.test(password)&&upper_case.test(password) && numbers.test(password) && symbol.test(password)){
        password_score++;
      }
      else{
        // Prevent passwords that do not meet the vaidation criteria
        status = false;
      }
    }
    else{
      password_score = 1;
      password_strength_display.style.marginTop = "157px";
      consecutive_characters_error.classList.remove("hide");
    }
    if(password.length==0){
      password_score = 0;
    }
    password_strength = (password_score / 8) * 100;
  
    if (password_strength <= 50) {
      password_strength_class = 'password-weak';
    } else if (password_strength <= 65) {
      password_strength_class = 'password-medium';
    } else if (password_strength <= 90) {
      password_strength_class = 'password-strong';
      status = true;
    } else {
      password_strength_class = 'password-very-strong';
      status = true;
    }
  
    // Fills the password strength meter after calculating password strength
    password_strength_meter_fill.style.width = password_strength + "%";
    setTimeout(function(){
    password_strength_meter_fill.className = "password-strength-meter-fill " + password_strength_class;
    },150)
    return status;
  }