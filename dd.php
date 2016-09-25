<?Php
@$cat_id=$_GET['category'];
//$make_id=2;
/// Preventing injection attack //// 
if(!ctype_alnum($cat_id)){
echo "Data Error";
exit;
 }
/// end of checking injection attack ////
require "connect_db.php";

$sql="select subcategory,subcate_id from subcategory where category='$cat_id'";
$row=$dbo->prepare($sql);
$row->execute();
$result=$row->fetchAll(PDO::FETCH_ASSOC);

$main = array('data'=>$result);
echo json_encode($main);
?>