<?php session_start(); 
function asMoney($value) {
  return number_format($value, 2);
}

?>

{{HTML::script('media/jquery-1.8.0.min.js') }}

@extends('layouts.erp')

<script type="text/javascript">
$(document).ready(function() {
  
    $('#invoice').change(function(){
     
        $.get("{{ url('api/totalsales')}}",
        { option: $(this).val() }, 
        function(data) {
          console.log('hi');
                $('#amountdue').val(data);
            });
        });
   });
</script>


{{ HTML::style('jquery-ui-1.11.4.custom/jquery-ui.css') }}
{{ HTML::script('jquery-ui-1.11.4.custom/jquery-ui.js') }}

<script type="text/javascript">
$(document).ready(function(){
$('#description').hide();

$('#item').change(function(){
if($(this).val()){
    $('#sup').show();
}else if($(this).val() == "EXPENSE"){
    $('#expensecategory').show();
    $('#assetcategory').hide();
    $('#liabilitycategory').hide();
    $('#incomecategory').hide();
    $('#assetcat').val('');
    $('#liabilitycat').val('');
    $('#incomecat').val('');
}else if($(this).val() == "LIABILITY"){
    $('#liabilitycategory').show();
    $('#assetcategory').hide();
    $('#expensecategory').hide();
    $('#incomecategory').hide();
    $('#assetcat').val('');
    $('#expensecat').val('');
    $('#incomecat').val('');
}else if($(this).val() == "INCOME"){
    $('#incomecategory').show();
    $('#assetcategory').hide();
    $('#expensecategory').hide();
    $('#liabilitycategory').hide();
    $('#assetcat').val('');
    $('#expensecat').val('');
    $('#liabilitycat').val('');
}else{
    $('#assetcategory').hide();
    $('#expensecategory').hide();
    $('#liabilitycategory').hide(); 
    $('#incomecategory').hide(); 
    $('#assetcat').val('');
    $('#expensecat').val('');
    $('#liabilitycat').val('');
    $('#incomecat').val('');
}

});
});
</script>

<script>
  $(document).ready(function(){
    $('#order').change(function(){
        $.get("{{ url('api/salesdropdown')}}", 
        { option: $(this).val() }, 
        function(data) {
            $('#invoice').empty(); 
            $('#invoice').append("<option>----------------Select Invoice--------------------</option>");
            for (var i = 0; i < data.length; i++) {
            $('#invoice').append("<option value='" + data[i].id +"'>" + data[i].erporder + "</option>");
            };
        });
    });
});
</script>

@section('content')

<br><div class="row">
  <div class="col-lg-12">
  <h4>Receivable Payments Details</h4>
<hr>
</div>  
</div>


<div class="row">
  <div class="col-lg-5">

    
    
     @if ($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>        
            @endforeach
        </div>
        @endif

     <form method="POST" action="{{{ URL::to('payments') }}}" accept-charset="UTF-8">
   
    <font color="red"><i>All fields marked with * are mandatory</i></font>
    <fieldset>
      
        
            <div class="form-group">
            <label for="username">Client Name</label><span style="color:red">*</span> :
           <select name="order" id="order" class="form-control" required>
                           <option></option>
                           <option>..................................Select Client....................................</option>
                           @foreach($clients as $client)
                          @if($client->type == 'Customer')
                        <option value="{{$client->id}}">{{$client->name}}</option>
                      @endif
                    @endforeach
                </select>
          </div>

        <input type="hidden" name="type" value="Customer">

          <div class="form-group">
                        <label for="username">Select Invoice <span style="color:red">*</span> :</label>
                        <select required="" name="invoice" id="invoice" class="form-control">
                            <option></option>
                        </select>
                
              </div>
          
        <div class="form-group">
        <label for="username">Amount Due <span style="color:red">*</span> :</label> 
          <div class="input-group">
            <span class="input-group-addon">KES</span>
            <input required type="text" class="form-control"  name="amountdue" id="amountdue" value= '{{asMoney(0.00)}}'> 
        </div>
      </div>

        <!--<div class="form-group">
            <label for="username">Payment Amount<span style="color:red">*</span> :</label>
            <input class="form-control" placeholder="" type="text" name="amount" id="amount" value="{{{ Input::old('amount') }}}" required>
        </div>-->

        <div class="form-group">
            
            <input class="form-control" placeholder="" type="hidden" name="credit_account" id="credit_account" value="2">
        </div>



         <div class="form-group">
            
            <input class="form-control" placeholder="" type="hidden" name="description" id="description" value="{{{ Input::old('description') }}}">
        </div>

        

      <hr>



        <div class="form-group">
            <label for="username">Payment Method</label><span style="color:red">*</span> :
           <select name="paymentmethod" class="form-control" required>
                          <option></option>
                           <option>......................Select Payment Method......................</option>
                           @foreach($paymentmethods as $paymentmethod)
                            <option value="{{$paymentmethod->id}}">{{$paymentmethod->name}}</option>
                           @endforeach
                        </select>
        </div> 

        <div class="form-group" id="description">
            <label for="username">Describe Payment Method</label>
            <textarea name="description" id="description" class="form-control"> </textarea>
        </div>


        <div class="form-group">
            <label for="username">Account</label><span style="color:red">*</span> :
           <select name="account" class="form-control" required>
                          <option></option>>
                           <option>...............................Select Account...........................</option>
                           @foreach($accounts as $account)
                            <option value="{{$account->id}}">{{$account->name}}</option>
                           @endforeach
                        </select>
        </div>       

        
            <input class="form-control" placeholder="" type="hidden" readonly="readonly" name="received_by" id="received_by" value="{{{ Confide::user()->username}}}">
        
         <div class="form-group">
                        <label for="username">Date</label>
                        <div class="right-inner-addon ">
                        <i class="glyphicon glyphicon-calendar"></i>
                        <input class="form-control datepicker"  readonly="readonly" placeholder="" type="text" name="pay_date" id="pay_date" value="{{date('d-M-Y')}}" required>
                        </div>
          </div>



          
        <div class="form-actions form-group">
        
          <button type="submit" class="btn btn-primary btn-sm">Accept Payment</button>
        </div>

    </fieldset>
</form>
    

  </div>

</div>

@stop