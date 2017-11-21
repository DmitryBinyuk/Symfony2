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

        //CHEATSHEET: $.post( "test.php", { title: "John", body: "2pm" } );
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

    $('.product-search-submit').click(function () {
        sendSearchRequest();
    });

    $('.products_search_text').keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
            sendSearchRequest();
        }
    });

    function sendSearchRequest(){
        var searchText = $('.products_search_text').val();

        if(searchText.length > 3){
            $.ajax({
                type: "POST",
                url: "/products-search",
                data: {searchText : searchText},
            }).success(function(data) {
                if(data.length > 0){
                    $.each( data, function( index, value ){
                        displayProductsSearch(value);
                    });
                    cloneCheker = 0;
                }
            });
        }
    }

    var cloneCheker = 0;
    function displayProductsSearch(product) {

        var clone = $('.product-item:first').clone();
        var image = '<img alt="image1" title="image1" src='+product.image+' width="150" height="150">';

        clone.find(".product-name").text(product.name);
        clone.find(".product-description").text(product.description);
        clone.find(".product-media").html(image);

        if(cloneCheker == 0){
            $('.products-list .product-item').remove();
            $('.navigation').remove();
        }
        cloneCheker++;

        $('.products-list').append(clone);
    }
});