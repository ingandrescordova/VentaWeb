<?php
 
	class ControlInventario_Modelo extends AyudasSQLConsultas {
	
		function __Construct() {
			parent::__Construct();	
		}
	 	        
        /**
	 	 * Metodo Publico
	 	 * ConsultaInventarioLista()
	 	 * 
	 	 * Consulta El Listado De Los Proveedores
	 	 * 
	 	 * */
		public function ConsultaInventarioLista() {
  			$Consulta = new NeuralBDConsultas;
			$Consulta->CrearConsulta('control_productos_inventario');
			$Consulta->AgregarColumnas(self::ListarColumnas('control_productos_inventario', false, false, 'POS'));
			$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Id', 'Status'), false, 'POS'));
			$Consulta->AgregarInnerJoin('catalogos_productos');
			$Consulta->AgregarCondicionInnerJoin('control_productos_inventario.Producto = catalogos_productos.Id');
			$Consulta->AgregarCondicion("control_productos_inventario.Status != 'ELIMINADO'");
			$Consulta->PrepararQuery();
			return $Consulta->ExecuteConsulta('POS');
        }
        
        /**
		 * Metodo Publico
		 * ConsultarCodigoProducto()
		 * 
		 * Realiza La Consulta Del Producto
		 * @param $Codigo: Necesario Para Realizar La Consulta
		 * 
		 * */
		public function ConsultarCodigoProducto($Codigo = false) {
			if($Codigo == true) {
				$ConsultaSQL = new NeuralBDConsultas;
			 	$ConsultaSQL->CrearConsulta('catalogos_productos');
			 	$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', false, false));
			 	$ConsultaSQL->AgregarCondicion("Codigo LIKE '%$Codigo%'");
			 	$ConsultaSQL->AgregarCondicion("Status != 'ELIMINADO' AND Status != 'INACTIVO'");
			 	$ConsultaSQL->PrepararCantidadDatos('Cantidad');
			 	$ConsultaSQL->PrepararQuery();
			 	return $ConsultaSQL->ExecuteConsulta('POS');
		 	}
		}
		
		/**
		 * Metodo Publico
		 * ConsultarDescripcionProducto($Descripcion = false)
		 * 
		 * Realiza La Consulta Del Producto
		 * @param $Descripcion: Necesario Para Realizar La Consulta
		 * 
		 * */
		public function ConsultarDescripcionProducto($Descripcion = false) {
			if($Descripcion == true) {
				$ConsultaSQL = new NeuralBDConsultas;
			 	$ConsultaSQL->CrearConsulta('catalogos_productos');
			 	$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', false, false));
			 	$ConsultaSQL->AgregarCondicion("NombreProducto LIKE '%$Descripcion%'");
			 	$ConsultaSQL->AgregarCondicion("Status != 'ELIMINADO' AND Status != 'INACTIVO'");
			 	$ConsultaSQL->PrepararCantidadDatos('Cantidad');
			 	$ConsultaSQL->PrepararQuery();
			 	return $ConsultaSQL->ExecuteConsulta('POS');
		 	}
		}
		 
		/**
		* Metodo Publico
		*  ConsultarProductoId($Id = false)
		* 
		* Realiza La Consulta Del Producto
		* @param $Codigo: Necesario Para Realizar La Consulta
		* 
		* */
		public function ConsultarProductoId($Id = false) {
			if($Id == true AND is_numeric($Id) == true) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('catalogos_productos');
				$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Status'), false));
				$ConsultaSQL->AgregarCondicion("Id = '$Id'");
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}
		}
		 
		/**
		* Metodo Publico
		* ConsultarCodigoExistente($Id = false)
		* 
		* Realiza La Consulta y Verifica Si Existe El Producto
		* @param $Id: Necesario Para Realizar La Consulta
		* 
		* */
		public function ConsultarCodigoExistente($Id = false) {
			if($Id == true AND is_numeric($Id) == true) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('control_productos_inventario');
				$ConsultaSQL->AgregarColumnas('Producto');
				$ConsultaSQL->AgregarCondicion("Producto = '$Id'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}
	  	}
	  	
	  	/**
	   	* Metodo Publico
		* GuardarInventario($Arreglo = false)
		* 
		* Guardar Datos Del Inventario
		* @param $Arreglo: Arreglos De Datos Necesarios Para Insertar
		* 
		**/ 
		public function GuardarInventario($Arreglo = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
		   		return self::GuardarDatos($Arreglo, 'control_productos_inventario', array('Id', 'Status'), 'POS' );
		   	}
		}
		
		/**
	 	 * Metodo Publico
	 	 * ConsultaInventarioEditar($Id_Inventario = false)
	 	 * 
	 	 * Consulta El Prodcuto De Inventario Para Editar
	 	 * @param $Id_Invenatrio: Necesaro Paara Ediatr
	 	 * 
	 	 * */
		public function ConsultaInventarioEditar($Id_Inventario = false) {
				if($Id_Inventario == true AND is_numeric($Id_Inventario) == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('control_productos_inventario');
				$Consulta->AgregarColumnas(self::ListarColumnas('control_productos_inventario', array('Producto', 'Id'), false, 'POS'));
				$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Id', 'Status'), false, 'POS'));
				$Consulta->AgregarInnerJoin('catalogos_productos');
				$Consulta->AgregarCondicionInnerJoin('control_productos_inventario.Producto = catalogos_productos.Id');
				$Consulta->AgregarCondicion("control_productos_inventario.Id = '$Id_Inventario' ");
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
			}
        }
        
        /**
         * Metodo Publico
         * EditarProductoInventario()
         * 
         * Realiza La Actualizacion De Los Datos Del Producto En El Inventario
         * @param $Arreglo: Arreglo De Datos A Actulizar
         * @param $Condicion: Condicion Necesaria Para Actualizar
         * 
         * */
         public function EditarProductoInventario($Arreglo = false, $Condicion = false) {
         	if($Arreglo == true AND is_array($Arreglo) == true AND $Condicion == true AND is_array($Condicion) == true) {
		   		return self::ActualizarDatos($Arreglo, $Condicion, 'control_productos_inventario', array('Id', 'Producto'), 'POS' );
		   	}         	
         }
         
         /**
	 	 * Metodo Publico
	 	 * VisualizarInventario($Id_Inventario = false)
	 	 * 
	 	 * Consulta El Producto De Inventario Para Editar
	 	 * 
	 	 * @param $Id_Inventaio: Necesario Para Realizar la Consulta
	 	 * 
	 	 * */
		public function VisualizarInventario($Id_Inventario = false) {
			if($Id_Inventario == true AND is_numeric($Id_Inventario) == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('control_productos_inventario');
				$Consulta->AgregarColumnas(self::ListarColumnas('control_productos_inventario', array('Producto', 'Id'), false, 'POS'));
				$Consulta->AgregarColumnas(self::ListarColumnas('catalogos_productos', array('Id', 'Status'), false, 'POS'));
				$Consulta->AgregarInnerJoin('catalogos_productos');
				$Consulta->AgregarCondicionInnerJoin('control_productos_inventario.Producto = catalogos_productos.Id');
				$Consulta->AgregarCondicion("control_productos_inventario.Id = '$Id_Inventario' ");
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
			}
        }
        
        /**
         * Metodo Publico
         * EliminarProductoInventarioStatus($Id_Proveedor = false)
         * 
         * Realiza La Actualizacion Del Status Del Producto De Inventario
         * @param $Id_Proveedor: Necesario Para Realizar La Operacion
         * 
         * */
         public function EliminarProductoInventarioStatus($Id_Inventario = false) {
         	if($Id_Inventario == true AND is_numeric($Id_Inventario) == true) {
         		return self::ActualizarDatos(array('Status' => 'ELIMINADO'), array('Id' => $Id_Inventario), 'control_productos_inventario', array('Producto', 'Stock_Minimo', 'Stock_Maximo', 'Precio_Venta', 'Id'), 'POS');;
         	}
         }
  	}