<?php
	
	class Index_Modelo extends AyudasSQLConsultas {
		
		/**
		 * Metodo Contructor
		 * 
		 **/
		function __Construct() {
			parent::__Construct();
		}
		
		/**
		 * Metodo Publico
		 * ConsultarUsuario($Usuario = false, $Password = false)
		 * 
		 * Consulta los datos del usuario
		 * retorna un array asociativo con los datos correspondientes
		 * @param $Usuario: username
		 * @param $Password: contraseña
		 * 
		 **/
		public function ConsultarUsuario($Usuario = false, $Password = false) {
			if($Usuario == true AND $Password == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('sistema_usuarios');
				$Consulta->AgregarColumnas(self::ListarColumnas('sistema_usuarios', array('Id', 'Password', 'Status'), false, 'POS'));
				$Consulta->AgregarColumnas(self::ListarColumnas('sistema_info_usuarios', array('Id'), false, 'POS'));
				$Consulta->AgregarInnerJoin('sistema_info_usuarios');
				$Consulta->AgregarCondicionInnerJoin('sistema_usuarios.Usuario = sistema_info_usuarios.Usuario');
				$Consulta->AgregarCondicion("sistema_usuarios.Usuario = '$Usuario'");
				$Consulta->AgregarCondicion("sistema_usuarios.Password = '$Password'");
				$Consulta->AgregarCondicion("sistema_usuarios.Status = 'ACTIVO'");
				$Consulta->PrepararCantidadDatos('Cantidad');
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
			}
		}
		
		/**
		 * Metodo Publico
		 * ConsultarSupension($Usuario = false, $Password = false)
		 * 
		 * Consulta si el usuario esta supendido
		 * @param $Usuario: Username
		 * @param $Password: Contraseña
		 * 
		 * */
		public function ConsultarSupension($Usuario = false, $Password = false) {
			if($Usuario == true AND $Password == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('sistema_usuarios');
				$Consulta->AgregarColumnas(self::ListarColumnas('sistema_usuarios', array('Id', 'Password', 'Status'), false, 'POS'));
				$Consulta->AgregarColumnas(self::ListarColumnas('sistema_info_usuarios', array('Id'), false, 'POS'));
				$Consulta->AgregarInnerJoin('sistema_info_usuarios');
				$Consulta->AgregarCondicionInnerJoin('sistema_usuarios.Usuario = sistema_info_usuarios.Usuario');
				$Consulta->AgregarCondicion("sistema_usuarios.Usuario = '$Usuario'");
				$Consulta->AgregarCondicion("sistema_usuarios.Password = '$Password'");
				$Consulta->AgregarCondicion("sistema_usuarios.Status != 'ACTIVO'");
				$Consulta->AgregarCondicion("sistema_usuarios.Status != 'ELIMINADO'");
				$Consulta->PrepararCantidadDatos('Cantidad');
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
			}	
		}
		
		/**
		 * Metodo Publico
		 * ConsultarPermisos($Permisos = false)
		 * 
		 * Genera la consulta de los datos correspondientes
		 * @param $Permiso: Identificador del permiso
		 * 
		 */
		public function ConsultarPermisos($Permisos = false) {
			if($Permisos == true) {
				$Consulta = new NeuralBDConsultas;
				$Consulta->CrearConsulta('sistema_perfiles');
				$Consulta->AgregarColumnas(self::ListarColumnas('sistema_perfiles', array('Id', 'Status'), false, 'POS'));
				$Consulta->AgregarCondicion("Nombre = '$Permisos'");
				$Consulta->PrepararCantidadDatos('Cantidad');
				$Consulta->PrepararQuery();
				return $Consulta->ExecuteConsulta('POS');
			}
		}
		
	}