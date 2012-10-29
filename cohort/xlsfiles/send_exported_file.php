<?php
header('Content-type: application/zip');
header('Content-Disposition: attachment; filename="database.zip"');
$file = fopen("database.zip","rb");
if ($file) {
  while(!feof($file)) {
    print(fread($file, 1024*8));
    flush();
    if (connection_status()!=0) {
      fclose($file);
      die();
    }
  }
  fclose($file);
}
//readfile('database.zip');
?> 
<script>
location.href = "../index.php";
</script>