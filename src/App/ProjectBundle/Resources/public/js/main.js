$(document).ready(function(){
    
    $('.product_ajax').click(function(e){
        
        console.log('inside ajax');
        
        e.preventDefault();
        
        var searchText = $('#form_query_text').val();
        
        $.ajax({
            url: "/app_dev.php/product_search", 
            data: searchText,
            success: function(result){
                
            }
    });
    
    });
    
});