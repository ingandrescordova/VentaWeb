<?php

	class Index extends Controlador {
		
		function __Construct() {
			parent::__Construct();
			AyudasSession::ValSessionGlobal();
		}
		
		/**
		 * Metodo Publico
		 * Index()
		 * 
		 * Muestra la pantalla de entrada
		 * 
		 * */
		public function Index() {
			// -- Redireccionamiento del usuario de acuerdo al perfil
			$Usuario = AyudasSession::MostrarDatosUsuaio();
			if($Usuario['Perfil'] == 'Administrador'){
				header("Location: ".NeuralRutasApp::RutaURLBase('Administrador'));
				unset($Usuario);
				exit();
			}
			elseif ($Usuario['Perfil'] == 'Vendedor') {
				header("Location: ".NeuralRutasApp::RutaURLBase('Ventas'));
				unset($Usuario);
				exit();
			}
		}
		
	}