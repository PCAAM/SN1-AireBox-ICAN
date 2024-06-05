<HTML>
<HEAD><link rel="shortcut icon" href="favicon.ico" />
<TITLE>Flujos AireBox - ICAN</TITLE>
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

		  $errors = array();
		    if(isset($_POST['nuevo']) && !isset($_POST['crear'])){				
				?>
				<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse"><u>Creación de Nuevo Flujo de datos en:</u></p>
				<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse"><?php echo $_POST['pais'].' - '.$_POST['marca'].' - '.$_POST['conexion']; ?></p>
				<form name="FormNewFlux" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<table cellspacing="0" cellpadding="4" align="Left" border="0" id="GridView" style="color:#333333;font-size:9pt;width:500px;border-collapse:collapse;vertical-align: middle">
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Nombre CIBLE del fichero:</th><th scope="col" align="left"><input type="text" name="nombrecible" size="40"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Nombre de fichero en DMS:</th><th scope="col" align="left"><input type="text" name="nombredms" size="40"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Nombre de fichero en sFTP:</th><th scope="col" align="left"><input type="text" name="nombresftp" size="40"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Directorio principal de flujo:</th><th scope="col" align="left"><input type="text" name="dirflux" size="40"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">SubDirectorio de flujo:</th><th scope="col" align="left"><input type="text" name="subdirflux" size="40"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Servidor sFTP:</th><th scope="col" align="left"><input type="text" name="urlsftp" size="40"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Upload/Download:</th><th scope="col" align="left"><select name="transmision">
																										  <option selected></option>
																										  <option value="UPLOAD">Upload</option>
																										  <option value="DOWNLOAD">Download</option>
																										</select></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Tramo Horario:</th><th scope="col" align="left"><input type="text" name="horainicio" size="4" value="03"> - <input type="text" name="horafin" size="4" value="05"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Conversión Dos2Unix:</th><th scope="col" align="left"><input type="radio" name="format" value="dos2unix"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Conversión Unix2Dos:</th><th scope="col" align="left"><input type="radio" name="format" value="unix2dos"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Eliminar si vacío:</th><th scope="col" align="left"><input type="checkbox" name="deletefile"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Duplicar:</th><th scope="col" align="left"><input type="text" name="duplicar" size="40"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Ajuste de línea:</th><th scope="col" align="left"><input type="text" name="ajuste" size="20"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Agreg. Encabezado:</th><th scope="col" align="left"><input type="checkbox" name="encabezado"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left">Realizar UNZIP:</th><th scope="col" align="left"><input type="checkbox" name="unzip"></th>
					</tr>					
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left"></th><th scope="col" align="left"></th>
					</tr>
					<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
						<th scope="col" align="left"></th><th scope="col" align="right"><input name="crear" id="crear" type="submit" value="Crear flujo"></input></th>
					</tr>
						<input type="hidden" name="pais" value="<?php echo $_POST['pais']; ?>"></input>
						<input type="hidden" name="marca" value="<?php echo $_POST['marca']; ?>"></input>
						<input type="hidden" name="version" value="<?php echo $_POST['version']; ?>"></input>	
						<input type="hidden" name="conexion" value="<?php echo $_POST['conexion']; ?>"></input>						
					</tr>
				</table>
				</form>
				<?php
		    }elseif(!isset($_POST['nuevo']) && isset($_POST['crear']) && isset($_POST['nombrecible'])){
				?>
				<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Creando la estructura para el nuevo flujo ...</p>
				<?php
				$nombrecible=$_POST['nombrecible'];
				$nombredms=$_POST['nombredms'];
				$nombresftp=$_POST['nombresftp'];
				$dirflux=$_POST['dirflux'];
				$subdirflux=$_POST['subdirflux'];
				$urlsftp=$_POST['urlsftp'];
				$transmision=$_POST['transmision'];
				$horainicio=$_POST['horainicio'];
				$horafin=$_POST['horafin'];
				$format=$_POST['format'];				
				$deletefile=$_POST['deletefile'];
				$duplicar=$_POST['duplicar'];
				$ajuste=$_POST['ajuste'];
				$encabezado=$_POST['encabezado'];
				$unzip=$_POST['unzip'];
				//Obtener version de archivo de flujos, pais y marca
				$marca=$_POST['marca'];
				$pais=$_POST['pais'];
				$version_old=$_POST['version'];	
				$conexion=$_POST['conexion'];

				if (!$horainicio){
					$horainicio='03';
				}
				if (!$horafin){
					$horafin='05';
				}				
				if ($format=='dos2unix'){
					$dos2unix='1';
					$unix2dos='0';
				}else if($format=='unix2dos'){
					$dos2unix='0';
					$unix2dos='1';
				}else{
					$dos2unix='0';
					$unix2dos='0';
				}
				if ($deletefile=='on'){
					$deletefile='1';
				}else{
					$deletefile='0';
				}
				if ($encabezado=='on'){
					$encabezado='1';
				}else{
					$encabezado='0';
				}
				if ($unzip=='on'){
					$unzip='1';
				}else{
					$unzip='0';
				}
				
				if ($format=='dos2unix' || $format=='unix2dos' || $deletefile=='1' || (strcasecmp( $duplicar, '' ) <> 0) || $encabezado=='1' || (strcasecmp( $ajuste, '' ) <> 0) || $unzip=='1'){
					$fluxextendido='true';	
					if ($duplicar==''){$duplicar='0';}	
					if ($ajuste==''){$ajuste='0';}				
				}else{
					$fluxextendido='false';
				}
				
				if (!$nombrecible || !$nombredms || !$nombresftp || !$transmision || !$conexion){
					echo 'No se puede generar el nuevo flujo debido a falta de información requerida';
					exit;
				}else{
								
					switch($transmision){
						case "UPLOAD":							
							?><p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Creando fichero de version ...</p><?php				
							//Modificacion de version.txt (en pais y distribucion)							
							$verfin=explode(".",$version_old);
							$num=$verfin[3];
							$num+=1;							
							$verfin[3]=$num;
							$version_new=implode(".",$verfin);

							//guardado para distribuciones
							?><p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Guardando el fichero de version para las distribuciones...</p><?php
							$fp = fopen("./".$pais."/".$marca."/Windows/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/Linux-x86/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/Linux-x86_64/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/Solaris-x86/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/FreeBSD-x86/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							
							$ruta=$_SERVER['DOCUMENT_ROOT'];
							
							
							////////////////WINDOWS//////////////////
							
							
							$fichero=$ruta."/ICAN/".$pais."/".$marca."/Windows/".$conexion."/".$version_old.".zip";
							if (file_exists($fichero)){
								//Abrimos archivo.zip para leer purga
								 $zip = new ZipArchive;
								 $res = $zip->open($fichero);
								 if ($res === TRUE) {
									 $zip->extractTo('./');
									 $zip->close();
									 echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Extrayendo informacion...</p>';
								 } else {
									 echo 'Informacion NO extraida<br>';
									 exit;
								 }
							}else{
								echo "No existe archivo ".$fichero;
								exit;
							}
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Creando archivo purga...</p>';
								 
							//Windows - Modificacion de purga
							if (file_exists("scripts/purga.bat")){							
								$fp = fopen("scripts/purga.bat","r") or die("No se ha podido abrir el fichero");
								$ff = fopen("scripts/purga_new.bat","wb") or die("No se ha podido abrir el fichero");
								$cadena = "rmdir";		
								while(!feof($fp)){
									$linea=fgets($fp);
									$valor=substr($linea,0,5);
									if ($valor==$cadena){
										fwrite($ff,'robocopy "%PATH_AIREBOX%\backup_DCS" c:\backup_borrar\ /MOV /MINAGE:61 /R:10 *'.$nombredms.'.*	>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"'.PHP_EOL);
										fwrite($ff,PHP_EOL);
										fwrite($ff,$linea);
									}else{
										fwrite($ff,$linea);
									}
								}
								fclose($fp);
								fclose($ff);
								
								$template_version=implode("",file("scripts/purga_new.bat"));
								$template_version=str_replace($version_old,$version_new,$template_version);
								$template_version=str_replace("2.8.1.1",$version_new,$template_version);
								$file_version = fopen("scripts/purga_new.bat","w");
								fwrite($file_version,$template_version);
								fclose($file_version);
								
								unlink("scripts/purga.bat");
								rename("scripts/purga_new.bat","scripts/purga.bat");
							}							
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Creando archivos de script...</p>';
							
							//Windows - Modificacion de daemon_send_AireBox y creacion de script
							if (file_exists("scripts/daemon_send_AireBox.bat")){	
								$fp = fopen("scripts/daemon_send_AireBox.bat","ab") or die("No se ha podido abrir el fichero");								
								fwrite($fp,"\n".'if %hour% GEQ 03 if %hour% LEQ 05 call %RUTA%\scripts\sftp_'.$nombrecible.'.bat');							
								fclose($fp);
								
								$template_version=implode("",file("scripts/daemon_send_AireBox.bat"));
								$template_version=str_replace($version_old,$version_new,$template_version);
								$template_version=str_replace("2.8.1.1",$version_new,$template_version);
								$file_version = fopen("scripts/daemon_send_AireBox.bat","w");
								fwrite($file_version,$template_version);
								fclose($file_version);
								
								$template_sftp=implode("",file("Templates/NUEVO_ENVIO.bat"));
								$template_sftp=str_replace("VERSION",$version_new,$template_sftp);
								$template_sftp=str_replace("FECHA",date("d-m-y"),$template_sftp);
								$template_sftp=str_replace("NOMBRE_CIBLE",$nombrecible,$template_sftp);
								$template_sftp=str_replace("NOMBRE_SFTP",$nombresftp,$template_sftp);
								$template_sftp=str_replace("NOMBRE_DMS",$nombredms,$template_sftp);
								$template_sftp=str_replace("NOMBRE_URL",$urlsftp,$template_sftp);								
								
								$file = fopen("scripts/sftp_".$nombrecible.".bat","w");
								fwrite($file,$template_sftp);
								fclose($file);
							}		

							//Windows - Modificacion de flujos en upload.flx
							if (file_exists("config/upload.flx")){
								$fp = fopen("config/upload.flx","ab") or die("No se ha podido abrir el fichero");
								if (filesize("config/upload.flx")>0){
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}										
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms);
										}										
									}									
								}else{
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms);
										}	
									}										
								}								
								fclose($fp);
							}							
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Creando archivo ZIP y checksum...</p>';
							
							//Windows - Creacion de ZIP
							if ($zip->open($version_new.".zip", ZIPARCHIVE::CREATE )!==TRUE) {
								exit("No se pudo abrir el archivo\n");
							}
							$directory = "scripts/";
							$files = glob($directory . "*.bat");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}
							
							$directory = "config/";
							$files = glob($directory . "*.flx");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}
							
							$zip->close();	
							
							//Windows - Modificacion de checksum.txt
							$file=$version_new.".zip";
							$fp = fopen("checksum.txt","w") or die("No se ha podido abrir el fichero");								
								fwrite($fp,md5_file($file));							
							fclose($fp);
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Moviendo ficheros y realizando limpieza...</p>';
							
							//Mover archivos y hacer limpieza
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Windows/'.$conexion."/".$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Windows/'.$conexion.'/checksum.txt');
							rrmdir("./scripts");
							rrmdir("./bin");
							rrmdir("./languages");
							rrmdir("./config");
							unlink($version_new.'.zip');
							unlink('checksum.txt');						
							
							
							////////////////UNIX//////////////////
							

							$fichero=$ruta."/ICAN/".$pais."/".$marca."/Linux-x86/".$conexion."/".$version_old.".zip";
							if (file_exists($fichero)){
								//Abrimos archivo.zip para leer purga
								 $zip = new ZipArchive;
								 $res = $zip->open($fichero);
								 if ($res === TRUE) {
									 $zip->extractTo('./');
									 $zip->close();
									 echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Extrayendo informacion...</p>';
								 } else {
									 echo 'Informacion NO extraida<br>';
									 exit;
								 }
							}else{
								echo "No existe archivo ".$fichero;
								exit;
							}
								 
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">UNIX - Creando archivo purga...</p>';
								
							
							//Unix - Modificacion de purga	
							if (file_exists("scripts/purga.sh")){
								$fp = fopen("scripts/purga.sh","ab") or die("No se ha podido abrir el fichero");								
								fwrite($fp,"\n".'echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'echo "*** Archivos a eliminar en ""$PATH_AIREBOX""/backup_DCS/'.$nombredms.'(+61 dias): "  	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'find ""$PATH_AIREBOX""/backup_DCS/*'.$nombredms.'* -mtime +61					>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'find ""$PATH_AIREBOX""/backup_DCS/*'.$nombredms.'* -mtime +61 -exec rm -rf {} \;		>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fclose($fp);
							}
							
							$template_version=implode("",file("scripts/purga.sh"));
							$template_version=str_replace($version_old,$version_new,$template_version);
							$template_version=str_replace("2.8.1.1",$version_new,$template_version);
							$file_version = fopen("scripts/purga.sh","w");
							fwrite($file_version,$template_version);
							fclose($file_version);
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">UNIX - Creando archivos de script...</p>';
							
							//Unix - Creacion de daemon_send_AireBox y creacion de script
							
							if (file_exists("scripts/daemon_send_AireBox.sh")){
								$fp = fopen("scripts/daemon_send_AireBox.sh","ab") or die("No se ha podido abrir el fichero");								
								fwrite($fp,"\n".'		if [ $HOUR -ge 03 -a $HOUR -le 05 ] ; then sh ""$PATH_AIREBOX""/Suite_DCS/scripts/sftp_'.$nombrecible.'.sh; fi');							
								fclose($fp);
								
								$template_version=implode("",file("scripts/daemon_send_AireBox.sh"));
								$template_version=str_replace($version_old,$version_new,$template_version);
								$template_version=str_replace("2.8.1.1",$version_new,$template_version);
								$file_version = fopen("scripts/daemon_send_AireBox.sh","w");
								fwrite($file_version,$template_version);
								fclose($file_version);
								
								$template_sftp=implode("",file("Templates/NUEVO_ENVIO.sh"));
								$template_sftp=str_replace("VERSION",$version_new,$template_sftp);
								$template_sftp=str_replace("FECHA",date("d-m-y"),$template_sftp);
								$template_sftp=str_replace("NOMBRE_CIBLE",$nombrecible,$template_sftp);
								$template_sftp=str_replace("NOMBRE_SFTP",$nombresftp,$template_sftp);
								$template_sftp=str_replace("NOMBRE_DMS",$nombredms,$template_sftp);
								$template_sftp=str_replace("NOMBRE_URL",$urlsftp,$template_sftp);
								
								$file = fopen("scripts/sftp_".$nombrecible.".sh","w");
								fwrite($file,$template_sftp);
								fclose($file);
															
							}

							//Unix - Modificacion de flujos en upload.flx
							if (file_exists("config/upload.flx")){
								$fp = fopen("config/upload.flx","ab") or die("No se ha podido abrir el fichero");
								if (filesize("config/upload.flx")>0){
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms);
										}										
									}									
								}else{
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}										
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms);
										}										
									}										
								}								
								fclose($fp);
							}								

							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">UNIX - Creando archivo ZIP y checksum...</p>';
							
							//Unix - Creacion de Zip
							if ($zip->open($version_new.".zip", ZIPARCHIVE::CREATE )!==TRUE) {
								exit("No se pudo abrir el archivo\n");
							}
							$directory = "scripts/";
							$files = glob($directory . "*.sh");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}
							
							$directory = "config/";
							$files = glob($directory . "*.flx");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}
							
							$zip->close();		

							echo 'UNIX - Moviendo ficheros y realizando limpieza...<br><br>';
							
							//Unix - Modificacion de checksum.txt	
							$file=$version_new.".zip";
							$fp = fopen("checksum.txt","w") or die("No se ha podido abrir el fichero");								
								fwrite($fp,md5_file($file));							
							fclose($fp);
							
							//Mover archivos y hacer limpieza
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Linux-x86/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Linux-x86/'.$conexion.'/checksum.txt');
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Linux-x86_64/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Linux-x86_64/'.$conexion.'/checksum.txt');
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Solaris-x86/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Solaris-x86/'.$conexion.'/checksum.txt');
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/FreeBSD-x86/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/FreeBSD-x86/'.$conexion.'/checksum.txt');
							rrmdir("./scripts");
							rrmdir("./bin");
							rrmdir("./languages");
							rrmdir("./config");
							unlink($version_new.'.zip');
							unlink('checksum.txt');	
							
							
							
							//Agregar a historial.txt el nuevo flujo y la version que lo modifica (en pais)
							?><p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Guardando el fichero de historial ...</p><?php
							$fecha = time ();
							$fechamod=date("Y/m/d G:i:s", $fecha );
							$fp = fopen("./".$pais."/".$marca."/historial.txt","ab") or die("No se ha podido abrir el fichero");
							fwrite($fp,"\n".$nombrecible." - ".$version_new." - ".$fechamod);
							fclose($fp);
							
							?>
							<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">... Flujo creado correctamente</p>

							<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col" align="right"><form name="FormNew" action="index.php" method="post">
									<input type="hidden" name="pais" value="<?php echo $_POST['pais']; ?>"></input>
									<input type="hidden" name="marca" value="<?php echo $_POST['marca']; ?>"></input>
									<input type="hidden" name="conexion" value="<?php echo $_POST['conexion']; ?>"></input>	
									<input type="hidden" name="enviar" value="<?php echo 'Consultar Flujos' ?>"></input>									
									<input name="nuevo" id="nuevo" type="submit" value="Volver a Flujos"></input>						
								</form></th>
								
							</tr>
							<?php
							exit;
							break;
							
						case "DOWNLOAD":
							?><p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Creando fichero de version ...</p><?php				
							//Modificacion de version.txt (en pais y distribucion)							
							$verfin=explode(".",$version_old);
							$num=$verfin[3];
							$num+=1;							
							$verfin[3]=$num;
							$version_new=implode(".",$verfin);

							//guardado para distribuciones
							?><p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Guardando el fichero de version para las distribuciones...</p><?php
							$fp = fopen("./".$pais."/".$marca."/Windows/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/Linux-x86/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/Linux-x86_64/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/Solaris-x86/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							$fp = fopen("./".$pais."/".$marca."/FreeBSD-x86/".$conexion."/version.txt","w") or die("No se ha podido abrir el fichero");
							fwrite($fp, $version_new);
							fclose($fp);
							
							$ruta=$_SERVER['DOCUMENT_ROOT'];
							
							////////////////WINDOWS//////////////////
							
							
							$fichero=$ruta."/ICAN/".$pais."/".$marca."/Windows/".$conexion."/".$version_old.".zip";
							if (file_exists($fichero)){
								//Abrimos archivo.zip para leer purga
								 $zip = new ZipArchive;
								 $res = $zip->open($fichero);
								 if ($res === TRUE) {
									 $zip->extractTo('./');
									 $zip->close();
									 echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Extrayendo informacion...</p>';
								 } else {
									 echo 'Informacion NO extraida<br>';
									 exit;
								 }
							}else{
								echo "No existe archivo ".$fichero;
								exit;
							}
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Creando archivo purga...</p>';	
								 
							//Windows - Modificacion de purga
							if (file_exists("scripts/purga.bat")){							
								$fp = fopen("scripts/purga.bat","r") or die("No se ha podido abrir el fichero");
								$ff = fopen("scripts/purga_new.bat","wb") or die("No se ha podido abrir el fichero");
								$cadena = "rmdir";		
								while(!feof($fp)){
									$linea=fgets($fp);
									$valor=substr($linea,0,5);
									if ($valor==$cadena){
										fwrite($ff,'robocopy "%PATH_AIREBOX%\backup_DCS" c:\backup_borrar\ /MOV /MINAGE:61 /R:10 *'.$nombredms.'.*	>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"'.PHP_EOL);
										fwrite($ff,PHP_EOL);
										fwrite($ff,$linea);
									}else{
										fwrite($ff,$linea);
									}
								}
								fclose($fp);
								fclose($ff);
								
								$template_version=implode("",file("scripts/purga_new.bat"));
								$template_version=str_replace($version_old,$version_new,$template_version);
								$template_version=str_replace("2.8.1.1",$version_new,$template_version);
								$file_version = fopen("scripts/purga_new.bat","w");
								fwrite($file_version,$template_version);
								fclose($file_version);
								
								unlink("scripts/purga.bat");
								rename("scripts/purga_new.bat","scripts/purga.bat");
							}							
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Creando archivos de script...</p>';
							
							//Windows - Modificacion de daemon_reception_AireBox y creacion de script
							if (file_exists("scripts/daemon_reception_AireBox.bat")){	
								$fp = fopen("scripts/daemon_reception_AireBox.bat","ab") or die("No se ha podido abrir el fichero");
								fwrite($fp,"\n".'if %HOUR% GEQ '.$horainicio.' if %HOUR% LEQ '.$horafin.' call %RUTA%\scripts\sftp_'.$nombrecible.'.bat');							
								fclose($fp);
								
								$template_version=implode("",file("scripts/daemon_reception_AireBox.bat"));
								$template_version=str_replace($version_old,$version_new,$template_version);
								$template_version=str_replace("2.8.1.1",$version_new,$template_version);
								$file_version = fopen("scripts/daemon_reception_AireBox.bat","w");
								fwrite($file_version,$template_version);
								fclose($file_version);
								
								$template_sftp=implode("",file("Templates/NUEVA_RECEPCION.bat"));
								$template_sftp=str_replace("VERSION",$version_new,$template_sftp);
								$template_sftp=str_replace("FECHA",date("d-m-y"),$template_sftp);
								$template_sftp=str_replace("NOMBRE_CIBLE",$nombrecible,$template_sftp);
								$template_sftp=str_replace("NOMBRE_SFTP",$nombresftp,$template_sftp);
								$template_sftp=str_replace("NOMBRE_DMS",$nombredms,$template_sftp);
								$template_sftp=str_replace("NOMBRE_URL",$urlsftp,$template_sftp);
								
								$file = fopen("scripts/sftp_".$nombrecible.".bat","w");
								fwrite($file,$template_sftp);
								fclose($file);
							}

							//Windows - Modificacion de flujos en download.flx
							if (file_exists("config/download.flx")){
								$fp = fopen("config/download.flx","ab") or die("No se ha podido abrir el fichero");
								if (filesize("config/download.flx")>0){
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}										
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms);
										}										
									}									
								}else{
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms);
										}	
									}												
								}									
								fclose($fp);
							}
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Creando archivo ZIP y checksum...</p>';
							
							//Windows - Creacion de ZIP
							if ($zip->open($version_new.".zip", ZIPARCHIVE::CREATE )!==TRUE) {
								exit("No se pudo abrir el archivo\n");
							}
							$directory = "scripts/";
							$files = glob($directory . "*.bat");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}
							
							$directory = "config/";
							$files = glob($directory . "*.flx");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}
							
							$zip->close();	
							
							//Windows - Modificacion de checksum.txt
							$file=$version_new.".zip";
							$fp = fopen("checksum.txt","w") or die("No se ha podido abrir el fichero");								
								fwrite($fp,md5_file($file));							
							fclose($fp);
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">WINDOWS - Moviendo ficheros y realizando limpieza...</p>';
							
							//Mover archivos y hacer limpieza
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Windows/'.$conexion."/".$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Windows/'.$conexion.'/checksum.txt');
							rrmdir("./scripts");
							rrmdir("./bin");
							rrmdir("./languages");
							rrmdir("./config");
							unlink($version_new.'.zip');
							unlink('checksum.txt');						
							
							
							////////////////UNIX//////////////////
							

							$fichero=$ruta."/ICAN/".$pais."/".$marca."/Linux-x86/".$conexion."/".$version_old.".zip";
							if (file_exists($fichero)){
								//Abrimos archivo.zip para leer purga
								 $zip = new ZipArchive;
								 $res = $zip->open($fichero);
								 if ($res === TRUE) {
									 $zip->extractTo('./');
									 $zip->close();
									 echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Extrayendo informacion...</p>';
								 } else {
									 echo 'Informacion NO extraida<br>';
									 exit;
								 }
							}else{
								echo "No existe archivo ".$fichero;
								exit;
							}
								 
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">UNIX - Creando archivo purga...</p>';
								
							
							//Unix - Modificacion de purga	
							if (file_exists("scripts/purga.sh")){
								$fp = fopen("scripts/purga.sh","ab") or die("No se ha podido abrir el fichero");								
								fwrite($fp,"\n".'echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'echo "*** Archivos a eliminar en ""$PATH_AIREBOX""/backup_DCS/'.$nombredms.'(+61 dias): "  	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'find ""$PATH_AIREBOX""/backup_DCS/*'.$nombredms.'* -mtime +61					>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fwrite($fp,"\n".'find ""$PATH_AIREBOX""/backup_DCS/*'.$nombredms.'* -mtime +61 -exec rm -rf {} \;		>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1');
								fclose($fp);
							}	
							$template_version=implode("",file("scripts/purga.sh"));
							$template_version=str_replace($version_old,$version_new,$template_version);
							$template_version=str_replace("2.8.1.1",$version_new,$template_version);
							$file_version = fopen("scripts/purga.sh","w");
							fwrite($file_version,$template_version);
							fclose($file_version);
							
							
							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">UNIX - Creando archivos de script...</p>';
							
							//Unix - Creacion de daemon_reception_AireBox y creacion de script
							
							if (file_exists("scripts/daemon_reception_AireBox.sh")){
								$fp = fopen("scripts/daemon_reception_AireBox.sh","ab") or die("No se ha podido abrir el fichero");	
								fwrite($fp,"\n".'	if [ $HOUR -ge '.$horainicio.' -a $HOUR -le '.$horafin.' ] ; then sh ""$PATH_AIREBOX""/Suite_DCS/scripts/sftp_'.$nombrecible.'.sh; fi');															
								fclose($fp);
								
								$template_version=implode("",file("scripts/daemon_reception_AireBox.sh"));
								$template_version=str_replace($version_old,$version_new,$template_version);
								$template_version=str_replace("2.8.1.1",$version_new,$template_version);
								$file_version = fopen("scripts/daemon_reception_AireBox.sh","w");
								fwrite($file_version,$template_version);
								fclose($file_version);
								
								$template_sftp=implode("",file("Templates/NUEVA_RECEPCION.sh"));
								$template_sftp=str_replace("VERSION",$version_new,$template_sftp);
								$template_sftp=str_replace("FECHA",date("d-m-y"),$template_sftp);
								$template_sftp=str_replace("NOMBRE_CIBLE",$nombrecible,$template_sftp);
								$template_sftp=str_replace("NOMBRE_SFTP",$nombresftp,$template_sftp);
								$template_sftp=str_replace("NOMBRE_DMS",$nombredms,$template_sftp);
								$template_sftp=str_replace("NOMBRE_URL",$urlsftp,$template_sftp);
								
								$file = fopen("scripts/sftp_".$nombrecible.".sh","w");
								fwrite($file,$template_sftp);
								fclose($file);
															
							}	
							
							//Linux - Modificacion de flujos en download.flx
							if (file_exists("config/download.flx")){
								$fp = fopen("config/download.flx","ab") or die("No se ha podido abrir el fichero");
								if (filesize("config/download.flx")>0){
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}										
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,"\n".$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,"\n".$nombrecible.', '.$nombredms);
										}										
									}									
								}else{
									if(!empty($dirflux) && !empty($subdirflux)){
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux.', '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms.', '.$dirflux.', '.$subdirflux);
										}
									}else{
										if ($fluxextendido=='true'){
											fwrite($fp,$nombrecible.', '.$nombredms.', , , '.$dos2unix.', '.$unix2dos.', '.$deletefile.', '.$duplicar.', '.$encabezado.', '.$ajuste.', '.$unzip);
										}else{
											fwrite($fp,$nombrecible.', '.$nombredms);
										}	
									}													
								}								
								fclose($fp);
							}

							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">UNIX - Creando archivo ZIP y checksum...</p>';
							
							//Unix - Creacion de Zip
							if ($zip->open($version_new.".zip", ZIPARCHIVE::CREATE )!==TRUE) {
								exit("No se pudo abrir el archivo\n");
							}
							$directory = "scripts/";
							$files = glob($directory . "*.sh");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}
							
							$directory = "config/";
							$files = glob($directory . "*.flx");
							foreach($files as $file)
							{
								$zip->addFile($file);
							}							
							
							$zip->close();	

							echo '<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">UNIX - Moviendo ficheros y realizando limpieza...</p>';
							
							//Unix - Modificacion de checksum.txt	
							$file=$version_new.".zip";
							$fp = fopen("checksum.txt","w") or die("No se ha podido abrir el fichero");								
								fwrite($fp,md5_file($file));							
							fclose($fp);
							
							//Mover archivos y hacer limpieza
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Linux-x86/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Linux-x86/'.$conexion.'/checksum.txt');
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Linux-x86_64/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Linux-x86_64/'.$conexion.'/checksum.txt');
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/Solaris-x86/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/Solaris-x86/'.$conexion.'/checksum.txt');
							copy($version_new.'.zip','./'.$pais.'/'.$marca.'/FreeBSD-x86/'.$conexion.'/'.$version_new.'.zip');
							copy('checksum.txt','./'.$pais.'/'.$marca.'/FreeBSD-x86/'.$conexion.'/checksum.txt');
							rrmdir("./scripts");
							rrmdir("./bin");
							rrmdir("./languages");
							rrmdir("./config");
							unlink($version_new.'.zip');
							unlink('checksum.txt');	
							
							
							
							//Agregar a historial.txt el nuevo flujo y la version que lo modifica (en pais)
							?><p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">Guardando el fichero de historial ...</p><?php
							$fecha = time ();
							$fechamod=date("Y/m/d G:i:s", $fecha );
							$fp = fopen("./".$pais."/".$marca."/historial.txt","ab") or die("No se ha podido abrir el fichero");
							fwrite($fp,"\n".$nombrecible." - ".$version_new." - ".$conexion." - ".$fechamod);
							fclose($fp);
							
							?>
							<p style="color:#333333;font-size:12pt;width:416px;border-collapse:collapse">... Flujo creado correctamente</p>

							<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
								<th scope="col"></th>
								<th scope="col"></th>
								<th scope="col" align="right"><form name="FormNew" action="index.php" method="post">
									<input type="hidden" name="pais" value="<?php echo $_POST['pais']; ?>"></input>
									<input type="hidden" name="marca" value="<?php echo $_POST['marca']; ?>"></input>
									<input type="hidden" name="conexion" value="<?php echo $_POST['conexion']; ?>"></input>	
									<input type="hidden" name="enviar" value="<?php echo 'Consultar Flujos' ?>"></input>									
									<input name="nuevo" id="nuevo" type="submit" value="Volver a Flujos"></input>						
								</form></th>
								
							</tr>
							<?php
							exit;
							break;						
					}
				}			
			
			}
		?>
 
	</BODY>
 </HTML>