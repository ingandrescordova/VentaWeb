<?php 
	
	class Productos_Modelo extends AyudasSQLConsultas {
		
		/**
		 * Metodo Publico
		 * Construct()
		 * 
		 * **/
		function __Construct() {
			parent::__Construct();
		}
		
		/**
		 * Metodo Publico
		 * ConsultaProductoLista()
		 * 
		 * Metodo Que Consulta Los Productos
		 * 
		 * **/
		public function ConsultaProductoLista()  {
			$ConsultaSQL = new NeuralBDConsultas;
			$ConsultaSQL->CrearConsulta('catalogos_productos');
			$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', false, false));
			$ConsultaSQL->AgregarCondicion("Status != 'ELIMINADO'");
			$ConsultaSQL->PrepararQuery();
			return $ConsultaSQL->ExecuteConsulta('POS');	
		}
	
		/**
		 * Metodo Publico
		 * ConsultaVisualizarProducto($Id = false)
		 * 
		 * Metodo Que Consulta El Producto Deacuerdo A Su Id
		 * @param $Id: Parametro Necesario Para Realizar La Consulta Del Producto
		 * 
		 * **/
		public function ConsultaVisualizarProducto($Id = false) {
			if(isset($Id) == true AND is_numeric($Id)) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('catalogos_productos');
				$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', false, false));
				$ConsultaSQL->AgregarCondicion("Id = '$Id'");
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}
		}
	
		/**
		 * Metodo Publico
		 * InsertarProducto($Arreglo = false)
		 * 
		 * Metodo Que Inserta A La Base De Datos El Arreglo Del Producto
		 * @param $Arreglo: Parametro Necesario Para Poder Inserta El Producto A La Tabla
		 * 
		 * **/
		public function InsertarProducto($Arreglo = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
				return self::GuardarDatos($Arreglo, 'catalogos_productos', array('Id', 'Status'), 'POS');
			}
		}
	
		/**
		 * Metodo Publico
		 * ConsultarProductoValidar($Id = false)
		 * 
		 * Metodo Que Realiza La Consulta De Un Producto Y La Retorna De Acuerdo A Su Codigo
		 * @param $Codigo: Parametro Necesario Para Realizar La Consulta Del Producto
		 * 
		 * **/
		public function ConsultarProductoValidar($Codigo = false) {
			if(isset($Codigo) == true) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('catalogos_productos');
				$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', false, false));
				$ConsultaSQL->AgregarCondicion("Codigo = '$Codigo'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}	
		}
		
		/**
		 * Metodo Publico
		 * ConsultarProductoValidarEditar($Id = false)
		 * 
		 * Metodo Que Realiza La Consulta De Un Producto Y La Retorna De Acuerdo A Su Codigo
		 * @param $Codigo: Parametro Necesario Para Realizar La Consulta Del Producto
		 * @param $Id: Necesario Para Realizar La Consulta Del Producto
		 * **/
		public function ConsultarProductoValidarEditar($Codigo = false, $Id = false) {
			if(isset($Id) == true AND isset($Codigo) == true AND is_numeric($Id)) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('catalogos_productos');
				$ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_productos', false,false));
				$ConsultaSQL->AgregarCondicion("Codigo = '$Codigo'");
				$ConsultaSQL->AgregarCondicion("Id != '$Id'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}	
		}
	
		/**
		 * Metodo Publico
		 * EliminarProductoStatusModelo($Id = false)
		 * 
		 * Metodo Que Realiza La Eliminacion Del Producto 
		 * @param $Id: Parametro Necesario Para Poder Realizar La Eliminación Del Producto
		 * 
		 * **/
		public function EliminarProductoStatusModelo($Id = false) {
			if($Id == true AND is_numeric($Id)) {
				return self::ActualizarDatos(array('Status' => 'ELIMINADO'), array('Id' => $Id), 'catalogos_productos', array('Id', 'Codigo', 'NombreProducto'), 'POS');
			}
		}
		
		/**
		 * Metodo Publico
		 * EditarProductoModelo($Array = false)
		 * 
		 * Metodo Que Realiza La Actualizacion Del Producto En La Tabla
		 * @param $Array: Parametro Necesario Para Poder Realizar La Actucalizacion Del Producto
		 * 
		 * **/
		public function EditarProductoModelo($Array = false) {
			if($Array == true) {
		 		return self::ActualizarDatos(array('Codigo' => $Array['Codigo'], 'NombreProducto' => $Array['NombreProducto'], 'Status' => $Array['Status']), array('Id' => $Array['Id']), 'catalogos_productos', array('Id'), 'POS');	
		 	}
		}
	}