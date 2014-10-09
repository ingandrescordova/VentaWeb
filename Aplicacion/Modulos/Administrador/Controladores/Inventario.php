<?php

	class Inventario extends Controlador {
		
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
	        echo $Plantilla->MostrarPlantilla('Inventario/Base.html', 'POS');
			unset($Plantilla, $Usuario);
			exit();
		}
		
		/**
		* Metodo Publico
		* frmInicioInventario()
		* 
		* Muestra La Pantalla Principal De Inventario
		* 
		* */
		public function frmInicioInventario() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Plantilla = new NeuralPlantillasTwig;
				echo $Plantilla->MostrarPlantilla('Inventario/PrincipalInventario.html');
				unset($Plantilla);
				exit();
			}	
		}
		
		/**
		* Metodo Publico
		* ListaInventario()
		* 
		* Muestra el Listado de Inventario
		* 
		* */
		public function ListaInventario() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$ConsultaControlInventario = $this->Modelo->ListaControlInventario();
				if(count($ConsultaControlInventario) > 0) {
					$ConsultaInvetario = $this->Modelo->ListaInventario();
					$Arreglo = AyudasInventario::GenerarListaInventario($ConsultaInvetario, $ConsultaControlInventario);
					$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->ParametrosEtiquetas('Consulta', $Arreglo);
					$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
						return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
					}); 
					echo $Plantilla->MostrarPlantilla('Inventario/ListaInventario.html');
					unset($Plantilla, $ConsultaControlInventario, $ConsultaInvetario, $Arreglo);
					exit();
				}
				else {
					$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
						return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
					}); 
					echo $Plantilla->MostrarPlantilla('Inventario/ListaInventario.html');
					unset($Plantilla, $ConsultaControlInventario);
					exit();
				}
			}	
		}
		
		/**
		* Metodo Publico
		* frmAgregarPorProducto()
		* 
		* Muestra La Pantalla De Agregar Por Producto Al Inventario
		* 
		* */
		public function frmAgregarPorProducto() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('Cantidad', '* Campo Requerido');
				$Validacion->Digitos('Cantidad', '*Solo Introducir Numeros');
				$Script[]=$Validacion->MostrarValidacion('Form');
				$Plantilla = new NeuralPlantillasTwig;
				$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
		 		echo $Plantilla->MostrarPlantilla('Inventario/AgregarPorProductoInventario.html', 'POS');
		 		unset($Plantilla, $Validacion, $Script);
		 		exit();
	 		}
		}
		 
		/**
		* Metodo Publico
		* ConsultarCodigoInventario()
		* 
		* Realiza La Consulta Del Codigo En La Tabla ControlInventario
		* 
		* */
		public function ConsultarCodigoInventario() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Consulta = $this->Modelo->ConsultarCodigoInventario($_POST['CodigoMInventario']);
				if($Consulta['Cantidad'] > 0) {
		 			unset($Consulta['Cantidad']);
		 			$Plantilla = new NeuralPlantillasTwig;
		 			$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
		 			echo $Plantilla->MostrarPlantilla('Inventario/ResultadoModalCodigoInventario.html', 'POS');
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
	    * Muestra La Vista De Agregar  Inventario
	    * 
		* */            
		public function AgregarProductoFormaResultadoInventario() {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	    		$Consulta = $this->Modelo->ConsultarInventarioId($_POST['Id']);
	    		echo json_encode($Consulta, true);
	            unset($Consulta);
	        	exit();
			}
		}
		
		/**
		* Metodo Publico
		* GuardarInventarioProducto()
		* 
		* Guarda Los Datos Del Producto En Inventario
		* 
		**/
		public function GuardarInventarioProducto() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
					if(isset($_POST['CodigoInventario']) AND isset($_POST['NombreProductoInventario'])){
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('CodigoInventario'));
						unset($DatosPost['Validar'], $DatosPost['NombreProductoInventario'], $DatosPost['CodigoInventario'] );
						$Consulta = $this->Modelo->ConsultarCodigoExistenteInventario($DatosPost['Id_Producto']);
						$DatosPost['Producto_Inventario'] = $DatosPost['Id_Producto'];
						unset($DatosPost['Id_Producto']);
						if($Consulta['Cantidad'] > 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/ErrorDuplicidadDatosInventario.html', 'POS');
							unset($Plantilla, $DatosPost, $Consulta);
							exit();
						}
						else {
							$this->Modelo->GuardarInventarioProducto($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/AlertaAgregarInventario.html', 'POS');
							unset($DatosPost, $Consulta, $Plantilla);
							exit();
						}						
					}
				}
			}
		}
		
		/**
		* Metodo Publico
		* frmEntradas()
		* 
		* Muestra La Pantalla De Entrada
		* 
		**/
		public function frmEntradas() {
			$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('Inventario/BaseEntradas.html', 'POS');
			unset($Plantilla);
		}
		
		/**
		* Metodo Publico
		* frmTipoentrada()
		* 
		* Muestra La Pantalla De Tipo De Entrada
		* 
		**/
		public function frmTipoEntrada() {
	 		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	 			$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('Movimiento', '* Campo Requerido');
				$Script[] = $Validacion->MostrarValidacion('Form');
 				$Plantilla = new NeuralPlantillasTwig;
 				$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
 				echo $Plantilla->MostrarPlantilla('Inventario/TipoEntrada.html', 'POS');
 				unset($Plantilla, $Script, $Validacion);
 				exit();
	    	}
		} 
		 
		/**
		* Metodo Publico
		* OpcionesMovimientos()
		* 
		* Muestra La Pantalla Segun La Opcion Seleccionada
		* 
		**/
		public function OpcionesMovimientos() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
		  		if(isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d') ) {
			  		unset($_POST['Validar']);
				  	if($_POST['Tipo_Movimiento'] == 'Proveedor') {
				  		$Validacion = new NeuralJQueryValidacionFormulario;
				  		$Validacion->Requerido('Producto_Inventario', '* Campo Requerido');
				  		$Validacion->Requerido('Cantidad', '* Campo Requerido');
				  		$Validacion->Digitos('Cantidad', '* Solo Introducir Numeros');
				  		$Validacion->Requerido('Fecha', '* Campo Requerido');
				  		$Validacion->Requerido('Proveedor', '* Campo Requerido');
				  		$Validacion->Requerido('Folio_Facturacion', '* Campo Requerido');
				  		$Validacion->Requerido('Usuario', '* Campo Requerido');
				  		$Script[] = $Validacion->MostrarValidacion('Form');
				  		$Fecha = date("Y-m-d H:i:s");
				  		$Plantilla = new NeuralPlantillasTwig;
				  		$Plantilla->ParametrosEtiquetas('Entrada', $_POST['Movimiento']);
				  		$Plantilla->ParametrosEtiquetas('Fecha', $Fecha);
				  		$Plantilla->ParametrosEtiquetas('TipoMovimiento', $_POST['Tipo_Movimiento']);
				  		$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
						$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
				  		echo $Plantilla->MostrarPlantilla('Inventario/MovimientoProveedor.html', 'POS');
				  		unset($Plantilla, $Validacion, $Script, $Fecha);
				  		exit();
			  		}
			  		if($_POST['Tipo_Movimiento'] == 'Donacion') {
			  			$Validacion = new NeuralJQueryValidacionFormulario;
			  			$Validacion->Requerido('Producto_Inventario', '* Campo Requerido');
				  		$Validacion->Requerido('Cantidad', '* Campo Requerido');
				  		$Validacion->Digitos('Cantidad', '* Solo Introducir Numeros');
				  		$Validacion->Requerido('Fecha', '* Campo Requerido');
				  		$Validacion->Requerido('Observaciones', '* Campo Requerido');
				  		$Validacion->Requerido('Usuario', '* Campo Requerido');
				  		$Script[] = $Validacion->MostrarValidacion('Form');
				  		$Fecha = date("Y-m-d H:i:s");
			  			$Plantilla = new NeuralPlantillasTwig;
			  			$Plantilla->ParametrosEtiquetas('Salida', $_POST['Movimiento']);
				  		$Plantilla->ParametrosEtiquetas('Fecha', $Fecha);
				  		$Plantilla->ParametrosEtiquetas('TipoMovimiento', $_POST['Tipo_Movimiento']);
				  		$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
						$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
				  		echo $Plantilla->MostrarPlantilla('Inventario/MovimientoDonacion.html', 'POS');
				  		unset($Plantilla, $Validacion, $Script, $Fecha);
				  		exit();
			  		}
			  		if($_POST['Tipo_Movimiento'] == 'Devolucion') {
			  			$Validacion = new NeuralJQueryValidacionFormulario;
			  			$Validacion->Requerido('Producto_Inventario', '* Campo Requerido');
				  		$Validacion->Requerido('Cantidad', '* Campo Requerido');
				  		$Validacion->Digitos('Cantidad', '* Solo Introducir Numeros');
				  		$Validacion->Requerido('Fecha', '* Campo Requerido');
				  		$Validacion->Requerido('Observaciones', '* Campo Requerido');
				  		$Validacion->Requerido('Usuario', '* Campo Requerido');
				  		$Script[] = $Validacion->MostrarValidacion('Form');
				  		$Fecha = date("Y-m-d H:i:s");
					  	$Plantilla = new NeuralPlantillasTwig;
					  	$Plantilla->ParametrosEtiquetas('Entrada', $_POST['Movimiento']);
				  		$Plantilla->ParametrosEtiquetas('Fecha', $Fecha);
				  		$Plantilla->ParametrosEtiquetas('TipoMovimiento', $_POST['Tipo_Movimiento']);
					  	$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
						$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
				  		echo $Plantilla->MostrarPlantilla('Inventario/MovimientoDevolucion.html', 'POS');
				  		unset($Plantilla);
				  		exit();
			  		}
			  	}
	  		}
		}
		
		/**
		* Metodo Publico
		* CodigoConsultar()
		* 
		* Realiza La Consulta del Producto
		* 
		**/
		public function CodigoConsultar() {
	  		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	  			$Consulta = $this->Modelo->ConsultarNombreProductoInventario($_POST['NombreProducto']);
  				if($Consulta['Cantidad'] > 0) {
  					unset($Consulta['Cantidad']);
  					$Plantilla = new NeuralPlantillasTwig;
  					$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
  					echo $Plantilla->MostrarPlantilla('Inventario/ResultadoNombreProducto.html', 'POS');
  					unset($Consulta, $Plantilla);
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
		* FormaResultadoProducto()
		* 
		* Muestra Resultados de Consulta Producto
		* 
		**/
		public function FormaResultadoProducto() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Consulta = $this->Modelo->ConsultarInventarioId($_POST['OpcionRadio']);
				echo json_encode($Consulta, true);
				exit();
			}
		}
		  
		/**
		* Metodo Publico
		* CodigoConsultar()
		* 
		* Realiza La Consulta del Producto
		* 
		**/
		public function CodigoConsultarProveedor() {
	  		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Consulta = $this->Modelo->ConsultarProveedor($_POST['NombreProveedor']);
  				if($Consulta['Cantidad'] > 0) {
  					unset($Consulta['Cantidad']);
  					$Plantilla = new NeuralPlantillasTwig;
  					$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
  					echo $Plantilla->MostrarPlantilla('Inventario/ResultadoProveedor.html', 'POS');
  					unset($Consulta, $Plantilla);
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
		* CodigoConsultarProveedor()
		* 
		* Muestra Resultados Del Proveedor
		* 
		**/
		public function AgregarProveedorFormaResultado() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	   			$Consulta = $this->Modelo->ConsultarProveedorId($_POST['OpcionRadio']);
				echo json_encode($Consulta, true);
				exit();	
  			}
	   	}
		   
		/**
		* Metodo Publico
		* GuardarProveedor()
		* 
		* Guarda La Entrada De Datods De Acuerdo Al Proveedor
		* 
		**/
		public function GuardarProveedor() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
					if(isset($_POST['Movimiento']) AND isset($_POST['Tipo_Movimiento']) AND isset($_POST['Cantidad']) AND isset($_POST['Producto_Inventario']) AND isset($_POST['Producto']) AND isset($_POST['Proveedor']) AND isset($_POST['Folio_Facturacion']) AND  isset($_POST['Usuario'])){
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Cantidad', 'Fecha', 'Producto_Inventario', 'IdProveedor', 'Producto', 'Usuario'));
						unset($DatosPost['Validar'], $DatosPost['Producto'], $DatosPost['NombreProveedor'] );
						$Consulta = $this->Modelo->ConsultarProveedorExistenteInventario($DatosPost['Producto_Inventario']);
						if($Consulta['Cantidad'] > 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/ErrorDuplicidadProductoMovimiento.html', 'POS');
							unset($Plantilla, $DatosPost, $Consulta);
							exit();
						}
						else {
							$this->Modelo->GuardarMovimientoProducto($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/AlertaAgregarMovimiento.html', 'POS');
							unset($DatosPost, $Consulta, $Plantilla);
							exit();
						}						
					}
				}
			}
		}
		
		/**
		* Metodo Publico
		* ConsultarProductoDonacion()
		* 
		* Realiza La Consulta del Producto
		* 
		**/
		public function ConsultarProductoDonacion() {
	  		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
	  			$Consulta = $this->Modelo->ConsultarNombreProductoInventario($_POST['NombreProductoDonacion']);
			  	if($Consulta['Cantidad'] > 0) {
  					unset($Consulta['Cantidad']);
  					$Plantilla = new NeuralPlantillasTwig;
  					$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
  					echo $Plantilla->MostrarPlantilla('Inventario/ResultadoProductoDonacion.html', 'POS');
  					unset($Consulta, $Plantilla);
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
		* GuardarProveedor()
		* 
		* Guarda La Entrada De Datods De Acuerdo Al Proveedor
		* 
		**/
		public function GuardarDonacion() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
					if(isset($_POST['Movimiento']) AND isset($_POST['Tipo_Movimiento']) AND isset($_POST['Cantidad']) AND isset($_POST['Producto_Inventario']) AND isset($_POST['Producto']) AND isset($_POST['Fecha']) AND isset($_POST['Observaciones']) AND  isset($_POST['Usuario'])){
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Cantidad', 'Fecha', 'Producto_Inventario','Producto', 'Usuario'));
						unset($DatosPost['Validar'], $DatosPost['Producto']);
						$Consulta = $this->Modelo->ConsultarCodigoExistenteInventario($DatosPost['Producto_Inventario']);
						if($Consulta['Cantidad'] > 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/ErrorDuplicidadDonacion.html', 'POS');
							unset($Plantilla, $DatosPost, $Consulta);
							exit();
						}
						else {
							$this->Modelo->GuardarMovimientoDonacion($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/AlertaAgregarMovimiento.html', 'POS');
							unset($DatosPost, $Consulta, $Plantilla);
							exit();
						}						
					}
				}
			}
		}
		
			
		/**
		* Metodo Publico
		* GuardarDevolucion()
		* 
		* Guarda La Entrada De Datods De Acuerdo Al Proveedor
		* 
		**/
		public function GuardarDevolucion() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
					if(isset($_POST['Movimiento']) AND isset($_POST['Tipo_Movimiento']) AND isset($_POST['Cantidad']) AND isset($_POST['Producto_Inventario']) AND isset($_POST['Producto']) AND  isset($_POST['Usuario'])){
						$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Cantidad', 'Fecha', 'Producto_Inventario', 'Producto', 'Usuario'));
						unset($DatosPost['Validar'], $DatosPost['Producto'] );
						$Consulta = $this->Modelo->ConsultarProveedorExistenteInventario($DatosPost['Producto_Inventario']);
						if($Consulta['Cantidad'] > 0) {
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/ErrorDuplicidadProductoMovimiento.html', 'POS');
							unset($Plantilla, $DatosPost, $Consulta);
							exit();
						}
						else {
							$this->Modelo->GuardarMovimientoProductoDevolucion($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Inventario/AlertaAgregarMovimiento.html', 'POS');
							unset($DatosPost, $Consulta, $Plantilla);
							exit();
						}					
					}
				}
			}
		}
		
		/**
	    * Metodo Publico
	    * CantidadListadoInventario()
	    * 
	    * Guarda la Cantidad De Cada Producto Del Listado De Inventario
	    * 
		**/            
		public function CantidadListadoInventario() {
	    	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST['pk']) == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['pk']), 'POS'))) {
		    		$ConsultaExiste = $this->Modelo->ConsultaExistenteIdInventario(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['pk']), 'POS'));
		    		if($ConsultaExiste['Cantidad'] > 0) {
		    			$DatosPost =  array('Existencia' => $_POST['value']);
			    		$Condicion = array('Producto_Inventario' => NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['pk']), 'POS'));
			    		$Consulta = $this->Modelo->ActualizarCantidadInventario($DatosPost, $Condicion);
			    		unset($ConsultaExiste, $DatosPost, $Condicion, $Consulta);
			    		exit();	
		    		}
					else {
						$DatosPost =  array('Producto_Inventario' => NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['pk']), 'POS'), 'Existencia' => $_POST['value']);
						$Consulta = $this->Modelo->GuardarCantidadInventario($DatosPost);
						unset($ConsultaExiste, $DatosPost, $Consulta);
						exit();
						}	
	    		}
    		}
		}
		
		/**
		* Metodo Publico
		* frmImportar()
		*
		* Muestra La Vista De La Forma De Imporar
		* 
		**/
		public function frmImportar() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('Datos', '* Campo Requerido');
				$Script[] = $Validacion->MostrarValidacion('Form');
				$Plantilla = new NeuralPlantillasTwig;
				$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
				echo $Plantilla->MostrarPlantilla('Inventario/Importar/Importar.html', 'POS');
				unset($Plantilla, $Validacion, $Script);
				exit();	
			}
		}
		
		/**
		* Metodo Publico
		* ProcesarDatos()
		* 
		* Convierte Los Datos A Un Array
		* 
		**/
		public function ProcesarDatos() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Datos']) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) { 
					$Arreglo = AyudasCopyPasteExcelArray::ConvertirExcelArrayColumnas($_POST['Datos'], array('Codigo', 'Producto', 'Existencia'));
					$Productos = $this->Modelo->ConsultaProductos();
					$ControlInventario = $this->Modelo->ConsultaControlInventarioProductos();
					foreach($Productos as $Producto => $Valor) {
						foreach($Arreglo as $ProductoExcel => $ValorExcel) {
							if($Productos[$Producto]['Codigo'] == $Arreglo[$ProductoExcel]['Codigo'] AND $Productos[$Producto]['NombreProducto'] == $Arreglo[$ProductoExcel]['Producto']) {
								$ArregloProductosExistentes[] = array('Id' => $Productos[$Producto]['Id'], 'Codigo' => $Productos[$Producto]['Codigo'], 'NombreProducto' => $Productos[$Producto]['NombreProducto'], 'Existencia' => $Arreglo[$ProductoExcel]['Existencia']);
							}	
						}
					}
					if (!empty($ArregloProductosExistentes)) {
						$ArregloFinal = AyudasInventario::ArregloImportar($ArregloProductosExistentes, $ControlInventario);
						$Plantilla = new NeuralPlantillasTwig;
						$Plantilla->ParametrosEtiquetas('Consulta', AyudasInventario::ArregloImportar($ArregloProductosExistentes, $ControlInventario));
						$Plantilla->ParametrosEtiquetas('Arreglo', AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos(gzcompress(json_encode($ArregloFinal, true)), 'POS')));
						$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
						echo $Plantilla->MostrarPlantilla('Inventario/Importar/DatosInsertar.html', 'POS');				
						unset($Arreglo, $Productos, $ControlInventario, $ArregloFinal, $Plantilla);
						exit();
					}
					else {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('Inventario/Importar/ErrorImportar.html', 'POS');
						unset($Arreglo, $Productos, $ControlInventario, $Plantilla);
						exit();
							
					}
				}
			}
		}
		
		/**
		* Metodo Publico
		* GuardarDatosImportar()
		* 
		* Guarda Los Datos A Importar
		* 
		**/
		public function GuardarDatosImportar() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) { 
					$Arreglo = json_decode(gzuncompress(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($_POST['Arreglo']), 'POS')), true);
					foreach($Arreglo as $Producto => $Id) {
						$ExisteProducto = $this->Modelo->ConsultaExistenteIdInventario($Arreglo[$Producto]['Producto_Inventario']);
						if($ExisteProducto['Cantidad'] > 0) {
							$DatosPost =  array('Existencia' => $Arreglo[$Producto]['Existencia']);
			    			$Condicion = array('Producto_Inventario' => $Arreglo[$Producto]['Producto_Inventario']);
			    			$this->Modelo->ActualizarCantidadInventario($DatosPost, $Condicion);
						}
						else {
							$DatosPost =  array('Producto_Inventario' => $Arreglo[$Producto]['Producto_Inventario'], 'Existencia' => $Arreglo[$Producto]['Existencia']);
							$this->Modelo->GuardarCantidadInventario($DatosPost);
						}
					}
					unset($Arreglo, $Producto, $Id, $ExisteProducto, $DatosPost, $Condicion);
					exit();	
				}
			}
		}
				 		
	}