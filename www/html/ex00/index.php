<?php
require_once('config.php');

session_start();
$_SESSION['username'] ="";
$_SESSION['message'] ="";

try{
    $db = new PDO(DSN, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo $e->getMessage();
    }

if(isset($_POST["send"])) {
    $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES);
}


if(!empty($username)) {
   $_SESSION['username'] = $username;
   }
   
if(!empty($message)) {
  $_SESSION['message'] = $message;
  }

$time = date('Y-m-d H:i:s');

//$stmt = $db->prepare("insert into tb1(username, message, time) value(?, ?, ?)");
//$stmt->execute([$username, $message, $time]);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$db->query("insert into tb1(id, username,message,time) values(null,'$username','$message','$time')");
}

$stmt = $db->prepare('select * from tb1 order by id desc');
$stmt->execute();
$loopcount = $stmt->rowCount();

$db = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   header("Location: /ex00/");
   exit;
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>掲示板</title>
</head>

<body>
<h1>掲示板</h1>
   

   
   <form action="" method="post">
<p>message:</p>
<input type="text" name="message" value="<?php if( !empty($_SESSION['message']) ){ echo $_SESSION['message']; } ?>">
<p>user:</p>
<input type="text" name="username" value="<?php if( !empty($_SESSION['username']) ){ echo $_SESSION['username']; } ?>">
<input type="submit" name="send" value="投稿">
<br><br>
</form>

<h2>投稿一覧
    <?php echo "(${loopcount}件)"; ?>
</h2>
<ul>
<?php $count = 0;?>
<?php foreach($stmt as $loop) {?>
        <li><?php echo "${loop['message']} (${loop['username']}) -   ${loop['time']}<br>"?></li>
        <?php $count = $count + 1;}?>
<?php if($count == 0) {
    echo "まだ投稿はありません";
}?>
</ul>
</body>
</html>
