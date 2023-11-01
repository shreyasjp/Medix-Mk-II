function showSection(sectionId, link) {
    // Hide all sections
    $('.sections').removeClass('hide');
    $('.sections').addClass('hide');

    $('#' + sectionId).removeClass('hide');

    $('.nav-links a').removeClass('active-text');
    $(link).addClass('active-text');
}
function showSubSection(section, subSectionID, link){
    // Hide all sections
    $('.'+section+'-sections').removeClass('hide');
    $('.'+section+'-sections').addClass('hide');

    $('#' + subSectionID).removeClass('hide');

    $('.'+section+'-link').removeClass('active-text');
    $(link).addClass('active-text');
}

function changePasswordButton() {
    // Reset all forms within #profile-security-content
    $('#profile-security-content form').each(function() {
      this.reset();
    });

    $('#update-form label').removeClass('active');
    $('#new-password-form label').removeClass('active');
  
    // Hide and show elements
    document.getElementById('delete-form').classList.add('hide');
    document.getElementById('update-form').classList.remove('hide');
  
    // Update the active state of buttons
    document.getElementById('delete-account').classList.remove('active-text');
    document.getElementById('change-password').classList.add('active-text');
  }
  
  function deleteAccountButton() {
    // Reset all forms within #profile-security-content
    $('#profile-security-content form').each(function() {
      this.reset();
    });

    $('#delete-form label').removeClass('active');
  
    // Hide and show elements
    document.getElementById('update-form').classList.add('hide');
    document.getElementById('delete-form').classList.remove('hide');
  
    // Update the active state of buttons
    document.getElementById('change-password').classList.remove('active-text');
    document.getElementById('delete-account').classList.add('active-text');
  }
  