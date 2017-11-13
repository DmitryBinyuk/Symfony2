$(document).ready(function(){
    $('.product-add-comment').click(function () {

        var id = $(this).attr("data-id");
        var title = $('.comment-title').val();
        var body = $('.comment-body').val();

        $.ajax({
            type: "POST",
            url: "/product/"+id+"/add-comment",
            data: {title : title, body: body},
        }).done(function() {
            $( this ).addClass( "done" );
        });

        // $.post( "test.php", { title: "John", body: "2pm" } );

    }); 
});