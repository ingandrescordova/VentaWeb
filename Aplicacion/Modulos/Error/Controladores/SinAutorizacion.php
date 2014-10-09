<?php
	class SinAutorizacion extends Controlador {
		
		/**
		 * Metodo Contructor
		 * __Construct()
		 * 
		 */
		function __Construct() {
			parent::__Construct();
		}
		
		/**
		 * Metodo Index
		 * Index()
		 * 
		 * Metodo Que Muestra el Error de Login
		 * 
		 */
		public function Index() {
			$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('General/Errores/ErrorLogin.html', 'POS');
			unset($Plantilla);
			exit();
		}
		
		/**
		 * Metodo Publico
		 * Suspendido()
		 * 
		 * Metodo Que Muestra La Vista de Suspendido
		 * 
		 * */
		public function Suspendido() {
			$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('General/Errores/ErrorSuspendido.html', 'POS');
			unset($Plantilla);
			exit();
		}
	}