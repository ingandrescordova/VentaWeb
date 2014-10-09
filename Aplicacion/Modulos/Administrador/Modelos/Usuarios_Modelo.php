<?php

	class Usuarios_Modelo extends AyudasSQLConsultas {
		
		function __Construct() {
			parent::__Construct();	
		}
		
		/**
		 * Metodo Publico
		 * ConsultaUsuariosLista()
		 * 
		 * Metodo Que Consulta Los Usuarios
		 * 
		 * **/
		public function ConsultaUsuariosLista() {
            $ConsultaSQL = new NeuralBDConsultas;
			$ConsultaSQL->CrearConsulta('sistema_info_usuarios');
			$ConsultaSQL->AgregarColumnas('sistema_info_usuarios.Id, sistema_info_usuarios.Nombre, sistema_info_usuarios.ApellidoPaterno, sistema_info_usuarios.ApellidoMaterno, sistema_info_usuarios.Correo, sistema_info_usuarios.Usuario, sistema_info_usuarios.Telefono_Principal');
			$ConsultaSQL->CrearConsulta('sistema_usuarios');
			$ConsultaSQL->AgregarColumnas('sistema_usuarios.Usuario');
			$ConsultaSQL->AgregarCondicion("sistema_info_usuarios.Usuario = sistema_usuarios.Usuario");
			$ConsultaSQL->AgregarCondicion("sistema_usuarios.Status != 'ELIMINADO'");
			$ConsultaSQL->PrepararQuery();
			return $ConsultaSQL->ExecuteConsulta('POS');
         }
        
        /**
         * Metodo Publico
         * ConsultarUsuarioEditar($Id = false)
         * 
         * Metodo Que Consulta El Usuario A Editar
         * @param $Id: Parametro Necesario Para Consultar El Usuario
         * **/
        public function ConsultarUsuarioEditar($Id = false) {
        	if(isset($Id) == true AND  is_numeric($Id)) {
	        	$ConsultaSQL = new NeuralBDConsultas;
	        	$ConsultaSQL->CrearConsulta('sistema_info_usuarios');
	        	$ConsultaSQL->AgregarColumnas(self::ListarColumnas('sistema_info_usuarios', array('Status'), false));
				$ConsultaSQL->AgregarCondicion("Id = '$Id'");
	        	$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}
		}
		
		/**
		 * Metodo Publico
		 * ConsultarUsuarioDatos($Usuario = false)
		 * 
		 * Metodo Para Consultar Los Datos Del Usuario
		 * @param $Usuario: Parametro Necesario Para Consultar Los Datos Del Usuario
		 * 
		 * **/
		public function ConsultarUsuarioDatos($Usuario = false) {
			if(isset($Usuario) == true) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('sistema_usuarios');
				$ConsultaSQL->AgregarColumnas(self::ListarColumnas('sistema_usuarios', false, false));
				$ConsultaSQL->AgregarCondicion("Usuario = '$Usuario'");
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}	
		}
		
        /**
         * Metodo Publico
         * ConsultaUsuarioVisualizar($Id = false)
         * 
         * Metodo Para Visualizar El Usuario
         * @param $Id: Parametro Necesario Para Consultar Los Datos Del Usuario
         * 
         * **/
        public function ConsultaUsuarioVisualizar($Id = false) {
        	if(isset($Id) == true AND is_numeric($Id)) {
	        	$ConsultaSQL = new NeuralBDConsultas;
	        	$ConsultaSQL->CrearConsulta('sistema_info_usuarios');
	        	$ConsultaSQL->AgregarColumnas(self::ListarColumnas('sistema_info_usuarios', false, false));
				$ConsultaSQL->AgregarCondicion("Id = '$Id'");
	        	$ConsultaSQL->PrepararQuery();
	        	return $ConsultaSQL->ExecuteConsulta('POS');
        	}
        }
        
		/**
		 * Metodo Publico
		 * ConsultarUsuario($Usuarios = false)
		 * 
		 * Metodo Que Consulta Los Datos Del Usuario
		 * @param $Usuario: Parametro Necesario Para Consultar Los Datos Del Usuario 
		 * 
		 * **/
		public function ConsultarUsuario($Usuario = false) {
			if(isset($Usuario) == true ) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('sistema_usuarios');
				$ConsultaSQL->AgregarColumnas(self::ListarColumnas('sistema_usuarios', array('Status', 'Password', 'Perfil'), false));
				$ConsultaSQL->AgregarCondicion("Usuario = '$Usuario'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
			}	
		}
		
		/**
		 * Metodo Publico
		 * ConsultarUsuarioValidar($Usuarios = false, $Id = false)
		 * 
		 * Metodo Que Consulta Los Datos Del Usuario
		 * @param $Usuario: Parametro Necesario Para Consultar Los Datos Del Usuario 
		 * @param $Id: Parametro Necesario Para COnsultar Los Datos Del Usuario.
		 * 
		 * **/
		public function ConsultarUsuarioValidar($Usuario = false, $Id = false) {
			if(isset($Usuario) == true AND isset($Id) == true) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('sistema_usuarios');
				$ConsultaSQL->AgregarColumnas('Usuario');
				$ConsultaSQL->AgregarColumnas('Id');
				$ConsultaSQL->AgregarCondicion("Usuario = '$Usuario' AND Id != '$Id'");
				$ConsultaSQL->PrepararCantidadDatos('Cantidad');
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');	
			}
		}
		
		/**
		 * Metodo Publico
		 * InsertarInfomacionUsuario($Arreglo = false)
		 * 
		 * Metodo Que Inserta La Información Del Usuario
		 * @param $Arreglo: Parametro Necesario Para Insertar Información
		 * 
		 * **/
		public function InsertarInfomacionUsuario($Arreglo = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
				return self::GuardarDatos($Arreglo, 'sistema_info_usuarios', array('Id'), 'POS');
			}
		}
		
		/**
		 * Metodo Publico
		 * InsertarUsuario($Arreglo = false)
		 * 
		 * Metodo Que Inserta El Usuario
		 * @param $Arreglo: Parametro Necesario Para Poder Insertar El Usuario
		 * 
		 * **/
		public function InsertarUsuario($Arreglo = false) {
			if($Arreglo == true AND is_array($Arreglo) == true) {
				return self::GuardarDatos($Arreglo, 'sistema_usuarios', array('Id', 'Status'), 'POS');
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
		public function InsertarInfomacionUsuarioEditar($Arreglo = false, $Condicion = false) {
		   /*if($Arreglo == true AND is_array($Arreglo) == true) {
		    return self::ActualizarDatos($Arreglo, $Condicion, 'sistema_info_usuarios', array('Id'), 'POS');
		   }*/
	   }
		
		/**
		 * Metodo Publico
		 * InsertarUsuarioEditar($Arreglo = false)
		 * 
		 * Metodo Que Inserta El Usuario Editado
		 * @param $Arreglo: Parametro Necesario Para Editar El Usuario
		 * 
		 * **/
		public function InsertarUsuarioEditar($Arreglo = false, $Condicion  = false, $Omitidos = false) {
		   if($Arreglo == true AND is_array($Arreglo) == true) {
		    return self::ActualizarDatos($Arreglo,  $Condicion, 'sistema_usuarios', $Omitidos, 'POS');
		   }
		}
		
		/**
		 * Metodo Publico
		 * ConsultarPerfil($Id = false)
		 * 
		 * Metodo Que Consulta EL Perfil
		 * @param $Id: Parametro Necesario Para Consultar El Perfil
		 *  
		 * **/
		public function ConsultarPerfil($Id = false) {
				$ConsultaSQL = new NeuralBDConsultas;
				$ConsultaSQL->CrearConsulta('sistema_perfiles');
				$ConsultaSQL->AgregarColumnas('Id');
				$ConsultaSQL->AgregarCondicion("Nombre = '$Id'");
				$ConsultaSQL->PrepararQuery();
				return $ConsultaSQL->ExecuteConsulta('POS');
		}
		
		/**
		 * Metodo Publico
		 * EliminarUsuarioStatus($Usuario = false)
		 * 
		 * Metodo Que Elimina EL Usuario
		 * @param$Usuario: Parametro Necesario Para Poder Eliminar EL Usuario
		 * 
		 * **/
		public function EliminarUsuarioStatus($Usuario = false) {
			if($Usuario == true) {
				$Omitidos = array('Id', 'Perfil', 'Usuario', 'Password');
				return self::ActualizarDatos(array('Status' => 'ELIMINADO'), array('Usuario' => $Usuario), 'sistema_usuarios', $Omitidos, 'POS');
			}		
		}	
	}