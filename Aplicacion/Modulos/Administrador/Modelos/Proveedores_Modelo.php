<?php

	class Proveedores_Modelo extends AyudasSQLConsultas {
	
		function __Construct() {
			parent::__Construct();	
		}
	 	
	 	/**
	 	 * Metodo Publico
	 	 * ConsultaProveedoresLista()
	 	 * 
	 	 * Consulta El Listado De Los Proveedores
	 	 * 
	 	 * */
		public function ConsultaProveedoresLista() {
  			$ConsultaSQL = new NeuralBDConsultas;
            $ConsultaSQL->CrearConsulta('catalogos_proveedores');
            $ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_proveedores', false, false));
            $ConsultaSQL->AgregarCondicion("Status != 'ELIMINADO'");
            $ConsultaSQL->PrepararQuery();
            return $ConsultaSQL->ExecuteConsulta('POS');
        }
        
        /**
         * Metodo Publico
         * ConsultarProveedor($RFC = false)
         * 
         * Consulta Si El Proveedor Existe
         * @param $RFC: RFC Del Proveedor Necesario Para La Consulta
         * @param $NombreComercial: Nombre Comercial De La Empresa Necesario Para La Consulta
         * @param $RazonSocial: Razon Social De La Empresa Necesaria Para La Consulta
         * 
         * */
        public function ConsultarProveedor($RFC = false, $NombreComercial = false, $RazonSocial = false) {
        	if($RFC == true AND $NombreComercial == true AND $RazonSocial == true) {
	        	$ConsultasSQL = new NeuralBDConsultas;
	        	$ConsultasSQL->CrearConsulta('catalogos_proveedores');
	        	$ConsultasSQL->AgregarColumnas(self::ListarColumnas('catalogos_proveedores', array('Telefono_Proveedor', 'URL', 'Direccion', 'Nombre_Representante', 'Cargo', 'Telefono_Representante', 'Movil_Representante', 'Correo'), false));
	        	$ConsultasSQL->AgregarCondicion("RFC = '$RFC' AND Nombre_Comercial = '$NombreComercial' AND Razon_Social = '$RazonSocial'");
	   			$ConsultasSQL->PrepararCantidadDatos('Cantidad');
	        	$ConsultasSQL->PrepararQuery();
	        	return $ConsultasSQL->ExecuteConsulta('POS');
        	}
        }
           
		/**
         * Metodo Publico
         * ConsultarProveedorEditar($RFC = false)
         * 
         * Consulta Si El Proveedor Existe
         * @param $RFC: RFC Del Proveedor Necesario Para La Consulta
         * @param $NombreComercial: Nombre Comercial De La Empresa Necesario Para La Consulta
         * @param $RazonSocial: Razon Social De La Empresa Necesaria Para La Consulta
         * 
         * */
        public function ConsultarProveedorEditar($RFC = false, $NombreComercial = false, $RazonSocial = false, $IdProveedor = false) {
        	if($RFC == true AND $NombreComercial == true AND $RFC == true AND $IdProveedor == true AND isset($RazonSocial)== true) {
	        	$ConsultasSQL = new NeuralBDConsultas;
	        	$ConsultasSQL->CrearConsulta('catalogos_proveedores');
	        	$ConsultasSQL->AgregarColumnas(self::ListarColumnas('catalogos_proveedores', array('RFC', 'Nombre_Comercial', 'Razon_Social', 'Telefono_Proveedor', 'URL', 'Direccion', 'Nombre_Representante', 'Cargo', 'Telefono_Representante', 'Movil_Representante', 'Correo', 'Status'), false));
	        	$ConsultasSQL->AgregarCondicion("RFC = '$RFC' AND Nombre_Comercial = '$NombreComercial' AND Razon_Social = '$RazonSocial' AND Id != '$IdProveedor'");
	   			$ConsultasSQL->PrepararCantidadDatos('Cantidad');
	        	$ConsultasSQL->PrepararQuery();
	        	return $ConsultasSQL->ExecuteConsulta('POS');
        	}
        } 
		  
		/**
		 * Metodo InsertarProveedor($Arreglo = false)
		 * 
		 * Inserta Los Datos Del Proveedor A La Base De Datos
		 * @param $Arreglo: Arreglo De Datos Del Proveedor Para Insertr el Regustro
		 * 
		 * */     
        public function InsertarProveedor($Arreglo = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
				return self::GuardarDatos($Arreglo, 'catalogos_proveedores', array('Id', 'Status'), 'POS');
			}
		}
		
		/**
		 * Metodo Publico 
		 * ConsultaProveedorVisualizar($Id = false)
		 * 
		 * Consulta De Proveedor Para Visualizar Sus Datos
		 * @param $Id: Id Del Proveedor Necesario Para La Consulta
		 * 
		 * */
		public function ProveedorVisualizar($Id = false) {
			if($Id == true AND is_numeric($Id)){
	        	$ConsultaSQL = new NeuralBDConsultas;
	            $ConsultaSQL->CrearConsulta('catalogos_proveedores');
	            $ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogos_proveedores', false, false));
				$ConsultaSQL->AgregarCondicion("Id = '$Id'");
	        	$ConsultaSQL->PrepararQuery();
	        	return $ConsultaSQL->ExecuteConsulta('POS');
        	}
        }
        
        /**
         * Metodo Publico
         * ConsultaProveedorEliminar($Id = false)
         * 
         * Consulta Para Eliminar El Proveedor
         * @param $Id: Id Del Proveedor Necesario Para La Eliminacion
         * 
         * */
        public function EliminarProveedor($Id = false) {
        	if($Id == true AND is_numeric($Id)) {
				return self::ActualizarDatos(array('Status' => 'ELIMINADO'), array('Id'=> $Id), 'catalogos_proveedores', array('Id', 'RFC', 'Nombre_Comercial', 'Razon_Social', 'Telefono_Proveedor', 'URL', 'Direccion', 'Nombre_Representante', 'Cargo', 'Telefono_Representante', 'Movil_Representante', 'Correo'), 'POS');
			}
        }
        
        /**
         * Metodo Publico
         * ConsultaEditarProveedor($Arreglo = false)
         * 
         * Actualizar Datos Del Proveedor
         * @param $Arreglo: Arreglo de Datos Del Proveedor Para Poder Actualizar Datos
         * 
         * */
        public function EditarProveedor($Arreglo = false, $Condicion = false) {
        	if($Arreglo == true AND is_array($Arreglo) == true AND $Condicion == true AND is_array($Condicion)) {
				return self::ActualizarDatos($Arreglo, $Condicion, 'catalogos_proveedores', array('Id'), 'POS');
			}
        }
	}