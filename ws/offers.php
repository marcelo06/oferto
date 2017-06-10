<?php
/*
 * Devuelve un listado de productos en oferta según los parámetros dados.
 *
 * @param company Id de la empresa; vacío o inexistente indica "todas las empresas". Default: ''.
 * @param categories Cadena con los id's de las categorías requeridas separados por comas; vacío o inexistente indica "todas las categorías". Default: ''.
 * @param quantity Cantidad de ofertas requeridas; vacío o inexistente indica que no hay límite. Default: ''.
 * @param order Forma de ordenar los resultados; usar 'random' para orden aleatorio o 'discount' para ordenar desde la mejor promoción. Default: 'random'.
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
		$response['errors'] = array(utf8_encode($db->err_msg));
	}
	else
	{
		$_GET['client'] = mysql_real_escape_string($_GET['client']);  // 'client' es la única variable que va directamente a la BD.
		$resultApc = $db->select('id_api_client, private_key', 'api_client', "client='".$_GET['client']."'");
		$rowApc = $db->fetch_array($resultApc);
		if(authenticate($_SERVER['REQUEST_URI'], $_GET['access_token'], $rowApc['private_key']))
		{
			$company = isset($_GET['company']) && !empty($_GET['company']) ? ' AND p.id_empresa='.$_GET['company'] : '';
			$categories = isset($_GET['categories']) && !empty($_GET['categories']) ? ' AND e.id_categoria IN ('.$_GET['categories'].')' : '';
			$orderVal = isset($_GET['order']) && !empty($_GET['order']) ? $_GET['order'] : 'random';
			switch($orderVal)
			{
				case 'random':
					$order = 'RAND()';
					break;
				case 'discount':
					$order = 'porcentaje DESC';
					break;
			}

			$quantity = isset($_GET['quantity']) && !empty($_GET['quantity']) ? intval($_GET['quantity']) : 16;
			$i = 0;
			$columns = 'id_producto, p.id_empresa, p.id_galeria, p.nombre, existencia_estado, existencia, oferta_descripcion, oferta_imagen, oferta_vencimiento, '.
				'oferta_existencia_estado, oferta_existencia, precio, oferta_precio, e.nombre AS empresa, CEIL(100-(oferta_precio*100/precio)) as porcentaje';
			$sql = 'SELECT '.$columns.' FROM productos AS p '.
				'LEFT JOIN core_empresas AS e ON p.id_empresa=e.id_empresa '.
				'LEFT JOIN core_categorias AS c ON e.id_categoria=c.id_categoria '.
				"WHERE borrado='0' AND p.estado!='Inactivo' AND p.oferta_portal='Activo' AND p.oferta_publicacion<=CURDATE() AND oferta_vencimiento>CURDATE() AND oferta_aprobada='Si' AND oferta_existencia>0".
				$company.$categories.' ORDER BY '.$order;
			$result = $db->query($sql);
			$rows = $db->fetch_all($result);
			foreach($rows as $key => $row)
			{
				$img = $db->fetch_array($db->select('archivo', 'galeria_imagenes', "id_galeria='$row[id_galeria]' ORDER BY posicion ASC LIMIT 1"));
				$row['foto'] = !empty($row['oferta_imagen']) ? 'files/productos/m'.$row['oferta_imagen'] : (!empty($img['archivo']) ? 'files/galerias/m'.$img['archivo'] : 'files/producto.png');

				// Descartar productos sin imágenes.
				if($row['foto'] == 'files/producto.png')
				{
					unset($rows[$key]);
					continue;
				}

				$row['empresa'] = $row['empresa'];
				$row['producto'] = !empty($row['oferta_descripcion']) ? $row['oferta_descripcion'] : $row['nombre'];
				$row['url'] = 'main-producto-id-'.$row['id_producto'].'-t-'.chstr($row['producto']);
				$row['dias_restantes'] = resta_fechas($row['oferta_vencimiento'], date("Y-m-d"));
				$row['precio_antes'] = $row['precio'] && $row['oferta_precio']<$row['precio'] ? vn($row['precio']) : '';
				$row['precio_ahora'] = !empty($row['oferta_precio']) ? vn($row['oferta_precio']) : '';
				$response['data'][] = $row;

				$i++;
				if($i == $quantity)
				{
					break;
				}
			}
		}
		else
		{
			$response['errors'] = array(utf8_encode('Error de autenticación.'));
		}
		$db->disconnect();
	}
}
else
{
	$response['errors'] = array(utf8_encode('Parámetros insuficientes. Por favor, verifique.'));
}
echo json_encode($response);
?>