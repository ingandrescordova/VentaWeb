<?php

	class Proveedores extends Controlador {
		
		/**
		 * Metodo Contructor
		 * 
		 */
		function __construct() {
			parent::__Construct();
			AyudasSession::ValSessionGlobal();
		}
		
		/**
		 * Metodo Index
		 * 
		 * Pantalla Principal de Proveedores
		 * 
		 */
		public function Index() {
			$Usuario = AyudasSession::MostrarDatosUsuaio();
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Nombre', $Usuario['Nombre']);
			$Plantilla->ParametrosEtiquetas('Perfil', $Usuario['Perfil']);	
	        echo $Plantilla->MostrarPlantilla('Proveedores/Base.html', 'POS');
	        unset($Plantilla, $Usuario);
	        exit();
		}
	    
		/**
		 * Metodo Publico
		 * ListaProveedores()
		 * 
		 * Pantalla De El Listado De Proveedores
		 * 
		 * */    
		public function ListaProveedores() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	        	$Consulta = $this->Modelo->ConsultaProveedoresLista();
	        	$Plantilla = new NeuralPlantillasTwig;
	        	$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
				$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
					return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
				});
	        	echo $Plantilla->MostrarPlantilla('Proveedores/ListaProveedores.html', 'POS');
	            unset($Plantilla, $Consulta);
	        	exit();
	 		}	
	   	}
	   	
	   	/**
	   	 * Metodo Publico
	   	 * AgregarProveedor()
	   	 * 
	   	 * Pantalla Agregar Proveedor
	   	 * 
	   	 * */
	 	public function AgregarProveedor() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('RFC', '* Campo Requerido');
				$Validacion->CantMaxCaracteres('RFC', 13,'* Maximo 13 Caracteres' );
				$Validacion->Requerido('Nombre_Comercial', '* Campo Requerido');
				$Validacion->Requerido('Razon_Social', '* Campo Requerido');
				$Validacion->Requerido('Telefono_Proveedor', '* Campo Requerido ');
				$Validacion->Requerido('Nombre_Representante', '* Campo Requerido');
				$Validacion->URL('URL', '* URL no valida');
				$Validacion->Remote('RFC', NeuralRutasApp::RutaURLBase('Administrador/Proveedores/ValidacionRFC'), 'POST', 'RFC incorrecto');
				$Validacion->EMail('Correo', '* Correo no valido');
				$Script[] = $Validacion->MostrarValidacion('Form');
			    $Plantilla = new NeuralPlantillasTwig;
			    $Plantilla->ParametrosEtiquetas('Controlador', 'Proveedores');
			    $Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
	    		echo $Plantilla->MostrarPlantilla('Proveedores/AgregarProveedor.html', 'POS');
	      		unset($Plantilla, $Validacion, $Script);
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
	  	 * GuardarProveedor()
	  	 *	
	  	 * Guardar los datos del proveedor
	  	 * 
	  	 * */
	  	public function GuardarProveedor() {
	  		if( isset($_POST) AND isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	        	if(isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
	        		if($_POST['RFC'] AND $_POST['Nombre_Comercial'] AND $_POST['Razon_Social'] AND $_POST['Telefono_Proveedor'] AND $_POST['Nombre_Representante']) {	
		        		$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('RFC', 'URL', 'Correo', 'Telefono_Proveedor', 'Telefono_Representante', 'Movil_Representante'));
						$DatosPost = AyudasPost::FormatoMayusOmitido($DatosPost, array('Nombre_Comercial', 'Razon_Social', 'Telefono_Proveedor', 'URL', 'Direccion', 'Nombre_Representante', 'Cargo', 'Telefono_Representante', 'Movil_Representante', 'Correo'));
						unset($DatosPost['Validar']);
	        			$Proveedor = $this->Modelo->ConsultarProveedor($DatosPost['RFC'], $DatosPost['Nombre_Comercial'], $DatosPost['Razon_Social']);
	        			if($Proveedor['Cantidad'] != 0 ) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Proveedores/ErrorExisteProveedor.html', 'POS');
							unset($Proveedor, $Plantilla, $DatosPost);
							exit();
						}
						else {
							$this->Modelo->InsertarProveedor($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Proveedores/AlertaAgregarProveedor.html', 'POS');
							unset($DatosPost, $Proveedor, $Plantilla);
							exit(); 	
						}
					}
					else {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('Proveedores/ErrorParametrosRequeridos.html', 'POS');
						unset($Plantilla);
						exit();	
					}	            	
				}
			}
		}          
	            
	    /**
		 * Metodo Publico
		 * frmEditarProveedores($Id = false)
		 * 
		 * Pantalla Editar Proveedores
		 * @param $Id: Id Del Proveedor Necesario Para La Consulta
		 * 
		 * */    
		public function frmEditarProveedor($Id = false) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if($Id == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
		        	$Consulta = $this->Modelo->ProveedorVisualizar(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
					$Validacion = new NeuralJQueryValidacionFormulario;
					$Validacion->Requerido('RFC', '* Campo Requerido');
					$Validacion->CantMaxCaracteres('RFC', 13,'* Maximo 13 Caracteres' );
					$Validacion->Requerido('Nombre_Comercial', '* Campo Requerido');
					$Validacion->Requerido('Razon_Social', '* Campo Requerido');
					$Validacion->Requerido('Telefono_Proveedor', '* Campo Requerido ');
					$Validacion->Requerido('Nombre_Representante', '* Solo introducir numeros');
					$Validacion->EMail('Correo', '* Correo Invalido');
					$Validacion->URL('URL', '* URL  no valida');
					$Validacion->Remote('RFC', NeuralRutasApp::RutaURLBase('Administrador/Proveedores/ValidacionRFC'), 'POST', 'RFC incorrecto');
					$Script[] = $Validacion->MostrarValidacion('Form');	
					$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
					$Plantilla->ParametrosEtiquetas('Id', $Id);
					$Plantilla->ParametrosEtiquetas('Controlador', 'Proveedores');
   					$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
					$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
		       		echo $Plantilla->MostrarPlantilla('Proveedores/EditarProveedor.html', 'POS');
		            unset($Plantilla, $Validacion, $Script, $Id, $Consulta);
		        	exit();
   				}
	 		}
	   	}
	   	
	   	/**
	   	 * Metodo Publico
	   	 * EditarProveedor()
	   	 * 
	   	 * Genera La Consulta Para Editar El Proveedor
	   	 * 
	   	 * */
	   	public function EditarProveedor() {
	   		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	        	if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
	        		if(isset($_POST['RFC']) AND isset($_POST['Razon_Social']) AND isset($_POST['Nombre_Comercial'])) {
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('RFC', 'URL', 'Correo', 'Telefono_Proveedor', 'Telefono_Representante', 'Movil_Representante', 'Status'));
						$DatosPost = AyudasPost::FormatoMayusOmitido($DatosPost, array('Nombre_Comercial', 'Razon_Social', 'Telefono_Proveedor', 'URL', 'Direccion', 'Nombre_Representante', 'Cargo', 'Telefono_Representante', 'Movil_Representante', 'Correo'));					
						$IdProveedor = NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Id']), 'POS');
						$Proveedor = $this->Modelo->ConsultarProveedorEditar($DatosPost['RFC'], $DatosPost['Nombre_Comercial'], $DatosPost['Razon_Social'], $IdProveedor);
						$DatosPost['Status'] = (isset($_POST['Status'])) ? 'ACTIVO' : 'INACTIVO';
						if($Proveedor['Cantidad'] > 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Proveedores/ErrorEditarProveedor.html', 'POS');
							unset($Proveedor, $Plantilla, $DatosPost, $IdProveedor);
							exit();
						}
						else {
							unset($DatosPost['Validar']);
							$Condicion = array('Id' =>$IdProveedor);
							unset($DatosPost['Id']);
							$Consulta = $this->Modelo->EditarProveedor($DatosPost, $Condicion);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Proveedores/AlertaAgregarProveedor.html', 'POS');
							unset($DatosPost, $Condicion, $IdProveedor, $Plantilla, $Proveedor);
							exit();	
						}	
					}
					else {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('Proveedores/ErrorParametrosRequeridos.html', 'POS');
						unset($Plantilla);
						exit();
					}
				}
			}
	   	}
	     
		/**
		 * Metodo Publico
		 * frmEliminarProveedor($Id = false )
		 * 
		 * Pantalla De Eliminar Proveedor
		 * @param $Id: Id Del Proveedor Necesario Para Realizar La Eliminacion
		 * 
		 * */    
		public function frmEliminarProveedor($Id = false) {
	 		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			if($Id == true) {
	 				$Plantilla = new NeuralPlantillasTwig;
	 				$Plantilla->ParametrosEtiquetas('Id', $Id);
					echo $Plantilla->MostrarPlantilla('Proveedores/EliminarProveedor.html', 'POS');
			        unset($Plantilla, $Id);
					exit();
				}
			}
		}
		
		/**
		 * Metodo Publico
		 * EliminarProveedor($Id = false)
		 * 
		 * Genera La Consulta Para Eliminar
		 * @param $Id: Necesario Para Realizar La Consulta
		 * 
		 * */
		public function EliminarProveedor($Id = false) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			if($Id == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS')) ) {
					$Consulta = $this->Modelo->EliminarProveedor(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
					unset($Id, $Consulta);
					exit();
				}
			}	
		}
	    
		/**
		 * Metodo Publico
		 * VisualizarProveedor($Id = false)
		 * 
		 * Pantalla De Visualizar Proveedor
		 * @param $Id: Id Del Proveedor Necesario Para La Consulta
		 * 
		 * */    
	    public function VisualizarProveedor($Id = false) {
	   		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
			   	if($Id == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
	       			$Consulta = $this->Modelo->ProveedorVisualizar(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
	       			$Plantilla = new NeuralPlantillasTwig;
	       			$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
	        		echo $Plantilla->MostrarPlantilla('Proveedores/VisualizarProveedor.html', 'POS');
	                unset($Plantilla, $Consulta, $Id);
	        		exit();
				}
			}	
	  	}
	}