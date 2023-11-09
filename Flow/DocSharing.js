const sharingForm = document.getElementById("sharing-form");
const sharinginputboxes = document.querySelectorAll("#sharing .input-box");
const sharinginputs = document.querySelectorAll("#sharing .input-box input");
const sharinglabels = document.querySelectorAll("#sharing .input-box label");
const sharingerror_messages = document.querySelectorAll("#sharing .error");
const sharingsubmit_button = document.getElementById("sharing-form-submit-button");
const sharingloading_indicator = document.getElementById("sharing-submit-loader");

function ShareData(medixID, docID){
    const login_endpoint = "PHP Modules/ShareDocs.php";
    var xhr = new XMLHttpRequest();
    xhr.open("POST", login_endpoint, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);
        if (response.success) {
            sharingForm.reset();
            sharinglabels.forEach(label => {
                label.classList.remove('active');
              });
            sharingsubmit_button.classList.remove("hide");
            sharingloading_indicator.classList.add("hide");
            document.getElementById('sharing-doctor-success').classList.remove('hide');
            setTimeout(()=>{
                document.getElementById('sharing-doctor-success').textContent='Redirecting';
            },2000);
            setTimeout(()=>{
                document.getElementById('sharing-doctor-success').classList.add('hide');
                window.close();
            },2000);
        } else {
            sharingForm.reset();
            sharinglabels.forEach(label => {
                label.classList.remove('active');
              });
            sharingsubmit_button.classList.remove("hide");
          sharingloading_indicator.classList.add("hide");
            if(response.reason){
                sharingerror_messages[1].textContent = "This document is already shared with this user.";
            }
            else{
                sharingerror_messages[1].textContent = "Something went wrong. Please try again later.";
            }
            sharingerror_messages[1].classList.remove("hide");
            setTimeout(() => {
                sharingerror_messages[1].classList.add("hide");
                }, 3000);
        }
      }
    };
    xhr.send("medixid=" + encodeURIComponent(medixID) + "&document=" + encodeURIComponent(docID));
  }

  async function validate_doctor(input, index) {
    var medixid = input.value.trim();
    doc_id=false;
  
    // Regular expression pattern for email validation
    const email_pattern =
      /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/;
  
    if (medixid.length === 0) {
      status = false;
      sharinginputboxes[index].classList.remove("box-error");
      sharingerror_messages[index].classList.add("hide");
    } else {
      if (email_pattern.test(medixid)) {
        try {
          const result = await user_check(medixid);
          if (result.exists) {
            status = true;
            sharinginputboxes[index].classList.remove("box-error");
            sharingerror_messages[index].classList.add("hide");
            doc_id = result.id;
          } else {
            status = false;
            sharinginputboxes[index].classList.add("box-error");
            sharingerror_messages[index].classList.remove("hide");
            sharingerror_messages[index].textContent =
              "The Medix user you searched for was not found";
            
          }
        } catch (error) {
          console.error("Error checking email availability:", error);
        }
      } else {
        status = false;
        sharinginputboxes[index].classList.add("box-error");
        sharingerror_messages[index].classList.remove("hide");
        sharingerror_messages[index].textContent =
          "Enter a valid Medix ID.";
      }
    }
    return [status, doc_id];
  }

   // Function to check email availability
   function user_check(medixid) {
    // Return a Promise that resolves or rejects based on the AJAX request
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.exists) {
                // Email exists in database
                resolve(response);
              } else {
                // Email doesn't exist in database
                resolve(response);
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


  document.addEventListener("DOMContentLoaded", function () {
    sharinginputs.forEach((input, input_index) => {
  
        if (input.id === "sharing-doctor-input") {
            input.addEventListener("blur", () => {
                validate_doctor(input, input_index)
                .then((result) => {
                  doc_status = result[0];
                    doc_id = result[1];
                })

            });
        }
  
      // Placeholder -> Label Movement
    });
    sharingForm.addEventListener("submit", function (event) {  
      event.preventDefault(); // Prevent form submission
      // Validate all fields
      if (doc_status === "true") {
          sharingsubmit_button.classList.add("hide");
          sharingloading_indicator.classList.remove("hide");
          ShareData(doc_id, $('#document').val() );
      }
    });
  });