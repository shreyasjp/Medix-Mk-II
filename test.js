$(document).ready(function () {
    $('#upload-id-box input').on('focus', function(){
      $('#upload-id-box').removeClass("box-error");
      $("#patient-id-error").addClass("hide");
    })
    $('#upload-id-box input').on('change', function(){
      $('#patient-info-display').addClass('hide');
      $('#patient-info-form-submit-button').val("Find patient");
    })
  $("#patient-info-form").on("submit", function (e) {
    $('#patient-info-form-submit-button').addClass("hide");
    $('#patient-info-submit-loader').removeClass("hide");
      e.preventDefault();
      // Retrieve the patient ID from the input field
      patientID = $("#upload-document-id-input").val();
      // Check if the patient ID is valid
      fetchPatient(patientID)
        .then((response) => {
          if (response.exists) {
            $('#patient-info-display').removeClass("hide");
            $("#patient-name-display").text(response.name);
            $("#patient-age-display").text(response.age);
            $("#patient-gender-display").text(response.gender);
            $('#patient-info-form-submit-button').removeClass("hide");
            $('#patient-info-submit-loader').addClass("hide");
            $('#patient-info-form-submit-button').val("Continue");
          } else {
            $("#patient-id-error").removeClass("hide");
            $('#upload-id-box').addClass("box-error");
            $('#patient-info-form-submit-button').removeClass("hide");
            $('#patient-info-submit-loader').addClass("hide");
          }
        })
        .catch((error) => {
          // AJAX request failed
          console.error(error);
          // Show an error message
          $("#patient-id-error").text(
            "An error occurred while fetching patient details."
          );
          $("#patient-id-error").removeClass("hide");
        });
  });
  });