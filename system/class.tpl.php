<?php
	class TplClass{

		private $outputData;
		private $params = Array();
		private $tplName = '';
		public $user = Array();

		public function DisplayError($a, $b){
			echo '<h2>'. $a .'</h2>';
			echo $b;
		}

		public function Display($a){
			echo '<div id="'.$a.'">';
		}

		public function DisplayClosed(){
			echo '</div>';
		}

		public function SetAll(){
			if($_SESSION['IS_LOGGED']){
				global $db;
				$users = $db->query("SELECT id, username, rank, look, motto, credits, activity_points, vip_points, last_online, mail, account_created, cms_refers FROM users WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'");
				$user = $users->fetch_array();
				$this->SetParam('USERNM', $user['username']);
				$this->SetParam('USER_ID', $user['id']);
				$this->SetParam('RANK', $user['rank']);
				$this->SetParam('LOOK', $user['look']);
				$this->SetParam('MOTTO', $user['motto']);
				$this->SetParam('MAIL', $user['mail']);
				$this->SetParam('CREDITS', $user['credits']);
				$this->SetParam('PIXELS', $user['activity_points']);
				$this->SetParam('DUCKETS', $user['activity_points']);
				$this->SetParam('DIAMONDS', $user['vip_points']);
				$this->SetParam('LAST_ONLINE', $user['last_online']);
				$this->SetParam('FIRST_DAY', $user['account_created']);
				$this->SetParam('REFERS_POINT', $user['cms_refers']);
			}else{
				$this->SetParam('USERNM', 'Reg&iacute;strate');
				$this->SetParam('RANK', '1');
				$this->SetParam('LOOK', LOOK);
				$this->SetParam('MOTTO', 'Usuario Invitado');
				$this->SetParam('MAIL', 'Inicia sesión');

			}
			unset($_SESSION['IS_LOGGED']);
		}

		public function AddTemplate($Dir, $Name){
			echo $this->GetHtml($Dir, $Name);
		}
		
		public function AddTemplateHK($Dir, $Name){
			echo $this->GetHtmlHK($Dir, $Name);
		}

		public function SetParam($param, $value){
			$this->params[$param] = $value;
		}
		
		public function UnsetParam($param){
			unset($this->params[$param]);
		}		

		public function FilterParams($str){
			foreach ($this->params as $param => $value){
				$str = str_ireplace('{' . $param . '}', $value, $str);
			}
			return $str;
		}

		public function GetHTML($a, $b){
			extract($this->params);
			$file = DIR . SEPARATOR .'Files/' . $a . '/' . $b . '.tpl';
			if(!file_exists($file)){
				$this->DisplayError('Archivo TPL no Encontrado', 'No se ha podido cargar el siguiente TPL: <b>' . $b .'.tpl</b>');
			}else{
				ob_start();
				include($file);
				$data = ob_get_contents();
				ob_end_clean();	
				return $this->FilterParams($data);
			}
		}
		
		public function GetHTMLHK($a, $b){
			extract($this->params);
			$file = DIR . SEPARATOR .'ADMIN/' . $a . '/' . $b . '.tpl';
			if(!file_exists($file)){
				$this->DisplayError('Archivo TPL no Encontrado', 'No se ha podido cargar el siguiente TPL: <b>' . $b .'.tpl</b>');
			}else{
				ob_start();
				include($file);
				$data = ob_get_contents();
				ob_end_clean();	
				return $this->FilterParams($data);
			}
		}
	}
?>