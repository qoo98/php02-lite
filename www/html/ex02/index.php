<?php
  $max = 5; //コンテンツの最大数
  $page = 1;
  $pageRange = 2;
$totalPage = 4;

$prev = max($page - 1, 1);
$next = min($page + 1, $totalPage);


// $startと$endはドット前後に最初と最後のページ番号リンクを表示するので、繰り上げ/繰り下げ
$nums = []; // ページ番号格納用
$start = max($page - $pageRange, 2); // ページ番号始点
$end = min($page + $pageRange, $totalPage - 1); // ページ番号終点

if ($page === 1) { // １ページ目の場合
  $end = $pageRange * 2; // 終点再計算
}

// ページ番号格納
for ($i = $start; $i <= $end; $i++) {
  $nums[] = $i;
}


 



  $contents = array();

  for ($i = 0; $i < 18; $i++) {
    $contents[] = ($i+1) . '個目のコンテンツ';
  }

  $contents_sum = count($contents); //コンテンツの総数
  $max_page = ceil($contents_sum / $max); //ページの最大値

  if (!isset($_GET['page'])) {
    $page = 1;
  } else {
    $page = $_GET['page'];
  }

  $start = $max * ($page - 1); //スタートするページを取得
  $view_page = array_slice($contents, $start, $max, true); //表示するページを取得

 ?>

 <!DOCTYPE html>
 <html lang="ja" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>ページング</title>
   </head>
   <body>
     <!-- コンテンツを表示 -->
     <?php
     foreach ($view_page as $value) {
       echo $value . '<br />';
     }
      ?>
      <!-- ページ移動 -->
    <?php  if ($page > 1): ?>
      <a href="index.php?page=<?php echo ($page-1); ?>">前のページへ</a>
    <?php endif; ?>

<?php print '<a href="?page=1">1</a>';?>

<?php foreach ($nums as $num) {
   
  // 現在地のページ番号
  if ($num === $page) {
    print '<span class="current">' . $num . '</span>';
  } else {
    // ページ番号リンク表示
    print '<a href="?page='. $num .'" class="num">' . $num . '</a>';
  }

} ?>



    <?php  if ($page < $max_page): ?>
      <a href="index.php?page=<?php echo ($page+1); ?>">次のページへ</a>
    <?php endif; ?>

   </body>
 </html>
