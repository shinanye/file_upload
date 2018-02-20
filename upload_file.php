<?php
$configContext = file_get_contents("config/upload_file.txt");

$error = $_FILES["file"]["error"];
//0:表示没有发生错误。
//1:表示上载文件的大小超出了约定值。文件大小的最大值是PHP配置文件中指定的，该指令是upload_max_filesize。
//2:表示上载文件大小超出了HTML表单的MAX_FILE_SIZE元素所指定的最大值。
//3:表示文件只被部分上载。
//4:表示没有上载任何文件。

$type = $_FILES["file"]["type"];
$configValueList = getConfigTypeArr("img");
if($error==0){
    //判断文件上传类型 1、判断if($type="img/png"||$type="img/jpg") 2、正则表达式  2、配置文件
}else{
    echo "nihel";
    echo "<script>alert('文件错误');location.href='upload_file.html'</script>";
}
if(is_array($configValueList)){
   if(in_array($type,$configValueList)){
        if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
            echo '已经上传到临时文件夹';
            $filename = "upload".date("Ymd-His").".png";
            //移动上传文件(将文件移动到指定文件夹)
            if (!move_uploaded_file($_FILES["file"]["tmp_name"],"img/".$filename)) {
                echo "<script>alert('移动失败');location.href='upload_file.html'</script>";
                exit;
            }else{
                echo "<br>";
                echo "移动成功";
            }
        } else {
            echo "<script>alert('临时文件不存在');location.href='upload_file.html'</script>";
        }
   }else{
       echo "<script>alert('配置文件中没有该文件类型');location.href='upload_file.html'</script>";
   }
}else{
    echo "<script>alert('添加上传文件类型');location.href='upload_file.html'</script>";
}

function getConfigTypeArr($type){
    global $configContext;
    $arr = explode("\n",$configContext);
    foreach($arr as $items){
        $itemArr = explode(":",$items);
        $itemType = $itemArr[0];
        $itemValue = $itemArr[1];
        if($type==$itemType){
            $itemValueArr = explode(",",$itemValue);
            return $itemValueArr;
        }
    }
    return false;
}