<?php
 
	class Empresa_Modelo extends AyudasSQLConsultas {
	
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
		public function ConsultarDatosEmpresa() {
		  	$ConsultaSQL = new NeuralBDConsultas;
            $ConsultaSQL->CrearConsulta('catalogo_datos_empresa');
            $ConsultaSQL->AgregarColumnas(self::ListarColumnas('catalogo_datos_empresa', false, false));
            $ConsultaSQL->PrepararQuery();
            return $ConsultaSQL->ExecuteConsulta('POS');
        }
        
        /**
         * Metodo Publico
         * ActualizarDatosEmpresa($Arreglo = false, $Condicion = false)
         * 
         * Actualiza los datos de la empresa
         * @param $Arreglo: Arreglo con los datos a actualizar
         * @param $Condicion: Condicion que tiene que complir para actualizar datos 
         * 
         * */
		public function ActualizarDatosEmpresa($Arreglo = false, $Condicion = false) {
        	if($Arreglo == true AND is_array($Arreglo) == true AND $Condicion == true AND is_array($Condicion)) {
				return self::ActualizarDatos($Arreglo, $Condicion, 'catalogo_datos_empresa', array('Id'), 'POS');
			}
		}
	}