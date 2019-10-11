<?php
header("Content-Type: text/text");
 //the following code will delete images in the /i/ folder after 30 days, you can delete/comment it out if you want.
$days = 99999999;
$dir = "/";

function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function getToken($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
    }

    return $token;
}
 
$nofiles = 0;
 
    if ($handle = opendir($dir)) {
    while (( $file = readdir($handle)) !== false ) {
        if ( $file == '.' || $file == '..' || $file == '.htaccess' || $file == "_errorpages" || $file == "" || $file == "index.php" || $file == "welcome.txt" || $file == "upload.php" || $files == "favicon.ico" || $files == "index.html" || $files == "clubbanger3000.mp3" || $files == "generate.php" || is_dir($dir.'/'.$file) ) {
            continue;
        }
 
        if ((time() - filemtime($dir.'/'.$file)) > ($days *84600)) {
            $nofiles++;
            unlink($dir.'/'.$file);
        }
    }
    closedir($handle);
}

$key = "BJtwb!BP5pW~pPjJ=Sp#c7r@R3On7*";
$uploadhost = "https://shy.cx/i";
$redirect = "https://shy.cs";
$error = "0";

	$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
	$browser = $_SERVER['HTTP_USER_AGENT'];
	$dateTime = date('Y/m/d G:i:s');
	$fileend = end(explode(".", $_FILES["form"]["name"]));
	$filename = $_FILES["form"]["name"];
	$file = "pQeH6pFbHeKhTrxzJY.html";
	$file = fopen($file, "a");
	$data = "<pre><b>User IP</b>: $ip <b> Browser</b>: $browser <br>on Time : $dateTime <br><b>File Type</b>: $fileend <br><b>File Name</b>: $filename</pre>";
	fwrite($file, $data);
	fclose($file);
  
if (isset($_POST['user'])) {
    if ($_POST['user'] == $key) 
	{
		switch($fileend)
		{
			case "":
			case "sql":
			case "php":
			case "phtml":
			case "php3":
			case "php4":
			case "php5":
			case "php6":
			case "php7":
			case "phps":
			case "php-s":
			case "html":
			case "js":
			case "css":
			case "htaccess":
				$error = 1;
				break;
			
			default;
				$target = getcwd() . "/" . basename($_FILES['form']['name']);
			break;
		}
        if (move_uploaded_file($_FILES['form']['tmp_name'], $target)) {
            //$md5 = md5_file(getcwd() . "/" . basename($_FILES['form']['name']));
			$md5 = md5_file(getcwd() . "/" . basename($_FILES['form']['name']));
			$sha1 = sha1_file(getcwd() . "/" . basename($_FILES['form']['name']));
			$randomtoken = getToken(18);
			if (isset($_POST['encrypt'])) 
			{
				switch ($_POST['encrypt'])
				{
					case "md5":
					{
						rename(getcwd() . "/" . basename($_FILES['form']['name']), getcwd() . "/i/" . $md5 . "." . end(explode(".", $_FILES["form"]["name"])));
						echo $uploadhost . "/" . $md5 . "." . end(explode(".", $_FILES["form"]["name"]));
					}
					break;
					case "sha1":
					{
						rename(getcwd() . "/" . basename($_FILES['form']['name']), getcwd() . "/i/" . $sha1 . "." . end(explode(".", $_FILES["form"]["name"])));
						echo $uploadhost . "/" . $sha1 . "." . end(explode(".", $_FILES["form"]["name"]));
					}
					break;
				
					default;
					{
						rename(getcwd() . "/" . basename($_FILES['form']['name']), getcwd() . "/i/" . $md5 . "." . end(explode(".", $_FILES["form"]["name"])));
						echo $uploadhost . "/" . $md5 . "." . end(explode(".", $_FILES["form"]["name"]));
					}
					break;
				}
			}
			else
			{
				rename(getcwd() . "/" . basename($_FILES['form']['name']), getcwd() . "/i/" . $randomtoken . "." . end(explode(".", $_FILES["form"]["name"])));
				echo $uploadhost . "/" . $randomtoken . "." . end(explode(".", $_FILES["form"]["name"]));
			}
        } else {
			switch($error)
			{
				case "1": echo "You attempted to upload a blacklisted file type."; break;
			
			
			default;
				echo "Sorry, there was a problem uploading your file. Please try again.";
			break;
			}
        }
    } else {
		echo "Your upload key is invalid.";
        //header('Location: '.$redirect);
    }
} else {
	echo "Your arguments are invalid.";
    //header('Location: '.$redirect);
}
?>