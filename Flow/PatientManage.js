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
        var keyA = $(a).find('#patient-id').text();
        var keyB = $(b).find('#patient-id').text();
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

// Create arrays to store the selected filters
var selectedGenders = [];
var selectedAgeGroup = [];

// Function to apply filters based on user selections
function ApplyFilters() {
    var searchText = document.getElementById("search-input").value.toLowerCase();

    // Get all items
    var items = $('#docs-container a');

    items.each(function (index, item) {
        var gender = $(item).data('gender').toLowerCase();
        var age = $(item).data('agegroup').toLowerCase();

        // Apply filters
        var showItem = true;

        // Filter by document type
        if (selectedGenders.length > 0) {
            showItem = showItem && selectedGenders.includes(gender.replace(/\s/g, ''));
        }

        // Filter by file type
        if (selectedAgeGroup.length > 0) {
            showItem = showItem && selectedAgeGroup.includes(age.replace(/\s/g, ''));
        }

        // Filter by search text
        if (searchText) {
            showItem = showItem && $(item).data('name').toLowerCase().includes(searchText);
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
$('.gender-filter, .age-filter').on('click', function () {
    $(this).toggleClass('filter-active');
    
    // Update the selected filters array based on the clicked filter
    var filterType = $(this).hasClass('gender-filter') ? selectedGenders : selectedAgeGroup;
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


// Event listener for search input
$('#search-input').on('input', function () {
    ApplyFilters();
});

// Initial application of filters
ApplyFilters();