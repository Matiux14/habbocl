<?php
	class Functions{
		public function CheckMaintenance($a){
			global $db; 
			$result = $db->query("SELECT * FROM cms_settings WHERE id = 1 LIMIT 1");
			$exp = $db->query("SELECT * FROM users WHERE username = '". $this->FilterText($_SESSION['username']) ."' LIMIT 1");
			while($mant = $result->fetch_array()){ 
				while($mantexp = $exp->fetch_array()){ 
					if($mant['mantenimiento'] == 1 AND $mantexp['rank'] <= 8){
						header("LOCATION: ". PATH ."/Mantenimiento");
					}
				}
			}
		}
		public function GetLast($a){
			if(!empty($a) || !$a == ''){
				if(is_numeric($a)){
					$date = $a;
					$date_now = time();
					$difference = $date_now - $date;
					if($difference <= '59'){ $echo = 'Justo Ahora'; }
					elseif($difference <= '3599' && $difference >= '60'){ 
						$minutos = date('i', $difference);
						if($minutos[0] == 0) { $minutos = $minutos[1]; }
						if($minutos == 1) { $minutos_str = 'minuto'; }
						else { $minutos_str = 'minutos'; }
						$echo = 'Hace '.$minutos.' '.$minutos_str;//Minutos
					}elseif($difference <= '82799' && $difference >= '3600'){
						$horas = date('G', $difference);
						if($horas == 1) { $horas_str = 'hora'; }
						else { $horas_str = 'horas'; }
						$echo = 'Hace '.$horas.' '.$horas_str;//Minutos
					}elseif($difference <= '518399' && $difference >= '82800'){
						$dias = date('j', $difference);
						if($dias == 1) { $dias_str = 'd&iacute;a'; }
						else { $dias_str = 'd&iacute;as'; }
						$echo = 'Hace '.$dias.' '.$dias_str;//Minutos
					}elseif($difference <= '2678399' && $difference >= '518400'){
						$semana = floor(date('j', $difference) / 7).'<!-- WTF -->';
						if($semana == 1) { $semana_str = 'semana'; }
						else { $semana_str = 'semanas'; }
						$echo = 'Hace '.floor($semana).' '.$semana_str;//Minutos
					}else { $echo = 'Hace '.date('n', $difference).' mes(es)'; }
					return $echo;
				}else{ return $a; }
			}else{ return 'A&uacute;n no te has conectado'; }
		}
		
		public function Get($a){
			global $db;
			$result = $db->query("SELECT {$a} FROM users WHERE username = '". $this->FilterText($_SESSION['username']) ."' LIMIT 1");
			$data = $result->fetch_array();
			return $data[$a];
		}
		
		public function GetCount($a){
			global $db;
			$userquery = $db->query("SELECT * FROM {$a}");
			$cnt = $userquery->num_rows;
			return $cnt;
		}
	
		public function GetOns(){
			global $db;																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																													
			$ad = $db->query("SELECT users_online FROM server_status");
			$add = $ad->fetch_array();
			return $add['users_online'];
		}

		public function GetID(){
			global $db;
			$result = $db->query("SELECT id FROM users WHERE username = '". $this->FilterText($_SESSION['username']) ."' LIMIT 1");
			$data = $result->fetch_array();
			return $data['id'];
		}

		public function Logged($a){
			$b = $this->CheckLogged($_SESSION['username'], $_SESSION['password']);
			if($a == "allow"){
				if($b){
					$_SESSION['IS_LOGGED'] = true;		
				}else{
					$_SESSION['IS_LOGGED'] = false;
				}
			}
			elseif($a == "false" AND $b){
				$_SESSION['IS_LOGGED'] = true;		
				header("LOCATION: ". PATH ."/me");
				exit;	
			}elseif($a == "true" AND !$b){
				header("LOCATION: ". PATH ."/index.php");
				exit;
			}elseif($b){
				$_SESSION['IS_LOGGED'] = true;		
			}		
		}

		public function FilterText($a){
			$a = stripslashes(htmlspecialchars($a));
			$a = trim($a);
			$a = str_replace('"','&#34;',$a);
			$a = str_replace("'","&#39;",$a);
			$a = str_replace("<script","",$a);
			$a = str_replace("(","",$a);
			$a = str_replace(")","",$a);
			return $a;  
		}
		
		public function FilterTextEmoji($a){
			$a = stripslashes(htmlspecialchars($a));
			$a = trim($a);
			$a = str_replace('"','&#34;',$a);
			$a = str_replace("'","&#39;",$a);
			$a = str_replace("<script","",$a);
			$a = str_replace("(","",$a);
			$a = str_replace(")","",$a);
			$a = str_replace(':D','<img src="/yezz/img/emojis/carita_sonriente.png" width="24" height="24">',$a);
			$a = str_replace(':P','<img src="/yezz/img/emojis/carita_lengua3.png" width="24" height="24">',$a);
			$a = str_replace('*guino*','<img src="/yezz/img/emojis/carita_guino.png" width="24" height="24">',$a);
			$a = str_replace(':|','<img src="/yezz/img/emojis/carita_plana2.png" width="24" height="24">',$a);
			$a = str_replace('x_x','<img src="/yezz/img/emojis/carita_xx.png" width="24" height="24">',$a);
			$a = str_replace('*risa*','<img src="/yezz/img/emojis/carita_sonriente2.png" width="24" height="24">',$a);
			$a = str_replace('*gallery*','<img src="/yezz/img/emojis/carita_corazon.png" width="24" height="24">',$a);
			$a = str_replace('*heart*','<img src="/yezz/img/emojis/carita_corazon.png" width="24" height="24">',$a);
			$a = str_replace('<3','<img src="/yezz/img/emojis/carita_corazon.png" width="24" height="24">',$a);
			$a = str_replace(':poop:','<img src="/yezz/img/emojis/carita_poop.png" width="24" height="24">',$a);
			$a = str_replace('*triste*','<img src="/yezz/img/emojis/carita_triste.png" width="24" height="24">',$a);
			$a = str_replace('XD','<img src="/yezz/img/emojis/carita_sonriente3.png" width="24" height="24">',$a);
			$a = str_replace('*lengua*','<img src="/yezz/img/emojis/carita_lengua2.png" width="24" height="24">',$a);
			$a = str_replace(';P','<img src="/yezz/img/emojis/carita_lengua1.png" width="24" height="24">',$a);
			$a = str_replace(':O','<img src="/yezz/img/emojis/carita_ooh.png" width="24" height="24">',$a);
			$a = str_replace('*sexy*','<img src="/yezz/img/emojis/carita_sonriente4.png" width="24" height="24">',$a);
			$a = str_replace(':*','<img src="/yezz/img/emojis/carita_kiss1.png" width="24" height="24">',$a);
			$a = str_replace('*kiss*','<img src="/yezz/img/emojis/carita_kiss.png" width="24" height="24">',$a);
			$a = str_replace('O_O','<img src="/yezz/img/emojis/carita_ooh1.png" width="24" height="24">',$a);
			$a = str_replace('^_^','<img src="/yezz/img/emojis/carita_sonriente5.png" width="24" height="24">',$a);
			$a = str_replace(':@','<img src="/yezz/img/emojis/carita_enojado.png" width="24" height="24">',$a);
			$a = str_replace('Q.Q','<img src="/yezz/img/emojis/carita_triste2.png" width="24" height="24">',$a);
			$a = str_replace(':/','<img src="/yezz/img/emojis/carita_triste1.png" width="24" height="24">',$a);
			$a = str_replace('*love*','<img src="/yezz/img/emojis/carita_ojos.png" width="24" height="24">',$a);
			$a = str_replace('-_-','<img src="/yezz/img/emojis/carita_plana.png" width="24" height="24">',$a);
			$a = str_replace('*angel*','<img src="/yezz/img/emojis/carita_angel.png" width="24" height="24">',$a);
			$a = str_replace('*lentes*','<img src="/yezz/img/emojis/carita_lentes.png" width="24" height="24">',$a);
			$a = str_replace('*applause*','<img src="/yezz/img/emojis/carita_applause.png" width="24" height="24">',$a);
			$a = str_replace('*god*','<img src="/yezz/img/emojis/carita_god.png" width="24" height="24">',$a);
			$a = str_replace('*strong*','<img src="/yezz/img/emojis/carita_strong.png" width="24" height="24">',$a);
			$a = str_replace('*decepcionado*','<img src="/yezz/img/emojis/carita_decepcion.png" width="24" height="24">',$a);
			$a = str_replace('*sinpalabras*','<img src="/yezz/img/emojis/carita_sinpalabras.png" width="24" height="24">',$a);
			$a = str_replace('*star*','<img src="/yezz/img/emojis/carita_star.png" width="24" height="24">',$a);
			$a = str_replace('*contodo*','<img src="/yezz/img/emojis/carita_golpe.png" width="24" height="24">',$a);
			$a = str_replace('*angelbebe*','<img src="/yezz/img/emojis/carita_angelbeb.png" width="24" height="24">',$a);
			$a = str_replace('*boy*','<img src="/yezz/img/emojis/carita_boy.png" width="24" height="24">',$a);
			$a = str_replace('*bebe*','<img src="/yezz/img/emojis/carita_bebe.png" width="24" height="24">',$a);
			$a = str_replace('*hey*','<img src="/yezz/img/emojis/boy_hey.png" width="24" height="24">',$a);
			$a = str_replace('*x*','<img src="/yezz/img/emojis/boy_x.png" width="24" height="24">',$a);
			$a = str_replace('*girlhey*','<img src="/yezz/img/emojis/girl_hey.png" width="24" height="24">',$a);
			$a = str_replace('*girlx*','<img src="/yezz/img/emojis/girl_x.png" width="24" height="24">',$a);
			$a = str_replace('*viejo*','<img src="/yezz/img/emojis/carita_viejo.png" width="24" height="24">',$a);
			$a = str_replace('*arrecho*','<img src="/yezz/img/emojis/carita_arrecho.png" width="24" height="24">',$a);
			$a = str_replace('*choquedemanos*','<img src="/yezz/img/emojis/hands.png" width="24" height="24">',$a);
			$a = str_replace('*hands2*','<img src="/yezz/img/emojis/hands2.png" width="24" height="24">',$a);
			$a = str_replace('*hand*','<img src="/yezz/img/emojis/hand.png" width="24" height="24">',$a);
			$a = str_replace('*hand2*','<img src="/yezz/img/emojis/hand2.png" width="24" height="24">',$a);
			$a = str_replace('*fuck*','<img src="/yezz/img/emojis/hand3.png" width="24" height="24">',$a);
			$a = str_replace('*lol*','<img src="/yezz/img/emojis/mecago_delarisa.png" width="24" height="24">',$a);
			$a = str_replace('*fantasma*','<img src="/yezz/img/emojis/fantasma.png" width="24" height="24">',$a);
			$a = str_replace('*lengua*','<img src="/yezz/img/emojis/lengua.png" width="24" height="24">',$a);
			$a = str_replace('*sueño*','<img src="/yezz/img/emojis/carita_sueño.png" width="24" height="24">',$a);
			$a = str_replace('*extra*','<img src="/yezz/img/emojis/carita_extra.png" width="24" height="24">',$a);
			$a = str_replace('*diabla*','<img src="/yezz/img/emojis/carita_diabla.png" width="24" height="24">',$a);
			$a = str_replace('*mongolico*','<img src="/yezz/img/emojis/carita_mongolico.png" width="24" height="24">',$a);
			return $a;  
		}

		public function Hash($a, $b){
			// $a = username || $b = password
			$c = sha1(strtolower($a) . md5($b));
			$c = hash('gost', $c);
			$c = hash('whirlpool', $c);
			$c = hash('sha512', $c);
			return $c;
		}

		public function CheckLogged($a, $b){
			if( !empty($a) AND !empty($b)){
				$banned = $this->CheckBanned($_SESSION['username'], USER_IP);
				if($banned){
					$_SESSION['LOGIN_ERROR'] = $banned;
					$bu = $_SESSION['username'];
					unset($_SESSION['username']);
					unset($_SESSION['password']);
					header("LOCATION: ". PATH ."/?username=". $bu ."&rememberme=false&focus=login-username");
					exit;
				}else{
					global $db;
					$Checked = $db->query("SELECT null FROM users WHERE username = '{$a}' AND password = '{$b}'");
					if($Checked->num_rows > 0){
						$_SESSION['username'] = $a;
						$_SESSION['password'] = $b;
						return true;
					}else{
						return false;
					}	
				}

			}
		}

		public function LoggedHk(){	
			global $db;
			$rank = $db->query("SELECT rank FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
			$ranks = $rank->fetch_array();
			if($ranks['rank'] >= MINRANK){
			}else{
				header("LOCATION: ". PATH ."/me");
				exit;
			}
		}
		
		public function LoggedHkADMIN(){	
			global $db;
			$rank = $db->query("SELECT rank FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
			$ranks = $rank->fetch_array();
			if($ranks['rank'] == MAXRANK){
			}else{
				$_SESSION['ERROR_RETURN'] = "Secci&oacute;n unicamente para los Dueños";
				header("LOCATION: ". HK ." ");
				exit;
			}
		}

		public function Login(){
			if(isset($_POST['username']) AND isset($_POST['password'])){
				$a = $this->FilterText($_POST['username']);
				$b = $this->FilterText($_POST['password']);
				if( empty($a) || empty($b) ){ $error = "Por favor, introduce tu usuario y contraseña para conectarte"; }
				elseif( $this->CheckLogged($a, $this->Hash($a, $b)) ){ header("LOCATION: ". PATH ."/me"); exit; }
				else{ $error = "Tu usuario y contraseña no coinciden "; }
				if( !empty($error) ){
					$_SESSION['LOGIN_ERROR']	 = $error;
					$_SESSION['LOGIN_USERNAME']  = $a;
					$_SESSION['LOGIN_PASSWORD']  = $b;
				}
				header("LOCATION: ". PATH ."/index.php?username=". $a ."&rememberme=false&focus=login-username");
				exit;
			}
			header("LOCATION: ". PATH ."/index.php");
			exit;
		}

		public function GenerateCaptcha(){
			$string = substr(md5(rand()*time()),0,5);
			$string = strtoupper($string);
			$string = str_replace("O","B", $string);
			$string = str_replace("0","C", $string);
			$_SESSION["captcha"] = strtoupper($string);
			return $string;
		}
		
		public function GenerateCode(){
			$string = substr(md5(rand()*time()),0,50);
			$string = strtoupper($string);
			$string = str_replace("O","B", $string);
			$string = str_replace("0","C", $string);
			$_SESSION["captcha"] = strtoupper($string);
			return $string;
		}

		public function GenerateTicket(){
			$sessionKey = 'YeezyCMS-'.rand(9,999).'-'.substr(sha1(time()).'-'.rand(9,9999999).'-'.rand(9,9999999).'-'.rand(9,9999999),0,33);
			return $sessionKey;
			
		}
		
		public function AddUser($username, $email, $password, $facebook_id, $facebook){
			global $db;
			$dbRegister = array();
			$dbRegister['username'] = $username;
			$dbRegister['password'] = $password;
			$dbRegister['mail'] = $email;
			$dbRegister['rank'] = 1;
			$dbRegister['gender'] = 'm';
			$dbRegister['account_created'] = time();
			$dbRegister['last_online'] = time();
			$dbRegister['ip_last'] = USER_IP;
			$dbRegister['ip_reg'] = USER_IP;
			$dbRegister['facebook_id'] = $facebook_id;
			$dbRegister['facebook'] = $facebook;
			$query = $db->insertInto('users', $dbRegister);
			$id = $db->insert_id();
			$dbInfo = array();
			$dbInfo['user_id'] = $id;
			$query = $db->insertInto('user_info', $dbInfo);
			return true;
		}
		
		public function AddTicket($id,$ticket){
			global $db;
			$ok = $db->query("SELECT NULL FROM user_auth_ticket WHERE user_id = '{$id}'");
			if($ok->num_rows > 0){
				$r1 = $db->query("DELETE FROM user_auth_ticket WHERE user_id = '{$id}' LIMIT 1");
			}
			$dbQuery= array();
			$dbQuery['userid'] = $id;
			$dbQuery['sessionticket'] = $ticket;
			$dbQuery['ipaddress'] = USER_IP;
			$query = $db->insertInto('user_auth_ticket', $dbQuery);
			return true;
		}
	
		public function ComprobateExist($a){
			global $db;
			$result = $db->query("SELECT * FROM users WHERE username = '{$a}' OR mail = '{$a}' LIMIT 1");
			if($db->num_rows($result) > 0){
				return true;
			}else{
				return false;
			}
		}
		
		public function ComprobateExistIP($a){
			global $db;
			$result = $db->query("SELECT null FROM users WHERE ip_reg = '".$_SERVER['REMOTE_ADDR']."'");
			if($db->num_rows($result) > 0){
				return true;
			}else{
				return false;
			}
		}
		
		public function CheckBanned($u, $ip){
			$H = date('H');
			$i = date('i');
			$s = date('s');
			$m = date('m');
			$d = date('d');
			$Y = date('Y');
			$j = date('j');
			$n = date('n');
			$today = $d;
			$month = $m;
			$year = $Y;
			global $db;
			$u = $this->FilterText($u);
			$ip = $this->FilterText($ip);
			$checkban = $db->query("SELECT * FROM bans WHERE value = '{$u}' or value = '{$ip}' LIMIT 1");
			if($checkban->num_rows < 1){ return false; } else {
				$bandata = $checkban->fetch_array();
				$reason = $bandata['reason'];
				$expire = $bandata['expire'];
				$xbits = explode(" ", $expire);
				$xtime = explode(":", $xbits[1]);
				$xdate = explode("-", $xbits[0]);
				$stamp_now = mktime(date('H'),date('i'),date('s'),$today,$month,$year);
				$datetoex = date("d-m-y",$expire);
				if(time() < $bandata['expire']){
					$login_error = "Has sido banedo por esta razón: \"".$reason."\". Tu baneo expira el: ".$datetoex.".";
					return $login_error;
				} else { 
					$db->query("DELETE FROM bans WHERE value = '{$u}' OR value = '{$ip}' LIMIT 1");
					return false;
				}
			}
		}
		
		public function RegisterSubmit(){
			if(isset($_POST['reg_username']) AND isset($_POST['reg_mail']) AND isset($_POST['reg_password']) AND isset($_POST['reg_password2']) AND isset($_POST['badge'])){

				$user = $this->FilterText($_POST['reg_username']);
				$mail = $this->FilterText($_POST['reg_mail']);
				$password = $this->FilterText($_POST['reg_password']);
				$password2 = $this->FilterText($_POST['reg_password2']);
				$dia = $this->FilterText($_POST['DD']);
				$mes = $this->FilterText($_POST['MM']);
				$ano = $this->FilterText($_POST['AAAA']);
				$badge = $this->FilterText($_POST['badge']);
				$gender = $this->FilterText($_POST['gender']);
				$nlook = $this->FilterText($_POST['look']);


				$_SESSION['REG_USERNAME'] = $user;
				$_SESSION['REG_MAIL'] = $mail;
				$_SESSION['REG_PASSWORD'] = $password;
				$_SESSION['REG_PASSWORD2'] = $password2;
			}
			header("LOCATION: ". PATH ."/welcome/register?&username&password");
			if(empty($user) || empty($mail) || empty($password) || empty($password2) || empty($dia) || empty($mes) || empty($ano) || empty($badge)){
					$_SESSION['REG_ERROR'] = "Rellena todos los campos";
				}else{
					//USERNAME CHECK
					$filter = preg_replace("/[^a-z\d\-=\?!@:\.]/i", "", $user);
					if($user !== $filter || strlen($user) < 2 || strlen($user) > 18){
						$error_1 = "<li>Inserta un nombre valido (Min: 2 Caract. Max 18 Caract)</li>";
					}elseif($this->ComprobateExist($user)){
						$error_1 = "<li>Ese nombre ya est&aacute; en uso</li>";
					}
					//IP CHECK
					global $db;
					$result = $db->query("SELECT * FROM cms_settings WHERE id = '1'");
						while($data = $result->fetch_array()){
						if($data['reg_ip'] == 1){
						   if($this->ComprobateExistIP($ip_reg)){
								$error_1 = "<li>¡Solo esta permitido 1 usuario por IP!</li>";
							} 
						}
					}
					//MOD CHECK
					global $db;
					$result = $db->query("SELECT * FROM cms_settings WHERE id = '1'");
						while($data = $result->fetch_array()){
						if($data['reg_mod'] == 1){
						   if(strpos($_SESSION['REG_USERNAME'], 'MOD-') !== false){
								$error_1 = "<li>Nombre No Permitido. Intenta con otro Diferente</li>"; 
							} 
						}
					} 
					//MAIL CHECK
					$email_check = preg_match("/^[a-z0-9_\.-]+@([a-z0-9]+([\-]+[a-z0-9]+)*\.)+[a-z]{2,7}$/i", $mail);
					if($email_check !== 1){
						$error_2 = "<li>Inserta un email v&aacute;lido</li>";
					}elseif($this->ComprobateExist($mail)){
						$error_2 = "<li>Inserta otro email, ese ya existe</li>";
					}
					//PASSWORD CHECK
					if(strlen($password) < 6 || strlen($password) > 32){
						$error_3 = "<li><b>Escribe una contrase&ntilde;a v&aacute;lida (debe atener m&aacute;s de 6 caracteristicas)</b></li>";
					}elseif(strlen($password) !== strlen($password2)){
						$error_2 = "<li>Las contrase&ntilde;as no coinciden</li>";
					}

					if(!empty($error_1) || !empty($error_2) || !empty($error_3) || !empty($error_4)){
						$_SESSION['REG_ERROR'] = $error_1 . $error_2 . $error_3 . $error_4;
					}else{
						$password3 = $this->Hash($user, $password);
						$this->AddUser($user, $mail, $password3, '', '');
						$_SESSION['username'] = $user;
						$_SESSION['password'] = $password3;
						global $db;
						$db->query("UPDATE users SET cms_birthday = '".$dia."/".$mes."/".$ano."', look = '".$nlook."' WHERE username = '".$_SESSION['username']."' LIMIT 1");	
						$check = $db->query("SELECT * FROM users WHERE username = '".$_SESSION['username']."' LIMIT 1");
						$row = $check->fetch_array();
						$db->query("INSERT INTO user_badges (user_id, badge_id, badge_slot) VALUES ('".$row['id']."', '".$badge."', '0')");
						//REFERIDO
						if(!empty($_SESSION['refer'])){
							$db->query("UPDATE users SET cms_refers = cms_refers + '1' WHERE ".$this->FilterText($_SESSION['refer_type'])." = '".$this->FilterText($_SESSION['refer'])."' LIMIT 1");
						}
						//HACEMOS EL LOGUEO
						$_SESSION['connection_type'] = "id";
						header("LOCATION: ". PATH ."/me");
						return true;
					}
				}
			exit;
		}
	}
?>