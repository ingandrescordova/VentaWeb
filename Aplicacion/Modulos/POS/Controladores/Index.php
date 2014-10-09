<?php

	/**
	 * Clase Index
	 * 
	 * Clase Inicial que carga el framework para la visualizacion Inicial
	 */
	class Index extends Controlador {
		
		/**
		 * Metodo Contructor
		 * __Construct()
		 * 
		 */
		function __Construct() {
			parent::__Construct();
		}
		
		/**
		 * Metodo Publico
		 * Index()
		 * 
		 * Muestra la pantalla de Login
		 * 
		 * */
		public function Index() {
			$Validacion = new NeuralJQueryValidacionFormulario;
			$Validacion->Requerido('username', '* Ingrese el nombre del usuario');
			$Validacion->Requerido('password', '* Ingrese contraseña');
			$Script[] = $Validacion->MostrarValidacion('Form');
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
			$Plantilla->ParametrosEtiquetas('Key', AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos(date("Y-m-d"), 'POS')));
			echo $Plantilla->MostrarPlantilla('Login/Login.html', 'POS');
			unset($Validacion, $Script, $Plantilla);
			exit();
		}
		
		/**
		 * Metodo Publico
		 * Autenticacion()
		 * 
		 * Autentificaca al usuario
		 * 
		 * */
		public function Autenticacion() {
			if(isset($_POST) AND isset($_POST['Key']) == true AND (NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['Key']), 'POS') == date("Y-m-d")) == true) {
				if(AyudasPost::DatosVacios($_POST) == false) {
					$DatosPost = AyudasPost::FormatoEspacio(AyudasPost::LimpiarInyeccionSQL($_POST));
					$Consulta = $this->Modelo->ConsultarUsuario($DatosPost['username'], hash('sha256', $DatosPost['password']));
					if($Consulta['Cantidad'] == 1) {
						$ConsultaPermisos = $this->Modelo->ConsultarPermisos($Consulta[0]['Perfil']);
						if($ConsultaPermisos['Cantidad'] == 1) {
							AyudasSession::RegistrarSession($Consulta[0], $ConsultaPermisos[0]);
							header("Location: ".NeuralRutasApp::RutaURLBase('Central'));
							unset($DatosPost, $Consulta, $ConsultaPermisos);
							exit();
						}
						else {
							header("Location: ".NeuralRutasApp::RutaURL('LogOut'));
							unset($DatosPost, $Consulta, $ConsultaPermisos);
							exit();
						}
					}
					else {
						$Supension = $this->Modelo->ConsultarSupension($DatosPost['username'], hash('sha256', $DatosPost['password']));
						if($Supension['Cantidad'] == 1) {
							// -- Generar Vista Usuario Supendido
							header("Location: ".NeuralRutasApp::RutaURLBase('Error/SinAutorizacion/Suspendido'));
							unset($DatosPost, $Consulta);
							exit();	
						}
						else {
							// -- Generar Vista Usuario y/o contraseña Incorrecto
							header("Location: ".NeuralRutasApp::RutaURLBase('Error/SinAutorizacion'));
							unset($DatosPost, $Consulta);
							exit();
						}
					}
				}
				else {
					// -- Genera la vista de Datos Vacios
					header("Location: ".NeuralRutasApp::RutaURLBase('Error/SinAutorizacion'));
					exit();
				}
			}
			else {
				header("Location: ".NeuralRutasApp::RutaURL('Index'));
				exit();
			}
		}	
	}