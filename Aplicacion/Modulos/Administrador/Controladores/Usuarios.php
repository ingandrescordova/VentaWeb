<?php

	class Usuarios extends Controlador {
	
		function __Construct() {
			parent::__Construct();
			AyudasSession::ValSessionGlobal();
		}
		/**
		 * Metodo Publico
		 * Index()
		 * 
		 * Muestra la Pantalla Principal de Usuarios
		 * 
		 * **/
		public function Index() {
			$Usuario = AyudasSession::MostrarDatosUsuaio();
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Nombre', $Usuario['Nombre']);
			$Plantilla->ParametrosEtiquetas('Perfil', $Usuario['Perfil']);	
	        echo $Plantilla->MostrarPlantilla('Usuarios/Base.html', 'POS');
        	unset($Plantilla, $Usuario);
        	exit();
		}
		
		/**
		 * Metodo Publico
		 * ListaUsuarios()
		 * 
		 * Muestra El Listado De Usuarios
		 * 
		 * **/
        public function ListaUsuarios() {
       		if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
    			$Consulta = $this->Modelo->ConsultaUsuariosLista();
    			$Plantilla = new NeuralPlantillasTwig;
    			$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
   				$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
					return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
				});
    			echo $Plantilla->MostrarPlantilla('Usuarios/ListaUsuarios.html', 'POS');
                unset($Plantilla, $Consulta);
    			exit();
        	}	
        }
        
		/**
		 * Metodo Publico
		 * AgregarUsuario()
		 * 
		 * Muestra La Vista De Agregar Usuario
		 * 
		 * **/         
        public function AgregarUsuario() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
				$Validacion = new NeuralJQueryValidacionFormulario;
				$Validacion->Requerido('Nombre', '* Campo Requerido');
				$Validacion->Requerido('ApellidoPaterno', '* Campo Requerido');
				$Validacion->Requerido('ApellidoMaterno', '* Campo Requerido');
				$Validacion->EMail('Correo', '* Introducir un email valido ');
				$Validacion->Requerido('Usuario', '* Campo Requerido');
				$Validacion->Requerido('Password', '* Campo Requerido');
				$Validacion->Requerido('RePassword', '* Campo Requerido');
				$Validacion->IgualACampo('Password', 'RePassword', '* Las Contraseñas no son iguales');
				$Validacion->Remote('Password', NeuralRutasApp::RutaURLBase('Administrador/Usuarios/ValidacionPassword'), 'POST', '* La Contraseña Debe Tener Minimo 8 Carateres, incluyendo una letra minuscula, mayuscula y un numero.');
				$Script[] = $Validacion->MostrarValidacion('Form');
			    $Plantilla = new NeuralPlantillasTwig;
			    $Plantilla->ParametrosEtiquetas('Controlador', 'Usuarios');
			    $Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
				$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
        		echo $Plantilla->MostrarPlantilla('Usuarios/AgregarUsuario.html', 'POS');
                unset($Plantilla, $Validacion, $Script);
        		exit();
   			}
        }
        
		/**
		* Metodo Publico
		* ValidacionPassword()
		* 
		* Valida Password a traves de procedimiento remoto
		* 
		* */
		public function ValidacionPassword() {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
		 		if(isset($_POST['Password'])){
			  		$regex = '/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/';
					$Validado = (preg_match($regex, $_POST['Password'])) ? "true" : "false";
				   	echo $Validado;
				   	unset($regex, $Validado);
				   	exit();
	  			}
			}
		}
		
		
        /**
         * Metodo Publico
         * GuardarUsuario()
         * 
         * Guarda El Usuario En La Base De Datos
         * 
         * **/
        public function GuardarUsuario() {
        	if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
               	if(isset($_POST['Nombre']) AND isset($_POST['ApellidoPaterno']) AND isset($_POST['ApellidoMaterno']) AND isset($_POST['Usuario']) AND isset($_POST['Password']) AND isset($_POST['RePassword']) AND isset($_POST['Perfil'])) {			
                   	$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Usuario', 'Correo', 'Telefono_Principal', 'Extension', 'Telefono_Movil', 'Telefono_Casa', 'Password', 'RePassword'));
					unset($DatosPost['Validar']);
					$Consulta = $this->Modelo->ConsultarUsuario($DatosPost['Usuario']);
					if($Consulta['Cantidad'] != 0 ) {
						$Plantilla = new NeuralPlantillasTwig;
						echo $Plantilla->MostrarPlantilla('Usuarios/ErrorExisteUsuario.html', 'POS');
						unset($Consulta, $Plantilla, $DatosPost);
						exit();
					}
					else {
						$Perfil = $this->Modelo->ConsultarPerfil($DatosPost['Perfil']);
						if($Perfil == true){
							$Matriz = array('Usuario'=> $DatosPost['Usuario'], 'Password'=>hash('sha256', $DatosPost['Password']), 'Perfil' => $Perfil['0']['Id']);
							$this->Modelo->InsertarUsuario($Matriz);
							unset($DatosPost['RePassword'], $DatosPost['Password']);
							$this->Modelo->InsertarInfomacionUsuario($DatosPost);
							$Plantilla = new NeuralPlantillasTwig;
							echo $Plantilla->MostrarPlantilla('Usuarios/AlertaAgregarUsuario.html', 'POS');
							unset($Matriz, $Perfil, $Plantilla, $Consulta);
							exit();	
						}
						unset($DatosPost, $Perfil, $Consulta);
						exit();		
					}	
				}   
     		}          
		}
            
  		/**
	   	 * Metodo Publico
	   	 * GuardarUsuarioEditar()
	   	 * 
	   	 * Genera La Consulta Para Editar El Proveedor
	   	 * 
	   	 * */
		public function GuardarUsuarioEditar() {
			if(isset($_POST) AND isset($_POST['Validar']) AND NeuralEncriptacion::DesencriptarDatos($_POST['Validar'], 'POS') == date('Y-m-d')) {
				if(isset($_POST['Nombre']) AND isset($_POST['ApellidoPaterno']) AND isset($_POST['ApellidoMaterno']) AND isset($_POST['Usuario'])  AND isset($_POST['Perfil']) ) {
	        		$DatosPost = AyudasPost::ConvertirTextoUcwordsOmitido(AyudasPost::LimpiarInyeccionSQL(AyudasPost::FormatoEspacio($_POST)), array('Usuario', 'Correo', 'Telefono_Principal', 'Extension', 'Telefono_Movil', 'Telefono_Casa', 'Password', 'RePassword'));
	        		unset($DatosPost['Validar']);
		     		$Consulta=$this->Modelo->ConsultarUsuarioValidar($DatosPost['Usuario'], NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['IdUsuario']), 'POS'));
		     		$Perfil=$this->Modelo->ConsultarPerfil($DatosPost['Perfil']);
		     		$DatosPost['Password'] = (!empty($DatosPost['Password'])) ? ($DatosPost['Password'] == $DatosPost['RePassword']) ? $DatosPost['Password'] : '' : '' ;
		     		$DatosPost['Status'] =  (isset($_POST['Status'])) ? 'ACTIVO' : 'INACTIVO';
		     		unset($DatosPost['RePassword']);
		     		$Omitidos = ($DatosPost['Password'] != '') ? array('Id') : array('Id', 'Password');
		     		$Matriz = ($DatosPost['Password'] != '') ? array('Usuario'=> $DatosPost['Usuario'], 'Password'=>hash('sha256', $DatosPost['Password']), 'Perfil' => $Perfil['0']['Id'], 'Status' => $DatosPost['Status']) : array('Usuario'=> $DatosPost['Usuario'], 'Perfil' => $Perfil['0']['Id'], 'Status' => $DatosPost['Status']);
		     		if($Consulta['Cantidad'] > 0) {
		     			$Plantilla = new NeuralPlantillasTwig;
		       			echo $Plantilla->MostrarPlantilla('Usuarios/ErrorEditarUsuario.html', 'POS');
						unset($Plantilla, $DatosPost, $Consulta, $Matriz, $Perfil, $Omitidos);
						exit();  	
		     		}
		     		else {
		     			$Condicion = array('Id' => NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['Id']), 'POS'));
		     			$CondicionUsuario = array('Id' => NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($DatosPost['IdUsuario']), 'POS'));
	     				unset($DatosPost['Password'], $DatosPost['Status']);
	    				unset($DatosPost['Id'], $DatosPost['IdUsuario']);
	    				$this->Modelo->InsertarUsuarioEditar($Matriz, $CondicionUsuario, $Omitidos);
	    				$this->Modelo->InsertarInfomacionUsuarioEditar($DatosPost, $Condicion);
	    				$Plantilla = new NeuralPlantillasTwig;
	    				echo $Plantilla->MostrarPlantilla('Usuarios/AlertaEditarUsuario.html', 'POS');
	    				unset($Perfil, $Matriz, $DatosPost, $Plantilla, $Omitidos);
	    				exit();	
		     		}
		 		}
				 else {
				 	$Plantilla = new NeuralPlantillasTwig;
    				echo $Plantilla->MostrarPlantilla('Usuarios/ErrorCamposRequeridos.html', 'POS');
    				unset($Plantilla);
    				exit();
				 }		
			}   
     	}
	   	
	   	/**
	   	 * Metodo Publico
	   	 * EditarUsuario($Id = false)
	   	 * 
	   	 * Muestra La Vista De Editar Usuario
	   	 * @param$Id: Parametro Necesario Para Poder Editar Usuario
	   	 * 
	   	 * **/
        public function EditarUsuario($Id = false) {
             if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
             	if(isset($Id) == true AND is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
					$Consulta = $this->Modelo->ConsultarUsuarioEditar(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
	        		$ConsultaDatos =$this->Modelo->ConsultarUsuarioDatos($Consulta['0']['Usuario']);
		            $Validacion = new NeuralJQueryValidacionFormulario;
					$Validacion->Requerido('Nombre', '* Campo Requerido');
					$Validacion->Requerido('ApellidoPaterno', '* Campo Requerido');
					$Validacion->Requerido('ApellidoMaterno', '* Campo Requerido');
					$Validacion->EMail('Correo', '* Introducir un email valido ');
					$Validacion->Requerido('Usuario', '* Campo Requerido');
					$Validacion->Remote('Password', NeuralRutasApp::RutaURLBase('Administrador/Usuarios/ValidacionPassword'), 'POST', '* La Contraseña Debe Tener Minimo 8 Carateres, incluyendo una letra minuscula, mayuscula y un numero.');
					$Validacion->IgualACampo('Password', 'RePassword', '* Las Contraseñas no son iguales');
					$Script[] = $Validacion->MostrarValidacion('Form');
				    $Plantilla = new NeuralPlantillasTwig;
				    $Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
	    			$Plantilla->ParametrosEtiquetas('ConsultaDatos', $ConsultaDatos);
	    			$Plantilla->AgregarFuncionAnonima('Encriptacion', function($Id) {
						return AyudasConversorHexAscii::ASCII_HEX(NeuralEncriptacion::EncriptarDatos($Id, 'POS'));
					});
	    			$Plantilla->ParametrosEtiquetas('Validar', NeuralEncriptacion::EncriptarDatos(date('Y-m-d'), 'POS'));
					$Plantilla->ParametrosEtiquetas('Script', NeuralScriptAdministrador::OrganizarScript(false, $Script));
	    			echo $Plantilla->MostrarPlantilla('Usuarios/EditarUsuario.html', 'POS');
	                unset($Plantilla, $Consulta, $ConsultaDatos, $Validacion, $Script, $Id);
	    			exit();
    			}
        	}
        }
        
        /**
         * Metodo Publico
         * EliminarUsuario($Usuario = false)
         * 
         * Metodo Que Muestra La Vista De Eliminar Usuario
         * @param$Usuario: Parametro necesario Para Eliminar usuario
         * 
         * **/
        public function EliminarUsuario($Usuario = false) {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
            	if(isset($Usuario) == true) {
	   				$Plantilla = new NeuralPlantillasTwig;
					$Plantilla->ParametrosEtiquetas('Usuario', $Usuario);
	    			echo $Plantilla->MostrarPlantilla('Usuarios/EliminarUsuario.html', 'POS');
	                unset($Plantilla, $Usuario);
	    			exit();
    			}
        	}
        }
        
        /**
         * Metodo Publico
         * CambiarStatus($Usuarios = false)
         * 
         * Metodo Que Elimina El Usuario
         * @param$Usuario:Parametro Necesario Para Eliminar 
         * 
         * **/
        public function CambiarStatus($Usuario = false) {
            if(isset($Usuario) AND isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
        		$this->Modelo->EliminarUsuarioStatus(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Usuario), 'POS'));
        		unset($Usuario);
			    exit();
        	}
        }
        
        /**
         * Metodo Publico
         * VisualizarUsuario($Id = false)
         * 
         * Metodo Que Visualiza Editar Usuario
         * @param$Id: Parametro Necesario Para Editar El Usuario
         * 
         * **/
        public function VisualizarUsuario($Id = false) {
        	if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) == true AND mb_strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' AND $_SERVER['HTTP_REFERER'] != $_SERVER['HTTP_HOST'] ) {
       			if($Id == true AND  is_numeric(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'))) {
       				$Consulta = $this->Modelo->ConsultaUsuarioVisualizar(NeuralEncriptacion::DesencriptarDatos(AyudasConversorHexAscii::HEX_ASCII($Id), 'POS'));
       				$Plantilla = new NeuralPlantillasTwig;
       				$Plantilla->ParametrosEtiquetas('Consulta', $Consulta);
        			echo $Plantilla->MostrarPlantilla('Usuarios/VisualizarUsuario.html', 'POS');
                    unset($Plantilla, $Consulta, $Id);
        			exit();
				}
   			}	
        }
	}