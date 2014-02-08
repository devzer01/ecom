{include file='header.tpl'}

<div class='well'>
<h2>Login to ECOM Backend</h2>
Please use the password provided to login to system backend.
</div>

<form method='post' action='login'>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required />
</div>

<button id='submitButton' type="submit" name="Post" class="btn btn-primary btn-lg" value='Submit'>Login</button>

</form>

{include file='footer.tpl'}