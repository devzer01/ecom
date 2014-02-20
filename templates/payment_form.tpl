{include file='header.tpl'}

<div class='well'>
<h2>Customer Information</h2>

Please enter your name, email address. <br/>
{if $is_donation eq "1"}
Verify your donation amount <br/>
{else}
Then verify the total order amount is correct. <br/>
{/if}
Then press the Submit button 

</div>

{if $smarty.const.SANDBOX}
<form id="paymentForm" method="post" action="{$smarty.const.TEST}">
{else}
<form id="paymentForm" method="post" action="{$smarty.const.PRODUCTION}">
{/if}

<input type="hidden" name="merchantId" value="{$smarty.const.MERCHANT_ID}">

<div class="form-group">
    <label for="orderRef1">Customer Name:</label>
    <input type="text" class="form-control" id="customer_name" name="orderRef1" placeholder="Customer Name" autocomplete="off" required />
</div>

<div class="form-group">
    <label for="orderRef2">Email Address:</label>
    <input type="text" class="form-control" id="email_address" name="orderRef2" placeholder="Email Address" autocomplete="off" required />
</div>  

{if $is_donation eq "1"}
<div class="form-group">
    <label for="amount2">Product Name:</label>
    Donation
</div>  	
<div class="form-group">
    <label for="amount">Donation Amount (Bhat):</label>
    <input type="text" class="form-control" id="amount" name="amount" placeholder="Donation Amount" autocomplete="off" required />
</div>  
{else}
<div class="form-group">
    <label for="amount2">Product Name:</label>
    {$product.name}
</div>  	
<div class="form-group">
    <label for="amount">Order Total (Bhat):</label>
    {{$product.price_dollar}}
    <input type="hidden" id='amount' name="amount" value="{$product.price_dollar}" />
</div>  		 
{/if}

<input type="hidden" id='order_id' name="orderRef" value="">

<input type="hidden" name="currCode" value="840" > 

<input type="hidden" name="successUrl" value="{$smarty.const.URL_SUCCESS}">

<input type="hidden" name="failUrl" value="{$smarty.const.URL_FAIL}"> 

<input type="hidden" name="cancelUrl" value="{$smarty.const.URL_CANCEL}">

<input type="hidden" name="payType" value="N"> 

<input type="hidden" name="lang" value="E"> 

<input type="hidden" name="remark" value="-"> 

<input type="hidden" name="redirect" value="30"> 

<input type="hidden" id='product_id' name="orderRef3" value="{$product.id}"> 

<input type="hidden" name="orderRef4" value="add-ref-00004"> 

<input type="hidden" name="orderRef5" value="add-ref-00005"> 
 

<button id='submitButton' type="button" name="Post" class="btn btn-primary btn-lg" value='Submit'>Submit</button> 

</form>

<script type='text/javascript'>
	$(document).ready(function () {
		$("#submitButton").click(function (e) {
			e.preventDefault();
			
			var attr = {};
			attr.url = 'addorder';
			attr.type = 'post';
			attr.data = { 'customer_name': $("#customer_name").val(), 
						  'email' : $("#email_address").val(), 
						  'product_id' : $("#product_id").val(),
						  'amount' : $("#amount").val() };
			attr.dataType = 'json';
			attr.success = function (json) {
				var order_id = json.order_id;
				$("#order_id").val(order_id);
				$("#paymentForm").submit();
			};
			
			$.ajax(attr);
			
		});
	});
</script>

{include file='footer.tpl'}