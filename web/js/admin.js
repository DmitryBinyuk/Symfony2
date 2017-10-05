$(document).ready(function () {

    //Product delete
    $('.delete-product').click(function () {
        var productDeleteId = $(this).attr("data-product-id");

        $(".delete-product-submit").attr("href", "/custom-admin/products/delete/"+productDeleteId);
    });

    $('.delete-product-submit').click(function () {
        $('#deleteProductModal').modal('hide');
    });

    //Producer delete
    $('.delete-producer').click(function () {
        var producerDeleteId = $(this).attr("data-producer-id");

        $(".delete-producer-submit").attr("href", "/custom-admin/producers/delete/"+producerDeleteId);
    });

    $('.delete-producer-submit').click(function () {
        $('#deleteProducerModal').modal('hide');
    });
});