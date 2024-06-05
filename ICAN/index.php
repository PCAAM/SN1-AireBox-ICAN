<HTML>
<HEAD><link rel="shortcut icon" href="favicon.ico" />
<TITLE>Flujos ICAN</TITLE>
	<script language="JavaScript" type="text/JavaScript">
</script>

</HEAD>
	<BODY>
	<?php
	
		function rrmdir($dir) {
			if (is_dir($dir)) {
			  $objects = scandir($dir);
			  foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
				  if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
				}
			  }
			  reset($objects);
			  rmdir($dir);
			}
		  }

		function removeDirectory($path)
			{
				$path = rtrim( strval( $path ), '/' ) ;			 
				$d = dir( $path );			 
				if( ! $d )
					return false;			 
				while ( false !== ($current = $d->read()) )
				{
					if( $current === '.' || $current === '..')
						continue;			 
					$file = $d->path . '/' . $current;			 
					if( is_dir($file) )
						removeDirectory($file);			 
					if( is_file($file) )
						unlink($file);
				}			 
				rmdir( $d->path );
				$d->close();
				return true;
			}
	?>
		<A HREF="installedAireBox.php"> - Comprobar Listado de ICAN ON-Line</A><br>
		<A HREF="../airebox/findAireBox.php"> - Búsqueda en BBDD de información de ICAN</A><br><br>
		Listado de Flujos:<br><br> 
		<table cellspacing="0" cellpadding="4" align="Left" border="0" id="GridView" style="color:#333333;font-size:9pt;width:512px;border-collapse:collapse;vertical-align: middle">
			<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
				<form name="FormAireBox" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
					<th scope="col" align="left">
					  Pais: <select name="pais">
						  <option selected></option>
						  <option value="ICAN">ICAN</option>
						  <option value="ICAN_preprod">ICAN_preprod</option>
						</select></th> 
					<th scope="col" align="left">
					  Marca: <select name="marca">
						  <option selected></option>
						  <option value="Citroen">Citroen</option>
						  <option value="Peugeot">Peugeot</option>
						</select></th>
					<th scope="col" align="left">
					  Tipo de Conexion: <select name="conexion">
						  <option selected></option>
						  <option value="Intranet">INTRANET</option>
						  <option value="Internet">Internet</option>
						</select></th>
					<th scope="col" align="right">
						<input name="enviar" id="enviar" type="submit" value="Consultar Flujos"></input>
					</th>
				</form>
			</tr>
		</table>
		<br>

		<br><br>	
		<!--<table cellspacing="0" cellpadding="4" align="Left" border="0" id="GridView1" style="color:#333333;font-size:12pt;width:512px;border-collapse:collapse;vertical-align: middle">
			<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
				<form name="FormNewVersion" action="../ICAN/newversion.php" method="post">
					<th scope="col" align="right">Agregar NUEVA VERSION de ICAN: 
							<input name="version" id="version" type="submit" value="Crear"></input>
					</th>
				</form>
			</tr>
		</table>
		</br>-->
		
		 <?php
		  $errors = array();
		   if(isset($_POST['enviar']) || (strlen($_GET['pais']) > 0 && strlen($_GET['marca']))){
			  if(!strlen($_POST['pais']) > 0 && !strlen($_GET['pais']) > 0){
				echo "</BR>";
				$errors[] = 'No has introducido el pais';
			  }

			  if(!strlen($_POST['marca']) > 0 && !strlen($_GET['marca']) > 0){
			  	echo "</BR>";
				$errors[] = 'No has introducido la marca';
			  }
			  
			  if(!strlen($_POST['conexion']) > 0 && !strlen($_GET['conexion']) > 0){
			  	echo "</BR>";
				$errors[] = 'No has especificado el tipo de conexión';
			  }
			  if ((strlen($_POST['pais']) > 0 && strlen($_POST['marca']) && strlen($_POST['conexion']) > 0) || (strlen($_GET['pais']) > 0 && strlen($_GET['marca']) && strlen($_GET['conexion']) > 0)){
				if ((strlen($_POST['pais'])) > 0){$pais=$_POST['pais'];}
				if ((strlen($_POST['marca'])) > 0){$marca=$_POST['marca'];}
				if ((strlen($_POST['conexion'])) > 0){$conexion=$_POST['conexion'];}
				if ((strlen($_GET['pais'])) > 0){$pais=$_GET['pais'];}
				if ((strlen($_GET['marca'])) > 0){$marca=$_GET['marca'];}
				if ((strlen($_GET['conexion'])) > 0){$conexion=$_GET['conexion'];}
				if ($conexion=="Intranet"){
					if (strpos($pais, 'preprod') !== false){
						$url="mts-preprod.inetpsa.com";
					}else{
						$url="mts.inetpsa.com";
					}
				}else{
					if (strpos($pais, 'preprod') !== false){
						$url="mts-preprod.mpsa.com";
					}else{
						$url="mts.mpsa.com";
					}
				}
				
				$ruta=$_SERVER['DOCUMENT_ROOT'];
				if (!file_exists($ruta."/ICAN/".$pais."/".$marca."/Windows/".$conexion."/version.txt")){
					echo '<br>';
					echo '<div class="listado"><br>';
						echo '<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">';
							echo '<li style="color:#333333;font-size:10pt;width:512px;border-collapse:collapse">No existen flujos definidos o configurados para AireBoxWeb en <b>'; echo $pais ; echo '</b> para <b>'.$marca.'</b></li>';
						echo '</tr>';
					echo '</div>';
					exit;
				}
			
				$fp = fopen($ruta."/ICAN/".$pais."/".$marca."/Windows/".$conexion."/version.txt","r") or die("No se ha podido abrir el fichero");
				$version=fread($fp,filesize($ruta."/ICAN/".$pais."/".$marca."/Windows/".$conexion."/version.txt"));
				fclose($fp);
				$fichero=$ruta."/ICAN/".$pais."/".$marca."/Windows/".$conexion."/".$version.".zip";
				
				//descomprimir zip
				//visualizar daemon_envio y daemon_sincro para ver flujos
				
				if (file_exists($fichero)){
				echo '</br>';
				echo '<hr>';
				echo '<div class="listado" align="center">';
					echo '<p style="color:White;background-color:#5D7B9D">Flujos creados para : <b>'.$pais.'</b> ---- <b>'.$marca.' ---- '.$conexion.'</b></p>';
					echo '</div>';
						echo '<table cellspacing="0" cellpadding="4" align="Center" border="0" id="GridView" style="color:#333333;font-size:9pt;width:980px;border-collapse:collapse;vertical-align: middle">';
							echo '<tr align="center" style="color:White;background-color:#5D7B9D;font-weight:bold;">';
								echo '<th scope="col">Activado</th>';
								echo '<th scope="col">Nombre CIBLE fichero</th>';
								echo '<th scope="col">Nombre DMS fichero</th>';
								echo '<th scope="col">Directorio de flujo</th>';
								echo '<th scope="col">SubDirectorio de flujo</th>';
								echo '<th scope="col">URL Servidor</th>';
								echo '<th scope="col">Sentido</th>';
							echo '</tr>';	
					//Abrimos archivo.zip para leer purga
					$zip = new ZipArchive;
					$res = $zip->open($fichero);
					if ($res === TRUE) {
						$zip->extractTo('./tmp');
						$zip->close();
					} else {
						echo 'Informacion NO extraida<br>';
						exit;
					}
				echo '<hr>';
				}else{
					echo '<div class="listado"><br>';
						echo '<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">';
							echo '<li style="color:#333333;font-size:10pt;width:512px;border-collapse:collapse">No existen flujos definidos o configurados para AireBoxWeb en <b>'; echo $pais ; echo '</b> para <b>'.$marca.'</b></li>';
						echo '</tr>';
					echo '</div>';
					exit;
				}
				//echo '<tr align="left" valign="middle" style="color:#333333;background-color:#F7F6F3;">';
				
				//echo '<tr>';
				if (file_exists("./tmp/scripts/daemon_send_AireBox.bat") || file_exists("./tmp/scripts/daemon_reception_AireBox.bat")){	
					if (file_exists("./tmp/scripts/daemon_send_AireBox.bat")){
						$fp = file("./tmp/scripts/daemon_send_AireBox.bat") or die("No se ha podido abrir el fichero");
						$cadena = "call";
						$cadena2 = "REM if";
						$flujosUpload = array();
						$i=0;
						$j=1;
						foreach($fp as $n=>$linea){	
							$valor=substr($linea,34,4);
							$valor2=substr($linea,0,6);
							if ($valor==$cadena){
								$name=substr($linea, 59);
								$pos=strpos($linea,'.bat');
								$name=substr($name,0,($pos-59));
								//echo $linea.'<br>';	
									echo '<tr align="left" valign="middle" style="color:#333333;background-color:#F7F6F3;">';								
									echo '<th scope="col"> <input type="checkbox" name="'.$name.'" disabled="disabled" checked="checked"></th>';
									echo '<th scope="col">'.$name.'</th>';
									if(file_exists("./tmp/config/upload.flx")){
										$fpUpload=fopen ("./tmp/config/upload.flx", "r");
										$contenidoUpload = fread($fpUpload, filesize("./tmp/config/upload.flx"));
										$arrUpload = explode("\n",$contenidoUpload );
										for($k=0;$k<sizeof($arrUpload);$k++){
											$fluxUpload=explode(",",$arrUpload[$k]);
											if ($name==$fluxUpload[0]){
												echo '<th scope="col">'.$fluxUpload[1].'</th>';
												echo '<th scope="col">'.$fluxUpload[2].'</th>';
												echo '<th scope="col">'.$fluxUpload[3].'</th>';
											}										
										}
										fclose($fpUpload);				
									}																
									echo '<th scope="col">'.$url.'</th>';
									echo '<th scope="col"> UPLOAD </th>';
								echo '</tr>';
								$flujosUpload[$i] = $name;
								$i=$i+2;
							}else{
								if ($valor2==$cadena2){
									$name=substr($linea, 59);
									$pos=strpos($linea,'.bat');
									$name=substr($name,0,($pos-59));
									//echo $linea.'<br>';
									echo '<tr align="left" valign="middle" style="color:#333333;background-color:#F7F6F3;">';
									echo '<th scope="col"> <input type="checkbox" name="'.$name.'" disabled="disabled"></th>';
										echo '<th scope="col">'.$name.'</th>';
										if(file_exists("./tmp/config/upload.flx")){
											$fpUpload=fopen ("./tmp/config/upload.flx", "r");
											$contenidoUpload = fread($fpUpload, filesize("./tmp/config/upload.flx"));
											$arrUpload = explode("\n",$contenidoUpload );
											for($k=0;$k<sizeof($arrUpload);$k++){
												$fluxUpload=explode(",",$arrUpload[$k]);
												if ($name==$fluxUpload[0]){
													echo '<th scope="col">'.$fluxUpload[1].'</th>';
													echo '<th scope="col">'.$fluxUpload[2].'</th>';
													echo '<th scope="col">'.$fluxUpload[3].'</th>';
												}										
											}
											fclose($fpUpload);				
										}		
										echo '<th scope="col">'.$url.'</th>';
										echo '<th scope="col"> UPLOAD </th>';
									echo '</tr>';
									$flujosUpload[$j] = $name;
									$j=$j+2;
								}
							}
						}
					}
						
					if (file_exists("./tmp/scripts/daemon_reception_AireBox.bat")){
						$fp = file("./tmp/scripts/daemon_reception_AireBox.bat") or die("No se ha podido abrir el fichero");
						$cadena = "call";
						$cadena2 = "REM if";
						$flujosDownload = array();
						$k=0;
						$l=1;
						foreach($fp as $n=>$linea){						
							$valor=substr($linea,34,4);
							$valor2=substr($linea,0,6);
							if ($valor==$cadena){
								$name=substr($linea, 59);	
								$pos=strpos($linea,'.bat');
								$name=substr($name,0,($pos-59));
								//echo $linea.'<br>';
								echo '<tr align="left" valign="middle" style="color:#333333;background-color:#F7F6F3;">';
								echo '<th scope="col"> <input type="checkbox" name="'.$name.'" disabled="disabled" checked="checked"></th>';
									echo '<th scope="col">'.$name.'</th>';
									if(file_exists("./tmp/config/download.flx")){
										$fpUpload=fopen ("./tmp/config/download.flx", "r");
										$contenidoUpload = fread($fpUpload, filesize("./tmp/config/download.flx"));
										$arrUpload = explode("\n",$contenidoUpload );
										for($k=0;$k<sizeof($arrUpload);$k++){
											$fluxUpload=explode(",",$arrUpload[$k]);
											if ($name==$fluxUpload[0]){
												echo '<th scope="col">'.$fluxUpload[1].'</th>';
												echo '<th scope="col">'.$fluxUpload[2].'</th>';
												echo '<th scope="col">'.$fluxUpload[3].'</th>';
											}										
										}
										fclose($fpUpload);				
									}		
									echo '<th scope="col">'.$url.'</th>';
									echo '<th scope="col"> DOWNLOAD </th>';
								echo '</tr>';
								$flujosDownload[$k] = $name;
								$k=$k+2;
							}else{
								if ($valor2==$cadena2){
									$name=substr($linea, 59);
									$pos=strpos($linea,'.bat');
									$name=substr($name,0,($pos-59));
									//echo $linea.'<br>';
									echo '<tr align="left" valign="middle" style="color:#333333;background-color:#F7F6F3;">';
									echo '<th scope="col"> <input type="checkbox" name="'.$name.'" disabled="disabled"></th>';
										echo '<th scope="col">'.$name.'</th>';
										if(file_exists("./tmp/config/download.flx")){
											$fpUpload=fopen ("./tmp/config/download.flx", "r");
											$contenidoUpload = fread($fpUpload, filesize("./tmp/config/download.flx"));
											$arrUpload = explode("\n",$contenidoUpload );
											for($k=0;$k<sizeof($arrUpload);$k++){
												$fluxUpload=explode(",",$arrUpload[$k]);
												if ($name==$fluxUpload[0]){
													echo '<th scope="col">'.$fluxUpload[1].'</th>';
													echo '<th scope="col">'.$fluxUpload[2].'</th>';
													echo '<th scope="col">'.$fluxUpload[3].'</th>';
												}										
											}
											fclose($fpUpload);				
										}		
										echo '<th scope="col">'.$url.'</th>';
										echo '<th scope="col"> DOWNLOAD </th>';
									echo '</tr>';
									$flujosDownload[$l] = $name;
									$l=$l+2;
								}
							}
						}
					}
					
					
					if(file_exists("./tmp/config/transfer.flx")){
						$fpTransfer=fopen ("./tmp/config/transfer.flx", "r");
						$contenidoTransfer = fread($fpTransfer, filesize("./tmp/config/transfer.flx"));
						$arrTransfer = explode("\n",$contenidoTransfer );
						echo '<tr><th></th><th></th><th></th><th></th><th></th><th></th> </tr>';
						echo '<tr align="left" valign="middle" style="color:#333333;background-color:#F7F6F3;">';
						for($k=0;$k<sizeof($arrTransfer);$k++){
							$fluxTransfer=explode(",",$arrTransfer[$k]);
							echo '<tr align="left" valign="middle" style="color:#333333;background-color:#F7F6F3;">';	
							echo '<th scope="col"> EXTERNAL </th>';								
							echo '<th scope="col">'.trim($fluxTransfer[1]).'</th>';
							echo '<th scope="col">'.trim($fluxTransfer[2]).'</th>';
							echo '<th scope="col">'.trim($fluxTransfer[3]).'</th>';
							echo '<th scope="col">'.trim($fluxTransfer[4]).'</th>';
							echo '<th scope="col">'.trim($fluxTransfer[5]).'://'.trim($fluxTransfer[6]).':'.trim($fluxTransfer[7]).'</th>';
							if (trim($fluxTransfer[0])=='U'){
								echo '<th scope="col"> UPLOAD</th>';
							}else{
								echo '<th scope="col"> DOWNLOAD</th>';
							}
							
							echo '</tr>';
						}							
						fclose($fpTransfer);							
					}
					
									
					rrmdir("./tmp");					
				
									
					$fileversion= "./".$pais."/".$marca."/Windows/".$conexion."/version.txt";										
					
					if (!file_exists($fileversion)) {
						echo '<li>No existen archivo de version disponible</li>';
					}else{
						$file = file($fileversion) or exit("Error abriendo fichero!");
						echo '<tr><th><th><th><th><th><th><th><th></tr>';
						echo '<tr>';
							echo '<td colspan="2"><li style="color:#333333;font-size:10pt;border-collapse:collapse">Versión de archivo de flujos: <b>'.$file[0].'</b></li></td>';
						echo '</tr>';	
						echo '<tr><th><th><th><th><th><th><th><th></tr>';
					}
						?>
							<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
								<th scope="col" align="left"><form name="FormEdit" action="saveflux.php" method="post">
									<input type="hidden" name="pais" value="<?php echo $_POST['pais']; ?>"></input>
									<input type="hidden" name="marca" value="<?php echo $_POST['marca']; ?>"></input>
									<input type="hidden" name="conexion" value="<?php echo $_POST['conexion']; ?>"></input>
									<input type="hidden" name="version" value="<?php if (!$file[0]){echo '2.8.0.0';}else{echo $file[0];} ?>"></input>
									<?php									
									foreach($flujosUpload as $key=>$value){ 
										if (is_array($value)){  
											//si es un array sigo recorriendo
											recorro($value);
										}else{  
											//si es un elemento lo muestro
											echo '<input type="hidden" name="fluxUpload'.$key.'" value="'.$value.'"></input>';
										}
									}
									foreach($flujosDownload as $key=>$value){ 
										if (is_array($value)){  
											//si es un array sigo recorriendo
											recorro($value);
										}else{  
											//si es un elemento lo muestro
											echo '<input type="hidden" name="fluxDownload'.$key.'" value="'.$value.'"></input>';
										}
									}
									echo '<input type="hidden" name="totalUpload" value="'.count($flujosUpload).'"></input>';
									echo '<input type="hidden" name="totalDownload" value="'.count($flujosDownload).'"></input>';
									//rrmdir("./tmp");
									?>
									<input name="editar" id="editar" type="submit" value="Modificar Flujos"></input>
								</form></th>
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col" align="right"><form name="SaveFlux" action="newflux.php" method="post">
									<input type="hidden" name="pais" value="<?php echo $_POST['pais']; ?>"></input>
									<input type="hidden" name="marca" value="<?php echo $_POST['marca']; ?>"></input>
									<input type="hidden" name="conexion" value="<?php echo $_POST['conexion']; ?>"></input>
									<input type="hidden" name="version" value="<?php if (!$file[0]){echo '2.8.0.0';}else{echo $file[0];} ?>"></input>							
									<input name="nuevo" id="nuevo" type="submit" value="Nuevo Flujo"></input>						
								</form></th>
								<th scope="col" align="right"><form name="SaveFluxExt" action="newfluxEXT.php" method="post">
									<input type="hidden" name="pais" value="<?php echo $_POST['pais']; ?>"></input>
									<input type="hidden" name="marca" value="<?php echo $_POST['marca']; ?>"></input>
									<input type="hidden" name="conexion" value="<?php echo $_POST['conexion']; ?>"></input>
									<input type="hidden" name="version" value="<?php if (!$file[0]){echo '2.8.0.0';}else{echo $file[0];} ?>"></input>							
									<input name="nuevoExt" id="nuevoExt" type="submit" value="Nuevo Flujo Externo"></input>						
								</form></th>
								
							</tr>
							<?php
						echo '</table>';
				}
				echo '<br><br>';

			  }
		   }
		   
		   if(count($errors) > 0){
			  echo '<div class="errors"><ul>';
			  foreach($errors as $error) {
				echo '<li>'.$error.'</li>';   
			  }
			  echo '</ul></div>';
		   }
		?>
		
	 </BODY>
 </HTML>