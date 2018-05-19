<p>
<?php echo form_open('', array("id" => "form_sell_triggers", "class" => "form-horizontal")); ?>
    <div class="form-group">
        <label class="control-label col-sm-2">Profit Target:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="profit_target" name="profit_target" placeholder="Enter Profit Target">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Stop Loss:</label>
        <div class="col-sm-10"> 
            <input type="text" class="form-control" id="stop_loss" name="stop_loss" placeholder="Enter Stop Loss">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">TSL Arm:</label>
        <div class="col-sm-10"> 
            <input type="text" class="form-control" id="tsl_arm" name="tsl_arm" placeholder="Enter TSL Arm">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">TSL:</label>
        <div class="col-sm-10"> 
            <input type="text" class="form-control" id="tsl" name="tsl" placeholder="Enter TSL">
        </div>
    </div>
    <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" id="btn_sell_triggers" class="btn btn-success">Submit</button>
        </div>
    </div>
</form>
<br/>
<br/>


<?php $this->view('common'); ?>