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

    //Manager delete
    $('.delete-manager').click(function () {
        var managerDeleteId = $(this).attr("data-manager-id");

        $(".delete-manager-submit").attr("href", "/custom-admin/managers/delete/"+managerDeleteId);
    });

    $('.delete-manager-submit').click(function () {
        $('#deleteManagerModal').modal('hide');
    });

    //Product category delete
    $('.delete-product-category').click(function () {
        var productCategoryDeleteId = $(this).attr("data-product-category-id");

        $(".delete-product-category-submit").attr("href", "/custom-admin/product-categories/delete/"+productCategoryDeleteId);
    });

    $('.delete-product-category-submit').click(function () {
        $('#deleteProductCategoryModal').modal('hide');
    });

    //Discount delete
    $('.delete-discount').click(function () {
        var discountDeleteId = $(this).attr("data-discount-id");

        $(".delete-discount-submit").attr("href", "/custom-admin/discounts/delete/"+discountDeleteId);
    });

    $('.delete-discount-submit').click(function () {
        $('#deleteDiscountModal').modal('hide');
    });
});