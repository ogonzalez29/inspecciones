<?php
$construct = "SELECT * FROM document WHERE
						(id+1000 LIKE '%$search%'
						OR firstname LIKE '%$search%'
						OR lastname LIKE '%$search%'
						OR license LIKE '%$search%'
						OR ordernumber LIKE '%$search%')"; 
$run = mysql_query($construct);
?>