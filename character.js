$(document).ready(function() {
    // Listen for save button click
    $('#save-button').on('click', function(e) {
        e.preventDefault();

        // Save character
        saveCharacter();
    });

    $('#load-button').on('click', function(e) {
        e.preventDefault();

        // Load character
        loadCharacter();
    });

    // Listen for changes to the strength spell checkbox
    $('#strengthSpell').on('change', function() {
        // Update strength
        updateStat('str', $(this).is(':checked') ? 6 : -6);
    });
});

function saveCharacter() {
    // Initialize character data
    var character = {};

    // Get all form inputs
    var inputs = $('#character-form :input[type=text], #character-form :input[type=checkbox], #character-form :input[type=number], #character-form :input[type=hidden]');

    // Loop through inputs
    inputs.each(function() {
        // Add input to character data
        var id = $(this).attr('id');
        var value = $(this).is(':checkbox') ? ($(this).is(':checked') ? '1' : '0') : $(this).val();
        character[id] = value;
    });
    console.log(character)
    // Send AJAX request to save_character.php
    $.ajax({
        url: 'save_character.php',
        type: 'post',
        data: character,
        success: function(response) {
            // Print the response data
            console.log(response);
            // Parse response
            var result = JSON.parse(response);

            // Check if save was successful
            if (result.success) {
                // Redirect to load_character.php with the id of the saved character'
                alert('Character saved successfully!');
                window.location.href = 'edit_character.php?id=' + result.id;
            } else {
                // Show error message
                alert('Failed to save character: ' + result.error);
            }
        },
        error: function() {
            // Show error message
            alert('Failed to save character: An error occurred.');
        }
});

    
}




function updateStat(stat, amount) {
    // Get current stat value
    var currentStat = parseInt($('#' + stat).val());

    // Update stat
    currentStat += amount;

    // Update stat field
    $('#' + stat).val(currentStat);
}

function loadCharacter() {
    // Get character ID from hidden input field
    var id = $('#id').val();

    // Send AJAX request to load_character.php
    $.ajax({
        url: 'load_character.php',
        type: 'get',
        data: { id: id },
        success: function(response) {
            // Parse response
            var character = JSON.parse(response);

            // Set form fields
            $('#id').val(character.id);
            $('#name').val(character.name);
            $('#str').val(character.str);
            $('#strengthSpell').prop('checked', character.strengthSpell == 1);
        },
        error: function() {
            // Handle error
            // ...
        }
    });
}
