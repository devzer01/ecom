{include file='header.tpl'}

{include file='menu.tpl'}

<div class='well'>
<h2>Orders</h2>
List of orders that have been placed through the system.
</div>

<table class="table table-striped">
  <tr>
  	<td>Order Id</td>
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