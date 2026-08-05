<?php require __DIR__.'/../includes/bootstrap.php';
if(!is_post()) json_response(['error'=>'Method not allowed'],405); verify_csrf();
$name=trim((string)($_POST['name']??'')); $email=filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL); $phone=trim((string)($_POST['phone']??'')); $type=(string)($_POST['payment_type']??''); $slug=(string)($_POST['package']??'');
if($name===''||!$email||$phone===''||!in_array($type,['full','deposit','quote'],true)) json_response(['error'=>'Invalid customer or payment details.'],422);
if($type==='quote') { $amountRupees=(int)($_POST['quote_amount']??0); if($amountRupees<1000||$amountRupees>10000000) json_response(['error'=>'Enter a valid approved quote amount.'],422); $amount=$amountRupees*100; $packageName='Custom Website Quote'; $slug='custom'; $notes=trim((string)($_POST['quote_ref']??'')); if($notes==='') json_response(['error'=>'Quote reference is required.'],422); }
else { if(!isset($packages[$slug])) json_response(['error'=>'Invalid package.'],422); $packageName=$packages[$slug]['name']; $amount=$type==='deposit'?$packages[$slug]['deposit']:$packages[$slug]['price']; $notes=null; }
$ref='RDA-'.date('ymd').'-'.strtoupper(bin2hex(random_bytes(3))); $pdo=db();
$stmt=$pdo->prepare('INSERT INTO orders(order_ref,customer_name,customer_email,customer_phone,package_slug,package_name,payment_type,amount_paise,notes) VALUES(?,?,?,?,?,?,?,?,?)');
$stmt->execute([$ref,$name,$email,$phone,$slug,$packageName,$type,$amount,$notes]); $localId=(int)$pdo->lastInsertId();
$payload=json_encode(['amount'=>$amount,'currency'=>'INR','receipt'=>$ref,'notes'=>['local_order_id'=>(string)$localId,'customer_email'=>(string)$email]]);
$ch=curl_init('https://api.razorpay.com/v1/orders'); curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_POST=>true,CURLOPT_POSTFIELDS=>$payload,CURLOPT_HTTPHEADER=>['Content-Type: application/json'],CURLOPT_USERPWD=>$config['razorpay']['key_id'].':'.$config['razorpay']['key_secret'],CURLOPT_TIMEOUT=>20]); $body=curl_exec($ch); $code=(int)curl_getinfo($ch,CURLINFO_HTTP_CODE); $curlError=curl_error($ch); curl_close($ch);
$rzp=json_decode((string)$body,true); if($code<200||$code>=300||empty($rzp['id'])) { $pdo->prepare("UPDATE orders SET status='failed' WHERE id=?")->execute([$localId]); error_log('Razorpay order error: '.$curlError.' '.(string)$body); json_response(['error'=>'Could not start payment. Please try again.'],502); }
$pdo->prepare('UPDATE orders SET razorpay_order_id=? WHERE id=?')->execute([$rzp['id'],$localId]);
json_response(['key'=>$config['razorpay']['key_id'],'order_id'=>$rzp['id'],'amount'=>$amount,'currency'=>'INR','name'=>'Reliance Digital Agency','description'=>$packageName.' - '.ucfirst($type),'prefill'=>['name'=>$name,'email'=>$email,'contact'=>$phone]]);

