<!DOCTYPE html>
<html lang="es">
	<head>
		<title>.:: Error: Modulo <?php echo $Parametros['Modulo']; ?> No Existe ::.</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php echo NeuralScriptAdministrador::OrganizarScript(array('CSS' => array('BOOSTRAP', 'DOCS', 'OTROS'))); ?>
	</head>
<body>
	
	<a class="sr-only" href="#content">Skip navigation</a>

		<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
		  <div class="container">
		    <div class="navbar-header">
		      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
      			<a class="navbar-brand">NEURAL PHP FRAMEWORK :: Error de Aplicaci&#243;n</a>
		    </div>    
		  </div>
		</header>
		
		<div class="bs-header" id="content">
	      <div class="container animated fadeInLeft">
	        <h2>Modulo <code><?php echo $Parametros['Modulo']; ?></code> No Existe</h2>
	        <p>Modulo: <code><?php echo rtrim($Parametros['Modulo'], '/'); ?></code></p>
	        <div id="carbonads-container"><div class="logo"><div id="azcarbon"></div>
        	<img class="animated wobble" src="<?php echo __NeuralUrlRoot__.'Public/images/nf_header.png' ?>"/></div></div>
	        <br />	
	      </div>
	    </div>
		
		<div class="container bs-docs-container">
			<br /><br /><br />
      		<div class="row">
			  	<div class="col-md-2"></div>
			  	<div class="col-md-8">
				<div class="alert alert-warning animated tada delay-2s">
					<p>
						Actualmente el Modulo <code><strong><?php echo $Parametros['Modulo']; ?></strong></code> No Existe en El Archivo de Configuraci&#243;n: <br />
						<code><?php echo __NeuralUrlRoot__.$Parametros['Modulo'].'/'; ?></code> 
					</p>
				</div>
				</div>
			</div>
			
			<div class="row">
			  	<div class="col-md-2"></div>
			  	<div class="col-md-8">
					<div class="bs-callout bs-callout-info">
		      		<h4 class="text-center"><span class="glyphicon glyphicon-send"></span> Ayuda General Neural PHP Framework</h4>
		      		<p>
					  Compruebe el modulo <code><strong><?php echo $Parametros['Modulo']; ?></strong></code> se encuentre instalado en la carpeta <code>Aplicacion\Modulos</code> y que la aplicaci&oacute;n se encuentre configurada en el archivo <code>Aplicacion\Configuracion\ConfigAcceso.json</code>
			  		</p>
		    		</div>
    			</div>
			</div>
			
			<footer class="bs-footer" role="contentinfo">
		      <div class="container">
		        <p>Realizado por Neural PHP Framework.</p>
		        <p>Bajo la licencia <a href="http://www.gnu.org/licenses/gpl-3.0.html" target="_blank">GNU/GPL v3.0</a></p>
		      </div>
		    </footer>
			
		</div>
		
	</body>
</html>