<?php
	
	class ControlInventario extends Controlador {
		
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
		 * Pantalla Principal de ControlInventario
		 * 
		 */
		public function Index() {
			$Usuario = AyudasSession::MostrarDatosUsuaio();
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Nombre', $Usuario['Nombre']);
			$Plantilla->ParametrosEtiquetas('Perfil', $Usuario['Perfil']);	
	        echo $Plantilla->MostrarPlantilla('ControlInventario/BaseInventario.html', 'POS');
			unset($Plantilla, $Usuario);
			exit();
		}
		
		/**
	     * Metodo Publico
	     * ListaInventario()
	     * 
	     * Muestra La Vista De Listado De Inventario Con La Consulta De Los Inventario
	     * 
		 * */    
		public function ListaInventario() {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	        	$Consulta = $this->Modelo->ConsultaInventarioLista();
	        	$Plantilla = new NeuralPlantillasTwig;
				$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
				$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
					return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
				});
				echo $Plantilla->MostrarPlantilla('ControlInventario/ListadoInventario.html', 'POS');
	            unset($Plantilla, $Consulta);
	        	exit();
			}	
	 	}
	 	
	 	/**
	     * Metodo Publico
	     * AgregarProductoInventario()
	     * 
	     * Muestra La Vista De Agregar Producto Inventario
	     * 
		 * */            
		public function AgregarProductoInventario() {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	     		$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('Stock_Minimo', '* Campo Requerido');
				$Validacion->Requerido('Stock_Maximo', '* Campo Requerido');
				$Validacion->Requerido('Precio_Venta', '* Campo Requerido');
				$Validacion->Digitos('Stock_Minimo', '*Solo Introducir Numeros');
				$Validacion->Digitos('Stock_Maximo', '*Solo Introducir Numeros');
				$Script[]=$Validacion->MostrarValidacion('Form');
				$Plantilla = new NeuralPlantillasTwig;
				$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
	        	echo $Plantilla->MostrarPlantilla('ControlInventario/AgregarProductoInventario.html', 'POS');
	            unset($Plantilla, $Validacion, $Script);
	        	exit();
			}
		}
		
		/**
		 * Metodo Publico
		 * ConsultarCodigo()
		 * 
		 * Realiza La Consulta Del Codigo En La Tabla Producto
		 * 
		 * */
		 public function ConsultarCodigo() {
		 	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			$Consulta = $this->Modelo->ConsultarCodigoProducto($_POST['CodigoM']);
		 		if($Consulta['Cantidad'] > 0) {
		 			unset($Consulta['Cantidad']);
		 			$Plantilla = new NeuralPlantillasTwig;
		 			$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
		 			$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
					return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
					});
		 			echo $Plantilla->MostrarPlantilla('ControlInventario/ResultadosModalCodigo.html', 'POS');
		 			unset($Plantilla, $Consulta);
		 			exit();
		 		}
		 		else {
		 			echo '<div class="alert alert-error"> <button type="button" class="close"  data-dismiss="alert"> </button>Error: No existe registro con el parámetro de búsqueda seleccionado.</div>';
		 			unset($Consulta);
		 			exit();
		 		}
		 	}
		 }
		 
		 /**
		 * Metodo Publico
		 * ConsultarDescripcion()
		 * 
		 * Realiza La Consulta De la Descripcion En La Tabla Producto
		 * 
		 * */
		 public function ConsultarDescripcion() {
		 	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			$Consulta = $this->Modelo->ConsultarDescripcionProducto($_POST['DescripcionM']);
		 		if($Consulta['Cantidad'] > 0) {
		 			unset($Consulta['Cantidad']);
		 			$Plantilla = new NeuralPlantillasTwig;
		 			$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
		 			$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
					return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
					});
		 			echo $Plantilla->MostrarPlantilla('ControlInventario/ResultadosModalDescripcion.html', 'POS');
		 			unset($Plantilla, $Consulta);
		 			exit();
		 			
		 		}
		 		else {
		 			echo '<div class="alert alert-error"> <button type="button" class="close"  data-dismiss="alert"> </button>Error: No existe registro con el parámetro de búsqueda seleccionado.</div>';
		 			unset($Consulta);
		 			exit();
		 		}
		 	}
		 }
		 
		 /**
	     * Metodo Publico
	     * AgregarProductoFormaResultado()
	     * 
	     * Muestra La Vista De Agregar Producto Inventario
	     * 
		 * */            
		public function AgregarProductoFormaResultado() {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	    		$Consulta = $this->Modelo->ConsultarProductoId(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['OpcionRadio']), 'POS'));
	    		$Consulta['0']['Id'] = AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Consulta['0']['Id'], 'POS'));
	    		echo json_encode($Consulta, true);
	            unset($Consulta);
	        	exit();
			}
		}
		
		/**
		 * Metodo Publico
		 * GuardarProductoInventario()
		 * 
		 * Guarda Los Datos Del Producto En Inventario
		 * 
		 * **/
		public function GuardarProductoInventario() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
					if(isset($_POST['Codigo']) AND isset($_POST['NombreProducto'])){
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Codigo'));
						unset($DatosPost['Validar'], $DatosPost['NombreProducto'], $DatosPost['Codigo']);
						$Consulta = $this->Modelo->ConsultarCodigoExistente(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Producto']), 'POS'));
						if($Consulta['Cantidad'] > 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('ControlInventario/ErrorDuplicidadDatos.html', 'POS');
							unset($Plantilla, $DatosPost, $Consulta);
							exit();
						}
						else {
							$DatosPost['Producto'] = NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Producto']), 'POS');
							$this->Modelo->GuardarInventario($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('ControlInventario/AlertaAgregarControlInventario.html', 'POS');
							unset($DatosPost, $Consulta, $Plantilla);
							exit();
						}						
					}
				}
			}
		}
		
		/**
		 * Metodo Publico
		 * EditarProductoInventario($Id_Producto = false, $Id_Inventario = false)
		 * 
		 * Muestra La Pantalla De Editar
		 * @param $Id_Inventario: Necesario Para Mostrar Los Datos Del Producto
		 * 
		 * */
		public function EditarProductoInventario($Id = false) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if($Id == true AND  is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
					$Consulta = $this->Modelo->ConsultaInventarioEditar(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
					$Validacion = new NeuralJQueryValidacionFormulario;
					$Validacion->Requerido('Stock_Minimo', '* Campo Requerido');
					$Validacion->Requerido('Stock_Maximo', '* Campo Requerido');
					$Validacion->Requerido('Precio_Venta', '* Campo Requerido');
					$Validacion->Digitos('Stock_Minimo', '*Solo Introducir Numeros');
					$Validacion->Digitos('Stock_Maximo', '*Solo Introducir Numeros');
					$Script[]=$Validacion->MostrarValidacion('Form');
					$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
					$Plantilla->ParametrosEtiquetas('Id', $Id);
					$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
					$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
					echo $Plantilla->MostrarPlantilla('ControlInventario/EditarProductoInventario.html', 'POS');
					unset($Consulta, $Validacion, $Script, $Plantilla);
					exit();
				}
			}
		}
		
		/**
		 * Metodo Publico
		 * EditarProducto()
		 * 
		 * Metodo Que Actualiza Los Datos Del Producto
		 * 
		 * */
		public function EditarProducto() {
	 		if(isset($_POST) == true AND isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			 if($_POST['Stock_Minimo'] == true AND $_POST['Precio_Venta'] == true) {
	 			 	$_POST['Status'] = (isset($_POST['Status'])) ? 'ACTIVO' : 'INACTIVO';
	 			 	unset($_POST['Validar'], $_POST['NombreProducto'], $_POST['Codigo']);
	 			 	$Condicion = array('Id' => NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['Id']), 'POS'));
	 				unset($_POST['Id']);
	 				$Consulta = $this->Modelo->EditarProductoInventario($_POST, $Condicion);
	 				unset($Consulta, $Condicion);
	 				exit();
	 			}
 			}
		}
		
		/**
		 * Metodo Publico
		 * VisualizarProductoInventario($Id_Inventario = false)
		 * 
		 * Muestra La Pantalla De Visualizar
		 * 
		 * */
		public function VisualizarProductoInventario($Id_Inventario = false) {
			if(isset($Id_Inventario) == true AND isset($_POST) == true AND isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Consulta = $this->Modelo->VisualizarInventario(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id_Inventario), 'POS'));
			 	$Plantilla = new NeuralPlantillasTwig;
			 	$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
			 	echo $Plantilla->MostrarPlantilla('ControlInventario/VisualizarProductoInventario.html', 'POS');
			 	unset($Consulta, $Plantilla);
			 	exit();
		 	}
		}
		 
		 /**
		  * Metodo Publico
		  * EliminarProductoInventario()
		  * 
		  * Muestra La Pantalla De Eliminar Producto De Inventario
		  * @param $Id_Inventario: Necesario Para Eliminar El Producto
		  * 
		  * */
		public function EliminarProductoInventario($Id = false) {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			$Plantilla = new NeuralPlantillasTwig;
	 			$Plantilla->ParametrosEtiquetas('Id', $Id);
	 			echo $Plantilla->MostrarPlantilla('ControlInventario/EliminarProductoInventario.html', 'POS');
	 			unset($Plantilla);
	 			exit();
		 	}
		}
		 
		/**
		 * Metodo Publico
		 * EliminarProducto($Id_Inventario = false)	 
		 * 
		 * Elimina El Producto De Acuerdo Al Id
		 * @param $Id_Inventario: Necesario Para Realizar La Eminacion
		 * 
		 * */
	  	public function EliminarProducto($Id = false) {
	  		if(isset($Id) == true AND ($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	  			if(isset($Id) == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
		        	$this->Modelo->EliminarProductoInventarioStatus(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
		            exit();
				}
  			}
	  	}
	}