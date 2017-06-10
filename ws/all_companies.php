<?php
/*
 * Devuelve el listado de empresas de Oferto.
 *
 * @param categories Cadena con los id's de las categorías requeridas separados por comas; vacío o inexistente indica "todas las categorías". Default: ''.
 * @param client Identificador del cliente que solicita acceso a la API. Req.
 * @param access_token Token de acceso a la API. Req.
 */

$response = array('data'=>array(), 'errors'=>array());

if(isset($_GET['client']) && isset($_GET['access_token']))
{
	include 'lib/functions.php';
	include 'lib/database.php';
	$db = new database();
	if($db->err_msg != '')
	{
		$response['errors'] = array(utf8_encode($db->err_msg));  // Cuando hay tildes debe codificarse.
	}
	else
	{
		$_GET['client'] = mysql_real_escape_string($_GET['client']);  // 'client' es la única variable que va directamente a la BD.
		$resultApc = $db->select('id_api_client, private_key', 'api_client', "client='".$_GET['client']."'");
		$rowApc = $db->fetch_array($resultApc);
		if(authenticate($_SERVER['REQUEST_URI'], $_GET['access_token'], $rowApc['private_key']))
		{
			$categories = isset($_GET['categories']) && !empty($_GET['categories']) ? ' AND e.id_categoria IN ('.$_GET['categories'].')' : '';
			$result = $db->select('id_empresa, nombre, descripcion_empresa, logo, telefono, movil, direccion, email, tipodominio, subdominio, dominio, latitud, longitud, categoria', 'core_empresas AS e, core_categorias AS c', 'e.id_categoria=c.id_categoria '.$categories.' ORDER BY categoria, nombre');  // Consulto todas las empresas.
			while($row = $db->fetch_array($result))
			{
				$search = array('Ã¡', 'Ã©', 'Ã­', 'Ã³', 'Ãº', 'Ã±', 'Ã', 'Ã‰', 'Ã', 'Ã“', 'Ãš', 'Ã‘');
				$replace = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
				$row['nombre'] = str_replace($search, $replace, $row['nombre']);
				$row['categoria'] = str_replace($search, $replace, $row['categoria']);
				$url = $row['tipodominio'] == 'dom' ? $row['dominio'] : $row['subdominio'].'.oferto.co';
				$response['data'][] = array('id'=>$row['id_empresa'], 'nombre'=>$row['nombre'], 'descripcion'=>$row['descripcion_empresa'], 'logo'=>$row['logo'], 'telefono'=>$row['telefono'], 'movil'=>$row['movil'], 'direccion'=>$row['direccion'], 'email'=>$row['email'], 'url'=>$url, 'latitud'=>$row['latitud'], 'longitud'=>$row['longitud'], 'categoria'=>$row['categoria']);
			}
		}
		else
		{
			$response['errors'] = array(utf8_encode('Error de autenticación.'));  // Cuando hay tildes debe codificarse.
		}
		$db->disconnect();
	}
}
else
{
	$response['errors'] = array(utf8_encode('Parámetros insuficientes. Por favor, verifique.'));  // Cuando hay tildes debe codificarse.
}
echo json_encode($response);
?>