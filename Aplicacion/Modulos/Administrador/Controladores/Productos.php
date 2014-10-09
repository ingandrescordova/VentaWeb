<?php

	class Productos extends Controlador {
		
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
	        echo $Plantilla->MostrarPlantilla('Productos/Base.html', 'POS');
			unset($Plantilla, $Usuario);
			exit();
		}
	    
		/**
	     * Metodo Publico
	     * ListaProducto()
	     * 
	     * Muestra La Vista De Listado De Producto Con La Consulta De Los Productos
	     * 
		 * */    
		public function ListaProducto() {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	        	$Consulta = $this->Modelo->ConsultaProductoLista();
	        	$Plantilla = new NeuralPlantillasTwig;
				$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
				$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
					return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
				});
				echo $Plantilla->MostrarPlantilla('Productos/ListaProducto.html', 'POS');
	            unset($Plantilla, $Consulta);
	        	exit();
			}	
	 	}
	    
		/**
	     * Metodo Publico
	     * AgregarProducto()
	     * 
	     * Muestra La Vista De Agregar Producto
	     * 
		 * */            
		public function AgregarProducto() {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	     		$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('Codigo', '* Campo Requerido');
				$Validacion->Requerido('NombreProducto', '* Campo Requerido');
				$Script[]=$Validacion->MostrarValidacion('Form');
				$Plantilla = new NeuralPlantillasTwig;
				$Plantilla->ParametrosEtiquetas('Controlador', 'Productos');
				$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
	        	echo $Plantilla->MostrarPlantilla('Productos/AgregarProducto.html', 'POS');
	            unset($Plantilla, $Validacion, $Script);
	        	exit();
			}
		}
		
		/**
		 * Metodo Publico
		 * GuardarProducto()
		 * 
		 * Guarda Los Datos Del Producto Pero Verifica Que No Exista Un Producto Con El Mismo Codigo, Si Es Asi, Muestra Una Pantalla De Error
		 * 
		 * **/
		public function GuardarProducto() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
					if(isset($_POST['Codigo']) AND isset($_POST['NombreProducto'])){
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Codigo'));
						$DatosPost = AyudasPost::FormatoMayusOmitido($DatosPost, array('NombreProducto'));
						unset($DatosPost['Validar']);
						$Consulta = $this->Modelo->ConsultarProductoValidar($DatosPost['Codigo']);
						if($Consulta['Cantidad'] != 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Productos/ErrorProducto.html', 'POS');
							unset($DatosPost, $Consulta, $Plantilla);
							exit();	
						}
						else {
							$this->Modelo->InsertarProducto($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Productos/AlertaAgregarProducto.html', 'POS');
							unset($DatosPost, $Consulta, $Plantilla);
							exit();
						}
					}
					else {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('Productos/ErrorCamposRequeridos.html', 'POS');
						unset($Plantilla);
						exit();	
					}
				}
			}
		}
		
		/**
		 * Metodo Publico
		 * EditarProducto($Id = false)
		 * 
		 * Consulta De La Información Del Libro Y Muestra La Pantalla Editar Producto
		 * @param $Id: Campo Id Necesario Para Realizar La Consulta de la Información Del Producto
		 *  
		 * **/
		public function EditarProducto($Id = false) {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	    		if(isset($Id) == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
					$Consulta = $this->Modelo->ConsultaVisualizarProducto(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
					$Validacion = new NeuralJQueryValidacionFormulario;
					$Validacion->Requerido('Codigo', '* Campo Requerido');
					$Validacion->Requerido('NombreProducto', '* Campo Requerido');
					$Script[]=$Validacion->MostrarValidacion('Form');
					$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->ParametrosEtiquetas('Controlador', 'Productos');
					$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
					$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
						return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
					});
					$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
					$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
		        	echo $Plantilla->MostrarPlantilla('Productos/EditarProducto.html', 'POS');
		            unset($Plantilla, $Validacion, $Script, $Consulta, $Id);
		        	exit();
    			}
			}
		}
		
		/**
		 * Metodo Publico
		 * GuardarEditarProducto()
		 * 
		 * Metodo Que Guarda Los Datos De La Vista De Editar
		 * 
		 * **/     
		public function GuardarEditarProducto() {
			if(isset($_POST) AND isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d') ) {
					if(isset($_POST['Codigo']) AND isset($_POST['NombreProducto'])) {
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Codigo'));
						$DatosPost = AyudasPost::FormatoMayusOmitido($DatosPost, array('NombreProducto'));
						unset($DatosPost['Validar']);
						$Consulta = $this->Modelo->ConsultarProductoValidarEditar($DatosPost['Codigo'], NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Id']), 'POS'));
						$DatosPost['Status'] = (isset($_POST['Status'])) ? 'ACTIVO' : 'INACTIVO';
						if($Consulta['Cantidad'] > 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Productos/ErrorEditarProducto.html', 'POS');
							unset($Plantilla, $DatosPost, $Consulta);
							exit();
						}
						else {
							$DatosPost['Id'] = NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Id']), 'POS');
							$this->Modelo->EditarProductoModelo($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Productos/AlertaEditarProducto.html', 'POS');
							unset($Plantilla, $DatosPost, $Consulta);
							exit();	
						}
					}
					else {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('Productos/ErrorCamposRequeridos.html', 'POS');
						unset($Plantilla);
						exit();	
					}
				}
			}
		}
		
		/**
		 * Metodo Publico
		 * EliminarProducto($Id = false)
		 * 
		 * Metodo Que Muestra La Vista Elimanar Producto
		 * @param $Id: Parametro Id Necesario Para Pasarlo A La Vista Eliminar Producto
		 * 
		 * **/
		public function EliminarProducto($Id = false) {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	    		if(isset($Id) == true) {
		        	$Plantilla = new NeuralPlantillasTwig;
		       		$Plantilla->ParametrosEtiquetas('Id', $Id);
		        	echo $Plantilla->MostrarPlantilla('Productos/EliminarProducto.html', 'POS');
		            unset($Plantilla, $Id);
		        	exit();
				}      		
	    	}
		}
		
		/**
		 * Metodo Publico
		 * EliminarProductoStatus($Id = false)
		 * 
		 * Metodo Que Elimina El Producto Deacuero Al Id
		 * @param $Id: Parametro Necesario Para Poder Eliminar El Producto
		 * 
		 * **/
		public function EliminarProductoStatus($Id = false) {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	    		if(isset($Id) == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
		        	$this->Modelo->EliminarProductoStatusModelo(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
		            unset($Id);
					exit();
				}
			}
		}
		
		/**
		 * Metodo Publico
		 * VisualizarProducto($Id= false)
		 * 
		 * Metodo Que Muestra La Vista de Visualizar Producto Con La Informacion Del Producto
		 * @param $Id: Parametro Necesario Para Poder Realizar La COnsulta De La Información Del Producto
		 * 
		 * **/
		public function VisualizarProducto($Id = false) {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	    		if(isset($Id) == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
		        	$Consulta = $this->Modelo->ConsultaVisualizarProducto(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
					$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
		        	echo $Plantilla->MostrarPlantilla('Productos/VisualizarProducto.html', 'POS');
		            unset($Plantilla, $Consulta, $Id);
		        	exit();
	        	}
			}
		}       
	}