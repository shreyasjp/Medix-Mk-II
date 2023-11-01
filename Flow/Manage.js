$('#sort-files').on('change', function() {
    var selectedOption = $(this).val();
    if (selectedOption === "NameAscending") {
      SortByName(0); // Sort by name in ascending order
    } else if (selectedOption === "NameDescending") {
      SortByName(1); // Sort by name in descending order
    } else if (selectedOption === "Newest") {
      SortByDate(1); // Sort by date in descending order
    } else if (selectedOption === "Oldest") {
      SortByDate(0); // Sort by date in ascending order
    }
  });

function SortByName(reverse){
    var items = $('#docs-container a').get();
    items.sort(function(a,b){
        var keyA = $(a).text();
        var keyB = $(b).text();
        if(reverse){
            if (keyA < keyB) return 1;
            if (keyA > keyB) return -1;
        }
        else{
            if (keyA < keyB) return -1;
            if (keyA > keyB) return 1;
        }
        return 0;
    });
    var ul = $('#docs-container');
    $.each(items, function(i, li){
        ul.append(li);
    });
}

function SortByDate(reverse){
    var items = $('#docs-container a').get();
    items.sort(function(a,b){
        var keyA = $(a).find('.doc-upload-date').text();
        var keyB = $(b).find('.doc-upload-date').text();
        if(reverse){
            if (keyA < keyB) return 1;
            if (keyA > keyB) return -1;
        }
        else{
            if (keyA < keyB) return -1;
            if (keyA > keyB) return 1;
        }
        return 0;
    });
    var ul = $('#docs-container');
    $.each(items, function(i, li){
        ul.append(li);
    });
}

function FilterPreview() {
    var Filter = document.getElementById("manage-filters");
    var FilterButton = $('#Filter-preview');
    if (Filter.classList.contains("hide")) {
      Filter.classList.remove("hide");
    } else {
      Filter.classList.add("hide");
    }
    if (!FilterButton.hasClass('active')) {
        FilterButton.addClass('active');
        }
    else {
        FilterButton.removeClass('active');
        }
  }

  function DeleteDocument(path,id){
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'PHP Modules/DeleteDocument.php', true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var response = JSON.parse(xhr.responseText);
              if (response.success) {
                $(`a[data-id="${id}"]`).remove();
                $('#doc-modal iframe').attr('src', '');
                $('#doc-modal').addClass('hide');
                ApplyFilters();
              } else {
                $('#delete-error').removeClass('hide');
                setTimeout(()=>{
                    $('#delete-error').addClass('hide');
                  },3000)
            }
        }
      };
      xhr.send("&filePath=" + encodeURIComponent(path) + "&docID=" + encodeURIComponent(id));
    }

// Create arrays to store the selected filters
var selectedDocTypes = [];
var selectedFileTypes = [];

// Function to apply filters based on user selections
function ApplyFilters() {
    var searchText = document.getElementById("search-input").value.toLowerCase();
    var isVerifiedFilter = document.getElementById("Verified-Filter").classList.contains("filter-active");

    // Get all items
    var items = $('#docs-container a');

    items.each(function (index, item) {
        var docType = $(item).find('.doc-type').text().toLowerCase();
        var fileType = $(item).find('.doc-file-type').text().toLowerCase();
        var docName = $(item).find('.doc-name').text().toLowerCase();
        var isVerified = $(item).find('#doc-verified-symbol-container img[src="Data/Icons/Greentick.png"]').length > 0;

        // Apply filters
        var showItem = true;

        // Filter by document type
        if (selectedDocTypes.length > 0) {
            showItem = showItem && selectedDocTypes.includes(docType.replace(/\s/g, ''));
        }

        // Filter by file type
        if (selectedFileTypes.length > 0) {
            showItem = showItem && selectedFileTypes.includes(fileType.replace(/\s/g, ''));
        }

        // Filter by Verified
        if (isVerifiedFilter) {
            showItem = showItem && isVerified;
        }

        // Filter by search text
        if (searchText) {
            showItem = showItem && docName.includes(searchText);
        }

        // Show or hide the item based on the combined effect of filters
        if (showItem) {
            $(item).show();
        } else {
            $(item).hide();
        }
    });
}

// Event listeners for filter elements
$('.doctype-filter, .file-type-filter').on('click', function () {
    $(this).toggleClass('filter-active');
    
    // Update the selected filters array based on the clicked filter
    var filterType = $(this).hasClass('doctype-filter') ? selectedDocTypes : selectedFileTypes;
    var filterText = $(this).text().toLowerCase().replace(/\s/g, '');

    if ($(this).hasClass('filter-active')) {
        filterType.push(filterText);
    } else {
        const index = filterType.indexOf(filterText);
        if (index > -1) {
            filterType.splice(index, 1);
        }
    }
    
    ApplyFilters();
});

// Event listener for Verified filter button click
$('#Verified-Filter').on('click', function () {
    $(this).toggleClass('filter-active');
    ApplyFilters();
});

// Event listener for search input
$('#search-input').on('input', function () {
    ApplyFilters();
});

// Initial application of filters
ApplyFilters();

$(document).ready(function () {
    var currentDocData = {}; // Variable to store the data of the currently clicked document
  
    // Click event handler for document links
    $('a[data-path]').on('click', function (e) {
      e.preventDefault();

      isConfirmation = false;
      $('#doc-modal #delete-doc-button').html('<span class="filter-icons"><img src="Data/Icons/Delete.png"></span>Delete');

  
      // Get data from the clicked link
      currentDocData.docName = $(this).data('name');
      currentDocData.docType = $(this).data('type');
      currentDocData.uploadDate = $(this).data('uploaddate');
      currentDocData.desc = $(this).data('description');
      currentDocData.absoluteDocPath = $(this).data('path');
      currentDocData.docPath = 'Medix MK II/' + $(this).data('path');
      currentDocData.docIcon = $(this).data('icon');
      currentDocData.isVerified = $(this).data('verified');
      currentDocData.docID = $(this).data('id');
      
      // Populate the modal's content
      $('#doc-modal .expanded-doc-name').html(`${currentDocData.docName} ${currentDocData.isVerified ? '<span id="expanded-doc-verified-symbol-container"><img id="expanded-doc-verified-symbol" src="Data/Icons/Greentick.png" alt="Verified"></span>' : ''}`);
      $('#doc-modal .expanded-doc-type').text(currentDocData.docType);
      $('#doc-modal .expanded-doc-upload-date').text('Uploaded: ' + currentDocData.uploadDate);
      $('#doc-modal .expanded-doc-description').text('Description: ' + currentDocData.desc);
      $('#doc-modal .expanded-doc-icon').attr('src', currentDocData.docIcon);
      $('#doc-modal iframe').attr('src', currentDocData.docPath);
  
      // Show the modal
      $('#doc-modal').removeClass('hide');
    });
  
    // Click event handler for closing the modal
    $('#doc-modal #close-doc-button').on('click', function () {
      // Clear the iframe's source and hide the modal
      $('#doc-modal iframe').attr('src', '');
      $('#doc-modal').addClass('hide');
      isConfirmation = false;
      $('#doc-modal #delete-doc-button').html('<span class="filter-icons"><img src="Data/Icons/Delete.png"></span>Delete');
    });

    document.getElementById('doc-modal').addEventListener('click', function (event) {
      if (event.target === this) {
        // Clear the iframe's source and hide the modal
      $('#doc-modal iframe').attr('src', '');
      $('#doc-modal').addClass('hide');
      isConfirmation = false;
      $('#doc-modal #delete-doc-button').html('<span class="filter-icons"><img src="Data/Icons/Delete.png"></span>Delete');
      }
    });
  
    // Click event handler for the "Delete" button in the modal
    $('#doc-modal #delete-doc-button').on('click', function () {
        if (isConfirmation) {
          // This is the second click (confirmation click)
          DeleteDocument(currentDocData.absoluteDocPath, currentDocData.docID);
        } else {
          // This is the first click
          // Change the button's text to "Confirm"
          $(this).text('Confirm');
      
          // Set the flag to indicate it's a confirmation click
          isConfirmation = true;
        }
      });
  });