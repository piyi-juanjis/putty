<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
	
<?php
	
	try{
		$base=new PDO("mysql:host=localhost; dbname=pruebas", "root", "");
		$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$base->exec("SET CHARACTER SET utf8");
		
/*		$sql_total="SELECT * FROM productos";*/
		$registros_por_pagina=5; /* CON ESTA VARIABLE INDICAREMOS EL NUMERO DE REGISTROS QUE QUEREMOS POR PAGINA*/
		$estoy_en_pagina=1;/* CON ESTA VARIABLE INDICAREMOS la pagina en la que estamos*/
		
			if (isset($_GET["pagina"])){
				$estoy_en_pagina=$_GET["pagina"];				
			}
		
		$empezar_desde=($estoy_en_pagina-1)*$registros_por_pagina;
		
		$sql_total="SELECT * FROM productos";
/* CON LIMIT 0,3 HACE LA SELECCION DE LOS 3 REGISTROS QUE HAY EMPEZANDO DESDE EL REGISTRO 0*/
		$resultado=$base->prepare($sql_total);
		$resultado->execute(array());
		
		$num_filas=$resultado->rowCount(); /* nos dice el numero de registros del reusulset*/
		$total_paginas=ceil($num_filas/$registros_por_pagina); /* FUNCION CEIL REDONDEA EL RESULTADO*/
		echo "Numero de Registros de la consulta: " . $num_filas . "<br>";
		echo "Mostramos " . $registros_por_pagina . " Registros por página." . "<br>";
		echo "Mostrando la página " . $estoy_en_pagina . " de " . $total_paginas . "<br>" . "<br>";

/* ESTA PRIMERA CONSULTA ES PARA SABER NUMERO TOTAL DE REGISTROS Y MOSTRAR LAS PAGINAS Y REGISTROS QUE HAY*/
		
/*		while ($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
			echo "Código Articulo: " . $registro['CODIGOARTICULO'] . " Seccion: " . $registro['SECCION'] ." Nombre Articulo: " . $registro['NOMBREARTICULO'] .  " Precio: " . $registro['PRECIO'] .  " Fecha: " . $registro['FECHA'] .  " Importado: " . $registro['IMPORTADO'] . " Pais de Origen: " . $registro['PAISDEORIGEN'] . "<br>";
		}*/
		
		$resultado->CloseCursor();
		$sql_limite="SELECT * FROM productos LIMIT $empezar_desde,$registros_por_pagina";
		$resultado=$base->prepare($sql_limite);
		$resultado->execute(array());
		
		while ($registro=$resultado->fetch(PDO::FETCH_ASSOC)){
			echo "Código Articulo: " . $registro['CODIGOARTICULO'] . " Seccion: " . $registro['SECCION'] ." Nombre Articulo: " . $registro['NOMBREARTICULO'] .  " Precio: " . $registro['PRECIO'] .  " Fecha: " . $registro['FECHA'] .  " Importado: " . $registro['IMPORTADO'] . " Pais de Origen: " . $registro['PAISDEORIGEN'] . "<br>";
		}
		
	}catch (Exception $e){
		die ("Error: " . $e->getMessage());
		
	}
	
/*-------------------------PAGINACION-----------------*/
	echo "<br>";
	
	for ($i=1; $i<=$total_paginas; $i++){
/*		echo "<a href='?pagina=" . $i . "'>" . $i . "</a>  ";*/
		echo "<a href='index.php?pagina=" . $i . "'>" . $i . "</a>  ";
	}
	
?>
</body>
</html>