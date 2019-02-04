
$( document ).ready(function() {
    var saveProductAmountAction = null;

    $('.orderPopup').click(function (e) {
        var insertMealAmount =  $('#insertMealAmount');
        insertMealAmount.draggable();

        var amount = $('#form_content');
        var productAmountAction = $(this).closest('form')[0].action;

        e.preventDefault();

        $.ajax({
            url : productAmountAction,
            method : "post",
            dataType : "json"
        })
            .done(function(response) {
                $('#form_content')[0].value = response.amount;
                insertMealAmount.show();

                saveProductAmountAction  = response.url;
                console.log(saveProductAmountAction);
            })
            .fail(function() {
                console.log("Wystąpił błąd");
            });


        insertMealAmount.find('#form_close').on('click', function () {
            insertMealAmount.hide();
        });
    });

    $('#form_save').click(function (e) {
        e.stopPropagation();
        var form = $('#form_content').closest('form');
        $.ajax({
            url : saveProductAmountAction,
            method : "post",
            data : { orderAmount : $('#form_content')[0].value},
            dataType : "json"
        })
            .done(function(response) {
                if(form.attr('reload') == "true"){
                    window.location.href = "";
                }
                $('#productAmount').text(response.amount)
                $('#insertMealAmount').hide();

            })
            .fail(function() {
                console.log("Wystąpił błąd");
            })

    });

    $('#form_finalizeForm').click(function(e){
        e.preventDefault();
        $('#realiseOrder').show();
    })
    $('#order_form_continueshopping').click(function (e) {
        e.preventDefault();
       createajaxAction("continueShopping");
        $('#realiseOrder').hide();
    })
    $('#order_form_save').click(function (e) {
        e.preventDefault();
        createajaxAction("save");
    })
});
function createajaxAction($additionalData){
    var form = $('form[name=order_form]');
    var action = form.attr('action');
    var formData = $(form).serialize();
    $.ajax({
        url: action,
        type: "post",
        data: formData,
        dataType: "json"
    })
        .done(function(response){
            console.log(response);
        })
        .fail(function(error){
            console.log('error '+ error)
        });
}
function getProductData($url){
    var url = null;
    $.ajax({
        url : $url,
        method : "post",
        dataType : "json"
    })
        .done(function(response) {
            $('#form_content')[0].value = response.amount;
            $('#insertMealAmount').show();

            return response.url;
        })
        .fail(function() {
            console.log("Wystąpił błąd");
        });

}
function saveProductAmount($url){


}