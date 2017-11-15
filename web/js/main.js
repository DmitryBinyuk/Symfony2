$(document).ready(function(){

    $('.product-add-comment').click(function () {

        var id = $(this).attr("data-id");
        var title = $('.comment-title-input').val();
        var body = $('.comment-body-input').val();

        $.ajax({
            type: "POST",
            url: "/product/"+id+"/add-comment",
            data: {title : title, body: body},
        }).success(function(data) {
            console.log(data);
            appendComment(title, body);
        });

        // $.post( "test.php", { title: "John", body: "2pm" } );

    });
    
    function appendComment(title, body) {
        var clone = $('.comment-container:last').clone();
        clone.find(".comment-title").text(title);
        clone.find(".comment-body").text(body);
        clone.appendTo('.comment-container:last');

        //clear inputs
        $('.product-add-comment-wrapper .comment-title-input').val("");
        $('.product-add-comment-wrapper .comment-body-input').val("");
    }
});