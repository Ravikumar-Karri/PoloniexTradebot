
<script>
    $(document).ready(function () {

        $("#li_triggers").addClass("active");

        get_dash_info();

        $("#btn_sell_triggers").on("click", function () {
            url = base + "triggers/sell_triggers";
            data = $("#form_sell_triggers").serialize();

            $.post({
                url: url,
                data: data
            }).done(function (response) {
                if (IsJsonString(response)) {
                    data = JSON.parse(response);
                    if (data == true) {
//                        $("#form_sell_triggers")[0].reset();
                        success("Sell Trigger Updated Successfully.");
                    } else {
                        error(data);
                    }
                }
            });
        });
    });

    function get_dash_info() {
        $.post({
            url: base + "triggers/get_dash_info",
            data: $("#sample_form").serialize()
        }).done(function (response) {
            if (IsJsonString(response)) {
                data = JSON.parse(response);
                form = $("#form_sell_triggers");
                form.find("#profit_target").val(data.profit_target);
                form.find("#stop_loss").val(data.stop_loss);
                form.find("#tsl_arm").val(data.tsl_arm);
                form.find("#tsl").val(data.tsl);
            }
        });
    }

</script>