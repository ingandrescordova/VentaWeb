<!DOCTYPE html>
<html lang="es">
	<head>
		<title>.:: Neural Framework - Error  Mod_ReWrite No Activo ::.</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="Public/css/bootstrap.css" rel="stylesheet" />
		<link href="Public/css/docs.css" rel="stylesheet" />
		<link href="Public/css/pygments-manni.css" rel="stylesheet" />
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
      			<a class="navbar-brand">NEURAL PHP FRAMEWORK :: Error de Requerimientos de Servidor</a>
		    </div>    
		  </div>
		</header>
		
		<div class="bs-header" id="content">
	      <div class="container animated fadeInLeft">
	        <h1>Requerimientos</h1>
	        <p>Los siguientes son los requerimientos básicos del Framework.</p>
	        <div id="carbonads-container"><div class="logo"><div id="azcarbon"></div>
        	<img class="animated wobble" src="Public/images/nf_header.png"/></div></div>
	        <br />	
	      </div>
	    </div>
	    
		<div class="container bs-docs-container">
			<div class="row">
        		<div class="col-md-3"></div>
        		<div class="col-md-9" role="main">
  					<div class="bs-docs-section">
  						
  						<br />
					    <h3 id="requerimientos">Requerimientos Básicos</h3>
					    <hr />
					    <p>Los siguientes requerimientos son necesarios para el funcionamiento del Framework.</p>
				<dl class="dl-horizontal">
					<dt><a>Versión de PHP</a></dt>
					<dd><div class="alert <?php echo (version_compare(phpversion(), '5.3.2', '>=')) ? 'alert-success' : 'alert-error'; ?>"><strong>Versión de PHP Mayor ó Igual a 5.3.2</strong></div></dd>
					<dt><a>Extensión ctype_alpha</a></dt>
					<dd><div class="alert <?php echo (function_exists('ctype_alpha')) ? 'alert-success' : 'alert-error'; ?>"><strong>Extensión Ctype_Alpha Disponible</strong></div></dd>
					<dt><a>Extensión MCrypt</a></dt>
					<dd><div class="alert <?php echo (extension_loaded('mcrypt')) ? 'alert-success' : 'alert-error'; ?>"><strong>Extensión Mcrypt Disponible</strong></div></dd>
					<dt><a>Extensión PDO</a></dt>
					<dd><div class="alert <?php echo (extension_loaded('PDO')) ? 'alert-success' : 'alert-error'; ?>"><strong>Extensión PDO Disponible</strong></div></dd>
				</dl>
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