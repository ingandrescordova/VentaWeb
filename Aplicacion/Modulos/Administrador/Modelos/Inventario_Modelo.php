<?php
	
	class Inventario_Modelo extends AyudasSQLConsultas {
		
		function __Construct() {
			parent::__Construct();	
		}
		
		/**
		 * Metodo Publico
		 * ConsultarCodigoInventario()
		 * 
		 * Realiza La Consulta Del Producto
		 * @param $Codigo: Necesario Para Realizar La Consulta
		 * 
		 * */
		public function ConsultarCodigoInventario($Codigo = false) {
			if($Codigo == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('control_productos_inventario');
				$Consulta->AgregarColumnas(self::ListarColumnas('control_productos_inventario', array('Producto', 'Stock_Minimo', 'Precio_Venta', 'Status'), false, 'POS'));
				$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Id', 'Status'), false, 'POS'));
				$Consulta->AgregarInnerJoin('catalogos_productos');
				$Consulta->AgregarCondicionInnerJoin('control_productos_inventario.Producto = catalogos_productos.Id');
				$Consulta->AgregarCondicion("control_productos_inventario.Status != 'ELIMINADO'");
				$Consulta->AgregarCondicion("catalogos_productos.Codigo LIKE '%$Codigo%'");
				$Consulta->PrepararCantidadDatos('Cantidad');
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
		 	}
		} 
		
		/**
		 * Metodo Publico
		 * ListaInventario()
		 * 
		 * Realiza La Consulta Del Inventario
		 * 
		 * */
		public function ListaInventario() {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('inventario');
			$Consulta->AgregarColumnas(self::ListarColumnas('inventario', false, false, 'POS'));
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta('POS');
	 	}
	 	
	 	/**
		 * Metodo Publico
		 * ListaControlInventario()
		 * 
		 * Realiza La Consulta Del Inventario
		 * 
		 * */
		public function ListaControlInventario() {
			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('control_productos_inventario');
			$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Id', 'Status'), false, 'POS'));
			$Consulta->AgregarColumnas(self::ListarColumnas('control_productos_inventario', array('Producto', 'Stock_Minimo', 'Stock_Maximo', 'Precio_Venta', 'Status'), false, 'POS'));
			$Consulta->AgregarInnerJoin('catalogos_productos');
			$Consulta->AgregarCondicionInnerJoin('control_productos_inventario.Producto = catalogos_productos.Id');
			$Consulta->AgregarCondicion("control_productos_inventario.Status = 'ACTIVO'");
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta('POS');
	 	}
	 	
		/**
		 * Metodo Publico
		 * ConsultarInventarioId()
		 * 
		 * Realiza La Consulta Del Producto
		 * @param $Codigo: Necesario Para Realizar La Consulta
		 * 
		 * */
		public function ConsultarInventarioId($Id = false) {
			if($Id == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('control_productos_inventario');
				$Consulta->AgregarColumnas(self::ListarColumnas('control_productos_inventario', array('Producto', 'Stock_Minimo', 'Precio_Venta', 'Status'), false, 'POS'));
				$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Id', 'Status'), false, 'POS'));
				$Consulta->AgregarInnerJoin('catalogos_productos');
				$Consulta->AgregarCondicionInnerJoin('control_productos_inventario.Producto = catalogos_productos.Id');
				$Consulta->AgregarCondicion("control_productos_inventario.Status != 'ELIMINADO'");
				$Consulta->AgregarCondicion("control_productos_inventario.Id = '$Id'");
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
		 	}
		}
		
		/**
		* Metodo Publico
		* ConsultarCodigoExistenteInventario($Id = false)
		* 
		* Realiza La Consulta y Verifica Si Existe El Producto
		* @param $Id: Necesario Para Realizar La Consulta
		* 
		* */
		public function ConsultarCodigoExistenteInventario($Id = false) {
			if($Id == true AND is_numeric($Id) == true) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('inventario');
				$ConsultaSQL->AgregarColumnas('Producto_Inventario');
				$ConsultaSQL->AgregarCondicion("Producto_Inventario = '$Id'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}
	  	}
	  	
	  		/**
	   	* Metodo Publico
		* GuardarInventarioProducto($Arreglo = false)
		* 
		* Guardar Datos Del Inventario
		* @param $Arreglo: Arreglos De Datos Necesarios Para Insertar
		* 
		**/ 
		public function GuardarInventarioProducto($Arreglo = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
		   		return self::GuardarDatos($Arreglo, 'inventario', array('Id'), 'POS' );
		   	}
		}
		
		/**
		 * Metodo Publico
		 * ConsultarCodigoInventario()
		 * 
		 * Realiza La Consulta Del Producto
		 * @param $NombreProducto: Necesario Para Realizar La Consulta
		 * 
		 * */
		public function ConsultarNombreProductoInventario($NombreProducto = false) {
			if($NombreProducto == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('control_productos_inventario');
				$Consulta->AgregarColumnas(self::ListarColumnas('control_productos_inventario', array('Producto', 'Stock_Minimo', 'Precio_Venta', 'Status'), false, 'POS'));
				$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Id', 'Status'), false, 'POS'));
				$Consulta->AgregarInnerJoin('catalogos_productos');
				$Consulta->AgregarCondicionInnerJoin('control_productos_inventario.Producto = catalogos_productos.Id');
				$Consulta->AgregarCondicion("control_productos_inventario.Status != 'ELIMINADO'");
				$Consulta->AgregarCondicion("catalogos_productos.NombreProducto LIKE '%$NombreProducto%'");
				$Consulta->PrepararCantidadDatos('Cantidad');
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
		 	}
		}
		
		/**
		 * Metodo Publico
		 * ConsultarProveedor()
		 * 
		 * Realiza La Consulta Del Proveedor
		 * @param $NombreProveedor: Necesario Para Realizar La Consulta
		 * */
		 public function ConsultarProveedor($NombreProveedor = false) {
		 	if($NombreProveedor == true) {
				$ConsultaSQL = new NeuralBDConsultas;
	            $ConsultaSQL->CrearConsulta('catalogos_proveedores');
	            $ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_proveedores', array('RFC', 'Direccion', 'Telefono_Proveedor', 'URL', 'Nombre_Representante', 'Cargo', 'Telefono_Representante', 'Movil_Representante', 'Correo','Status'), false));
	            $ConsultaSQL->AgregarCondicion("Status = 'ACTIVO'");
	            $ConsultaSQL->AgregarCondicion("Nombre_Comercial LIKE '%$NombreProveedor%'");
	            $ConsultaSQL->PrepararCantidadDatos('Cantidad');
	            $ConsultaSQL->PrepararQuery();
	            return $ConsultaSQL->ExecuteConsulta('POS');
		 	}
		 }
		 
		 /**
		 * Metodo Publico
		 * ConsultarProveedorId()
		 * 
		 * Realiza La Consulta Del Producto
		 * @param $Id: Necesario Para Realizar La Consulta
		 * 
		 * */
		public function ConsultarProveedorId($Id = false) {
			if($Id == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('catalogos_proveedores');
				$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_proveedores', array('RFC', 'Razon_Social', 'Telefono_Proveedor', 'URL', 'Direccion', 'Nombre_Representante', 'Cargo', 'Telefono_Representante', 'Movil_Representante', 'Correo', 'Status'), false));
				$Consulta->AgregarCondicion("Id = '$Id'");
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
		 	}
		}
		
		/**
		* Metodo Publico
		* ConsultarProveedorExistenteInventario($Id = false)
		* 
		* Realiza La Consulta y Verifica Si Existe El Producto
		* @param $Id: Necesario Para Realizar La Consulta
		* 
		* */
		public function ConsultarProveedorExistenteInventario($Id = false) {
			if($Id == true AND is_numeric($Id) == true) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('movimientos_inventario');
				$ConsultaSQL->AgregarColumnas('Producto_Inventario');
				$ConsultaSQL->AgregarCondicion("Producto_Inventario = '$Id'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}
	  	}
	  	
	  	/**
	  	 * Metodo Publico
	  	 * GuardarMovimientoProducto()
	  	 * 
	  	 * Guarda Los Datos Del Movimiento Por Proveedor
	  	 * @param $Arreglo: Arreglo De Datos Para Insertar Registro
	  	 * 
	  	 * */
	  	 public function GuardarMovimientoProducto($Arreglo = false) {
 	 		if($Arreglo == true AND is_array($Arreglo) == true) {
		   		return self::GuardarDatos($Arreglo, 'movimientos_inventario', array('Id', 'Numero_Ticket', 'Status'), 'POS' );
		   	}
	  	 }
	  	 
	  	 /**
	  	 * Metodo Publico
	  	 * GuardarMovimientoProducto()
	  	 * 
	  	 * Guarda Los Datos Del Movimiento Por Donacion
	  	 * @param $Arreglo: Arreglo De Datos Para Insertar Registro
	  	 * 
	  	 * */
	  	 public function GuardarMovimientoDonacion($Arreglo = false) {
 	 		if($Arreglo == true AND is_array($Arreglo) == true) {
		   		return self::GuardarDatos($Arreglo, 'movimientos_inventario', array('Id', 'Numero_Ticket', 'Proveedor', 'Folio_Facturacion', 'Status'), 'POS' );
		   	}
	  	 }
	  	  
	  	 /**
	  	 * Metodo Publico
	  	 * GuardarMovimientoProductoDevolucion()
	  	 * 
	  	 * Guarda Los Datos Del Movimiento Por Proveedor
	  	 * 
	  	 * */
	  	 public function GuardarMovimientoProductoDevolucion($Arreglo = false) {
 	 		if($Arreglo == true AND is_array($Arreglo) == true) {
		   		return self::GuardarDatos($Arreglo, 'movimientos_inventario', array('Id', 'Proveedor', 'Folio_Facturacion', 'Status'), 'POS' );
		   	}
	  	 }
	  	 
	  	 /**
	  	 * Metodo Publico
	  	 * ActualizarCantidadInventario()
	  	 * 
	  	 * Guarda Los Datos Del Movimiento Por Proveedor
	  	 * 
	  	 * */
	  	 public function ActualizarCantidadInventario($Arreglo = false, $Condicion = false) {
 	 		if($Arreglo == true AND is_array($Arreglo) == true) {
		   		return self::ActualizarDatos($Arreglo, $Condicion, 'inventario', array('Id', 'Producto_Inventario'), 'POS');
		   	}
	  	 }
	  	 
	  	 /**
	  	 * Metodo Publico
	  	 * GuardarMovimientoProductoDevolucion()
	  	 * 
	  	 * Guarda Los Datos Del Movimiento Por Proveedor
	  	 * 
	  	 * */
	  	 public function GuardarCantidadInventario($Arreglo = false) {
 	 		if($Arreglo == true AND is_array($Arreglo) == true) {
		   		return self::GuardarDatos($Arreglo, 'inventario', array('Id'), 'POS' );
		   	}
	  	 }
	  	 
	  	 /**
	  	 * Metodo Publico
	  	 * ConsultaExistenteIdInventario()
	  	 * 
	  	 * Guarda Los Datos Del Movimiento Por Proveedor
	  	 * 
	  	 * */
	  	 public function ConsultaExistenteIdInventario($Producto_Inventario = false) {
 	 		if($Producto_Inventario == true) {
		   		$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('inventario');
				$ConsultaSQL->AgregarColumnas('Producto_Inventario');
				$ConsultaSQL->AgregarCondicion("Producto_Inventario = '$Producto_Inventario'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
		   	}
	  	 }
	  	 
	  	 /**
	  	 * Metodo Publico
	  	 * ConsultaProductos()
	  	 * 
	  	 * Consulta Tabla Productos
	  	 * 
	  	 * */
	  	 public function ConsultaProductos() {
 			$ConsultaSQL = new NeuralBDConsultas;
			$ConsultaSQL->CrearConsulta('catalogos_productos');
			$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Status'), false,'POS'));
			$ConsultaSQL->AgregarCondicion("Status = 'ACTIVO'");
			$ConsultaSQL->PrepararQuery();
			return $ConsultaSQL->ExecuteConsulta('POS');
	  	 }
	  	 
	  	 /**
	  	 * Metodo Publico
	  	 * ConsultaControlInventarioProductos()
	  	 * 
	  	 * Consulta Tabla Control Inventario
	  	 * 
	  	 * */
	  	 public function ConsultaControlInventarioProductos() {
 			$ConsultaSQL = new NeuralBDConsultas;
			$ConsultaSQL->CrearConsulta('control_productos_inventario');
			$ConsultaSQL->AgregarColumnas(self::ListarColumnas('control_productos_inventario', array('Stock_Minimo', 'Stock_Maximo', 'Precio_Venta', 'Status'), false,'POS'));
			$ConsultaSQL->AgregarCondicion("Status = 'ACTIVO'");
			$ConsultaSQL->PrepararQuery();
			return $ConsultaSQL->ExecuteConsulta('POS');
	  	 }
	  	 
	}