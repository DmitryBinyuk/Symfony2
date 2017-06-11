$(document).ready(function () {

    $('.search_product').keyup(function () {
        console.log('test' + $('.search_product').val());
        $.ajax({
            url: "/app_dev.php/product_search",
            type: "POST",
//            dataType: "json",
            data: {search_val: $('.search_product').val()},
            success: function (result) {
                $('.product_result').children().remove();
                $('.product_result').append(result);
            }});
    });

    $('.search_product_xhr').keyup(function () {
//        var params = "lorem=ipsum&name=binny";
        var params = $('.search_product_xhr').val();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/app_dev.php/product_search', true);
        xhr.send(params);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById("product_result").innerHTML = xhr.responseText;
            }
        }


//        if (xhr.status != 200) {
//            alert( xhr.status + ': ' + xhr.statusText ); // 404: Not Found
//          } else if (xhr.status == 200) {
//              console.log('aaa')
//              var a = JSON.parse( xhr.responseText ); 
//            console.log(a);// responseText 
//          }

    });

    //File upload
    // Variable to store your files
    var files;

    // Add events
    $('input[type=file]').on('change', prepareUpload);

    // Grab the files and set them to our variable
    function prepareUpload(event)
    {
        files = event.target.files;
    }

    $('#file_upload').on('click', uploadFiles);

// Catch the form submit and upload the files
    function uploadFiles(event)
    {
        console.log('test')
        event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        // START A LOADING SPINNER HERE

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function (key, value)
        {
            data.append(key, value);
        });

        $.ajax({
            url: '/app_dev.php/product_search',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function (data, textStatus, jqXHR)
            {
                if (typeof data.error === 'undefined')
                {
                    // Success so call function to process the form
                    submitForm(event, data);
                } else
                {
                    // Handle errors here
                    console.log('ERRORS: ' + data.error);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // Handle errors here
                console.log('ERRORS: ' + textStatus);
                // STOP LOADING SPINNER
            }
        });
    }




});