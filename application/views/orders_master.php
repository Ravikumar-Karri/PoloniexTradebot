
<h3>Open Orders</h3>
<table id="table_buy_order" class="table table-hover table-responsive-lg table-striped">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Exchange</th>
            <th>Coin</th>
            <th>Base Currency</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Cost</th>
            <th>Total</th>
            <th>Age</th>
        </tr>
    </thead>
</table>
<br/>
<br/>
<h3>Open Positions</h3>
<table id="table_sell_order" class="table table-hover table-responsive-lg table-striped">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Exchange</th>
            <th>Coin</th>
            <th>Amount</th>
            <th>Cost</th>
            <th>Total</th>
            <th>Age</th>
            <th>Result</th>
        </tr>
    </thead>
</table>
<br/>
<br/>

<form id="sample_form" class="hidden">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
</form>

<?php $this->view('common'); ?>
