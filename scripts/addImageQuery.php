<?php session_start();
header("content-type: application/json");
include("datos.php");
$clave = isset($_GET['clave']) ? $_GET['clave']: NULL;
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : NULL;
$desc = isset($_GET['desc']) ? $_GET['desc'] : NULL;
$unidad = isset($_GET['unidad']) ? $_GET['unidad'] : 0;	  		
$image = isset($_GET['image']) ? $_GET['image'] : NULL ;
$emp = isset($_GET['emp']) ? $_GET['emp'] : 0 ;
$area = isset($_GET['area']) ? $_GET['area'] : 0;
$familia = isset($_GET['familia']) ? $_GET['familia'] : NULL ;
$subfamilia = isset($_GET['subfamilia']) ? $_GET['subfamilia'] : NULL ;
$precio1 = isset($_GET['precio1']) ? $_GET['precio1'] : 0 ;
$precio2 = isset($_GET['precio2']) ? $_GET['precio2'] : 0 ;
$precio3 = isset($_GET['precio3']) ? $_GET['precio3'] :  0 ;
$precio4 = isset($_GET['precio4']) ? $_GET['precio4'] :  0 ;
$compra = isset($_GET['compra']) ? $_GET['compra'] : 0 ;

try{
	$bd=new PDO($dsnw,$userw,$passw,$optPDO);
	$bd->query("INSERT INTO  articulos(id_empresa,area,familia,subfamilia,clave,nombre,descripcion,unidades,activo,image)
	 	VALUES
	 	($emp,'$area','$familia','$subfamilia',$clave,'$nombre','$desc','$unidad',1,'$image'); ");	
	
	$sql = "SELECT MAX(id_articulo) as id from articulos";
	$query = $bd->query($sql);
	$res = $query->fetch(PDO::FETCH_ASSOC);
	$art = $res["id"];
	//echo $art;
	$bd->query("INSERT INTO listado_precios(id_empresa,id_articulo,compra,precio1,precio2,precio3,precio4) VALUES ($emp,$art,$compra,$precio1,$precio2,$precio3,$precio4);");

	$data["continuar"]=true;
}catch(PDOException $err){
	$data["continuar"]=false;
	echo $option=$err->getMessage();
}

echo json_encode($data);
?>