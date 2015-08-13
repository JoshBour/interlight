$(function () {
    var flash = $(".flash");
    if (flash.is(":visible")) {
        flash.setRemoveTimeout(5000)
    }

    /**
     * Created by Josh on 13/7/2015.
     */
    var bTable = $('.tableWrapper').betterTable({
        unsortableCells: [0, 13],
        hiddenCells: [0],
        tableName: "Users",
        lengthMenu: [1, 5, 7, 10, 20, 30, -1],
        defaultLength: 10,
        columnNumber: 50
    });

    $('.formWrapper textarea').ckeditor({
        customConfig: betterTableUrl + '/custom-config.js'
    })

    $('.formWrapper .element select').each(function(){
        var select = $(this);
        if(!select.hasClass('attributeList')) select.selectBox();
    });

    var $productForm = $("#productForm");

    if ($productForm.length > 0) {
        var tableAttributes = new TableAttributes($('.attributeSelect'));
        //
        //var $attributeSelect = $('.attributeSelect');
        //var $attributeList = $attributeSelect.children('.attributeList');
        //var $activeAttributes = $attributeSelect.find('.activeAttributes').find('tbody');
        //$('.addAttribute').find('.button').on('click', function () {
        //    var $attributeRow = $('<tr></tr>').appendTo($activeAttributes);
        //    $('<td></td>').append($attributeList.clone().show()).appendTo($attributeRow);
        //    $('<td></td>').append($("<input />", {
        //        "type": "text",
        //        "name": "attributeValue"
        //    })).appendTo($attributeRow);
        //    $('<td></td>').append($("<input />", {
        //        "type": "text",
        //        "name": "attributePosition"
        //    })).appendTo($attributeRow);
        //
        //    $('<td></td>').append($("<span></span>", {
        //        "class": "attributeDelete button",
        //        "text": "Delete"
        //    })).appendTo($attributeRow);
        //
        //
        //});
        //
        //$(document).on('click','.attributeDelete',function(){
        //    $(this).closest('tr').remove();
        //});
        //
        $productForm.on('submit', function (e) {

            var encodedAttributes = tableAttributes.getEncodedAttributes();

            var attributeInput = $productForm.children('input[name="product[attributes]"]');
            if(attributeInput.length <= 0) {
                attributeInput = $('<input />', {
                    name: "product[attributes]"
                }).hide().appendTo($productForm);
            }
            attributeInput.val(encodedAttributes);
            //console.log($productForm.serialize());
            //return false;
        });

    }
});
