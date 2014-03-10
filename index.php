<?php 
session_start();
error_reporting(E_ALL & ~E_STRICT);
header("Access-Control-Allow-Origin:*");
require_once('config.php');
require_once 'vendor/autoload.php';
require_once('smarty3/Smarty.class.php');
require_once('db.php');
require_once('lib.php');

date_default_timezone_set('Asia/Bangkok');

$app = new \Slim\Slim();

$smarty = new Smarty();
$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');
$smarty->setConfigDir('configs/');
$smarty->setCacheDir('cache/');

$app->post('/feed', function () {
	
	$successCode = $HTTP_POST_VARS[���successcode���];
	
	$payRef = $HTTP_POST_VARS[���PayRef���];
	
	$Ref = $HTTP_POST_VARS[���Ref���];
		
	Echo ���OK���;
	
	$fp = fopen("payment.log", "w+");
	
	If ($successCode = "0") {
		fprintf($fp, "Payment Successful for Order %s, with Reference %s\n", $payRef, $Ref);
	}else{
		fprintf($fp, "Payment Error for Order %s, with Reference %s\n", $payRef, $Ref);
	}
	
	fclose($fp);
});

$app->get("/error", function () {
	$pdo = getDbHandler();
	$sql = "UPDATE `order` SET status = 'declined' WHERE id = :id";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':id' => $_GET['Ref']));
	
	echo "Your credit card didn't work";
});

$app->get("/success", function () {
	//https://aaccu.coop/ecom/success?Ref=13&Ref1=Test%20Name&Ref2=nayana@corp-gems.com&Ref3=1&Ref4=add-ref-00004&Ref5=add-ref-00005
	$pdo = getDbHandler();
	$sql = "UPDATE `order` SET status = 'approved' WHERE id = :id";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':id' => $_GET['Ref']));
	
	$sql = "SELECT * FROM `order` WHERE id = :id ";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':id' => $_GET['Ref']));
	
	$order = $sth->fetch(PDO::FETCH_ASSOC);
	
	$subject = "Your Order with AACCU.COOP";
	$message = sprintf("Your Order %d Has Been Approved, Your credit card was charged Baht %s", $order['id'], number_format($order['amount'], 2));
	
	sendMail($order['email'], $subject, $message);
	
	printf("Your order has been approved, you will receive a confirmation email shortly");
});

$app->get("/cancel", function () {
	
	$pdo = getDbHandler();
	$sql = "UPDATE `order` SET status = 'canceled' WHERE id = :id";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':id' => $_GET['Ref']));
	
	echo "Show Cancel Error Message Here";
});

$app->post('/addorder', function () use ($app) {
	
	$pdo = getDbHandler();
	$sql = "INSERT INTO `order` (product_id, amount, customer_name, email, status, created_date) VALUES (:product_id, :amount, :customer_name, :email, 'pending', now()) ";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':product_id' => $_POST['product_id'], ':amount' => $_POST['amount'], ':customer_name' => $_POST['customer_name'], ':email' => $_POST['email']));
	
	$order_id = $pdo->lastInsertId();
	
	$json = array('order_id' => $order_id);
	
	$app->contentType("application/json");
	echo json_encode($json);
});

$app->get("/product/:product_id", function ($product_id) use ($smarty) {
	$pdo = getDbHandler();
	$sql = "SELECT * FROM product WHERE id = :id ";
	$sth = $pdo->prepare($sql);
	$sth->execute(array(':id' => $product_id));
	
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	
	$smarty->assign('product', $row);
	$smarty->assign('is_donation', 0);
	$smarty->display("payment_form.tpl");
});

if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {

	$app->get('/orders', function () use ($smarty) {
		
		$pdo = getDbHandler();
		$sql = "SELECT * FROM `order` WHERE product_id NOT IN (0, 100)";
		$sth = $pdo->prepare($sql);
		$sth->execute();
		
		$orders = $sth->fetchAll();
		
		$sql = "SELECT * FROM product";
		$sth = $pdo->prepare($sql);
		$sth->execute();
		
		$products = $sth->fetchAll();
		
		$smt_products = array();
		
		foreach ($products as $product) {
			$smt_products[$product['id']] = $product['name'];
		}
		
		$smarty->assign('products', $smt_products);
		$smarty->assign('orders', $orders);
		$smarty->display('orders.tpl');
	});
	
	$app->get('/donations', function () use ($smarty) {
	
		$pdo = getDbHandler();
		$sql = "SELECT * FROM `order` WHERE product_id = 0";
		$sth = $pdo->prepare($sql);
		$sth->execute();
	
		$orders = $sth->fetchAll();
	
		$smarty->assign('orders', $orders);
		$smarty->display('donations.tpl');
	});
	
	$app->get('/dues', function () use ($smarty) {
		
			$pdo = getDbHandler();
			$sql = "SELECT * FROM `order` WHERE product_id = 100";
			$sth = $pdo->prepare($sql);
			$sth->execute();
		
			$orders = $sth->fetchAll();
		
			$smarty->assign('orders', $orders);
			$smarty->display('dues.tpl');
		});
	
	$app->post('/addproduct', function () use ($app) {
		
		$pdo = getDbHandler();
		$sql = "INSERT INTO product (name, price, dollar_price, created_date) VALUES (:name, :price, :dollar_price, NOW())";
		$sth = $pdo->prepare($sql);
		$sth->execute(array(':name' => $_POST['name'], ':price' => $_POST['price'], ':dollar_price' => $_POST['dollar_price']));
		
		$app->redirect('products');
	});
	
	$app->get('/delete/product/:id', function ($id) use ($app) {
		
		$pdo = getDbHandler();
		$sql = "DELETE FROM product WHERE id = :id";
		$sth = $pdo->prepare($sql);
		$sth->execute(array(':id' => $id));
		
		$app->redirect('products');
	});
	
	$app->get('/edit/product/:id', function ($id) use ($smarty) {
		
		$pdo = getDbHandler();
		$sql = "SELECT * FROM product WHERE id = :id";
		$sth = $pdo->prepare($sql);
		$sth->execute(array(':id' => $id));
		
		$product = $sth->fetch(PDO::FETCH_ASSOC);
		$smarty->assign('product', $product);
		$smarty->display('edit_product.tpl');
	});
	
	$app->post('/update/product', function () use ($app) {
		
		$pdo = getDbHandler();
		$sql = "UPDATE product SET name = :name, price = :price, dollar_price = :dollar_price WHERE id = :id ";
		$sth = $pdo->prepare($sql);
		$sth->execute(array(':name' => $_POST['name'], ':price' => $_POST['price'], ':dollar_price' => $_POST['dollar_price'], ':id' => $_POST['id']));

		$app->redirect('products');
	});
	
	$app->get('/products', function () use ($smarty) {
		$pdo = getDbHandler();
		$sql = "SELECT * FROM `product`";
		$sth = $pdo->prepare($sql);
		$sth->execute();
		
		$orders = $sth->fetchAll();
		
		$smarty->assign('products', $orders);
		
		
		$smarty->display('products.tpl');
	});
	
	$app->get('/logout', function () use ($app) {
		session_destroy();
		session_regenerate_id(true);
		$app->redirect('login');
	});
}
	
$app->post('/login', function() use ($app) {
	
	if ($_POST['password'] == 'secret') {
		$_SESSION['auth'] = 1;
		$app->redirect('orders');
		return;
	}
	
	$app->redirect('login');
});


$app->get('/login', function () use ($smarty) {
	$smarty->display('login.tpl');
});

$app->get("/donate", function () use ($smarty) {
	$smarty->assign('is_donation', 1);
	$product = array('id' => 0);
	$smarty->assign('product', $product);
	$smarty->display("payment_form.tpl");
});

$app->get("/due", function () use ($smarty) {
		$smarty->assign('is_donation', 2);
		$product = array('id' => 100);
		$smarty->assign('product', $product);
		$smarty->display("payment_form.tpl");
	});

$app->get("/", function () {
	echo "ACCU ECOM GW 0.1";
});

$app->notFound(function () use ($app, $smarty) {
	$app->redirect(".");
	return true;
});

$app->run();