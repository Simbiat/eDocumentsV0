<?php
include_once "./genfunc/globalstart.php";
if ($loggedin) {
	if (isset($_SESSION['usergroup'])) {
		if (strcasecmp($_SESSION['usergroup'], "ispclient") == 0 or strcasecmp($_SESSION['usergroup'], "isops") == 0) {
			if (isset($_POST['userdr']) and keycheck("/acc\d{1}/", $_POST)) {
				if (rightmaker()) {
					echo "Access rights updated!<BR><BR>";
				} else {
					echo "Failed to update access rights!<BR><BR>";
				}
			}
			if (isset($_POST['userdr'])) {
				$rights = json_decode(str_replace("for(;;);", "", decrypt(getrights(decrypt($_POST['userdr'])))), true);
				if (strcasecmp($_SESSION['usergroup'], "ispclient") == 0) {
					$prights = json_decode(str_replace("for(;;);", "", decrypt(getrights($_SESSION['username']))), true);
				}
				if (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
					echo "<script type=\"text/javascript\">function rightscreator(){
							var myform = document.getElementById('rights');
							var inputTags = myform.getElementsByTagName('input');
							var elementCount = 0;
							var emptycount = 0;
							for (var i=0, length = inputTags.length; i<length; i++) {
								if (inputTags[i].type == 'text') {
									elementCount++;
								}
								if (/\S/.test(inputTags[i].value) == false) {
									emptycount++;
								}
							}
							if (elementCount == 0 || emptycount == 0) {
								newElement = document.createElement('div');
								newElement.innerHTML = '<table id=\"tbl' + (elementCount+1) + '\" name=\"tbl' + (elementCount+1) + '\">\
									<tr><td>Account: <input onchange=\"rightscreator();\" onkeypress=\"this.onchange();\" onpaste=\"this.onchange();\" oninput=\"this.onchange();\" oncut=\"this.onchange();\" textinput=\"this.onchange();\" \
									id=\"acc' + (elementCount+1) + '\" name=\"acc' + (elementCount+1) + '\" type=\"text\"></td><td>\
									<label><input id=\"sta' + (elementCount+1) + '\" name=\"sta' + (elementCount+1) + '\" type=\"Checkbox\">Statements<BR></label>\
									<label><input id=\"adv' + (elementCount+1) + '\" name=\"adv' + (elementCount+1) + '\" type=\"Checkbox\">Advices<BR></label>\
									<label><input id=\"adm' + (elementCount+1) + '\" name=\"adm' + (elementCount+1) + '\" type=\"Checkbox\">Admin messages<BR></label>\
									<label><input id=\"inp' + (elementCount+1) + '\" name=\"inp' + (elementCount+1) + '\" type=\"Checkbox\">Incoming payments<BR></label>\
									<label><input id=\"oup' + (elementCount+1) + '\" name=\"oup' + (elementCount+1) + '\" type=\"Checkbox\">Outgoing payments<BR></label>\
									<label><input id=\"ino' + (elementCount+1) + '\" name=\"ino' + (elementCount+1) + '\" type=\"Checkbox\">Incoming orders<BR></label>\
									<label><input id=\"ouo' + (elementCount+1) + '\" name=\"ouo' + (elementCount+1) + '\" type=\"Checkbox\">Outgoing orders<BR></label>\
									<label><input id=\"cui' + (elementCount+1) + '\" name=\"cui' + (elementCount+1) + '\" type=\"Checkbox\">Currency incomings<BR></label>\
									<label><input id=\"cuo' + (elementCount+1) + '\" name=\"cuo' + (elementCount+1) + '\" type=\"Checkbox\">Currency outgoings<BR></label></td></tr></table>';
								while (newElement.firstChild) {
									myform.appendChild(newElement.firstChild);
								}
								newElement.parentNode.removeChild(newElement);
							}
							if (emptycount > 1) {
								while (emptycount > 1) {
									var inputTags = myform.getElementsByTagName('table');
									for (var i=inputTags.length; i>0; i--) {
										if (/\S/.test(document.getElementById('acc' + i).value) == false) {
											var elemtodel = document.getElementById('tbl' + i);
											elemtodel.parentNode.removeChild(elemtodel);
											emptycount--;
											break;
										}
									}
								}
							}
						}
						</script>";
				}
				echo "<form style=\"margin:0; padding:0; display:inline;\" method=\"POST\" action=\"".esc_url($_SERVER['PHP_SELF'])."\" id=\"userrigupd\">";
				echo "<input type=\"hidden\" name=\"userdr\" value=\"".$_POST['userdr']."\"/>";
				echo "Username: ".decrypt($_POST['userdr'])."<BR>";
				echo "<div id=\"rights\" name=\"rights\">";
				if (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
					if (!is_null($rights)) {
						$itter = 1;
						foreach ($rights as $key => $right) {
							echo "<table id=\"tbl".$itter."\" name=\"tbl".$itter."\">
								<tr><td>Account: <input value=\"".$key."\" onchange=\"rightscreator();\" onkeypress=\"this.onchange();\" onpaste=\"this.onchange();\" oninput=\"this.onchange();\" oncut=\"this.onchange();\" textinput=\"this.onchange();\" 
								id=\"acc".$itter."\" name=\"acc".$itter."\" type=\"text\"></td><td>
								<label><input id=\"sta".$itter."\" name=\"sta".$itter."\" type=\"Checkbox\"";
								if ($right['sta']) {
									echo " checked";
								}
								echo ">Statements<BR></label>
								<label><input id=\"adv".$itter."\" name=\"adv".$itter."\" type=\"Checkbox\"";
								if ($right['adv']) {
									echo " checked";
								}
								echo ">Advices<BR></label>
								<label><input id=\"adm".$itter."\" name=\"adm".$itter."\" type=\"Checkbox\"";
								if ($right['adm']) {
									echo " checked";
								}
								echo ">Admin messages<BR></label>
								<label><input id=\"inp".$itter."\" name=\"inp".$itter."\" type=\"Checkbox\"";
								if ($right['inp']) {
									echo " checked";
								}
								echo ">Incoming payments<BR></label>
								<label><input id=\"oup".$itter."\" name=\"oup".$itter."\" type=\"Checkbox\"";
								if ($right['oup']) {
									echo " checked";
								}
								echo ">Outgoing payments<BR></label>
								<label><input id=\"ino".$itter."\" name=\"ino".$itter."\" type=\"Checkbox\"";
								if ($right['ino']) {
									echo " checked";
								}
								echo ">Incoming orders<BR></label>
								<label><input id=\"ouo".$itter."\" name=\"ouo".$itter."\" type=\"Checkbox\"";
								if ($right['ouo']) {
									echo " checked";
								}
								echo ">Outgoing orders<BR></label>
								<label><input id=\"cui".$itter."\" name=\"cui".$itter."\" type=\"Checkbox\"";
								if ($right['cui']) {
									echo " checked";
								}
								echo ">Currency incomings<BR></label>
								<label><input id=\"cuo".$itter."\" name=\"cuo".$itter."\" type=\"Checkbox\"";
								if ($right['cuo']) {
								echo " checked";
								}
								echo ">Currency outgoings<BR></label></td></tr></table>";
							$itter = $itter + 1;
						}
					}
				} elseif (isset($prights) and !is_null($prights) AND strcasecmp($_SESSION['usergroup'], "ispclient") == 0) {
					$itter = 0;
					foreach ($prights as $key => $pright) {
						echo "<table id=\"tbl".$itter."\" name=\"tbl".$itter."\">
							<tr><td>Account: ".$key."<input value=\"".$key."\" id=\"acc".$itter."\" name=\"acc".$itter."\" type=\"hidden\"></td><td>";
							if ($pright['sta']) {
								echo "<label><input id=\"sta".$itter."\" name=\"sta".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['sta']) {
									echo " checked";
								}
								echo ">Statements<BR></label>";
							}
							if ($pright['adv']) {
								echo "<label><input id=\"adv".$itter."\" name=\"adv".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['adv']) {
									echo " checked";
								}
								echo ">Advices<BR></label>";
							}
							if ($pright['adm']) {
								echo "<label><input id=\"adm".$itter."\" name=\"adm".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['adm']) {
									echo " checked";
								}
								echo ">Admin messages<BR></label>";
							}
							if ($pright['inp']) {
								echo "<label><input id=\"inp".$itter."\" name=\"inp".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['inp']) {
									echo " checked";
								}
								echo ">Incoming payments<BR></label>";
							}
							if ($pright['oup']) {
								echo "<label><input id=\"oup".$itter."\" name=\"oup".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['oup']) {
									echo " checked";
								}
								echo ">Outgoing payments<BR></label>";
							}
							if ($pright['ino']) {
								echo "<label><input id=\"ino".$itter."\" name=\"ino".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['ino']) {
									echo " checked";
								}
								echo ">Incoming orders<BR></label>";
							}
							if ($pright['ouo']) {
								echo "<label><input id=\"ouo".$itter."\" name=\"ouo".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['ouo']) {
									echo " checked";
								}
								echo ">Outgoing orders<BR></label>";
							}
							if ($pright['cui']) {
								echo "<label><input id=\"cui".$itter."\" name=\"cui".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['cui']) {
									echo " checked";
								}
								echo ">Currency incomings<BR></label>";
							}
							if ($pright['adv']) {
								echo "<label><input id=\"cuo".$itter."\" name=\"cuo".$itter."\" type=\"Checkbox\"";
								if ($prights[$key]['cuo']) {
									echo " checked";
								}
								echo ">Currency outgoings<BR></label>";
							}
							echo "</td></tr></table>";
						$itter = $itter + 1;
					}
				} elseif (!isset($prights) or (isset($prights) and is_null($prights) AND strcasecmp($_SESSION['usergroup'], "ispclient") == 0)) {
					header('Location: ../edocuments/index.php');
				}
				echo "</div><BR><input autofocus type=\"button\" value=\"Update rights\" onclick=\"this.form.submit();\" /></form>";
				if (strcasecmp($_SESSION['usergroup'], "isops") == 0) {
					echo "<script type=\"text/javascript\">rightscreator()</script>";
				}
			} else {
				header('Location: ../edocuments/index.php');
			}
		} else {
			header('Location: ../edocuments/index.php');
		}
	} else {
		header('Location: ../edocuments/index.php');
	}
} else {
	header('Location: ../edocuments/index.php');
}
?>