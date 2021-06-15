<?php
use Config\AppConfig as Config;
use App\ModelClass;


/**
 * @api Ejemplo sencillo de consumir recursos del API "OpenWeather".
 * @category Pruebas de desarro PHP
 * @author Ing. Alfonso Chávez Baquero <alfonso.chb@gmail.com>
 * @since Creado: 2021-06-08
 * @see Referencias:
 * @link https://openweathermap.org/api Página oficial del API.
 * @link https://openweathermap.org/weather-conditions Iconos de clima.
 * @link https://geekflare.com/es/weather-api/ Otras API
 */
class ClassMetereologica extends ModelClass
{

	# Variable con los id de ciudades definidos en el API.
	// Ver los id de ciudades de Colombia en el archivo "json/ubicaciones-colombia.json"
	private $cities = [
		'3688689', // Barranquilla
		'3674962', // Bogotá
		'3689147' // Medellin
	];


    /**
    * @see Genera un string con información de la fecha actual
    * @return (string) - Fecha actual
    */
    public function currentDate()
    {
        $meses = ['01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'];
        $dias = ['1' => 'lunes', '2' => 'martes', '3' => 'miercoles', '4' => 'jueves', '5' => 'viernes', '6' => 'sábado', '7' => 'domingo'];
        return ucfirst(strtolower($dias[date('N')])).' '.date('d').' de '.$meses[date('m')].' de '.date('Y');
    }


   /**
    * Método para obtener datos desde API.
    * @param (string) $url_api - La URL del recurso API.
    * @param (array) $params - Los parametros requeridos por el API.
    * @return (array structure) - Una estructura de datos obtenida del API.
    */
    public function curlGetRequestJson( $url_api=null, $params='' )
    {
        $endpoint = $url_api . "?" . http_build_query($params);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);// SSL: certificate
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 80);
        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if( curl_error($curl) ){
            return ['error' => 'Request Error: '.curl_error($curl)];
        }
        curl_close($curl);
        $response = strip_tags( $response );
        return json_decode($response, true);
    }


   /**
    * Método para realizar el llamado a la API.
    */
    public function apiCurrentWeatherData()
    {
    	$array_data = [];
    	$config = new Config();
    	//$cities_colombia = json_decode(file_get_contents( "./json/ubicaciones-colombia.json" ), true);
    	
		foreach ($this->cities as $key => $code) {
			$response = $this->curlGetRequestJson( $config->endPointCurrent, [
				'appid' => $config->apiKey,
				'id' 	=> $code, // por ID ciudad
				//'q' 	=> $city['name'], // por nombre de ciudad
				'lang' 	=> 'es',
				'units' => 'metric',
				'mode' 	=> 'json' 
			]);
			$info = [
				'id' 			=> 0, 
	            'city_id' 		=> $response['id'], 
	            'name' 			=> $response['name'], 
	            'country' 		=> $response['sys']['country'], 
	            'timezone' 		=> $response['timezone'], 
	            'latitud' 		=> $response['coord']['lat'], 
	            'longitud' 		=> $response['coord']['lon'], 
	            'forecast' 		=> $response['weather'][0]['main'], 
	            'description' 	=> $response['weather'][0]['description'], 
	            'icon' 			=> $response['weather'][0]['icon'], 
	            'temp' 			=> $response['main']['temp'], 
	            'feels_like' 	=> $response['main']['feels_like'], 
	            'temp_min' 		=> $response['main']['temp_min'], 
	            'temp_max' 		=> $response['main']['temp_max'], 
	            'pressure' 		=> $response['main']['pressure'], 
	            'humidity' 		=> $response['main']['humidity'], 
	            'created_at' 	=> date("Y-m-d H:i:s"), 
			];
			array_push($array_data, (object)$info);
		}
    	return $array_data;
    }


   /**
    * Método para actualizar base de datos.
    * @param (array) $array_data - Los datos para actualizar.
    * @return (void) - Continuación del flujo.
    */
    public function addHistory( $array_data=[] )
    {
    	if ( is_array($array_data) and !empty($array_data) ) {
    		foreach ($array_data as $key => $info) {
		    	$list = $this->listHistory([
		    		'city_id' => $info->city_id,
		    		'date' => date("Y-m-d"),
		    		'hour' => date("H")
		    	]);

		    	if ( !is_array($list) or empty($list) ) {
			    	$add = $this->insert([
			    		'city_id' 		=> $info->city_id,
			    		'name' 			=> $info->name,
						'country' 		=> $info->country,
			    		'timezone' 		=> $info->timezone,
			    		'latitud' 		=> $info->latitud,
			    		'longitud' 		=> $info->longitud,
			    		'forecast' 		=> $info->forecast,
			    		'description' 	=> $info->description,
			    		'icon' 			=> $info->icon,
			    		'temp' 			=> $info->temp,
			    		'feels_like' 	=> $info->feels_like,
			    		'temp_min' 		=> $info->temp_min,
			    		'temp_max' 		=> $info->temp_max,
			    		'pressure' 		=> $info->pressure,
			    		'humidity' 		=> $info->humidity,
			    		'created_at' 	=> date("Y-m-d H:i:s")
			    	]);
		    	}
    		}
    	}
    	return;
    }


   /**
    * Método para obtener el historial del dia actual.
    * @return (array structure) - Historial solo del día actual.
    */
    public function getHistorical()
    {
    	return $this->listHistory([
    		'date' => date("Y-m-d")
    	]);
    }	
}

// -------------------------------------------------------------------------
$obj = new ClassMetereologica();


// -------------------------------------------------------------------------
// Obtener la fecha actual
$current_date = $obj->currentDate();


// -------------------------------------------------------------------------
// Consultar clima de la última hora, desde la base de datos.
$last_report = $obj->listHistory(['date' => date("Y-m-d"), 'hour' => date("H")]);


// -------------------------------------------------------------------------
// Si no hay registros entonces consultar API y actualizar historial.
if ( empty($last_report) ) {
	$last_report = $obj->apiCurrentWeatherData();
	$add = $obj->addHistory( $last_report );
}

$historical = $obj->getHistorical();
//echo "<pre>"; print_r($last_report);  die;
?>