<?php
$construct3 = "SELECT * FROM document3 WHERE
						(id+3000 LIKE '%$search3%'
						OR firstname LIKE '%$search3%'
						OR lastname LIKE '%$search3%'
						OR license LIKE '%$search3%')"; 
$run3 = mysql_query($construct3);
?>