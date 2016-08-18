<?
if (file_exists('./templates/Default/'))
foreach (glob('./templates/Default/*') as $file)
unlink($file);
?>