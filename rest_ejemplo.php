<?php
//Código Base para REST con PHP

$method = $_SERVER['REQUEST_METHOD'];
// tendremos que tratar esta variable para obtener el recurso adecuado de nuestro modelo.
$resource = $_SERVER['REQUEST_URI'];
// Dependiendo del método de la petición ejecutaremos la acción correspondiente.
switch ($method) {
    case 'GET':
        $particion = explode("/",$resource);
        if($particion[3]=="GetUF")// Solo acepta el parametro GetUF
        {
            $data = file_get_contents("http://www.ufhoy.cl/page/19/");
            if ( preg_match('|<h1 id="logo-text">(.*?)</h1>|is' , $data , $cap ) )
            {
                if ( preg_match('|UF:(.*?)-|is' , $data , $cap ) )
                {
                    //echo $cap[1];
                    $vowels = array("$", ".");
                    $cadena = str_replace($vowels, '' ,$cap[1]);
                    $cadena = str_replace(',', '.' ,$cadena);
                    $uf = (float)$cadena;
                    $response = array( "UF" => $uf );// Devuelve la uf
                }
            }
        }
        else
        {
          $response = array( "estadoHTTP" => "Bad Request","mensaje" => "Parametros mal ingreados" ); 
        }
        // código para método GET
        break;
    case 'POST':
        $response = array( "estadoHTTP" => "Bad Request","mensaje" => "Este Servicio no soporta petcion POST" ); 
        // código para método POST
        break;
    case 'PUT':
        $response = array( "estadoHTTP" => "Bad Request","mensaje" => "Este Servicio no soporta petcion PUT" ); 
        // código para método PUT
        break;
    case 'DELETE':
        $response = array( "estadoHTTP" => "Bad Request","mensaje" => "Este Servicio no soporta petcion DETELE" ); 
        break;
}
echo json_encode($response, true); // $response será un array con los datos de nuestra respuesta.
?>