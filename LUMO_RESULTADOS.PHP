<?PHP
include("programas/sesiones.php");
if($continua == 1)
   {
     ?>
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
      <link rel="stylesheet" type="text/css" href="css/jquery.ui.css">
      <link rel="stylesheet" type="text/css" href="css/default.css"/>

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
  margin: 5px;
  padding: 5px;
  border-bottom: #CCC 1px solid;
  border-right: #CCC 1px solid;
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
 table {
  border: #CCC 1px solid;
}
 </style>
 <script>
       jQuery(document).ready(function()
          {

           $('input,textarea,select,date').blur(function()
              {

               var field = $(this);

               if($(this).val() == "")
                  {
                   return;
                  }

               field.css('background-color','#fffbed');

               //alert($(this).attr('id'));
               //alert($(this).val());

                 //var parametro = document.principal.id_parametro.value;
                      var dataString = 'value='+$(this).val()+'&field='+$(this).attr('id');
                      var id_detalle = field.attr('id').split('-');

                 $.ajax({
                     type: "POST",
                     url: "lumo_act_res.php",
                     data: dataString,
                     success: function(data) {

                         field.val(data);
                         //alert(data);
                         $('#'+parent+' .loader').fadeOut(function()
                            {
                             $('#'+parent).append('<div class="ok" >&nbsp;&nbsp;&nbsp;</div>').fadeIn('slow');
                            }
                           );
                        }

                 });


              });





          });
               function calcula(valor,ide)
              {
                alert(ide);
            };

 </script>
 <?php

     include("includes/conexion.php");


     $fecha_ini = str_replace('-','',$_POST["fechai"]);
     $fecha_fin = str_replace('-','',$_POST["fechaf"]);

    $wfecha = $fecha_ini;
    include("includes/mostrarfecha.php");
    $fecha_i = $wfecha;

    $wfecha = $fecha_fin;
    include("includes/mostrarfecha.php");
    $fecha_f = $wfecha;

     $sucursal = $_POST["sucursal"];
     echo '<form name=principal id=principal action="#" method=post enctype="multipart/form-data" >
     <table style="border-bottom-width: 1em;padding:10px;font-size:18px;"  >



          <tr style="background-color:#C0392B;font-size:18px;font-color:white;">
         <td colspan=12 >RESULTADOS X SUCURSAL X RANGO DE FECHAS  '.$sucursal.' '.$fecha_i.' AL  '.$fecha_f.'</td></tr>


       <tr style="background-color:#CCC;font-size:12px;" >
           	              <td>&nbsp;           </td>
           	              <td>Factura          </td>
           	              <td>Placa           </td>
                          <td>Serie           </td>
           	              <td>Fecha factura    </td>
           	              <td>Subtotal         </td>
           	              <td>IVA               </td>
           	              <td>Total Factura      </td>
                           <td>Autorizacion / Estatus </td>
         	                <td>Fecha de Revision       </td>
                          <td>Fecha de Vencimiento    </td>
                          <td> Fecha de Pago </td>
                          <td>Administrador           </td>
           	              </tr>';
                           //EMPIEZAAQUI //
			$sqlx  = " SELECT * FROM DETALLE_CXC  WHERE ID_CXC = $ide AND DESCRIPCION <> 'SALDO INICIAL' ";
         //$sqlx .= "  AND CUENTASXCOBRAR.CLAVE_CLIENTE = '".$cvecliente."' AND DETALLE_CXC.ESTADO = 0  AND CUENTASXCOBRAR.SUCURSAL = '".$sucu."'";
         #echo $sqlx.' <br>';
         $resxy  = mysql_query($sqlx);
         while($regxy =mysql_fetch_array($resxy))
            {
             $fecha = $regxy["FECHA_PAGO"];
             $id_deta = $regxy["ID_DETALLE_CXC"];
             include("includes/mmostrarfecha.php");
             $fecha = $wfecha;
                   //echo "<td><input type='text' id='custId'  value=".$id_detas." readonly></td>";
             //IF*/
               }else{
                   echo '<td>'.$fecha.'</td>';
                   
                } 
                          $i =0;
                          $sql="SELECT *  FROM DOCUMENTOS WHERE TDOCUMENTO =  'FACTURA' AND  SUCURSAL = '$sucursal' AND ANULADO = 0 AND (CLAVE_CLIENTE = 'EPS-00005' OR CLAVE_CLIENTE = 'EPS-00057' ) AND FECHA >= '".$fecha_ini."' AND FECHA <= '".$fecha_fin."'  " ;
                          #echo $sql;
                          //echo $sql . "<br>";
                          $res=mysql_query($sql);
                         while($registro=mysql_fetch_array($res))
                             {
                               $ir += 1;
//HASTA AQUI SEGUN YO //
                               $SQLAU = "SELECT NOSERIE FROM VEHICULOS WHERE PLACAS = '".$registro['PLACAS']."' ";
              						     #echo $SQLAU;
                               $SQLAU = mysql_query($SQLAU,$enlace);
                               $rowau = mysql_fetch_array($SQLAU);
                               $serie = $rowau["NOSERIE"];

                               if($user == "GABRIELAZARATE" || $user == "ROOT")
                                  {
                                    echo "
                                              <tr>
                                                 <td>".$ir."           </td>
                                                 <td>".$registro["ID_AUTOOPERSUC"]."          </td>
                                                 <td>".$registro["PLACAS"]."           </td>
                                                 <td>".$serie."           </td>
                                                 <td>".$registro["SISTEMA"]."</td>
                                                 <td>".number_format($registro["BRUTO"],2)."</td>
                                                 <td>".number_format($registro["IMPUESTO"],2)."</td>
                                                 <td>".number_format($registro["TOTAL"],2)."</td>";

                                              echo "<td><div  id='1-".$ir."'   ><input type=text size=10   ID='NO_AUTORIZACION-".$registro["ID_DOCUMENTO"]."-".$registro["ID_ORDEN"]."'   value='".$registro["NO_AUTORIZACION"]."'  ></div></td>
                                                 <td><div  id='2-".$ir."'   ><input type=date size=10      ID='FECHA_REVISION-".$registro["ID_DOCUMENTO"]."-".$registro["ID_ORDEN"]."'       value='".$registro["FECHA_REVISION"]."'      ></div></td>
                                                <td><div  id='3-".$ir."'   ><input type=date size=10       ID='FECHA_VENCIMIENTO-".$registro["ID_DOCUMENTO"]."-".$registro["ID_ORDEN"]."'    value='".$registro["FECHA_VENCIMIENTO"]."'   ></div></td>
                                                <td><div  id='4-".$ir."'   ><input type=text size=10      ID='ADMINISTRADOR-".$registro["ID_DOCUMENTO"]."-".$registro["ID_ORDEN"]."'   value='".$registro["ADMINISTRADOR"]."' ></div></td>";
                                                 echo "</tr>";

                                 } 
                                else {
                                         echo "
                                                   <tr>
                                                      <td>".$ir."</td>
                                                      <td>".$registro["ID_AUTOOPERSUC"]."          </td>
                                                      <td>".$registro["PLACAS"]."           </td>
                                                      <td>".$serie."           </td>
                                                      <td>".$registro["SISTEMA"]."</td>
                                                      <td>".number_format($registro["BRUTO"],2)."</td>
                                                      <td>".number_format($registro["IMPUESTO"],2)."</td>
                                                      <td>".number_format($registro["TOTAL"],2)."</td>
                                                      <td>".$registro["NO_AUTORIZACION"]." </td>
                                                      <td>".$registro["FECHA_REVISION"]." </td>
                                                     <td>".$registro["FECHA_VENCIMIENTO"]." </td>
                                                     <td>".$registro["FECHA_PAGO"]."</td>
                                                     <td>".$registro["ADMINISTRADOR"]."           </td>
                                                      </tr>";

                                }





                                            $brutot +=   $registro["BRUTO"];
                                            $impuestot +=   $registro["IMPUESTO"];
                                            $totalt +=   $registro["TOTAL"];
                             }

                             echo "
                                              <tr  >
                                                 <td colspan=12 ><hr size=2 color=black ></td>
                                                 </tr>";
                                                 echo "
                                                                  <tr>
                                                                     <td colspan=4><h1>&nbsp;TOTALES </h1></td>
                                                                     <td> $&nbsp;".number_format($brutot,2)."</td>
                                                                     <td> $&nbsp;".number_format($impuestot,2)."</td>
                                                                     <td> $&nbsp;".number_format(  $totalt,2)."</td>
                                                                     <td colspan=5 >&nbsp; </td>
                                                                     </tr>";


     echo "</table>";
echo "<hr size=2 color=black >";


echo "<table >";
echo '<TR style="background-color:#C0392B;font-size:18px;font-color:white;"><td colspan=4 >RESULTADOS X SUCURSAL X ADMINISTRADOR X RANGO DE FECHAS <BR> '.$sucursal.' '.$fecha_i.' AL  '.$fecha_f.'</td></tr>';
echo "<tr></tr>
<td>Administrador </td>
<td>Ordenes </td>
<td> $ Total </td>";
$sql="SELECT *  FROM ADMINISTRADORES " ;
#echo $sql;
//echo $sql . "<br>";
$res=mysql_query($sql);
while($registro=mysql_fetch_array($res))
   {

     $sqlx="SELECT COUNT(ID_DOCUMENTO) AS FACTS, SUM(TOTAL) AS TOT  FROM DOCUMENTOS WHERE TDOCUMENTO =  'FACTURA' AND  SUCURSAL = '$sucursal' AND ANULADO = 0 AND CLAVE_CLIENTE = 'EPS-00005' AND ADMINISTRADOR = '".$registro["ADMINISTRADOR"]."' AND FECHA >= '".$fecha_ini."' AND FECHA <= '".$fecha_fin."' " ;
     #echo $sql;
     //echo $sql . "<br>";
     $resx=mysql_query($sqlx);
    while($registrox=mysql_fetch_array($resx))
        {
          echo "<tr></tr>
          <td>".$registro["ADMINISTRADOR"]."</td>
          <td>".$registrox["FACTS"]."</td>
          <td>$ ".number_format($registrox["TOT"],2)."</td>

          ";

        $total_t +=  $registrox["TOT"];
        $total_ods +=  $registrox["FACTS"];
        }


}


echo "
                 <tr>
                    <td>&nbsp;</td>
                    <td>".number_format($total_ods,2)."</td>
                    <td> $&nbsp;".number_format($total_t,2)."</td>
                    </tr>";
echo "</table>";

     mysql_close($enlace);
   }
else
{
include("VACIO.PHP");
}



?>