<?php

	/**
	 * Clase Index
	 * 
	 * Clase Inicial que carga el framework para la visualizacion Inicial
	 */
	class SinPermisos extends Controlador {
		
		/**
		 * Metodo Contructor
		 * __Construct()
		 * 
		 */
		function __Construct() {
			parent::__Construct();
			AyudasSession::ValSessionGlobal();
		}
		
		/**
		 * Metodo Index
		 * Index()
		 * 
		 * Metodo Que Muestra La Pantalla de Error
		 * 
		 */
		public function Index() {
			$Plantilla = new NeuralPlantillasTwig;
			echo $Plantilla->MostrarPlantilla('General/Errores/ErrorSinPermisos.html', 'POS');
			unset($Plantilla);
			exit();
		}
		
	}