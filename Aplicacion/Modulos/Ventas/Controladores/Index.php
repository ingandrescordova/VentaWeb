<?php
	class Index extends Controlador {
		
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
		 *Metodo que Muestra La Pantalla Principal de Vendedor
		 */
		public function Index() {
			echo 'Este es Vendedor';
		}
	}