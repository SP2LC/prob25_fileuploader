<!DOCTYPE HTML>
<html>
<head>
<title>問題アップローダー</title>
<script type="text/javascript" src="resources/menu.js"></script>
<link rel="stylesheet" href="resources/main.css" type="text/css">
<link rel="stylesheet" href="resources/menu.css" type="text/css">
</head>
<body>
<h1>Problem(25) Uploader</h1>
<div class="menus">
<div class="menu_on">
 <div class="menuitem" onclick="doToggleClassName(getParentObj(this),'menu_on','menu_off')">メニュー</div>
 <ul>
  <li><a href="add.html">追加</a></li>
 </ul>
</div>

</div>
<div class="list">
問題一覧
<table border=6 width=800 align=center>
<tr>
<th>問題ID</th>
<th>画像名</th>
<th>分割数</th>
<th>選択コスト</th>
<th>交換コスト</th>
<th>最大選択回数</th>
<th>削除</th>
</tr>
<?php
  include "show.php";
  main();
?>
</table>
</div>
</body>
</html>
