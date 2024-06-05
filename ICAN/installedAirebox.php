<?php
include("geoip.inc");
include("geoipcity.inc");
include("geoipregionvars.php");		

class FreeGeoIP
{
    public function Lookup($ip) 
    {
		$auth = base64_encode('u10200:citroen');

		$aContext = array(
			'http' => array(
				'proxy' => 'tcp://192.168.16.2:8080',
				'request_fulluri' => true,
				'header' => "Proxy-Authorization: Basic $auth",
			),
		);
		$cxContext = stream_context_create($aContext);
		
        $url = "http://freegeoip.net/json/".$ip;
        $string = file_get_contents($url, False, $cxContext);
        return $string;
    }
}
		
?>

<HTML>
<HEAD><link rel="shortcut icon" href="favicon.ico" />
<TITLE>Estadísticas de Actualizciones ICAN</TITLE>
	<script language="JavaScript" type="text/JavaScript">
</script>

</HEAD>
	<BODY>

		<table cellspacing="0" cellpadding="4" align="Left" border="0" id="GridView" style="color:#333333;font-size:9pt;width:1024px;border-collapse:collapse;vertical-align: middle">
			<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
				<form name="FormAireBox" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<th scope="col" align="left">
					Selecciona Fecha a consultar: 
						<select name="dia" id="dia">
								<?php
								for ($i=1; $i<=31; $i++) {
									if ($i == date('j')-1)
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
						</select>
						<select name="mes" id="mes">
								<?php
								for ($i=1; $i<=12; $i++) {
									if ($i == date('m'))
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
						</select>
						<select name="ano" id="ano">
								<?php
								for($i=date('y'); $i>=00; $i--){
									if ($i == date('y'))
										echo '<option value="'.$i.'" selected>'.$i.'</option>';
									else
										echo '<option value="'.$i.'">'.$i.'</option>';
								}
								?>
						</select></th>
					<th scope="col" align="left">
					  Pais: <select name="pais">
						  <option selected></option>
						  <option value="ICAN">ICAN</option>
						</select></th>
					<th scope="col" align="left">
					  Marca:<select name="marca">
						  <option selected></option>
						  <option value="Citroen">Citroen</option>
						  <option value="Peugeot">Peugeot</option>
						</select></th>
					<th scope="col" align="left">
					 </th>
					<th scope="col" align="left">
					 </th>
					<th scope="col" align="left">
					 </th>
					<th scope="col" align="right">
						<input name="enviar" id="enviar" type="submit" value="Consultar Pais"></input>
					</th>
				</form>
			</tr>
		</table>
		<br>
	<?php	
		$errors = array();
		if(isset($_POST['enviar'])){
			if(!strlen($_POST['pais']) > 0){
				echo "</BR>";
				$errors[] = 'No has especificado el pais';
			}			
			if (strlen($_POST['pais']) > 0){
				///////////Inicio de cadena de conexion a BBDD
				require 'config.php';

				try{
					$conn = new PDO( "sqlsrv:server=".SERVERNAME.",54508;database=".DATABASE, DB_USER, DB_PASS);
					$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
					$conn->setAttribute(PDO::SQLSRV_ATTR_DIRECT_QUERY , true);    
				}catch(PDOException $e){
					echo $e->getMessage();
					exit();		
				}
				/////////Fin de cadena de conexion a BBDD
	
				$pais=$_POST['pais'];
				$marca=$_POST['marca'];
				$dia=$_POST['dia'];
				$mes=$_POST['mes'];
				$ano=$_POST['ano'];
				$dia1=str_pad($dia, 2, "0", STR_PAD_LEFT);
				$mes1=str_pad($mes, 2, "0", STR_PAD_LEFT);
				$ano1=str_pad($ano, 2, "0", STR_PAD_LEFT);
				$archivo="u_ex".$ano1.$mes1.$dia1.".log";
				//echo $archivo;
				if(!strlen($_POST['marca']) > 0){
					$marca="o";
				}
				
				$miarrayRRDI = array(); // creo el array
				$miarray=array();
				$file_handle = fopen("../AireBox/logs/".$archivo, "rb") or die("No esta disponible el fichero de LOG");
				while (!feof($file_handle) ) {
					$line_of_text = fgets($file_handle);
					if(( strpos( $line_of_text, $pais ) !== false ) && ( strpos( $line_of_text, $marca) !== false) && (strstr($line_of_text, 'version.txt')) && (strstr($line_of_text, 'GET'))) {
						array_push($miarray, substr($line_of_text, stripos($line_of_text,$ano1),strpos($line_of_text,"Java")-strlen($line_of_text)));
					}
				}
				fclose($file_handle);
				$result = array_unique($miarray);
				
				$fecha = date("d-m-Y", strtotime("20".$ano1."-".$mes1."-".$dia1));
				$data1=strtotime('-1 day',strtotime($fecha));
				$data2=strtotime('-2 day',strtotime($fecha));
				$data3=strtotime('-3 day',strtotime($fecha));
						
				//echo $miarray;
				//print_r($result);
					echo '<div class="listado"><br>';
						echo '<table cellspacing="0" cellpadding="2" align="Left" border="1" id="GridView" 		style="color:#333333;font-size:9pt;width:1280px;border-collapse:collapse;vertical-align: middle">
						<tr align="left" style="color:Black;background-color:#5D7AAA;font-weight:bold;">';
						echo '<th scope="col">Hora Conexión</th>';	
						echo '<th scope="col">PAIS</th>';								
						echo '<th scope="col">MARCA</th>';
						echo '<th scope="col">Sistema Operativo</th>';
						echo '<th scope="col">IP WAN</th>';
						echo '<th scope="col">Vers. ICAN</th>';
						echo '<th scope="col">Cod. RRDI</th>';
						echo '<th scope="col">Vers. DMS & Backup</th>';
						echo '<th scope="col">Serv. Sincro</th>';
						echo '<th scope="col">Serv. Envio</th>';
						echo '<th scope="col">'.date('d/m/Y',$data1).'</th>';
						echo '<th scope="col">'.date('d/m/Y',$data2).'</th>';
						echo '<th scope="col">'.date('d/m/Y',$data3).'</th>';
						echo '<tr><th></th><th></th><th></th><th></th><th></th><th></th><th></th></tr>';
						$contador=0;	
						$winXP=0;
						$win2K3=0;
						$winVista=0;
						$win7=0;
						$win2K8=0;
						$win8=0;
						$win2K12=0;
						$linux=0;
						$indefinido=0;
						
						foreach($result as $linea){
							$array=explode("/",$linea);
							//echo $linea.'<br>';
							echo '<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">';
							echo '<th scope="col">'.str_replace('10.159.172.247 GET',' ',$array[0]).'</th>';
							$ip=str_replace(' AireBox','',str_replace('version.txt - 80 - ','',$array[7]));		
							$gi = geoip_open("./GeoLiteCity.dat", GEOIP_STANDARD);
							$rsGeoData = geoip_record_by_addr($gi, $ip);							 
							geoip_close($gi);
							
							$arrayPais=$array[3];
							$arrayMarca=$array[4];
							$arraySO=$array[5];
							$arrayTipoFlujo=$array[6];
							$arrayVerAireBox=$array[8];
							$arrayRRDI=$array[9];
							$arrayVerDMS=str_replace('\'','',$array[12]);
							if ((preg_match('/STAR/',$array[12]))){
								$arrayBackup=str_replace('+','',$array[13]);
							}else{
								$arrayBackup='X';
							}
							$arrayServicios=$array[11];
							$arrayVerJava=$array[14];

							echo '<th scope="col">'.$arrayPais.'</th>';	
							echo '<th scope="col">'.$arrayMarca.'</th>';
							echo '<th scope="col">'.$arraySO.' ('.str_replace('+',' ',$array[10]).')</th>';
							echo '<th scope="col"><A HREF="http://www.iplocation.net/index.php?query='.$ip.'&submit=Query" target="_blank">'.$ip.'</A>
								- <A HREF="http://api.hostip.info/get_html.php?ip='.$ip.'">
								<IMG SRC="http://api.hostip.info/flag.php?ip='.$ip.'" width="20" height=auto></A> - '.$rsGeoData->country_name.', '.$rsGeoData->city.'</th>';
							echo '<th scope="col">'.$arrayVerAireBox.'</th>';
							echo '<th scope="col">'.$arrayRRDI.'</th>';
							//Si no existe agrega a bbdd
							$insertQuery = "IF NOT EXISTS(SELECT * FROM AireBox_Data WHERE rrdi_code='".$arrayRRDI."') 
												BEGIN 
													INSERT INTO AireBox_Data (rrdi_code, pais, marca, airebox_version, SO, IP, last_connection, java_version, dms_version, backup_dms,tipo_flujo) 
													VALUES ('".$arrayRRDI."','".$arrayPais."','".$arrayMarca."','".$arrayVerAireBox."', '".$arraySO.' ('.str_replace('+',' ',$array[10]).")', '".$ip."', '".str_replace('10.159.172.247 GET',' ',$array[0])."', '".$arrayVerJava."', '".str_replace('+',' ',$arrayVerDMS)."', '".$arrayBackup."','".$arrayTipoFlujo."') 
												END";
							$dbobj = $conn->prepare($insertQuery);
							$dbobj->execute(array(""));	
							$dbobj = NULL;
							
							$selectQuery = "SELECT last_connection FROM AireBox_Data WHERE rrdi_code='".$arrayRRDI."'";
							$stmt = $conn->prepare($selectQuery);
							$stmt->execute();
							while ($row = $stmt->fetch()) {
							  $ultimaConexionDB = trim($row[0],' ');
							}
							$stmt = NULL;
							
							$fechaReal = strtotime(trim(str_replace('10.159.172.247 GET',' ',$array[0]),' '));
							$fechaDB = strtotime($ultimaConexionDB);
							
							if($fechaReal > $fechaDB){
								$insertQuery2="BEGIN
												UPDATE AireBox_Data 
												SET airebox_version='".$arrayVerAireBox."', 
													SO='".$arraySO.' ('.str_replace('+',' ',$array[10]).")', 
													IP='".$ip."', 
													last_connection='".str_replace('10.159.172.247 GET',' ',$array[0])."', 
													dms_version='".str_replace('+',' ',$arrayVerDMS)."',
													backup_dms='".$arrayBackup."',
													tipo_flujo='".$arrayTipoFlujo."'
												WHERE rrdi_code='".$arrayRRDI."'
											END";
								$dbobj2 = $conn->prepare($insertQuery2);
								$dbobj2->execute(array(""));	
								$dbobj2 = NULL;
							}	
							if(strcmp('0', $arrayBackup) === 0){
								echo '<th scope="col" style="background-color:Red">'.str_replace('+',' ',$arrayVerDMS).'</th>';
							}else{
								echo '<th scope="col">'.str_replace('+',' ',$arrayVerDMS).'</th>';
							}
							
							if ((str_replace('+','',$arrayServicios))=='00') {
								echo '<th scope="col" style="background-color:Red">OFF</th>';
								echo '<th scope="col" style="background-color:Red">OFF</th>';
							}else if (str_replace('+','',$arrayServicios)=='10') {
								echo '<th scope="col" style="background-color:Green">ON</th>';
								echo '<th scope="col" style="background-color:Red">OFF</th>';
							}else if (str_replace('+','',$arrayServicios)=='01') {
								echo '<th scope="col" style="background-color:Red">OFF</th>';
								echo '<th scope="col" style="background-color:Green">ON</th>';
							}else if (str_replace('+','',$arrayServicios)=='11') {
								echo '<th scope="col" style="background-color:Green">ON</th>';
								echo '<th scope="col" style="background-color:Green">ON</th>';
							}else{
								echo '<th scope="col"> Sin datos</th>';
								echo '<th scope="col"> Sin datos</th>';
							}							
							for ($i=1; $i<=3; $i++) {
								$fileLog = fopen ("../AireBox/logs/u_ex".date('ymd',strtotime('-'.$i.' day',strtotime($fecha))).".log", "r");
								$encontrado=false;
								while (!feof($fileLog) && !$encontrado) { 
									$lineaLog = fgets($fileLog);
									if (strpos($lineaLog, $arrayRRDI) && strpos($lineaLog,"version.txt")) {
										$encontrado=true;
									}								
								} 								
								if ($encontrado) { 
									echo '<th scope="col"><font color="Green">On Line<font></th>';
								} else { 
									echo '<th scope="col"><font color="Red">Off Line<font></th>';
								} 
								fclose ($fileLog); 
							}
							
								
							echo '</tr>';
							//$excel.= $array[3] . $tab . $array[4] . $tab . $array[5] . $tab . $array[8] . $tab . $array[9] . $cr;
							$contador=$contador+1;
							if (strstr($array[10],'5.1')){
								$winXP=$winXP+1;
							}else if (strstr($array[10],'2003-5.2')){
								$win2K3=$win2K3+1;
							}else if (strstr($array[10],'vista-6.0')){
								$winVista=$winVista+1;
							}else if (strstr($array[10],'6.') && strstr($array[10],'2008')){
								$win2K8=$win2K8+1;
							}else if (strstr($array[10],'7-6.1')){
								$win7=$win7+1;
							}else if (strstr($array[10],'8-6.2')){
								$win8=$win8+1;
							}else if (strstr($array[10],'6.2') && strstr($array[10],'2012')){
								$win2K12=$win2K12+1;
							}else if (strstr($array[10],'linux')){
								$linux=$linux+1;
							}else{
								$indefinido=$indefinido+1;
							}
						}

						echo "<font face='arial' color='blue' size='2px'>Fecha consulta: ".$dia1."/".$mes1."/".$ano1,"  ||  ";
						if ($marca=="o") {
							$marcaFin="Citroen & Peugeot";
						}else{
							$marcaFin=$marca;
						}
						echo "Pais: ".$pais."  ||  Marca: ".$marcaFin."<br>";
						echo "Nº de máquinas: ".$contador."<br>
						Windows XP :: ".$winXP." || Windows Vista :: ".$winVista." || Windows 7 :: ".$win7." || Windows 8 :: ".$win8." || Windows Server 2003 :: ".$win2K3." || Windows  Server 2008 :: ".$win2K8." || Windows Server 2012 :: ".$win2K12." || Linux :: ".$linux." || No definidos :: ".$indefinido."<br><br>";
						echo '</font></tr></table>';		
					echo '</div>';
					
					//close the connection
					$conn = null;
					
			}
		}
	?>
	</br>
	<!-- // <form action=export.php method = POST><input type=text name=export value=<?php echo $excel;?>/>  // -->
	<!-- //<input type = submit value = Exportar></form> // -->
	</BODY>
 </HTML>