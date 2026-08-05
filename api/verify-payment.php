<?php require __DIR__.'/../includes/bootstrap.php';
if(!is_post()) json_response(['error'=>'Method not allowed'],405); verify_csrf();
$orderId=(string)($_POST['razorpay_order_id']??''); $paymentId=(string)($_POST['razorpay_payment_id']??''); $signature=(string)($_POST['razorpay_signature']??'');
$stmt=db()->prepare('SELECT * FROM orders WHERE razorpay_order_id=? LIMIT 1'); $stmt->execute([$orderId]); $order=$stmt->fetch(); if(!$order) json_response(['error'=>'Order not found.'],404);
$expected=hash_hmac('sha256',$order['razorpay_order_id'].'|'.$paymentId,$config['razorpay']['key_secret']);
if(!hash_equals($expected,$signature)) { db()->prepare("UPDATE orders SET status='failed' WHERE id=?")->execute([$order['id']]); json_response(['error'=>'Payment verification failed.'],400); }
$pdo=db(); $pdo->beginTransaction(); try { $pdo->prepare("UPDATE orders SET status='paid' WHERE id=?")->execute([$order['id']]); $pdo->prepare("INSERT INTO payments(order_id,razorpay_payment_id,razorpay_signature,amount_paise,status) VALUES(?,?,?,?, 'verified')")->execute([$order['id'],$paymentId,$signature,$order['amount_paise']]); $pdo->commit(); } catch(Throwable $e){$pdo->rollBack(); throw $e;}
json_response(['success'=>true,'order_ref'=>$order['order_ref']]);

