<?php
function query_runner($host, $dbname, $port, $socket, $username, $password, $query) {
	global $sesuser, $iuser, $ipass, $mhost, $mdbname, $mport, $msocket, $ruser, $suser, $uuser, $separateusers;
	$link = mysqli_connect($host, $username, $password, $dbname);
	if (!$link) {
		die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		return false;
	} else {
		mysqli_set_charset($link, "utf8");
		if ((($username <> $suser and $username <> $sesuser) or $separateusers === false) and strcasecmp(substr($query, 0, 21), "DELETE FROM `ed__strikes`") !== 0) {
			$linkhis = mysqli_connect($mhost, $iuser, $ipass, $mdbname);
			if ($linkhis) {
			mysqli_set_charset($linkhis, "utf8");
				$hisquery = mysqli_real_escape_string($linkhis, $query);
				mysqli_query($linkhis, "INSERT INTO `ed__history` (`type`, `details`) VALUES ('action', '$hisquery')");
			}
			mysqli_close($linkhis);
		}
		if ($username === $suser AND $result = mysqli_query($link, $query) AND mysqli_num_rows($result) > 0) {
			while($row = mysqli_fetch_assoc($result)){
				$toreturn[] = $row;
			}
			return $toreturn;
		} elseif ($username === $suser AND $result = mysqli_query($link, $query) AND !(mysqli_num_rows($result))) {
			return true;
		} elseif ($username === $suser AND !($result = mysqli_query($link, $query))) {
			return false;
		} elseif ($username <> $suser AND $result = mysqli_query($link, $query)) {
			return true;
		} elseif ($username <> $suser AND !($result = mysqli_query($link, $query))){
			$sqlerror = mysqli_real_escape_string($link, mysqli_error($link));
			$linkhis = mysqli_connect($mhost, $iuser, $ipass, $mdbname, $mport, $msocket);
			if ($linkhis) {
				mysqli_set_charset($linkhis, "utf8");
				mysqli_query($linkhis, "INSERT INTO `ed__history` (`type`, `details`) VALUES ('error', '$sqlerror')");
			}
			mysqli_close($linkhis);
			return false;
		} elseif ($username === $sesuser) {
			if (strcasecmp(substr($query, 0, 6), "SELECT") === 0) {
				if ($result = mysqli_query($link, $query) AND mysqli_num_rows($result) > 0) {
					return mysqli_fetch_assoc($result);
				} elseif ($result = mysqli_query($link, $query) AND !(mysqli_num_rows($result))) {
					return true;
				} else {
					return false;
				}
			} else {
				if ($result = mysqli_query($link, $query)) {
					return true;
				} else {
					return false;
				}
			}
		}
	}
	mysqli_close($link);
}



function spicing_up() {
	$characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*:;/(){}[]-_=+?";
	$i = 0;
	$cumin = "";
	$charoli = "";
	$cubeb = "";
	$mace = "";
	while ($i < 30) {
		$cumin .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
		$charoli .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
		$cubeb .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
		$mace .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
		$i++;
	}
	return array($cumin, $charoli, $cubeb, $mace);
}



function pass_hash($cumin, $charoli, $unhashed, $cubeb, $mace) {
	$hashed = hash("sha512", $unhashed);
	return hash("sha512", $cumin.substr($hashed, 0, 1).$charoli.substr($hashed, 1, -1).$cubeb.substr($hashed, -1).$mace);
}



function esc_url($url) {
	if ('' == $url) {
		return $url;
	}
	$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
	$strip = array('%0d', '%0a', '%0D', '%0A');
	$url = (string) $url;
	$count = 1;
	while ($count) {
		$url = str_replace($strip, '', $url, $count);
	}
	$url = str_replace(';//', '://', $url);
	$url = htmlentities($url);
	$url = str_replace('&amp;', '&#038;', $url);
	$url = str_replace("'", '&#039;', $url);
	if ($url[0] !== '/') {
		return '';
	} else {
		return $url;
	}
}



class session {
function __construct() {
   // set our custom session functions.
   session_set_save_handler(array($this, 'open'), array($this, 'close'), array($this, 'read'), array($this, 'write'), array($this, 'destroy'), array($this, 'gc'));
 
   // This line prevents unexpected effects when using objects as save handlers.
   register_shutdown_function('session_write_close');
}
function start_session($session_name, $secure) {
   // Make sure the session cookie is not accessible via javascript.
   $httponly = true;
 
   // Hash algorithm to use for the session. (use hash_algos() to get a list of available hashes.)
   $session_hash = 'sha512';
 
   // Check if hash is available
   if (in_array($session_hash, hash_algos())) {
      // Set the has function.
      ini_set('session.hash_function', $session_hash);
   }
   // How many bits per character of the hash.
   // The possible values are '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ",").
   ini_set('session.hash_bits_per_character', 5);
 
   // Force the session to only use cookies, not URL variables.
   ini_set('session.use_only_cookies', 1);
 
   // Get session cookie parameters 
   $cookieParams = session_get_cookie_params(); 
   // Set the parameters
   session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 
   // Change the session name 
   session_name($session_name);
   // Now we cat start the session
   session_start();
   // This line regenerates the session and delete the old one. 
   // It also generates a new encryption key in the database. 
   session_regenerate_id(true); 
}
function open() {
	$host="localhost";
	$user="simbiatr";
	$pass="9Nyf6ozL05";
	$name="simbiatr_simbiat";
   $mysqli = new mysqli($host, $user, $pass, $name);
   $this->db = $mysqli;
   return true;
}
function close() {
   $this->db->close();
   return true;
}
function read($id) {
   if(!isset($this->read_stmt)) {
      $this->read_stmt = $this->db->prepare("SELECT data FROM ed__sessions WHERE id = ? LIMIT 1");
   }
   $this->read_stmt->bind_param('s', $id);
   $this->read_stmt->execute();
   $this->read_stmt->store_result();
   $this->read_stmt->bind_result($data);
   $this->read_stmt->fetch();
   $key = $this->getkey($id);
   $data = $this->decrypt($data, $key);
   return $data;
}
function write($id, $data) {
   // Get unique key
   $key = $this->getkey($id);
   // Encrypt the data
   $data = $this->encrypt($data, $key);
 
   $time = time();
   if(!isset($this->w_stmt)) {
      $this->w_stmt = $this->db->prepare("REPLACE INTO ed__sessions (id, set_time, data, session_key) VALUES (?, ?, ?, ?)");
   }
 
   $this->w_stmt->bind_param('siss', $id, $time, $data, $key);
   $this->w_stmt->execute();
   return true;
}
function destroy($id) {
   if(!isset($this->delete_stmt)) {
      $this->delete_stmt = $this->db->prepare("DELETE FROM ed__sessions WHERE id = ?");
   }
   $this->delete_stmt->bind_param('s', $id);
   $this->delete_stmt->execute();
   return true;
}
function gc($max) {
   if(!isset($this->gc_stmt)) {
      $this->gc_stmt = $this->db->prepare("DELETE FROM ed__sessions WHERE set_time < ?");
   }
   $old = time() - $max;
   $this->gc_stmt->bind_param('s', $old);
   $this->gc_stmt->execute();
   return true;
}
private function getkey($id) {
   if(!isset($this->key_stmt)) {
      $this->key_stmt = $this->db->prepare("SELECT session_key FROM ed__sessions WHERE id = ? LIMIT 1");
   }
   $this->key_stmt->bind_param('s', $id);
   $this->key_stmt->execute();
   $this->key_stmt->store_result();
   if($this->key_stmt->num_rows == 1) { 
      $this->key_stmt->bind_result($key);
      $this->key_stmt->fetch();
      return $key;
   } else {
      $random_key = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
      return $random_key;
   }
}
private function encrypt($data, $key) {
   $salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
   $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
   $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv));
   return $encrypted;
}
private function decrypt($data, $key) {
   $salt = 'cH!swe!retReGu7W6bEDRup7usuDUh9THeD2CHeGE*ewr4n39=E@rAsp7c-Ph@pH';
   $key = substr(hash('sha256', $salt.$key.$salt), 0, 32);
   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
   $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
   $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($data), MCRYPT_MODE_ECB, $iv);
   $decrypted = rtrim($decrypted, "\0");
   return $decrypted;
}
}



function checkbrute($userid) {
	global $suser, $spass, $mhost, $mdbname, $mport, $msocket;
	// Get timestamp of current time 
	$now = date('Y-m-d H:i:s', time());
	// All login attempts are counted from the past 2 hours. 
	$valid_attempts = $now - (2 * 60 * 60);
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `userid` FROM `ed__strikes` WHERE `userid` = '$userid' AND `time` > '$valid_attempts'");
        // If there have been more than 5 failed logins 
        if (is_array($qres) AND count($qres) > 4) {
            return true;
        } else {
            return false;
        }
}



function brute_gc() {
	global $ruser, $rpass, $mhost, $mdbname, $mport, $msocket;
	$old = date('Y-m-d H:i:s', time() - 30);
	return query_runner($mhost, $mdbname, $mport, $msocket, $ruser, $rpass, "DELETE FROM `ed__strikes` WHERE `time` < '$old'");
}



function brute_gc_sel($id) {
	global $ruser, $rpass, $mhost, $mdbname, $mport, $msocket;
	return query_runner($mhost, $mdbname, $mport, $msocket, $ruser, $rpass, "DELETE FROM `ed__strikes` WHERE `userid` = '$id'");
}


function login($username, $password) {
	global $uuser, $upass, $iuser, $ipass, $suser, $spass, $mhost, $mdbname, $mport, $msocket;
	brute_gc();
	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `userid` FROM `ed__users` WHERE `username` = '$username' LIMIT 1");
        if (is_array($qres)) {
        	$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT * FROM `ed__users` WHERE `username` = '$username' LIMIT 1");
		if (is_array($qres)) {
			if (checkbrute($qres[0]['userid']) == true) {
				return "locked";
			} else {
				$password = pass_hash($qres[0]['cumin'], $qres[0]['charoli'], $password, $qres[0]['cubeb'], $qres[0]['mace']);
				if ($password === $qres[0]['password']) {
					if ($qres[0]['IsEnabled'] == 0) {
						return "disabled";
					}
					$rflags = array("IsAdmin" => $qres[0]['IsAdmin'], "IsISA" => $qres[0]['IsISA'], "IsOps" => $qres[0]['IsOps'], "IsPClient" => $qres[0]['IsPClient'], "IsCCLient" => $qres[0]['IsCClient']);
					$flagcount = array_count_values($rflags);
					if (!isset($flagcount['1']) or $flagcount['1'] != 1) {
						return "wrights";
					}
					brute_gc_sel($qres[0]['userid']);
					$user_browser = $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'];
					$qres[0]['userid'] = preg_replace("/[^0-9]+/", "", $qres[0]['userid']);
					$_SESSION['userid'] = $qres[0]['userid'];
					$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
					$_SESSION['username'] = $username;
					$_SESSION['usergroup'] = array_search('1', $rflags);
					$_SESSION['login_string'] = hash('sha512', $_SESSION['usergroup'].$password.$user_browser);
					if ($qres[0]['PassRes'] == 1) {
						$_SESSION['PassRes'] = true;
						header('Location: ../edocuments/passchange.php');
						return "passres";
					} else {
						if (isset($_SESSION['PassRes'])) {
							unset($_SESSION['PassRes']);
						}
					}
					return "succ";
				} else {
					if (query_runner($mhost, $mdbname, $mport, $msocket, $iuser, $ipass, "INSERT INTO `ed__strikes` (`userid`) VALUES ('".$qres[0]['userid']."')")) {
						if (checkbrute($qres[0]['userid'])) {
							if (query_runner($mhost, $mdbname, $mport, $msocket, $uuser, $upass, "UPDATE ed__users SET `IsEnabled`='0' WHERE `username` = '$username'")) {
								return "brute";
							} else {
								return "dberr";
							}
						} else {
							return "brute";
						}
					} else {
						return "dberr";
					}
				}
			}
		} else {
			return "dberr";
		}
        } else {
            return "nouser";
        }
}



function login_check() {
	global $suser, $spass, $mhost, $mdbname, $mport, $msocket;
	// Check if all session variables are set
	if (isset($_SESSION['userid'], $_SESSION['username'], $_SESSION['login_string'])) {
		$userid = $_SESSION['userid'];
		$login_string = $_SESSION['login_string'];
		$username = $_SESSION['username'];
		// Get the user-agent string of the user.
		$user_browser = $_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR'];
 		$qres = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `password` FROM `ed__users` WHERE `userid` = '$userid' LIMIT 1");
        	if (is_array($qres)) {
			$login_check = hash('sha512', $_SESSION['usergroup'].$qres[0]['password'].$user_browser);
			if ($login_check === $login_string) {
                    		// Logged In!!!! 
				if (isset($_SESSION['PassRes']) and (stripos($_SERVER['REQUEST_URI'], "edocuments/passchange.php") === false)) {
					header('Location: ../edocuments/passchange.php');
					return true;
				}
                    		return true;
			} else {
                    		// Not logged in 
                    		return false;
			}
		} else {
			// Not logged in 
			return false;
		}
	} else {
		// Not logged in 
		return false;
	}
}



function Decrypt($s) {
	$salt = 'Hb9cpTPDe-7ss7HHA*e26peUnhpHGEewru43uDErr=79WDEt@eeu!wu@G!RRhcCs';
	$rijnKey = substr(hash('sha256', $salt."youwillneverguess".$salt), 0, 32);
	$block = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$rijnIV = mcrypt_create_iv($block, MCRYPT_RAND);
	if ($s == "") { return $s; }
	// Turn the cipherText into a ByteArray from Base64
	try {
		$s = str_replace("BIN00101011BIN", "+", $s);
		$s = base64_decode($s);
		$s = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $rijnKey, $s, MCRYPT_MODE_ECB, $rijnIV);
	} catch(Exception $e) {
		// There is a problem with the string, perhaps it has bad base64 padding
		// Do Nothing
	}
	$pad = ord($s[($len = strlen($s)) - 1]);
	return substr($s, 0, strlen($s) - $pad);
}
function Encrypt($s) {
	$salt = 'Hb9cpTPDe-7ss7HHA*e26peUnhpHGEewru43uDErr=79WDEt@eeu!wu@G!RRhcCs';
	$rijnKey = substr(hash('sha256', $salt."youwillneverguess".$salt), 0, 32);
	$block = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
	$rijnIV = mcrypt_create_iv($block, MCRYPT_RAND);
	$pad = $block - (strlen($s) % $block);
	$s .= str_repeat(chr($pad), $pad);
	$s = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $rijnKey, $s, MCRYPT_MODE_ECB, $rijnIV);
	$s = base64_encode($s);
	$s = str_replace("+", "BIN00101011BIN", $s);
	return $s;
}



function linkform($id, $action, $linkname, $arroff) {
	echo "<script>function linksubm(formid) {
		document.getElementById(formid).submit();  
		return true;
		}</script>";
	echo "<form style=\"margin:0; padding:0; display:inline;\" method=\"POST\" action=\"".esc_url($action)."\" id=\"".$id."\">";
	foreach ($arroff as &$value) {
		echo "<input type=\"hidden\" name=\"".$value[0]."\" value=\"".encrypt($value[1])."\">";
	}
	echo "</form>";
	echo "<a href=\"javascript:void(0);\" onclick=\"linksubm('".$id."');\">".$linkname."</a>";
}



function linkformug($id, $action, $linkname, $arroff) {
	echo "<script>function linksubm(formid) {
		document.getElementById(formid).submit();  
		return true;
		}</script>";
	echo "<form style=\"margin:0; padding:0; display:inline;\" method=\"POST\" action=\"".esc_url($action)."\" id=\"".$id."\">";
	echo "<select id=\"".$id."_usergroup\" name=\"usergroup\"";
	if (isset($_SESSION['usergroup'])) {
		if (strcasecmp($_SESSION['usergroup'], "iscclient") == 0) {
			echo "			 disabled>";
		} else {
			echo "			>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
			echo "				<option selected=true value=\"".encrypt("isadmin")."\">Admin</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
			echo "				<option selected=true value=\"".encrypt("isisa")."\">ISA</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isisa") == 0) {
			echo "				<option selected=true value=\"".encrypt("isops")."\">Operator</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "isops") == 0 or strcasecmp($_SESSION['usergroup'], "ispclient") == 0) {
			echo "				<option selected=true value=\"".encrypt("ispclient")."\">Client Admin</option>";
		}
		if (strcasecmp($_SESSION['usergroup'], "ispclient") == 0) {
			echo "				<option selected=true value=\"".encrypt("iscclient")."\">Client Operator</option>";
		}
	} else {
		echo "			 disabled>
						<option selected=true value=\"".encrypt("nope")."\">=(</option>";
	}
	echo "</select>";
	foreach ($arroff as &$value) {
		echo "<input type=\"hidden\" name=\"".$value[0]."\" value=\"".encrypt($value[1])."\">";
	}
	echo "</form>";
	echo "&nbsp;<a href=\"javascript:void(0);\" onclick=\"linksubm('".$id."');\">".$linkname."</a>";
}



function admincheck() {
	global $suser, $spass, $mhost, $mdbname, $mport, $msocket;
	if (is_array(query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `userid` FROM `ed__users` WHERE `IsAdmin` = 1"))) {
		return true;
	} else {
		return false;
	}
}



function deluser($username) {
	global $suser, $spass, $ruser, $rpass, $mhost, $mdbname, $mport, $msocket;
	if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0 or (strcasecmp($_SESSION['usergroup'], "isops") == 0 and checkifclient($username)) or (strcasecmp($_SESSION['usergroup'], "ispclient") == 0 and checkparent($username))) {
		$uqery = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `userid` FROM `ed__users` WHERE `username` = '$username' LIMIT 1");
		if (is_array($uqery)) {
			$uid = $uqery[0]['userid'];
			if ($uid === $_SESSION['userid']) {
				return false;
			}
		} else {
			return false;
		}
		$uqery = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `userid` FROM `ed__users` WHERE `parentid` = '$uid' LIMIT 1");
		if (is_array($uqery)) {
			return false;
		}
		if (query_runner($mhost, $mdbname, $mport, $msocket, $ruser, $rpass, "DELETE FROM `ed__users` WHERE `username` = '$username' LIMIT 1")) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}



function checkparent($username) {
	global $suser, $spass, $mhost, $mdbname, $mport, $msocket;
	if (is_array(query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `userid` FROM `ed__users` WHERE `username` = '$username' AND `parentid` = '".$_SESSION['userid']."'"))) {
		return true;
	} else {
		return false;
	}
}



function getrights($username) {
	global $suser, $spass, $mhost, $mdbname, $mport, $msocket;
	$rights = query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `rights` FROM `ed__users` WHERE `username` = '$username' AND `rights` LIKE 'for(;;);%'");
	if (is_array($rights)) {
		return str_replace("for(;;);", "", $rights[0]['rights']);
	} else {
		return false;
	}
}



function checkifclient($username) {
	global $suser, $spass, $mhost, $mdbname, $mport, $msocket;
	if (is_array(query_runner($mhost, $mdbname, $mport, $msocket, $suser, $spass, "SELECT `userid` FROM `ed__users` WHERE `username` = '$username' AND `IsPClient` + `IsCClient` = '1'"))) {
		return true;
	} else {
		return false;
	}
}



function enbuser($username) {
	global $ruser, $rpass, $uuser, $upass, $mhost, $mdbname, $mport, $msocket;
	if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0 or (strcasecmp($_SESSION['usergroup'], "isops") == 0 and checkifclient($username)) or (strcasecmp($_SESSION['usergroup'], "ispclient") == 0 and checkparent($username))) {
		if (query_runner($mhost, $mdbname, $mport, $msocket, $uuser, $upass, "UPDATE `ed__users` SET `IsEnabled` = '1' WHERE `username` = '$username'")) {
			if (query_runner($mhost, $mdbname, $mport, $msocket, $ruser, $rpass, "DELETE FROM `ed__strikes` WHERE `ed__strikes`.`userid` = (SELECT `userid` FROM `ed__users` WHERE `username` = '$username' LIMIT 1)")) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}



function uguser($username, $usergroup) {
	global $uuser, $upass, $mhost, $mdbname, $mport, $msocket;
	if (strcasecmp($_SESSION['usergroup'], "isadmin") == 0 or strcasecmp($_SESSION['usergroup'], "isisa") == 0 or (strcasecmp($_SESSION['usergroup'], "isops") == 0 and checkifclient($username)) or (strcasecmp($_SESSION['usergroup'], "ispclient") == 0 and checkparent($username))) {
		$query = "UPDATE `ed__users` SET `IsAdmin` = ";
		if (strcasecmp($usergroup, "isadmin") == 0) {
			$query = $query."'1'";
		} else {
			$query = $query."'0'";
		}
		$query = $query.", `IsISA` = ";
		if (strcasecmp($usergroup, "isisa") == 0) {
			$query = $query."'1'";
		} else {
			$query = $query."'0'";
		}
		$query = $query.", `IsOps` = ";
		if (strcasecmp($usergroup, "isops") == 0) {
			$query = $query."'1'";
		} else {
			$query = $query."'0'";
		}
		$query = $query.", `IsPClient` = ";
		if (strcasecmp($usergroup, "ispclient") == 0) {
			$query = $query."'1'";
		} else {
			$query = $query."'0'";
		}
		$query = $query.", `IsCClient` = ";
		if (strcasecmp($usergroup, "iscclient") == 0) {
			$query = $query."'1'";
		} else {
			$query = $query."'0'";
		}
		$query = $query." WHERE `username` = '$username'";
		if (query_runner($mhost, $mdbname, $mport, $msocket, $uuser, $upass, $query)) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}



function keycheck($pattern, $array) {
    $keys = array_keys($array);    
    return (bool) preg_grep($pattern,$keys);
}


function rightmaker() {
	global $uuser, $upass, $mhost, $mdbname, $mport, $msocket;
	$json = "for(;;);{";
	foreach ($_POST as $key => $value) {
		if (preg_match("/acc\d{1}/", $key) and preg_match("/\d{1,}/", $value)) {
			$json = $json."\"".$value."\":{";
			$id = substr($key, 3, 1);
			if (isset($_POST['sta'.$id])) {
				$json = $json."\"sta\":".$_POST['sta'.$id].",";
			} else {
				$json = $json."\"sta\":false,";
			}
			if (isset($_POST['adv'.$id])) {
				$json = $json."\"adv\":".$_POST['adv'.$id].",";
			} else {
				$json = $json."\"adv\":false,";
			}
			if (isset($_POST['adm'.$id])) {
				$json = $json."\"adm\":".$_POST['adm'.$id].",";
			} else {
				$json = $json."\"adm\":false,";
			}
			if (isset($_POST['inp'.$id])) {
				$json = $json."\"inp\":".$_POST['inp'.$id].",";
			} else {
				$json = $json."\"inp\":false,";
			}
			if (isset($_POST['oup'.$id])) {
				$json = $json."\"oup\":".$_POST['oup'.$id].",";
			} else {
				$json = $json."\"oup\":false,";
			}
			if (isset($_POST['ino'.$id])) {
				$json = $json."\"ino\":".$_POST['ino'.$id].",";
			} else {
				$json = $json."\"ino\":false,";
			}
			if (isset($_POST['ouo'.$id])) {
				$json = $json."\"ouo\":".$_POST['ouo'.$id].",";
			} else {
				$json = $json."\"ouo\":false,";
			}
			if (isset($_POST['cui'.$id])) {
				$json = $json."\"cui\":".$_POST['cui'.$id].",";
			} else {
				$json = $json."\"cui\":false,";
			}
			if (isset($_POST['cuo'.$id])) {
				$json = $json."\"cuo\":".$_POST['cuo'.$id];
			} else {
				$json = $json."\"cuo\":false";
			}
			$json = $json."},";
		}
	}
	$json = $json."}";
	if (strcasecmp($json, "for(;;);{}") == 0) {
		$json = "NONE";
	} else {
		$json = str_replace("},}", "}}", str_replace(":on", ":true", $json));
		$json = "for(;;);".encrypt($json);
	}
	if ((strcasecmp($_SESSION['usergroup'], "isops") == 0 and checkifclient(decrypt($_POST['userdr']))) or (strcasecmp($_SESSION['usergroup'], "ispclient") == 0 and checkparent(decrypt($_POST['userdr'])))) {
		if (query_runner($mhost, $mdbname, $mport, $msocket, $uuser, $upass, "UPDATE `ed__users` SET `rights` = '$json' WHERE `username` =  '".decrypt($_POST['userdr'])."'")) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}



function docgrabber() {
	//should be used in query builder
	global $suser, $spass, $dhost, $ddbname, $dport, $dsocket;
	$docs = query_runner($dhost, $ddbname, $dport, $dsocket, $suser, $spass, "SELECT * FROM `ed__transactions` WHERE `benAccount` LIKE '%70070116'");
	if (is_array($docs)) {
		return $docs;
	} else {
		return false;
	}
}



function num2str($num) {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','п€ть','шесть','семь', 'восемь','дев€ть'),
        array('','одна','две','три','четыре','п€ть','шесть','семь', 'восемь','дев€ть'),
    );
    $a20=array('дес€ть','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'п€тнадцать','шестнадцать','семнадцать','восемнадцать','дев€тнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','п€тьдес€т','шестьдес€т','семьдес€т' ,'восемьдес€т','дев€носто');
    $hundred=array('','сто','двести','триста','четыреста','п€тьсот','шестьсот', 'семьсот','восемьсот','дев€тьсот');
    $unit=array( // Units
        array('копейка' ,'копейки' ,'копеек',	 1),
        array('рубль'   ,'рубл€'   ,'рублей'    ,0),
        array('тыс€ча'  ,'тыс€чи'  ,'тыс€ч'     ,1),
        array('миллион' ,'миллиона','миллионов' ,0),
        array('миллиард','милиарда','миллиардов',0),
    );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}
function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}
?>