<?php
 
	class Perfil_Modelo extends AyudasSQLConsultas {
	
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
		public function ConsultarUsuarioPerfil($Usuario = false) {
			if($Usuario == true) {
  		       	$ConsultaSQL = new NeuralBDConsultas;
	        	$ConsultaSQL->CrearConsulta('sistema_info_usuarios');
	        	$ConsultaSQL->AgregarColumnas(self::ListarColumnas('sistema_info_usuarios', false, false));
				$ConsultaSQL->AgregarCondicion("Usuario = '$Usuario'");
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}
        }
        
        /**
		 * Metodo Publico
		 * InsertarUsuarioEditar($Arreglo = false)
		 * 
		 * Metodo Que Inserta El Usuario Editado
		 * @param $Arreglo: Parametro Necesario Para Editar El Usuario
		 * 
		 * **/
		public function EditarPerfilUsuario($Arreglo = false, $Condicion  = false, $Omitidos = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
	    		return self::ActualizarDatos($Arreglo,  $Condicion, 'sistema_usuarios', $Omitidos, 'POS');
		   	}
		}
		
		/**
		 * Metodo Publico
		 * InsertarInfomacionUsuarioEditar($Arreglo = false)
		 * 
		 * Metodo Que Inserta Los Datos Del Usuario Editado
		 * @param $Arreglo: Parametro Necesario Para Poder Editar El Usuario
		 * 
		 * **/
		public function EditarInformacionPerfil($Arreglo = false, $Condicion = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
		  		return self::ActualizarDatos($Arreglo, $Condicion, 'sistema_info_usuarios', array('Id', 'Perfil', 'Usuario'), 'POS');
		   	}
	   	}
   }