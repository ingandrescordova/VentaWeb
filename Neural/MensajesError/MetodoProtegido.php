<!DOCTYPE html>
<html lang="es">
	<head>
		<title>.:: Error: Controlador <?php echo $Parametros['URL'][1]; ?>.php No Existe ::.</title>
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
	        <h2>Metodo <code><?php echo $Parametros['URL'][2]; ?></code> definido como Protected &#243; Private</h2>
	        <p>Modulo: <code><?php echo rtrim($Parametros['Modulo'], '/'); ?></code><br />Controlador: <code><?php echo $Parametros['URL'][1]; ?>.php</code><br />Metodo: <code><?php echo $Parametros['URL'][2]; ?></code></p>
	        <div id="carbonads-container"><div class="logo"><div id="azcarbon"></div>
        	<img class="animated wobble" src="<?php echo __NeuralUrlRoot__.'Public/images/nf_header.png' ?>"/></div></div>
	      </div>
	    </div>
	    
		<div class="container bs-docs-container">
			<br /><br /><br />
      		<div class="row">
			  	<div class="col-md-2"></div>
			  	<div class="col-md-8">
				<div class="alert alert-warning animated tada delay-2s">
					<p>
						Actualmente el Metodo <code><strong><?php echo $Parametros['URL'][2]; ?></strong></code> no es accesible por la ruta:
					 	<br />
						<code><?php echo __NeuralUrlRoot__.$Parametros['URL'][0].'/'.$Parametros['URL'][1].'/'.$Parametros['URL'][2]; ?></code><br />
						Este metodo se encuentra definido como Protected &#243; Private.
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
					  Compruebe que el metodo <code><strong><?php echo $Parametros['URL'][2]; ?></strong></code> se encuentre declarado como Public
					  para poder accesar al metodo.
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