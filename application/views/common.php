
<?php echo form_open('', array("id" => "sample_form", "class" => "form-horizontal hidden")); ?>
    <input type="hidden" name="id" id="id"/>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
</form>

<div id="modal_success" class="modal fade" role="dialog" style="z-index: 2056 !important;">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title">Operatrion Successful</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-success">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme btn-alt-theme" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_error" class="modal fade" role="dialog" style="z-index: 2056 !important;">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
<!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <h4 class="modal-title">Operatrion Failed</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-theme btn-alt-theme" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    global_data = {};
    base = "<?php echo base_url(); ?>";


    function IsJsonString(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    }

    function success(msg) {
        $("#modal_success").find(".alert-success").html(msg);
        view("modal_success");
    }

    function error(msg) {
        $("#modal_error").find(".alert-danger").html(msg);
        view("modal_error");
    }

    function view(modal_id) {
        setTimeout(function () {
            $("#" + modal_id).modal("show");
        }, 1000);
    }
</script>