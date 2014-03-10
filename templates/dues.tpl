{include file='header.tpl'}

{include file='menu.tpl'}

<div class='well'>
<h2>Dues</h2>
List of dues that have been placed through the system. <br/>

URL to accept donations is {$smarty.const.BASE_URL}due/

</div>

<table class="table table-striped">
  <tr>
  	<td>Dues Id</td>
  	<td>Customer Name</td>
  	<td>Email</td>
  	<td>Total</td>
  	<td>Date</td>
  	<td>Status</td>
  </tr>
  
  {foreach from=$orders item=order}
  	<tr>
	  	<td>{$order.id}</td>
	  	<td>{$order.customer_name}</td>
	  	<td>{$order.email}</td>
	  	<td>{$order.amount}</td>
	  	<td>{$order.created_date}</td>
	  	<td>{$order.status}</td>
  	</tr>
  {/foreach}
</table>

{include file='footer.tpl'}