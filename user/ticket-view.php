<?php if(isset($_SESSION['nombre']) && isset($_SESSION['tipo'])){
        

        if(isset($_POST['fecha_ticket']) && isset($_POST['name_ticket']) && isset($_POST['email_ticket'])){

          /*Este codigo nos servira para generar un numero diferente para cada ticket*/
          $codigo = ""; 
          $longitud = 2; 
          for ($i=1; $i<=$longitud; $i++){ 
            $numero = rand(0,9); 
            $codigo .= $numero; 
          } 
          $num=Mysql::consulta("SELECT id FROM ticket");
          $numero_filas = mysqli_num_rows($num);

          $numero_filas_total=$numero_filas+1;
          $id_ticket="UNIT".$codigo."N".$numero_filas_total;
          /*Fin codigo numero de ticket*/


          $fecha_ticket= MysqlQuery::RequestPost('fecha_ticket');
          $nombre_ticket= MysqlQuery::RequestPost('name_ticket');
          $email_ticket=MysqlQuery::RequestPost('email_ticket');
          $departamento_ticket=MysqlQuery::RequestPost('departamento_ticket');
          $asunto_ticket=MysqlQuery::RequestPost('asunto_ticket');    
          $tipo_soporte=MysqlQuery::RequestPost('tipo_soporte');    
          $mensaje_ticket=MysqlQuery::RequestPost('mensaje_ticket');
          $estado_ticket="Pendiente";
          $cabecera="";
          $mensaje_mail="¡Gracias por reportarnos su problema!  ".$id_ticket;
          $mensaje_mail=wordwrap($mensaje_mail, 70, "\r\n");

          if(MysqlQuery::Guardar("ticket","fecha,nombre_usuario,email_cliente,departamento,asunto,tipo,mensaje,estado_ticket,serie,solucion", "'$fecha_ticket','$nombre_ticket','$email_ticket','$departamento_ticket','$asunto_ticket','$tipo_soporte','$mensaje_ticket', '$estado_ticket','$id_ticket',''")){

            /*----------  Enviar correo con los datos del ticket
            mail($email_ticket, $asunto_ticket, $mensaje_mail, $cabecera)
            ----------*/
            
            echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">TICKET CREADO</h4>
                    <p class="text-center">
                        Ticket creado con exito '.$_SESSION['nombre'].'<br>El TICKET ID es: <strong>'.$id_ticket.'</strong>
                    </p>
                </div>
            ';

          }else{
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        No hemos podido crear el ticket. Por favor intente nuevamente.
                    </p>
                </div>
            ';
          }
        }
?>
        <div class="container">
          <div class="row well">
            <div class="col-sm-3">
              <img src="img/ticket.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-9 lead">
              <h2 class="text-info">¿Cómo abrir un nuevo Ticket?</h2>
              <p>Para abrir un nuevo ticket deberá llenar todos los campos en el siguiente formulario. Usted podra verificar el estado de su ticket mediante el <strong>Ticket ID</strong> que se le proporcionara al termino del registro.</p>
            </div>
          </div><!--fin row 1-->

          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-info">
                <div class="panel-heading">
                  <h3 class="panel-title text-center"><strong><i class="fa fa-ticket"></i>&nbsp;&nbsp;&nbsp;Ticket</strong></h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-4 text-center">
                      <br><br><br>
                      <img src="img/write_email.png" alt=""><br><br>
                      <p class="text-primary text-justify">Por favor llene todos los campos para abrir su ticket. El <strong>Ticket ID</strong> será enviado a la dirección de correo electronico proporcionada en este formulario.</p>
                    </div>
                    <div class="col-sm-8">
                      <form class="form-horizontal" role="form" action="" method="POST">
                          <fieldset>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Fecha</label>
                            <div class='col-sm-10'>
                                <div class="input-group">
                                    <input class="form-control" type="text" id="fechainput" placeholder="Fecha" name="fecha_ticket" required="" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Nombre</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Nombre" required="" pattern="[a-zA-Z ]{1,30}" name="name_ticket" title="Nombre Apellido" value="<?php echo $_SESSION['nombre_completo']; ?>" >
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email_ticket" required="" title="Ejemplo@dominio.com" value="<?php echo $_SESSION['email']; ?>" >
                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                              </div> 
                          </div>
                        </div>
<!-- combo box para poner las opciones de seleccion de dependencias de la unach-->
                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Departamento</label>
                          <div class="col-sm-10">
                              <div class='input-group' place>
                                <select class="form-control" name="departamento_ticket">
                                  <option value="CTI">CTI</option>
                                  <option value="Rectoria">Rectoria</option>
                                  <option value="FCA">FCA</option>
                                  <option value="Ingenieria Civil">Ingenieria Civil</option>
                                  <option value="Arquitectura">Arquitectura</option>
                                  <option value="Lenguas">Fac. Lenguas</option>
                                  <option value="LSC">LSC</option>
                                  <option value="Humanidades">Humanidades</option>
                                  <option value="Ceune">Ceune</option>

                                </select>

                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                              </div> 
                          </div>

                        </div>


<!--solicitud via en combo aun pendiente de agregar a la base de datos

<div class="form-group">
                          <label  class="col-sm-2 control-label">Solicitud via</label>
                          <div class="col-sm-10">
                              <div class='input-group' >
                                <select class="form-control" name="departamento_ticket">
                                  <option value="CTI">Oficio</option>
                                  <option value="Rectoria">Telefonica</option>
                                  <option value="FCA">Correo Electronico</option>
                                  <option value="Ingenieria Civil">Personal</option>
                                  <option value="Arquitectura">Otro</option>
                                </select>
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                              </div> 
                          </div>
                        </div-->

<!--br>

<imagen
<div >
<form name="subida-imagenes" type="POST" enctype="multipart/formdata" style="text-align: center;" >
  <input type="file" name="imagen" />
</form>

<br>
</div-->


 



                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Asunto del reporte</label>
                          <div class="col-sm-10">
                              <div class='input-group'>
                                <input type="text" class="form-control" placeholder="Asunto" name="asunto_ticket" required="">
                                <span class="input-group-addon"><i class="fa fa-paperclip"></i></span>
                              </div> 
                          </div>
                        </div>

                          <div class="form-group">
                          <center>
                          <label>Seleccione una Opción</label><br>
                          <label> Soporte de Red</label>
                             <input type="radio" name="tipo_soporte" value="Soporte de Red"> </input>&nbsp; &nbsp;
                          <label> Soporte Telefonia IP</label>
                               <input type="radio" name="tipo_soporte" value="Soporte Telefonia IP"></input>&nbsp; &nbsp;
                          <label>Conectividad WIFI</label>     
                               <input type="radio" name="tipo_soporte" value="Conectividad WIFI"> </input>&nbsp; &nbsp;
                          <label>Instalación de Red</label>     
                               <input type="radio" name="tipo_soporte" value="Instalación de Red"> </input>&nbsp; &nbsp;
                          <label>Instalación de Telefono IP</label>     
                               <input type="radio" name="tipo_soporte" value="Instalación de Telefono IP"> </input>&nbsp; &nbsp;

                        </center>
                          <div class="col-sm-10">
                              <div class='input-group' place>
                                

                                 
                                
                              </div> 
                          </div>

                        </div>




                        <div class="form-group">
                          <label  class="col-sm-2 control-label">Describa brevemente el problema</label>
                          <div class="col-sm-10">
                            <textarea class="form-control" rows="3" placeholder="Escriba el problema de conectividad que presenta" name="mensaje_ticket" required=""></textarea>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info">Abrir ticket</button>
                          </div>
                        </div>
                             </fieldset> 
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php
}else{
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="./img/Stop.png" alt="Image" class="img-responsive"/><br>
                <img src="./img/SadTux.png" alt="Image" class="img-responsive"/>
                
            </div>
            <div class="col-sm-7 text-center">
                <h1 class="text-danger">Lo sentimos esta página es solamente para usuarios registrados en UNIT</h1>
                <h3 class="text-info">Inicia sesión para poder acceder</h3>
            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>
    </div>
<?php
}
?>
<script type="text/javascript">
  $(document).ready(function(){
      $("#fechainput").datepicker();
  });
</script>