<?php
// Function For Pagination
function pagination($query,$recordsperpage)
{
        $db=mysqli_connect('localhost','root','','rportal');
        $GLOBALS['page']=(isset($_GET['page'])&& $_GET['page']>0)?(int)$_GET['page']:1;
        $perpage=$recordsperpage;
        $page=$GLOBALS['page'];
        $limit=($page>1)?($page*$perpage)-$perpage:0;
        $newQuery=$query." LIMIT {$limit},{$perpage}";
        
        $query=mysqli_query($db,"$newQuery");
        $GLOBALS['records']=mysqli_fetch_all($query);

        $total=mysqli_query($db,"SELECT FOUND_Rows() as total");
        $total=mysqli_fetch_assoc($total)['total'];

        $GLOBALS['pages']=ceil($total/$perpage);
}
?>
