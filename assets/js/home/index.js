/**
 * @package     Allshore
 * @author      Bahadur O
 * @copyright   Copyright (c) 2017
 */

$(document).ready(function(){

    var bar     = $('.progress-bar'); // progress bar element
    $("#clear").click(function(){

        var control = $("#hin_file");
        control.removeAttr('disabled');
        control.val("");
        $("#submit").removeAttr('disabled');
        $('.wrap_uploading_progress').hide();
        $('.col-md-5 > table').remove();
        $('.col-md-5 > h4').append("<p></p>");
        var percentComplete = 0;
        var percentVal = percentComplete + '%';
        bar.width(percentVal);
        bar.attr('aria-valuenow',percentComplete);
        bar.text(percentComplete);
        $('#sample_image').attr('src', '');
        $('#sample_image').hide();
    })
    $("#hin_file").change(function(){

        readURL(this);
    });

    // enabled image preview and progress bar on select image
    function readURL(input) {

        if (input.files && input.files[0]) {

            var reader = new FileReader();
            reader.onload = function (e) {

                $('#sample_image').attr('src', e.target.result);
                $('#sample_image').show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // ajaxFrom initialized
    $frm = $('form').ajaxForm({

        url: 'index.php/home/doUpload',
        beforeSend: function(xhr){

            $('#hin_file').attr("disabled","disabled");
            $('#submit').attr("disabled","disabled");
        },
        uploadProgress: function (event, position, total, percentComplete){

            // progress bar wrapper shown
            $('.wrap_uploading_progress').show();
            var percentVal = percentComplete + '%';
            bar.width(percentVal);
            bar.attr('aria-valuenow',percentComplete);
            bar.text(percentComplete);
            $('.col-md-5 > p').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        },
        success: function(){

            $('#txt_upload_message').text("Upload complete. Processing image");
        },

        complete: function(data) {

            $('#txt_upload_message').text("Processing image complete.");
            var content = JSON.parse(data.responseText);
            if(content.status == "success") {

                $('.col-md-5 > p').remove();
                $('<table class="table"></table>').insertAfter('.col-md-5 > h4');
                content.content.forEach(function (element) {

                    $('.col-md-5 > table').append('<tr><td>' + element + '</td></tr>');
                });
            } else {

                $('.col-md-5 > p').text(content.error);
            }
        }
    })
});