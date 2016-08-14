<?php
$cache_ext = '.html'; //file extension
$cache_time = 86400;  //Cache file expire time (24 hour = 86400 sec)
$cache_folder = 'cache_files/'; //Cache files folder 

$webpage_url = 'http://'.$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING'];
$cache_file = $cache_folder.md5($webpage_url).$cache_ext; // creating unique name for cache file

if (file_exists($cache_file) && time() - $cache_time < filemtime($cache_file)) 
{ 
 ob_start('ob_gzhandler'); 
 readfile($cache_file); 
 echo '<!-- cached page - '.date('l jS \of F Y h:i:s A', filemtime($cache_file)).', Page : '.$webpage_url.' -->';
 ob_end_flush(); 
 exit(); 
}
else
{
ob_start('ob_gzhandler'); 

// Your Webpage Content Starts
?>

<html>
<body>
<h1>Your Webpage Content</h1>
</body>
</html>

<?php
// Your Webpage Content Ends 

if (!is_dir($cache_folder)) 
{ 
 mkdir($cache_folder);
}

$file = fopen($cache_file, 'w');
fwrite($file, ob_get_contents()); 
fclose($file);
ob_end_flush();
}
?>
