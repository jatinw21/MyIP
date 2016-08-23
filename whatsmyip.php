<?php /* This page is available at www.jatin-wadhwa.com/index.php/myip */

// this code improves the code for the cases when user is visiting the site from a proxy
// a proxy (in most cases) sets one of the various values given below as user's actual IP before sending it's request to the site
// so we can try and obtain these values

// the function below returns only the first value it sees is set. these are arranged in order of priority and most common ones
?>
<?php 

function forwarded_ip() {
  $keys = array(
    'HTTP_X_FORWARDED_FOR',
    'HTTP_X_FORWARDED',
    'HTTP_FORWARDED_FOR',
    'HTTP_FORWARDED',
    'HTTP_CLIENT_IP',
    'HTTP_X_CLUSTER_CLIENT_IP',
  );
  
  foreach($keys as $key) {
    if(isset($_SERVER[$key])) {
      // sometimes when it goes through multiple proxies, the values are comma separated, then return 1st in list
      $ip_array = explode(',', $server[$key]);
      foreach($ip_array as $ip) {
        $ip = trim($ip);
        if (validate_ip($ip)){
        return $ip;
        }
      }
    }
  }
  return '';
}

// checking for a valid IP format
function validate_ip($ip) {
  if(filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 |
  FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
  return false;
  } else {
    return true;
  }
}

$remote_ip = $_SERVER['REMOTE_ADDR'];
$forwarded_ip = forwarded_ip();

?>

Remote IP Address: <?php echo $remote_ip; ?><br/>
<br/>

<?php // If any of those forwarded ones were found, then show them ?>
<?php if($forwarded_ip != '') { ?>
  Forwarded for: <?php echo $forwarded_ip; ?><br/>
  <br/>
<?php } ?>


