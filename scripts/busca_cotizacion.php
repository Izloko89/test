<?php session_start();
include("datos.php");
header("Content-type: application/json");
$term=$_GET["term"];
$id_user=$_SESSION["id_usuario"];
try{

	$bd=new PDO($dsnw, $userw, $passw, $optPDO);
	
		
		//trae la id del evento si es que la cotizacion es evento
	$sql="select id_cotizacion from cotizaciones where clave='$term'";
	$res=$bd->query($sql);
	$res=$res->fetchAll(PDO::FETCH_ASSOC);
	$id = $res[0]["id_cotizacion"];
	
	$sql="select id_evento from eventos where id_cotizacion='$id'";
	$res=$bd->query($sql);
	$filas=$res->rowCount();
	$res=$res->fetchAll(PDO::FETCH_ASSOC);

	if($filas>0)
	{
		$r["id_evento"] = $res[0]["id_evento"];
		echo json_encode($r);
		exit;
	}

	
	$bd=new PDO($dsnw, $userw, $passw, $optPDO);
	$sql="SELECT 
		cotizaciones.nombre as label,
		id_cotizacion,
		cotizaciones.id_empresa,
		cotizaciones.id_usuario,
		cotizaciones.id_cliente,
		cotizaciones.edad,
		cotizaciones.no_personas,
		cotizaciones.no_ninos,
		cotizaciones.no_adultos,
		cotizaciones.medio,
		clientes.nombre as cliente_cotizacion,
		cotizaciones.clave,
		cotizaciones.salon,
		cotizaciones.eventosalon,
		cotizaciones.nombre,
		cotizaciones.personaje,
		cotizaciones.promocion,
		cotizaciones.color_mantel,
		cotizaciones.pastel,
		cotizaciones.pinata,
		cotizaciones.centro_mesa,
		cotizaciones.invitaciones,
		cotizaciones.servicios_extra,
		cotizaciones.no_ninos_menu,
		cotizaciones.no_adultos_menu,
		cotizaciones.promocion,
		cotizaciones.guarnicion,
		cotizaciones.botana,
		cotizaciones.aguas,
		cotizaciones.refrescos,
		cotizaciones.hora_cena,
		tipo_evento.id_tipo,
		fechaevento,
		fechamontaje,
		fechadesmont
	FROM cotizaciones
	INNER JOIN tipo_evento ON tipo_evento.id_tipo=cotizaciones.id_tipo
	INNER JOIN clientes ON cotizaciones.id_cliente=clientes.id_cliente 
	WHERE cotizaciones.clave='$term' AND id_usuario=$id_user;";
	
	$res=$bd->query($sql);
	$filas=$res->rowCount();
	$res=$res->fetchAll(PDO::FETCH_ASSOC);
	
	if($filas>0){
		//arreglar fechas
		if($res[0]["fechaevento"]!=0){
			$res[0]["fechaevento"]=date("d/m/Y h:i a",strtotime($res[0]["fechaevento"]));
		}
		if($res[0]["fechamontaje"]!=0){
			$res[0]["fechamontaje"]=date("d/m/Y h:i a",strtotime($res[0]["fechamontaje"]));
		}
		if($res[0]["fechadesmont"]!=0){
			$res[0]["fechadesmont"]=date("d/m/Y h:i a",strtotime($res[0]["fechadesmont"]));
		}
		//se escribe el row obtenido
		$res[0]["bool"]=true;
		echo json_encode($res[0]);
	}else{
		$res=array(
			"bool"=>false,
			"id_empresa"=>$_SESSION["id_empresa"],
			"id_usuario"=>$_SESSION["id_usuario"]
		);
		echo json_encode($res);
	}
	
}catch(PDOException $err){
	echo json_encode($err);
}

?>