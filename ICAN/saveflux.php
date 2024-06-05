<HTML>
<HEAD><link rel="shortcut icon" href="favicon.ico" />
<TITLE>Editar Flujos AireBox - ICAN</TITLE>
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
	if(isset($_POST['editar'])){
		if(!strlen($_POST['pais']) > 0){
			echo "</BR>";
			$errors[] = 'No has introducido el pais';
		}

		if(!strlen($_POST['marca']) > 0){
			echo "</BR>";
			$errors[] = 'No has introducido la marca';
		}

		if(!strlen($_POST['conexion']) > 0){
			echo "</BR>";
			$errors[] = 'No has especificado el tipo de conexión';
		}
		if(!strlen($_POST['version']) > 0){
			echo "</BR>";
			$errors[] = 'No has especificado el tipo de conexión';
		}
		$pais=$_POST['pais'];
		$marca=$_POST['marca'];
		$conexion=$_POST['conexion'];
		$totalUpload=$_POST['totalUpload'];
		$totalDownload=$_POST['totalDownload'];
		$version=$_POST['version'];
		$controlUpload=0;
		$controlDownload=0;
		echo '<p style="color:White;background-color:#5D7B9D">Se realizarán los siguientes cambios en los flujos de: <b>'.$pais.'</b> ---- <b>'.$marca.' ---- '.$conexion.'</b></p>';
		echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
		echo '<div class="listado" align="center">';
			echo '<table cellspacing="0" cellpadding="4" align="Center" border="0" id="GridView" style="color:#333333;font-size:9pt;width:512px;border-collapse:collapse;vertical-align: middle">';
				echo '<tr scope="col"><p style="color:White;background-color:#5D7B9D;width:200px">UPLOAD ACTIVOS</p></tr>';				
					for($i = 0; $i < $totalUpload*2; $i++){
						if ($_POST['fluxUpload'.$i]==""){
						}else{
							echo '<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
							<th>Activo: </th><th><input type="checkbox" name="upload_'.$controlUpload.'" value="'.$_POST['fluxUpload'.$i].'" checked/>'.$_POST['fluxUpload'.$i].'
												 <input type="hidden" name="uploadValue_'.$controlUpload.'" value="'.$_POST['fluxUpload'.$i].'" /></th></tr>';		
							$controlUpload=$controlUpload+1;
						}						
						$i=$i+1;						
					}
			echo '</table>';
			echo '<table cellspacing="0" cellpadding="4" align="Center" border="0" id="GridView" style="color:#333333;font-size:9pt;width:512px;border-collapse:collapse;vertical-align: middle">';
				echo '<tr scope="col"><p style="color:White;background-color:#5D7B9D;width:200px">UPLOAD NO ACTIVOS</p></tr>';				
					for($i = 1; $i < $totalUpload*2; $i++){
						if ($_POST['fluxUpload'.$i]==""){
						}else{
							echo '<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
							<th>Desactivado: </th><th><input type="checkbox" name="upload_'.$controlUpload.'" value="'.$_POST['fluxUpload'.$i].'" />'.$_POST['fluxUpload'.$i].'
													  <input type="hidden" name="uploadValue_'.$controlUpload.'" value="'.$_POST['fluxUpload'.$i].'" /></th></tr>';	
							$controlUpload=$controlUpload+1;	
						}
						$i=$i+1;
					}
			echo '</table>';
			echo '<table cellspacing="0" cellpadding="4" align="Center" border="0" id="GridView" style="color:#333333;font-size:9pt;width:512px;border-collapse:collapse;vertical-align: middle">';
				echo '<tr scope="col"><p style="color:White;background-color:#5D7B9D;width:200px">DOWNLOAD ACTIVOS</p></tr>';				
					for($i = 0; $i < $totalDownload*2; $i++){
						if ($_POST['fluxDownload'.$i]==""){
						}else{
							echo '<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
							<th>Activo: </th><th><input type="checkbox" name="download_'.$controlDownload.'" value="'.$_POST['fluxDownload'.$i].'" checked/>'.$_POST['fluxDownload'.$i].'
												 <input type="hidden" name="downloadValue_'.$controlDownload.'" value="'.$_POST['fluxDownload'.$i].'" /></th></tr>';
							$controlDownload=$controlDownload+1;		
						}						
						$i=$i+1;
					}
			echo '</table>';
			echo '<table cellspacing="0" cellpadding="4" align="Center" border="0" id="GridView" style="color:#333333;font-size:9pt;width:512px;border-collapse:collapse;vertical-align: middle">';
				echo '<tr scope="col"><p style="color:White;background-color:#5D7B9D;width:200px">DOWNLOAD NO ACTIVOS</p></tr>';				
					for($i = 1; $i < $totalDownload*2; $i++){
						if ($_POST['fluxUpload'.$i]==""){
						}else{
							echo '<tr align="left" style="color:White;background-color:#5D7B9D;font-weight:bold;">
							<th>Desactivado: </th><th><input type="checkbox" name="download_'.$controlDownload.'" value="'.$_POST['fluxDownload'.$i].'" />'.$_POST['fluxDownload'.$i].'
													  <input type="hidden" name="downloadValue_'.$controlDownload.'" value="'.$_POST['fluxDownload'.$i].'" /></th></tr>';	
							$controlDownload=$controlDownload+1;	
						}
						$i=$i+1;
					}
			echo '</table>';			
		echo '</div>';
		echo '<input type="hidden" name="controlUpload" value="'.$controlUpload.'"></input>';
		echo '<input type="hidden" name="controlDownload" value="'.$controlDownload.'"></input>';
		echo '<input type="hidden" name="pais" value="'.$pais.'"></input>';
		echo '<input type="hidden" name="marca" value="'.$marca.'"></input>';
		echo '<input type="hidden" name="conexion" value="'.$conexion.'"></input>';
		echo '<input type="hidden" name="version" value="'.$version.'"></input>';
		echo '<p style="color:White;background-color:#5D7B9D"><input type="submit" name="editFlux" value="Realizar Cambios" /></p>';
		echo '</form>';
	}
	
	if(isset($_POST['editFlux'])){
		$totalUpload=$_POST['controlUpload'];
		$totalDownload=$_POST['controlDownload'];
		$pais=$_POST['pais'];
		$marca=$_POST['marca'];
		$conexion=$_POST['conexion'];
		$version_old=$_POST['version'];
		$ruta=$_SERVER['DOCUMENT_ROOT'];

		//1. Modificacion de version.txt (en pais y distribucion)							
		$verfin=explode(".",$version_old);
		$num=$verfin[3];
		$num+=1;							
		$verfin[3]=$num;
		$version=implode(".",$verfin);
		
		if (!is_dir($ruta."/ICAN/temp")) {
			mkdir($ruta."/ICAN/temp");
		}
		if (!is_dir($ruta."/ICAN/temp/scripts")) {
			mkdir($ruta."/ICAN/temp/scripts");
		}
		if (!is_dir($ruta."/ICAN/temp/config")) {
			mkdir($ruta."/ICAN/temp/config");
		}
		
		//2. Descomprimir zips
		$fichero=$ruta."/ICAN/".$pais."/".$marca."/Windows/".$conexion."/".$version_old.".zip";
		$zip = new ZipArchive;
		$res = $zip->open($fichero);
		if ($res === TRUE) {
			$zip->extractTo($ruta.'/ICAN/temp');
			$zip->close();
		} else {
			echo 'Informacion NO extraida<br>';
			exit;
		}
		
		$fichero=$ruta."/ICAN/".$pais."/".$marca."/Linux-x86/".$conexion."/".$version_old.".zip";
		$zip = new ZipArchive;
		$res = $zip->open($fichero);
		if ($res === TRUE) {
			$zip->extractTo($ruta.'/ICAN/temp');
			$zip->close();
		} else {
			echo 'Informacion NO extraida<br>';
			exit;
		}
		rename($ruta."/ICAN/temp/config/upload.flx",$ruta."/ICAN/temp/config/upload_old.flx");
		rename($ruta."/ICAN/temp/config/download.flx",$ruta."/ICAN/temp/config/download_old.flx");
		unlink($ruta."/ICAN/temp/scripts/daemon_send_AireBox.bat");
		unlink($ruta."/ICAN/temp/scripts/daemon_send_AireBox.sh");
		unlink($ruta."/ICAN/temp/scripts/daemon_reception_AireBox.bat");
		unlink($ruta."/ICAN/temp/scripts/daemon_reception_AireBox.sh");

		
		//2. Crear daemon_send_AireBox (.bat + .sh) y modificar upload.flx + download.flx
		$fpWin = fopen("temp/scripts/daemon_send_AireBox.bat","ab") or die("No se ha podido abrir el fichero");	
		$fpUnix = fopen("temp/scripts/daemon_send_AireBox.sh","ab") or die("No se ha podido abrir el fichero");
		$fpUpload = fopen("temp/config/upload.flx","ab") or die("No se ha podido abrir el fichero");		
		$fpDownload = fopen("temp/config/download.flx","ab") or die("No se ha podido abrir el fichero");		
		
		fwrite($fpWin,'@echo off');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)');
		fwrite($fpWin,"\n".'REM # Version: @(#)daemon_send_airebox v.'.$version.' // 28-Sep-2012 arce@redcitroen.com');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'REM # "-----  Archivo del demonio de envios AireBox  -----"');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( ');
		fwrite($fpWin,"\n".'if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b');
		fwrite($fpWin,"\n".')');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'set RUTA="%PATH_AIREBOX%\Suite_DCS"');
		fwrite($fpWin,"\n".'set NOM_ENVIO=daemon_send_AireBox');
		fwrite($fpWin,"\n".'cd %RUTA%');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'set YEAR=%date:~-4%');
		fwrite($fpWin,"\n".'set MONTH=%date:~3,2%');
		fwrite($fpWin,"\n".'if "%MONTH:~0,1%" == " " set MONTH=0%MONTH:~1,1%');
		fwrite($fpWin,"\n".'set DAY=%date:~0,2%');
		fwrite($fpWin,"\n".'if "%DAY:~0,1%" == " " set DAY=0%DAY:~1,1%');
		fwrite($fpWin,"\n".'set HOUR=%time:~0,2%');
		fwrite($fpWin,"\n".'if "%HOUR:~0,1%" == " " set HOUR=0%HOUR:~1,1%');
		fwrite($fpWin,"\n".'set MINUTES=%time:~3,2%');
		fwrite($fpWin,"\n".'if "%MINUTES:~0,1%" == " " set MINUTES=0%MINUTES:~1,1%');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'REM # LLamadas a scripts a ejecutar entre las 03 y 05 (ambos inclusive)');
		fwrite($fpWin,"\n".'');	
		fwrite($fpWin,"\n".'');
		
		fwrite($fpUnix,'#!/bin/bash');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)');
		fwrite($fpUnix,"\n".'# Version: @(#)daemon_send_AireBox_v.'.$version.' // 28-Sep-2012 arce@redcitroen.com');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'NOM_ENVIO=daemon_send_AireBox');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'YEAR=$(date +%Y)');
		fwrite($fpUnix,"\n".'MONTH=$(date +%m)');
		fwrite($fpUnix,"\n".'DAY=$(date +%d)');
		fwrite($fpUnix,"\n".'HOUR=$(date +%k)');
		fwrite($fpUnix,"\n".'MINUTE=$(date +%M)');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'# LLamadas a scripts a ejecutar');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'');		
		echo '<div class="listado" align="Center">';
		echo '<table cellspacing="0" cellpadding="4" align="Left" border="0" id="GridView" style="color:#333333;font-size:9pt;width:512px;border-collapse:collapse;vertical-align: middle">';		
		echo '<tr scope="col"><th><p style="color:White;background-color:#5D7B9D;width:200px"><u>MODIFICACIÓN DE FLUJOS:</u></p><th></tr><tr><th><th></tr>';	
		for($i=0;$i<$totalUpload;$i++){
			$fileUpload = fopen("temp/config/upload_old.flx","r") or die("No se ha podido abrir el fichero");
			while($linea = fgets($fileUpload)) {
				if (feof($fileUpload)) break;
				if (strpos($linea, $_POST['upload_'.$i])!== FALSE){
					$nom_dms=trim(substr($linea,strlen($_POST['upload_'.$i]) +2,strlen($linea)));
					break;
				}
			}
			fclose($fileUpload);
			if ($_POST['upload_'.$i]!=""){
				echo '<tr style="color:White;background-color:#5D7B9D;font-weight:bold;"><th>Flujo UPLOAD habilitado :</th><th>'.$_POST['upload_'.$i].'</th></tr>';	
				fwrite($fpWin,"\n".'if %hour% GEQ 03 if %hour% LEQ 05 call %RUTA%\scripts\sftp_'.$_POST['upload_'.$i].'.bat');	
				fwrite($fpUnix,"\n".'if [ $HOUR -ge 03 -a $HOUR -le 05 ] ; then sh ""$PATH_AIREBOX""/Suite_DCS/scripts/sftp_'.$_POST['upload_'.$i].'.sh; fi');
				if (filesize("temp/config/upload.flx")>0){					
					fwrite($fpUpload,"\n".$_POST['upload_'.$i].', '.$nom_dms);
				}else{
					fwrite($fpUpload,$_POST['upload_'.$i].', '.$nom_dms);
				}

			}else{
				echo '<tr style="color:White;background-color:Red;font-weight:bold;"><th>Flujo UPLOAD deshabilitado :</th><th>'.$_POST['uploadValue_'.$i].'</th></tr>';	
				fwrite($fpWin,"\n".'REM if %hour% GEQ 03 if %hour% LEQ 05 call %RUTA%\scripts\sftp_'.$_POST['uploadValue_'.$i].'.bat');	
				fwrite($fpUnix,"\n".'#if [ $HOUR -ge 03 -a $HOUR -le 05 ] ; then sh ""$PATH_AIREBOX""/Suite_DCS/scripts/sftp_'.$_POST['uploadValue_'.$i].'.sh; fi');			
				unlink($ruta.'/ICAN/temp/scripts/sftp_'.$_POST['uploadValue_'.$i].'.bat');
				unlink($ruta.'/ICAN/temp/scripts/sftp_'.$_POST['uploadValue_'.$i].'.sh');
			}
		}		
		fclose($fpWin);
		fclose($fpUnix);
		fclose($fpUpload);
		unlink($ruta.'/ICAN/temp/config/upload_old.flx');

		//3. Crear daemon_recep_AireBox (.bat + .sh)
		$fpWin = fopen("temp/scripts/daemon_reception_AireBox.bat","ab") or die("No se ha podido abrir el fichero");	
		$fpUnix = fopen("temp/scripts/daemon_reception_AireBox.sh","ab") or die("No se ha podido abrir el fichero");	

		fwrite($fpWin,'@echo off');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)');
		fwrite($fpWin,"\n".'REM # Version: @(#)daemon_reception_airebox v.'.$version.' // 28-Sep-2012 arce@redcitroen.com');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'REM # "-----  Archivo del demonio de recepcion AireBox  -----"');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( ');
		fwrite($fpWin,"\n".'if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b');
		fwrite($fpWin,"\n".')');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'set RUTA="%PATH_AIREBOX%\Suite_DCS"');
		fwrite($fpWin,"\n".'cd %RUTA%');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'set YEAR=%date:~-4%');
		fwrite($fpWin,"\n".'set MONTH=%date:~3,2%');
		fwrite($fpWin,"\n".'if "%MONTH:~0,1%" == " " set MONTH=0%MONTH:~1,1%');
		fwrite($fpWin,"\n".'set DAY=%date:~0,2%');
		fwrite($fpWin,"\n".'if "%DAY:~0,1%" == " " set DAY=0%DAY:~1,1%');
		fwrite($fpWin,"\n".'set HOUR=%time:~0,2%');
		fwrite($fpWin,"\n".'if "%HOUR:~0,1%" == " " set HOUR=0%HOUR:~1,1%');
		fwrite($fpWin,"\n".'set MINUTES=%time:~3,2%');
		fwrite($fpWin,"\n".'if "%MINUTES:~0,1%" == " " set MINUTES=0%MINUTES:~1,1%');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'LLamadas a scripts a ejecutar entre las 00 y 24 (ambos inclusive)');
		fwrite($fpWin,"\n".'');	
		fwrite($fpWin,"\n".'');
		fwrite($fpWin,"\n".'if %HOUR% GEQ 07 if %HOUR% LEQ 24 cmd /c javaw -Xrs -jar %RUTA%\bin\recep_DCS.jar');
		fwrite($fpWin,"\n".'');	
		
		fwrite($fpUnix,'#!/bin/bash');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)');
		fwrite($fpUnix,"\n".'# Version: @(#)daemon_reception_AireBox_v.'.$version.' // 28-Sep-2012 arce@redcitroen.com');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'NOM_ENVIO=daemon_reception_AireBox');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'YEAR=$(date +%Y)');
		fwrite($fpUnix,"\n".'MONTH=$(date +%m)');
		fwrite($fpUnix,"\n".'DAY=$(date +%d)');
		fwrite($fpUnix,"\n".'HOUR=$(date +%k)');
		fwrite($fpUnix,"\n".'MINUTE=$(date +%M)');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'# LLamadas a scripts a ejecutar');
		fwrite($fpUnix,"\n".'');
		fwrite($fpUnix,"\n".'cd ""$PATH_AIREBOX""/Suite_DCS');
		fwrite($fpUnix,"\n".'if [ $HOUR -ge 07 -a $HOUR -le 24 ] ; then nohup java -Xrs -jar ""$PATH_AIREBOX""/Suite_DCS/bin/recep_DCS.jar; fi');
		fwrite($fpUnix,"\n".'');		
		for($i=0;$i<$totalDownload;$i++){
			$fileDownload = fopen("temp/config/download_old.flx","r") or die("No se ha podido abrir el fichero");
			while($linea = fgets($fileDownload)) {
				if (feof($fileDownload)) break;
				if (strpos($linea, $_POST['download_'.$i])!== FALSE){
					$nom_dms=trim(substr($linea,strlen($_POST['download_'.$i]) +2,strlen($linea)));
					break;
				}
			}
			fclose($fileDownload);
			if ($_POST['download_'.$i]!=""){
				echo '<tr style="color:White;background-color:#5D7B9D;font-weight:bold;"><th>Flujo DOWNLOAD habilitado :</th><th>'.$_POST['download_'.$i].'</th></tr>';	
				fwrite($fpWin,"\n".'if %HOUR% GEQ 03 if %HOUR% LEQ 05 call %RUTA%\scripts\sftp_'.$_POST['download_'.$i].'.bat');
				fwrite($fpUnix,"\n".'if [ $HOUR -ge 03 -a $HOUR -le 05 ] ; then sh ""$PATH_AIREBOX""/Suite_DCS/scripts/sftp_'.$_POST['download_'.$i].'.sh; fi');
				if (filesize("temp/config/download.flx")>0){
					fwrite($fpDownload,"\n".$_POST['download_'.$i].', '.$nom_dms);
				}else{
					fwrite($fpDownload,$_POST['download_'.$i].', '.$nom_dms);
				}
			}else{
				echo '<tr style="color:White;background-color:Red;font-weight:bold;"><th>Flujo DOWNLOAD deshabilitado :</th><th>'.$_POST['downloadValue_'.$i].'</th></tr>';	
				fwrite($fpWin,"\n".'REM if %HOUR% GEQ 03 if %HOUR% LEQ 05 call %RUTA%\scripts\sftp_'.$_POST['downloadValue_'.$i].'.bat');
				fwrite($fpUnix,"\n".'#if [ $HOUR -ge 03 -a $HOUR -le 05 ] ; then sh ""$PATH_AIREBOX""/Suite_DCS/scripts/sftp_'.$_POST['downloadValue_'.$i].'.sh; fi');				
				unlink($ruta.'/ICAN/temp/scripts/sftp_'.$_POST['downloadValue_'.$i].'.bat');
				unlink($ruta.'/ICAN/temp/scripts/sftp_'.$_POST['downloadValue_'.$i].'.sh');
			}
		}
		fclose($fpWin);
		fclose($fpUnix);
		fclose($fpDownload);
		unlink($ruta.'/ICAN/temp/config/download_old.flx');
		
		echo '</table>';
		echo '</div>';

		//4. Actualizar archivo de version	
		$fp = fopen($ruta."/ICAN/temp/version.txt","w") or die("No se ha podido abrir el fichero");
		fwrite($fp, $version);
		fclose($fp);
	
		//5. Comprimir Zip Windows
		$fichero=$ruta."/ICAN/temp/".$version."_Windows.zip";
		$zip = new ZipArchive;
		
		if ($zip->open($fichero, ZIPARCHIVE::CREATE)==TRUE) 
			{ 
				$zip->addFile("./temp/config/upload.flx","config/upload.flx");
				$zip->addFile("./temp/config/download.flx","config/download.flx");
				$zip->addFile("./temp/scripts/daemon_send_AireBox.bat","scripts/daemon_send_AireBox.bat");
				$zip->addFile("./temp/scripts/daemon_reception_AireBox.bat","scripts/daemon_reception_AireBox.bat");
				for($i=0; $i<$totalUpload; $i++) {
					if ($_POST['upload_'.$i]!=""){
						$zip->addFile("./temp/scripts/sftp_".$_POST['upload_'.$i].'.bat',"scripts/sftp_".$_POST['upload_'.$i].'.bat');
					}
				}
				for($i=0; $i<$totalDownload; $i++) {
					if ($_POST['download_'.$i]!=""){
						$zip->addFile("./temp/scripts/sftp_".$_POST['download_'.$i].'.bat',"scripts/sftp_".$_POST['download_'.$i].'.bat');
					}
				}
				$zip->close();
			}
		else{
			echo "No se ha podido generar el fichero ".$fichero;
		}			

		//6. Comprimir Zip Unix
		$fichero=$ruta."/ICAN/temp/".$version."_Unix.zip";
		$zip = new ZipArchive;
		
		if ($zip->open($fichero, ZIPARCHIVE::CREATE)==TRUE) 
			{ 	
				$zip->addFile("./temp/config/upload.flx","config/upload.flx");
				$zip->addFile("./temp/config/download.flx","config/download.flx");
				$zip->addFile("./temp/scripts/daemon_send_AireBox.bat","scripts/daemon_send_AireBox.sh");
				$zip->addFile("./temp/scripts/daemon_reception_AireBox.bat","scripts/daemon_reception_AireBox.sh");
				for($i=0; $i<$totalUpload; $i++) {
					if ($_POST['upload_'.$i]!=""){
						$zip->addFile("./temp/scripts/sftp_".$_POST['upload_'.$i].'.sh',"scripts/sftp_".$_POST['upload_'.$i].'.sh');
					}
				}
				for($i=0; $i<$totalDownload; $i++) {
					if ($_POST['download_'.$i]!=""){
						$zip->addFile("./temp/scripts/sftp_".$_POST['download_'.$i].'.sh',"scripts/sftp_".$_POST['download_'.$i].'.sh');
					}
				}
				$zip->close();
			}
		else{
			echo "No se ha podido generar el fichero ".$fichero;
		}
		
		//Creacion de Checksum.txt
		$file=$ruta."/ICAN/temp/".$version."_Windows.zip";
		$fp = fopen($ruta."/ICAN/temp/checksum_Windows.txt","w") or die("No se ha podido abrir el fichero");								
			fwrite($fp,md5_file($file));							
		fclose($fp);
		$file=$ruta."/ICAN/temp/".$version."_Unix.zip";
		$fp = fopen($ruta."/ICAN/temp/checksum_Unix.txt","w") or die("No se ha podido abrir el fichero");								
			fwrite($fp,md5_file($file));							
		fclose($fp);		
	}
	?>
	</BODY>
</HTML>