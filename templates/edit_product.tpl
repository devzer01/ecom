{include file='header.tpl'}

{include file='menu.tpl'}


<div class='well'>
<h2>Update Product</h2>
Update the product information and press save
</div>

<form method='post' action='update/product'>

<div class="form-group">
    <label for="name">Product Name</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Product Name" autocomplete="off" value='{$product.name}' required />
</div>

<div class="form-group">
    <label for="price">Bhat Amount</label>
    <input type="text" class="form-control" id="amount" name="price" placeholder="Bhat Amount" autocomplete="off" value='{$product.price}' required />
</div>

<div class="form-group">
    <label for="dollar_price">Dollar Amount</label>
    <input type="text" class="form-control" id="dollar_amount" name="dollar_price" placeholder="Dollar Amount" autocomplete="off" value='{$product.dollar_price}' required />
</div>

<input type='hidden' name='id' value='{$product.id}' />
<button id='submitButton' type="submit" name="Post" class="btn btn-primary btn-lg" value='Submit'>Save</button>

</form>

{include file='footer.tpl'}