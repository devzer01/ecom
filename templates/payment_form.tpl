{if $smarty.const.SANDBOX}
<form name="payFormCcard" method="post" action="{$smarty.const.TEST}">
{else}
<form name="payFormCcard" method="post" action="{$smarty.const.PRODUCTION}">
{/if}

<input type="hidden" name="merchantId" value="{$smarty.const.MERCHANT_ID}">

{if $product.is_donation eq "1"}
	<input type="text" name="amount" value="0" />
{else}
	<input type="hidden" name="amount" value="{$product.amount}" /> 
{/if}

<input type="hidden" name="orderRef" value="{$order.id}">

<input type="hidden" name="currCode" value="344" > 

<input type="hidden" name="successUrl" value="{$smarty.const.URL_SUCCESS}">

<input type="hidden" name="failUrl" value="{$smarty.const.URL_FAIL}"> 

<input type="hidden" name="cancelUrl" value="{$smarty.const.URL_CANCEL}">

<input type="hidden" name="payType" value="N"> 

<input type="hidden" name="lang" value="E"> 

<input type="hidden" name="remark" value="-"> 

<input type="hidden" name="redirect" value="30"> 

<input type="hidden" name="orderRef1" value="add-ref-00001"> 

<input type="hidden" name="orderRef2" value="add-ref-00002"> 

<input type="hidden" name="orderRef3" value="add-ref-00003"> 

<input type="hidden" name="orderRef4" value="add-ref-00004"> 

<input type="hidden" name="orderRef5" value="add-ref-00005"> 
 

<input type="submit" name="submit"> 

</form>