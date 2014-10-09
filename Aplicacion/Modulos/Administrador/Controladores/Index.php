<?php

	class Index extends Controlador {
		
		/**
		 * Metodo Contructor
		 * 
		 * */
		function __Construct() {
			parent::__Construct();
			AyudasSession::ValSessionGlobal();
		}
		
		/**
		 * Metodo Index
		 * 
		 * Pantalla Principal de la Aplicación
		 * 
		 */
		public function Index() {
			$Usuario = AyudasSession::MostrarDatosUsuaio();
			$Plantilla = new NeuralPlantillasTwig;
			$Plantilla->ParametrosEtiquetas('Nombre', $Usuario['Nombre']);
			$Plantilla->ParametrosEtiquetas('Perfil', $Usuario['Perfil']);
			$Plantilla->ParametrosEtiquetas('Correo', $Usuario['Correo']);
			echo $Plantilla->MostrarPlantilla('General/Base.html', 'POS');
			unset($Plantilla, $Usuario);
			exit();
		}
	
	}