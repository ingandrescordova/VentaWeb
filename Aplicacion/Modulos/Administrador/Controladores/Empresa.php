<?php

	class Empresa extends Controlador {
	
		function __construct() {
			parent::__Construct();
			AyudasSession::ValSessionGlobal();
		}
		
		/**
		 * Metodo Index
		 * 
		 * Pantalla Principal de Empresa
		 * 
		 */
		public function Index() {
			$Usuario = AyudasSession::MostrarDatosUsuaio();
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Nombre', $Usuario['Nombre']);
			$Plantilla->ParametrosEtiquetas('Perfil', $Usuario['Perfil']);	
	        echo $Plantilla->MostrarPlantilla('Empresa/Base.html', 'POS');
	        unset($Plantilla, $Usuario);
	        exit();
		}
		
		
		/**
		 * Metodo Publico
		 * frmPrincipalEmpresa()
		 * 
		 * Muestra La Pantalla Principal De Empresa
		 * 
		 * */
		 public function frmPrincipalEmpresa() {
		 	$Plantilla = new NeuralPlantillasTwig;
		 	echo $Plantilla->MostrarPlantilla('Empresa/PrincipalEmpresa.html', 'POS');
		 	unset($Plantilla);
			exit();	
		 }
		 
		/**
		 * Metodo Publico
		 * frmAgregarEmpresa()
		 * 
		 * Muestra La Pantalla de Agregar Empresa
		 * 
		 * */
		public function frmAgregarEmpresa() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Consulta = $this->Modelo->ConsultarDatosEmpresa();
				$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('RFC', '* Campo Requerido');
				$Validacion->CantMaxCaracteres('RFC', 13,'* Maximo 13 Caracteres' );
				$Validacion->Requerido('Nombre_Comercial', '* Campo Requerido');
				$Validacion->Requerido('Razon_Social', '* Campo Requerido');
				$Validacion->Requerido('Telefono_Proveedor', '* Campo Requerido ');
				$Validacion->Requerido('Nombre_Representante', '* Campo Requerido');
				$Validacion->Requerido('IVA', '* Campo Requerido');
				$Validacion->Digitos('IVA', '* Solo introducir numeros');
				$Validacion->URL('URL', '* URL no valida');
				$Validacion->Remote('RFC', NeuralRutasApp::RutaURLBase('Administrador/Empresa/ValidacionRFC'), 'POST', 'RFC incorrecto');
				$Script[] = $Validacion->MostrarValidacion('Form');
			    $Plantilla = new NeuralPlantillasTwig;
			    $Plantilla->ParametrosEtiquetas('Controlador', 'Inventario');
			    $Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
			    $Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
					return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
				});
			    $Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
				echo $Plantilla->MostrarPlantilla('Empresa/AgregarEmpresa.html', 'POS');
	      		unset($Plantilla, $Validacion, $Consulta, $Script);
	    		exit();
	  		}
		}
		
		/**
	 	 * Metodo Publico
	 	 * ValidacionRFC()
	 	 * 
	 	 * Valida RFC a traves de procedimiento remoto
	 	 * 
	 	 * */
	 	public function ValidacionRFC() {
	 		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
			 	if(isset($_POST['RFC'])){
			 		$regex = '/^[A-Z]{3,4}([0-9]{2})(1[0-2]|0[1-9])([0-3][0-9])([ -]?)([A-Z0-9]{2,4})$/';
			  		$Validado = (preg_match($regex, $_POST['RFC'])) ? "true" : "false";
			  		echo $Validado;
			  		unset($regex, $Validado);
			  		exit();
		 	 	}
 	 		}
	 	}
	 	
	 	/**
	 	 * Metodo Publico
	 	 * GuardarEmpresa()
	 	 * 
	 	 * Guarda Los Datos De La Empresa
	 	 * 
	 	 * */
	 	public function GuardarEmpresa() {
	 		if( isset($_POST) AND isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			if(isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
	 				if($_POST['RFC'] AND $_POST['Nombre_Comercial'] AND $_POST['Razon_Social'] AND $_POST['Telefono_Proveedor'] AND $_POST['IVA']) {
	 					$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('RFC', 'URL', 'Telefono_Proveedor', 'IVA'));
						$DatosPost = AyudasPost::FormatoMayusOmitido($DatosPost, array('Nombre_Comercial', 'Razon_Social', 'Telefono_Proveedor', 'URL', 'Direccion','IVA', 'Mensaje'));
						$Condicion = array('Id' => NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Id']), 'POS'));
						unset($DatosPost['Validar'], $DatosPost['Id']);
						$Consulta = $this->Modelo->ActualizarDatosEmpresa($DatosPost, $Condicion);
						unset($DatosPost, $Condicion);
						exit();
 					}
	 			}
			}	 		
	 	}
	}