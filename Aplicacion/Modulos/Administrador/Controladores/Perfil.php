<?php

	class Perfil extends Controlador {
		
		/**
		 * Metodo Publico
		 * Construct()
		 * 
		 **/
		public function __Construct() {
			parent::__Construct();
			AyudasSession::ValSessionGlobal();
		}
		
		/**
		 * Metodo Publico
		 * Index()
		 * 
		 * Muestra la Pantalla Principal de  Productos
		 * 
		 * */
		public function Index() {
			$Usuario = AyudasSession::MostrarDatosUsuaio();
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Nombre', $Usuario['Nombre']);
			$Plantilla->ParametrosEtiquetas('Perfil', $Usuario['Perfil']);	
	        echo $Plantilla->MostrarPlantilla('Perfil/Base.html', 'POS');
			unset($Plantilla, $Usuario);
			exit();
		}
		
		/**
		 * Metodo Publico
		 * 
		 * Modificacion Perfil()
		 * Muestra La Pantalla Para Editar El Perfil Del Usuario
		 * 
		 * */
		public function ModificacionPerfil() {
			$Usuario = AyudasSession::Usuario();
			$Consulta = $this->Modelo->ConsultarUsuarioPerfil($Usuario);
			$Validacion = new NeuralJQueryValidacionFormulario;
	  		$Validacion->Requerido('Nombre', '* Campo Requerido');
	  		$Validacion->Requerido('ApellidoPaterno', '* Campo Requerido');
	  		$Validacion->Requerido('ApellidoMaterno', '* Campo Requerido');
	  		$Validacion->EMail('Correo', '* Introducir un email valido ');
	  		$Validacion->Remote('Password', NeuralRutasApp::RutaURLBase('Administrador/Perfil/ValidacionPassword'), 'POST', '* La Contraseña Debe Tener Minimo 8 Carateres, incluyendo una letra minuscula, mayuscula y un numero.');
			$Validacion->IgualACampo('Password', 'RePassword', '* Las Contraseñas no son iguales');
	  		$Script[] = $Validacion->MostrarValidacion('Form');
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
			$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
				return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
			});
			$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
			$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
			echo $Plantilla->MostrarPlantilla('Perfil/ModificacionPerfil.html');
			unset($Usuario, $Consulta, $Validacion, $Script, $Plantilla);
			exit();
		}
		
		/**
		 * Metodo Publico
		 * 
		 * GuardarModificacionPerfil()
		 * Guarda la Modificacion del Perfil Del Usuario
		 * 
		 * */
		 public function GuardarModificacionPerfil() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
					if(isset($_POST['Nombre']) == true AND  isset($_POST['ApellidoPaterno']) == true AND isset($_POST['ApellidoMaterno']) == true){
						unset($_POST['Validar']);
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Usuario', 'Correo', 'Telefono_Principal', 'Extension', 'Telefono_Movil', 'Telefono_Casa', 'Password', 'RePassword'));
						$DatosPost['Password'] = (!empty($DatosPost['Password'])) ? ($DatosPost['Password'] == $DatosPost['RePassword']) ? $DatosPost['Password'] : '' : '' ;
						unset($DatosPost['RePassword']);
						$Omitidos = ($DatosPost['Password'] == '') ?array('Id', 'Password', 'Usuario', 'Perfil', 'Status') : array('Id', 'Usuario', 'Perfil', 'Status');
						$Condicion = array('Id'=>NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Id']), 'POS'));
		     			$CondicionUsuario = array('Usuario' => $DatosPost['Usuario']);
		     			if ($DatosPost['Password'] != '') {
		     				$Matriz = array('Password' => hash('sha256', $DatosPost['Password']));
		     				unset($DatosPost['Usuario'], $DatosPost['Perfil'], $DatosPost['Status'], $DatosPost['Password'], $DatosPost['Id']);
		     				$this->Modelo->EditarPerfilUsuario($Matriz, $CondicionUsuario, $Omitidos);
		     				$this->Modelo->EditarInformacionPerfil($DatosPost, $Condicion);
		     				unset($DatosPost, $Omitidos, $Condicion, $CondicionUsuario, $Matriz);
		     				exit();
		     			}
		     			else {
		     				unset($DatosPost['Usuario'], $DatosPost['Perfil'], $DatosPost['Status'], $DatosPost['Password'], $DatosPost['Id']);
     						$this->Modelo->EditarInformacionPerfil($DatosPost, $Condicion);
     						unset($DatosPost, $Omitidos, $Condicion, $CondicionUsuario);
     						exit();
						}
					}
				}	 		
		 	}
		 }
		
		/**
		* Metodo Publico
		* ValidacionPassword()
		* 
		* Valida Password a traves de procedimiento remoto
		* 
		* */
		public function ValidacionPassword() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
		 		if(isset($_POST['Password'])){
			  		$regex = '/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/';
					$Validado = (preg_match($regex, $_POST['Password'])) ? "true" : "false";
				   	echo $Validado;
				   	unset($regex, $Validado);
				   	exit();
	  			}
			}
		}
		
	}