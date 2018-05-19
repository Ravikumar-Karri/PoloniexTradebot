<?php echo form_open('', array("id" => "form_trade_limits", "class" => "form-horizontal")); ?>
    <div class="form-group">
        <label class="control-label col-sm-6">Total allowable trading amount:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="trade_limit" id="trade_limit" placeholder="Enter Total allowable trading amount">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-6">Maximum Amount:</label>
        <div class="col-sm-10"> 
            <input type="text" class="form-control" name="max_amount" id="max_amount" placeholder="Enter Maximum Amount">
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-6">Minimum Amount:</label>
        <div class="col-sm-10"> 
            <input type="text" class="form-control" name="min_amount" id="min_amount" placeholder="Enter Minimum Amount">
        </div>
    </div>
    
    <div class="form-group"> 
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" id="btn_save_trade_limits" class="btn btn-success">Save</button>
        </div>
    </div>
    
</form>
<br/>
<br/>

<?php $this->view('common'); ?>