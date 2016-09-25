/*jslint  browser: true, white: true, plusplus: true */
/*global $, names */

$(function () {
    'use strict';

    var namesArray = $.map(names, function (value, key) { return { value: value, data: key }; });
    var lastnamesArray = $.map(lastnames, function (value, key) { return { value: value, data: key }; });

    // Setup jQuery ajax mock for names:
    $.mockjax({
        url: '*',
        responseTime: 2000,
        response: function (settings) {
            var query = settings.data.query,
                queryLowerCase = query.toLowerCase(),
                re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi'),
                suggestions = $.grep(namesArray, function (name) {
                    return re.test(name.value);
                }),
                response = {
                    query: query,
                    suggestions: suggestions
                };

            this.responseText = JSON.stringify(response);
        }
    });

    // Setup jQuery ajax mock for lastnames:
    $.mockjax({
        url: '*',
        responseTime: 2000,
        response: function (settings) {
            var query = settings.data.query,
                queryLowerCase = query.toLowerCase(),
                re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi'),
                suggestions = $.grep(lastnamesArray, function (lastname) {
                    return re.test(lastname.value);
                }),
                response = {
                    query: query,
                    suggestions: suggestions
                };

            this.responseText = JSON.stringify(response);
        }
    });


    // Initialize ajax autocomplete (for names):
    $('#element_7_1').autocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: namesArray,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
    });

    $('#element_2_1').autocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: namesArray,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
    });

    // Initialize ajax autocomplete (for lastnames):
    $('#element_7_2').autocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: lastnamesArray,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
    });

    $('#element_2_2').autocomplete({
        // serviceUrl: '/autosuggest/service/url',
        lookup: lastnamesArray,
        lookupFilter: function(suggestion, originalQuery, queryLowerCase) {
            var re = new RegExp('\\b' + $.Autocomplete.utils.escapeRegExChars(queryLowerCase), 'gi');
            return re.test(suggestion.value);
        },
    });

});