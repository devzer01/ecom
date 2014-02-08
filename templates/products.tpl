{include file='header.tpl'}

{include file='menu.tpl'}

<div class='well'>
<h2>Products</h2>
Configure the products in the system
</div>

<table class="table table-striped">
  <tr>
  	<td>Product Id</td>
  	<td>Product Name</td>
  	<td>Bhat Amount</td>
  	<td>Dollar Amount</td>
  	<td>Date</td>
  </tr>
  
  {foreach from=$products item=product}
  	<tr>
	  	<td>{$product.id}</td>
	  	<td>{$product.name}</td>
	  	<td>{$product.price}</td>
	  	<td>{$product.dollar_price}</td>
	  	<td>{$product.created_date}</td>
  	</tr>
  {/foreach}
</table>

<form method='post' action='addproduct'>

<div class="form-group">
    <label for="name">Product Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Product Name" autocomplete="off" required />
</div>

<div class="form-group">
    <label for="price">Bhat Amount</label>
    <input type="text" class="form-control" id="amount" name="price" placeholder="Bhat Amount" autocomplete="off" required />
</div>

<div class="form-group">
    <label for="dollar_price">Dollar Amount</label>
    <input type="text" class="form-control" id="dollar_amount" name="dollar_price" placeholder="Dollar Amount" autocomplete="off" required />
</div>


<button id='submitButton' type="submit" name="Post" class="btn btn-primary btn-lg" value='Submit'>Add Product</button>

</form>


{include file='footer.tpl'}