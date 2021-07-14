<?php
include("programas/sesiones.php");

if($continua == 1)
   {

     ?>
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <link rel="stylesheet" type="text/css" href="css/jquery.ui.css">
    <script>

      jQuery(document).ready(function()
        {
          $('input,textarea,select').blur(function()
          {
            var field = $(this);

            if($(this).val() == "")
            {
              return;
            }

            //alert($(this).attr('id'));
            field.css('background-color','#ff5733');

            var dataString = 'value='+$(this).val()+'&field='+$(this).attr('id');
            //var id_detalle = field.attr('id').split('-');


            $.ajax({
              type: "POST",
              url: "ACTUALIZA_PAGO.PHP",
              data: dataString,
              success: function(data) {
                field.val(data);

              }
            });

          });




         // $('.botoncito').click(function()
          $('.botoncito').on('click', function(){
        alert('Ha hecho click sobre el boton'); 
        

          {
           
            //var dataString = 'custId='+$("#custId").val()+'&custIdcxc='+$("#custIdcxc").val();

            var dataString = 'value='+$(this).val()+'&field='+$(this).attr('id');
            //alert("boton click")
            //url: "mane_prueba.php",

            $.ajax({
            type: "POST",
            url: "mane_prueba.php",
            data: dataString,
              success: function(data){
                alert("Registro eliminado con exito.");
                $("#resultado").val(data);
                location.reload();

              } 
            });

          }

        });
});
        </script>

     <style>

    body {
	font-family: Arial;; font-size: 16px;font-weight="lighter";

	}

	th	{
		font: caption;
	  font-size: 13px;
	 font-weight="lighter";
	 font-style: normal;
	}

td {
	 font: caption;
   font-size: 13px;
   font-weight="lighter";
	 font-style: normal;
	}

	h1	{
	font-size: 150%;
	margin-top: 5px;
	margin-bottom: 5px;
	}

		h3	{
	font-size: 110%;
	margin-top: 5px;
	margin-bottom: 5px;
	}
 </style>

<body>
<?php

error_reporting(0);
$sucu    = $_REQUEST["sucu"] ;
$cvecliente    = $_REQUEST["clie"] ;
$cxc    = $_REQUEST["cxc"] ;

include("includes/conexion.php");


echo "<form name=pagos method=post id=pagos ><table  cellspacing=0 cellpadding=0 border=1>";



echo "<tr><td colspan=17 ><div align=center ><h1><font colot=red >
	REPORTE DE PAGOS CUENTA X COBRAR $cxc ";

echo "</h1><br><br>";
echo "</div></td></tr>";

$sqlc = "SELECT * FROM CLIENTES WHERE  CLAVE_CLIENTE = '".$cvecliente."' ";
				#$resc  = mysql_query($sqlc);

				while($regc =mysql_fetch_array($resc))
				{
					$nom = $regc["RAZON_SOCIAL"];
				}

echo "<tr>";
echo "<th colspan=3 ><div align=left >Cliente:          </div></th>";
echo "<th colspan=9 ><div align=left >&nbsp;$nom</DIV></th>";
echo "<th colspan=3 >&nbsp;        </th>";
echo "<th>&nbsp;    </th>";
echo "</tr>";

echo "<tr><td colspan=17 ><hr size=3 color=black ></td></tr>";
echo "<tr class=Caption>";

echo "<th>&nbsp;Fecha Pago         &nbsp;</th>";
echo "<th>&nbsp;ID        &nbsp;</th>";
echo "<th>&nbsp;Forma de Pago           &nbsp;</th>";
echo "<th>&nbsp;Estado </th>";
echo "<th>&nbsp;Referencia</th>";
echo "<th>&nbsp;Pagos        &nbsp;</th>";




echo "<th colspan=6>&nbsp;</th>";
echo "</tr>";

echo "<tr><td colspan=17 ><hr size=3 color=black ></td></tr>";



	$sqlx = "SELECT * FROM CUENTASXCOBRAR WHERE ID_CXC = ".$cxc." AND ESTADO= 0";
	//$sqlx = "SELECT * FROM PAGOS WHERE NOMBREC	 = '".$cve_cxc."' AND SUCURSAL='".$sucu."' ";
	//echo $sqlx.' <br><br>';
	$resx  = mysql_query($sqlx);

	while($regx =mysql_fetch_array($resx))
		{
			$ide =  $regx["ID_CXC"];
			$sucu = $regx["SUCURSAL"];
			$venta = $regx["ID_VENTA"];
			$fec =  $regx["FECHA_REGISTRO"];

			$sqlx  = " SELECT * FROM DETALLE_CXC  WHERE ID_CXC = $ide AND DESCRIPCION <> 'SALDO INICIAL' ";
                //$sqlx .= "  AND CUENTASXCOBRAR.CLAVE_CLIENTE = '".$cvecliente."' AND DETALLE_CXC.ESTADO = 0  AND CUENTASXCOBRAR.SUCURSAL = '".$sucu."'";
                #echo $sqlx.' <br>';
                $resxy  = mysql_query($sqlx);
                while($regxy =mysql_fetch_array($resxy))
                   {
                    $fecha = $regxy["FECHA_PAGO"];
                    $tipopago = $regxy["TIPO_PAGO"];
                    $pago  = $regxy["PAGO"];
                    $estado  = $regxy["ESTADO"];
                    $referencia = $regxy["REFERENCIA"];

                    $id_deta = $regxy["ID_DETALLE_CXC"];

                    $wfecha = $fecha;
                    include("includes/mmostrarfecha.php");
                    $fecha = $wfecha;

                    echo "<tr>";
                    $id_detas = $regxy["ID_DETALLE_CXC"];
                    if($estado == 0)
                       {
                          //echo "<td>".$fecha."</td>";
						              $cxc     = $cxc;
						              $tablap = "DETALLE_CXC";
						              $campo  = "ID_DETALLE_CXC";
                          echo '<td><input type=text size=10   ID="FECHA_PAGO-'.$id_deta.'-'.$tablap.'-'.$campo.'-'.$cxc.'-MOD" VALUE='.$fecha.' ></td>';
                          

                          //echo "<td><input type='text' id='custId'  value=".$id_detas." readonly></td>";
                       }else{
                          echo '<td>'.$fecha.'</td>';
                          
                       }
                       echo "<td>".$id_detas."</td>";
                   
                    echo "<td>".$tipopago."</td>";
                    echo "<input type='hidden' id='custIdcxc' value=".$cxc.">";

                    if($estado == 0)
                       {
                         echo "<td><img src=imagenes/exito.png width=20 ></td>";
                       }
                    elseif($estado == 1) {
                      echo "<td><img src=imagenes/error.png width=20 ></td>";
                    }
                    else {
                      echo "<td>&nbsp;</td>";
                    }


              			echo "<td>".$referencia."</td>";
                  		echo "<td>".number_format($pago,2)."</td>";
                    echo "<td>&nbsp;</td>";
                    echo "<td>".$id_deta."</td>";
                    //echo "<td><div align=right><img src='imagenes/delete.gif'  class='botoncito'  ID=".$id_deta." >&nbsp;</div></td>";

                    if($estado == 0)
                       {
                        echo '<td><img src="imagenes/delete.gif"  class="botoncito"  ID="'.$cxc.'-'.$id_deta.'-ELI" ></td>';
                       }
                    echo "<td><input type='hidden' size=10 id='resultado'></td>";

              		echo "</tr>";
                   }





	}


echo "</table></form>";
}
else {
  include("VACIO.PHP");
}

?>
