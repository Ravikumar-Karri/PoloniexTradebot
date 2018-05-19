<script>


    $(document).ready(function () {

        $("#li_orders").addClass("active");

        //  *** Buy orders Datatable
        global_data.table_buy_order_title = "open order";
        global_data.table_buy_order = $("#table_buy_order").DataTable({
            "order": false, //[[ 2, "desc" ]],
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "language": {
                "emptyTable": "There are no " + global_data.table_buy_order_title,
                "info": "Showing _START_ to _END_ of _TOTAL_ " + global_data.table_buy_order_title,
                "infoEmpty": "No results found",
                "infoFiltered": "(filtered from _MAX_ total " + global_data.table_buy_order_title + ")",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Show _MENU_ " + global_data.table_buy_order_title,
                "loadingRecords": "Loading " + global_data.table_buy_order_title,
                "processing": "Processing " + global_data.table_buy_order_title,
                "search": "",
                "zeroRecords": "No matching " + global_data.table_buy_order_title + " found"
            },
            "ajax": "<?php echo base_url(); ?>orders/fetch_open_orders",
            "rowCallback": function (row, data, index) {
                $('td:eq(0)', row).html(global_data.table_buy_order.page.info().start + index + 1);
            }
        });



        //  *** Sell orders Datatable
        global_data.table_sell_order_title = "open positions";
        global_data.table_sell_order = $("#table_sell_order").DataTable({
            "order": false, //[[ 2, "desc" ]],
            "processing": true,
            "serverSide": true,
            "autoWidth": false,
            "language": {
                "emptyTable": "There are no " + global_data.table_sell_order_title,
                "info": "Showing _START_ to _END_ of _TOTAL_ " + global_data.table_sell_order_title,
                "infoEmpty": "No results found",
                "infoFiltered": "(filtered from _MAX_ total " + global_data.table_sell_order_title + ")",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Show _MENU_ " + global_data.table_sell_order_title,
                "loadingRecords": "Loading " + global_data.table_sell_order_title,
                "processing": "Processing " + global_data.table_sell_order_title,
                "search": "",
                "zeroRecords": "No matching " + global_data.table_sell_order_title + " found"
            },
            "ajax": "<?php echo base_url(); ?>orders/ssp_sell_orders",
            "rowCallback": function (row, data, index) {
//                $('td:eq(5)', row).html(
//                        "<button type='button' class='btn btn-danger' onclick='delete_user_tweet(" + data[5] + ")'><i class='fa fa-trash'></i>"
//                        );
            },
//            "dom": get_dom_plan(),
            // "drawCallback": set_patients_table,
//            "columnDefs": [
//                {"width": "50%", "targets": 0},
//                {"width": "25%", "targets": 1},
//                {"width": "25%", "targets": 2}
//            ]
        });
    });

</script>
