<?php

if(!is_dir("./files")) mkdir("./files", 0755); 
//$_FILES['Filedata']['name'] = iconv(“UTF-8″,”GB2312″,$_FILES[$upload_name]['name']);
$file_name = $_FILES['Filedata']['name'];
$file_name = iconv("UTF-8","GB2312",$file_name);
move_uploaded_file($_FILES['Filedata']['tmp_name'], "./files/".$file_name);

?>
