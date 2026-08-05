<?php require __DIR__.'/../includes/bootstrap.php';
$raw=file_get_contents('php://input')?:''; $received=(string)($_SERVER['HTTP_X_RAZORPAY_SIGNATURE']??''); $expected=hash_hmac('sha256',$raw,$config['razorpay']['webhook_secret']);
if(!hash_equals($expected,$received)){http_response_code(400);exit('Invalid signature');}
$event=json_decode($raw,true); $type=$event['event']??''; $payment=$event['payload']['payment']['entity']??[]; $orderId=$payment['order_id']??''; $paymentId=$payment['id']??'';
if($type==='payment.captured'&&$orderId&&$paymentId){$pdo=db();$stmt=$pdo->prepare('SELECT id,amount_paise FROM orders WHERE razorpay_order_id=?');$stmt->execute([$orderId]);$order=$stmt->fetch();if($order){$pdo->prepare("UPDATE orders SET status='paid' WHERE id=?")->execute([$order['id']]);$pdo->prepare("INSERT INTO payments(order_id,razorpay_payment_id,amount_paise,status) VALUES(?,?,?,'captured') ON DUPLICATE KEY UPDATE status='captured'")->execute([$order['id'],$paymentId,$order['amount_paise']]);}}
http_response_code(200); echo 'ok';

