/*****************************************************************************\
 * GLOBAL OBJECT DECLARATION.
 * Our application is controlled under 1 global object: APP. Use only 1 global
 * object to prevent cluttered global variables.
\*****************************************************************************/
var APP = new Object(); // Main object
APP.DOM = new Object(); // jQuery DOM object related

// Global constants
APP.GLOBAL = {
    SERVICE_URL:'locations.php' // Autocomplete service endpoint
};


/*****************************************************************************\
 * OUR MAIN CLOSURE.
 * Wait for the DOM fully loaded, before doing any further actions.
\*****************************************************************************/
$(function() {
    APP.DOM.init();
    APP.DOM.attachEvents(); 
    APP.initAutocomplete();
});


/*****************************************************************************\
 * JQUERY DOM LOADER.
 * Load all required DOMs and save it into a variable for a better performance
\*****************************************************************************/
APP.DOM.init = function() {
    APP.DOM.from = $("#from");              // Origin location
    APP.DOM.to = $("#to");                  // Destination
    APP.DOM.weight = $("#weight");          // Weight field
    APP.DOM.sessionID = $("#session_id");   // Hidden input that hold session ID
    APP.DOM.originCode = $("#origin_code");
    APP.DOM.destinationCode = $("#destination_code");
}


/*****************************************************************************\
 * ATTACH ALL DESIGNED EVENTS TO DOM OBJECTS
\*****************************************************************************/
APP.DOM.attachEvents = function() {
    // Check code location on blur
    APP.DOM.from.blur(APP.validateLocation);
    APP.DOM.to.blur(APP.validateLocation);
    APP.DOM.weight.blur(APP.validateWeight);
}


/*****************************************************************************\
 * VALIDATE SELECTED LOCATION
\*****************************************************************************/
APP.validateLocation = function(event) {
    // Determine which code to retrieve
    var id = $(this).attr("id");
    if (id == 'from') var target = APP.DOM.originCode;
    else if (id == 'to') var target = APP.DOM.destinationCode;

    // If null, clear input text
    if (!target.val()) $(this).val("");
}


/*****************************************************************************\
 * VALIDATE WEIGHT INPUT
\*****************************************************************************/
APP.validateWeight = function(event) {
    // Trim value
    var weight = APP.DOM.weight.val().trim();
    // If not a number, clear it!
    if (isNaN(parseFloat(weight)) || !isFinite(weight)) APP.DOM.weight.val("");
    // If less than a zero, clear it!
    if (parseFloat(weight) <= 0) APP.DOM.weight.val("");
}


/*****************************************************************************\
 * INITIALIZE AUTOCOMPLETE
\*****************************************************************************/
APP.initAutocomplete = function() {
    var options = {
        serviceUrl  : APP.GLOBAL.SERVICE_URL,
        minChars    : 3,
        params      : { session_id: APP.DOM.sessionID.val() },
        transformResult: function(response, originalQuery) {
            return { suggestions: $.parseJSON(response) }
        },
        onSelect: function (suggestion) {
            // Determine which code to update
            var id = $(this).attr("id");
            if (id == 'from') var target = APP.DOM.originCode;
            else if (id == 'to') var target = APP.DOM.destinationCode;

            // Update location code
            var code = suggestion.data.trim();
            if (code == "null") {
                code = null;
                $(this).val("");
            }
            target.val(code);
        },
        onInvalidateSelection: function() {
            // Determine which code to update
            var id = $(this).attr("id");
            if (id == 'from') var target = APP.DOM.originCode;
            else if (id == 'to') var target = APP.DOM.destinationCode;

            target.val(null);
        }
    }
    APP.DOM.from.autocomplete(options);
    APP.DOM.to.autocomplete(options);
}