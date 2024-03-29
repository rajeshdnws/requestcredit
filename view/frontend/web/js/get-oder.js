define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/mage'
], function($, modal) {
    return function(config) {
        var url = config.starbucksb2bUrl + 'requestcredit/order/index',
            title = config.starbucksb2bPopupTitle,
            data = config.dataOrder,
            orderRefund = config.orderRefund
            orders = config.orders;
        var options = {
            wrapperClass: 'starbucksb2b-modals-wrapper',
            modalClass: 'starbucksb2b-modal',
            overlayClass: 'starbucksb2b-modals-overlay',
            responsiveClass: 'starbucksb2b-modal-slide',
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: title,
            buttons: [{
                text: $.mage.__('Send Request'),
                class: 'starbucksb2b-popup-button',
                click: function (data) {
                    var form_data = $("#starbucksb2b-refund-form").serialize();
                    if ($('#starbucksb2b-refund-form').valid()) {

                        $.ajax({
                            showLoader: true,
                            url: url,
                            type: 'POST',
                            data: form_data
                        })
                            .done(function () {
                                $("#starbucksb2b-refund-modal").modal('closeModal');
                                $("#starbucksb2b-refund-form")[0].reset();
                                location.reload(true);

                            })
                            .fail(function () {
                                $("#starbucksb2b-refund-modal").modal('closeModal');
                            });
                    }
                }
            },
                {
                    text: $.mage.__('Cancel Request'),
                    class: 'starbucksb2b-popup-button',
                    click: function (data) {
                        $("#starbucksb2b-refund-form")[0].reset();
                        $("#starbucksb2b-refund-modal").modal('closeModal');

                    }
                }
            ]
        };

        $("#my-orders-table tbody tr").each(function() {
            var pos = $(this).closest("tr");
            var col1 = pos.find("td:eq(0)").text();
            col1 = $.trim(col1);
            var array = orderRefund.split(",");
            var status = "";
            $(this).attr("data-oder-id", col1);

            /* Add refund button to each Order Row */
            $.each(orders, function(key, value) {
                if (value.increment_id == col1) {
                    status = value.status;
                    return;
                }
            });
            if ($.inArray(status, array) !== -1) {
                $(this).find('.col.actions').append("<span class='refund'><a href='#' class='refund-order'>Refund</a></span>");
            }

            var buttonPos = "tr[data-oder-id="+col1+"] td.col.actions";
            $.each(data, function(key, value) {
                var classRefund = buttonPos + ' ' + 'span.refund';
                if (col1 == value.increment_id && value.refund_status == 0) {
                    $(classRefund).html('Pending');
                }
                if (col1 == value.increment_id && value.refund_status == 1) {
                    $(classRefund).html('Accepted');
                }
                if (col1 == value.increment_id && value.refund_status == 2) {
                    $(classRefund).html('Rejected');
                }
            });
        });

        $(document).on('click', '.refund-order', function () {
            var test = $(this).closest("tr");
            var col1=test.find("td:eq(0)").text();
            col1 = col1.replace(/\s/g, '');
            $(this).attr("data-oder-id", col1);
        });
        $(document).on('click', '.refund-order', function () {
            var order_id = $(this).attr('data-oder-id');
            modal(options, $("#starbucksb2b-refund-modal"));
            $("#starbucksb2b-refund-modal").modal('openModal');
            $(".starbucksb2b-refund-oder-id").attr('value', order_id);
        });
    }
});