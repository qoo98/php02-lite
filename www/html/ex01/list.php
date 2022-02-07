<?php
require_once('functions.php');

$pdo = connectDB();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得
    
    $sql = 'SELECT * FROM images ORDER BY created_at DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $images = $stmt->fetchAll();

}
else{
    if (!empty($_FILES['image']['name'])) {

        $url = $_POST['url'];
        $list = array("url" => $url);
        header("Content-type: application/json; charset=UTF-8");
        echo json_encode($list);

        $name = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $content = file_get_contents($_FILES['image']['tmp_name']);

                
                $updir = "./movie";
                $tmp_file = $_FILES['image']['tmp_name'];
                $copy_file = date("YmdHis") . $name;
                $path_file = $updir . "/" . $copy_file;
                if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                move_uploaded_file($tmp_file,"$updir/$copy_file");

            // 画像を保存
            $sql = 'INSERT INTO images(image_url, image_type, image_content, created_at)
                            VALUES (:image_url, :image_type, :image_content, now())';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':image_url', $name, PDO::PARAM_STR);
                    $stmt->bindValue(':image_type', $type, PDO::PARAM_STR);
                    $stmt->bindValue(':image_content', $content, PDO::PARAM_STR);
            
                    $stmt->execute();
        }

    }
    header('Location:list.php');
    exit();

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Image Test</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>
<div id="attachment">
    <form method="post" action="" enctype="multipart/form-data">
        <label>
            <input type="file" onchange="changeFile(this);" name="input_file"  class="fileinput" accept="image/*" id="src_img"/>Upload!
        </label>
    </form>
</div>
<div id="file_viewer"></div>
<script>

function changeFile(){
    setTimeout(function () {
    location.reload();
  }
    , 300);
}



</script>
<div class="container mt-5">
    <ul class="list-unstyled">
        <?php for($i = 0; $i < count($images); $i++): ?>
        <li class="media mt-5">
            <img src="image.php?id=<?= $images[$i]['image_id']; ?>" width="300" height="auto" class="mr-3">
        </li>
        <?php endfor; ?>
    </ul>
</div>

<script src="./script/simple.js"></script>

<style>
    #attachment label {
 /* ボタン部分の見た目（任意） */
 background: lightskyblue;
 color: white;
 font-size: 16px;
 padding: 10px 18px;
 border-radius: 4px;
 width: 100%;
 text-align: center;
}

#attachment label input {
 /* 今回のポイント */
 position: absolute;
 left:0;
 top:0;
 opacity: 0;
 width: 100%;
 height: 50px;
 cursor: pointer;
}
#attachment .filename {
 font-weight: 16px;
 margin:0 0 0 10px;
}
</style>
</body>
</html>
