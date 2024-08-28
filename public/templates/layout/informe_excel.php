<?php
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/vnd.ms-excel");
header ("Content-Disposition: attachment; filename=\"Resoluciones-".date('YmdHis').".xls" );
header ("Content-Description: Reporte" );

print '<?xml version="1.0"?>'.chr(10);
print '<?mso-application progid="Excel.Sheet"?>'.chr(10);
?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
	<Styles>
  		<Style ss:ID="Default" ss:Name="Normal">
		   <Alignment ss:Vertical="Bottom"/>
		   <Borders/>
		   <Font ss:FontName="Arial" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
		   <Interior/>
		   <NumberFormat/>
		   <Protection/>
		</Style>
		<Style ss:ID="EncabezadoInforme">
	  	   	<Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
	  	   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="14" ss:Color="#0B68A2"/>
	  	</Style>
	  	<Style ss:ID="EncabezadoTitulo">
	  	   	<Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
	  	   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="11" ss:Color="#0B68A2"/>
	  	</Style>
		<Style ss:ID="TituloInforme">
	  	   	<Alignment ss:Horizontal="Left" ss:Vertical="Center" ss:WrapText="1"/>
			<Borders>
				<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
		   	</Borders>
		   	<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="10" ss:Color="#0B68A2" ss:Bold="1"/>
		   	<Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
	  	</Style>
		<Style ss:ID="TituloColumna">
	  	   	<Alignment ss:Vertical="Bottom" ss:WrapText="1"/>
	  	   	<Borders>
	  	   		<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
			<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="10" ss:Color="#0B68A2" ss:Bold="1" />
			<Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
		</Style>
		<Style ss:ID="PieCuadro">
			<Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
			<Font ss:FontName="Arial" x:Family="Swiss" ss:Size="11" ss:Color="#000000" />
		</Style>
		<Style ss:ID="color1">
		   <Borders>
	  	   		<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
		   <Interior ss:Color="#E1E1E1" ss:Pattern="Solid"/>
		   <Alignment ss:WrapText="1"/>
		   <NumberFormat ss:Format="Standard"/>
		</Style>
		<Style ss:ID="color2">
			<Borders>
	  	   		<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
		    <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
		    <Alignment ss:WrapText="1"/>
		    <NumberFormat ss:Format="Standard"/>
		</Style>
		<Style ss:ID="color1_derecho">
		   <Borders>
	  	   		<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
		   <Interior ss:Color="#E1E1E1" ss:Pattern="Solid"/>
		  <Alignment ss:WrapText="1" ss:Horizontal="Right" />
		   <!--<NumberFormat ss:Format="Standard"/>-->
		    
		</Style>
		<Style ss:ID="color2_derecho">
			<Borders>
	  	   		<Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
                <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#000000"/>
            </Borders>
		    <Interior ss:Color="#FFFFFF" ss:Pattern="Solid"/>
		    <Alignment ss:WrapText="1" ss:Horizontal="Right" />
		   <!-- <NumberFormat ss:Format="Standard"/>-->
		   
		</Style>
		<Style ss:ID="FormatoNumerico">
		   <NumberFormat ss:Format="Standard"/>
		</Style>
		<Style ss:ID="FormatoNumerico2">
		   <NumberFormat/>
		</Style>
		<Style ss:ID="CuadroEnmiendas">
		   	<Interior ss:Color="#FFCC99" ss:Pattern="Solid"/>
	  	</Style>
	</Styles> 	
 	
	<?php echo $this->fetch('content'); ?>
	
</Workbook>	