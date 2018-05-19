
<script>
    $(document).ready(function () {
        $("#li_trade_limits").addClass("active");
        
        get_dash_info();
        
        $("#btn_save_trade_limits").on("click", function () {
            url = base + "trade_limits/update_trade_limits";
            data = $("#form_trade_limits").serialize();

            $.post({
                url: url,
                data: data
            }).done(function (response) {
                if (IsJsonString(response)) {
                    data = JSON.parse(response);
                    if (data == true) {
                        success("Trade limits saved successfully");
                    } else {
                        error(data);
                    }
                }
            });
        });

    });
    
    function get_dash_info() {
        $.post({
            url: base + "trade_limits/get_dash_info",
            data: $("#sample_form").serialize()
        }).done(function (response) {
            if (IsJsonString(response)) {
                data = JSON.parse(response);
                form = $("#form_trade_limits");
                form.find("#trade_limit").val(data.trade_limit);
                form.find("#max_amount").val(data.max_amount);
                form.find("#min_amount").val(data.min_amount);
            }
        });
    }

</script>