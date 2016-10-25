/*
 * jQuery File Upload Plugin JS Example
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */

$(function () {
    'use strict';

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: '/admin/upload',
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            '_token': $('input[name="_token"]').val()
        },
        prependFiles:true
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(
            /\/[^\/]*$/,
            '/cors/result.html?%s'
        )
    );
        // alert( $('#fileupload').fileupload('option', 'url'));
        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
  
        // console.log( $('#fileupload').fileupload('option', 'url'));
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Demo':'bangnk'
            },
            dataType: 'json',
            context: $('#fileupload')[0],
            prependFiles:true
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});
        });
});
