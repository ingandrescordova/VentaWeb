<?php
	class LogOut extends Controlador {
		
		/**
		 * Metodo Contructor
		 * __Construct()
		 * 
		 * Destruye la sesion
		 * 
		 * */
		function __Construct() {
			parent::__Construct();
			NeuralSesiones::Inicializacion();
			NeuralSesiones::Finalizacion();
			header("Location: ".NeuralRutasApp::RutaURL('Index'));
			exit();
		}
		
		/**
		 * Metodo Publico
		 * Index()
		 * 
		 * Redirecciona a la pantalla Login
		 * 
		 * */
		public function Index() {
			header("Location: ".NeuralRutasApp::RutaURL('Index'));
		}
	}