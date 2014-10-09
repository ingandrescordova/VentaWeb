<?php
	class AyudasInventario {
		/**
		* Metodo Estatico Publico
		* GenerarListaInventario($ArregloInventario = false, $ArregloControlInventario = false)
		* 
		* Genera El Arreglo De La Lista De Inventario Final
		* @param $ArregloInventario: Arreglo Necesario Para Genrar El Arreglo Final
		* @param $ArregloControlInventario: Arreglo Necesario Para Genrar El Arreglo Final 
		* 
		* */
		public static function GenerarListaInventario($ArregloInventario = false, $ArregloControlInventario = false) {
			if(count($ArregloInventario) > 0) {
				foreach($ArregloControlInventario as $Control => $ValorControl) {
					foreach($ArregloInventario as $Inventario => $ValorInventario) {
						($ArregloControlInventario[$Control]['Id'] == $ArregloInventario[$Inventario]['Producto_Inventario']) ? $ArregloControlInventario[$Control]['Existencia'] = $ArregloInventario[$Inventario]['Existencia'] : null;
						(isset($ArregloControlInventario[$Control]['Existencia'])== false) ? $ArregloControlInventario[$Control]['Existencia']= '0' : null;
					}
				}
			}
			else {
				foreach($ArregloControlInventario as $Control => $ValorControl) {
					(isset($ArregloControlInventario[$Control]['Existencia'])== false) ? $ArregloControlInventario[$Control]['Existencia']= '0' : null;
				}
			}
			return $ArregloControlInventario;
		}
		
		/**
		 * Metodo Estatico Publico
		 * ArregloImportar($ProductosExistentes = false, $ControlInventario = false)
		 * 
		 * Retorna El Arreglo Final 
		 * @param $ProductosExistentes: Arreglo Necesario Para Realizar El Arreglo Final
		 * @param $ControlInventario: Arreglo Necesario Para Realizar El Arreglo Final
		 *  
		 **/
		public static function ArregloImportar($ProductosExistentes = false, $ControlInventario = false) {
			if(count($ProductosExistentes) > 0) {
				foreach($ProductosExistentes as $Existente => $ValorExistente) {
					foreach($ControlInventario as $Control => $ValorControl) {
						if($ControlInventario[$Control]['Producto'] == $ProductosExistentes[$Existente]['Id']) {
							$ArregloFinal[] = array('Producto_Inventario' => $ControlInventario[$Control]['Producto'], 'Codigo' => $ProductosExistentes[$Existente]['Codigo'], 'NombreProducto' => $ProductosExistentes[$Existente]['NombreProducto'], 'Existencia' => $ProductosExistentes[$Existente]['Existencia']);
						}
					}
				}	
			}
			return $ArregloFinal;
		}		
	} 