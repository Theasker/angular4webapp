<?php
require_once 'vendor/autoload.php';

$app = new \Slim\Slim();

$db = new mysqli('localhost', 'root', 'Theasker', 'curso_angular4');

// Configuración de cabeceras CORS
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

// Nuevo producto
$app->post('/productos', function() use($app, $db){
    $json = $app->request->post('json');
    $data = json_decode($json, true);
    
    if(!isset($data['imagen'])){
        $data['imagen'] = null;
    }
    if(!isset($data['descripcion'])){
        $data['descripcion'] = null;
    }

    $query = "INSERT INTO productos VALUES(NULL,".
            "'{$data['nombre']}',".
            "'{$data['descripcion']}',".
            "'{$data['precio']}',".
            "'{$data['imagen']}');";

    $insert = $db->query($query);

    $result = array(
        "status" => 'error',
        "code" => 404,
        "message" => 'El producto NO creado correcamente'
    );

    if ($insert){
        $result = array(
            "status" => 'success',
            "code" => 200,
            "message" => 'Producto creado correcamente'
        );
    };

    echo json_encode($result);
 
});

// Listar todos los productos
$app->get('/productos', function() use($app, $db){
    $sql = 'SELECT * FROM productos ORDER BY id DESC;';
    $query = $db->query($sql);
    $productos = array();
    while($producto = $query->fetch_assoc()){
        $productos[] = $producto;
    }
    $result = array(
        'status' => 'success',
        'code' => 200,
        'data' => $productos
    );

    echo json_encode($result);
});

// Listar un producto
$app->get('/producto/:id', function($id) use($app, $db){
    $sql = 'SELECT * FROM productos WHERE id = '.$id;
    $query = $db->query($sql);

    $result = array(
        'status'    => 'error',
        'code'      => 404,
        'message'   => 'Producto no encontrado'
    );
    
    if ($query->num_rows == 1){
        $producto = $query->fetch_assoc();
        $result = array(
            'status'    => 'success',
            'code'      => 200,
            'data'   => $producto
        );
    }    
    
    echo json_encode($result);
});

// Eliminar un producto
$app->get('/delete-producto/:id', function($id) use($app, $db){
    $sql = 'DELETE FROM productos WHERE id = '.$id;
    $query = $db->query($sql);

    if($db->affected_rows){ 
        $result = array(
            'status'    => 'success',
            'code'      => 200,
            'message'   => 'Producto eliminado'
        );
    }else {
        $result = array(
            'status'    => 'error',
            'code'      => 404,
            'message'   => 'Producto NO se ha eliminado'
        );
    }
    echo json_encode($result);
});

// Actualizar un producto
$app->post('/update-producto/:id', function($id) use($app, $db){
    $json = $app->request->post('json');
    $data = json_decode($json, true);
    $sql = "UPDATE productos SET ".
        "nombre = '{$data['nombre']}',".
        "descripcion = '{$data['descripcion']}',";
    if (isset($data['imagen'])){
        $sql .= "imagen = '{$data['imagen']}',";
    }
    $sql .= "precio = '{$data['precio']}' WHERE id = ".$id;
    $query = $db->query($sql);

    if($query){
        $result = array(
            'status'    => 'success',
            'code'      => 200,
            'message'   => 'Producto se ha actualizado'
        );
    }else {
        $result = array(
            'status'    => 'error',
            'code'      => 404,
            'message'   => 'Producto NO se ha actualizado'
        );
    }
    echo json_encode($result);        
});

// Subir imagen a un producto
$app->post('/upload-file', function() use($app, $db){
    $result = array(
        'status'    => 'error',
        'code'      => 404,
        'message'   => 'El archivo no ha podido subirse'
    );

    if (isset($_FILES['uploads'])){
        $piramideUploader = new PiramideUploader();
        //var_dump($piramideUploader);
        $filesAvailable = array('image/jpeg','image/png','image/gif');

        $upload = $piramideUploader->upload('image','uploads','uploads',$filesAvailable);
        $file = $piramideUploader->getInfoFile();
        $filename = $file['complete_name'];

        if (isset($upload) && $upload['uploaded'] == false) {
            $result = array(
                'status'    => 'error',
                'code'      => 404,
                'message'   => 'El archivo no ha podido subirse'
            );
        }else {
            $result = array(
                'status'    => 'success',
                'code'      => 200,
                'message'   => 'El archivo se ha subido',
                'filename'  => $filename
            );
        }

    }
    echo json_encode($result);
});    

$app->run();