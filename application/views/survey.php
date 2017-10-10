              <script>
              var submitSurvey = function(origin) {
                submitted=true;
                _gaq.push(['_trackEvent', 'Encuesta', 'Enviar email', origin]);
                console.log('submit!!');
              }
              </script>

              <div id="survey-modal" class="modal hide fade" tabindex="-1" role="dialog">
                <iframe name="hidden_iframe" id="hidden_iframe" style="display:none;" ></iframe>
                <div class="modal-header text-center">
                  <button type="button" class="close" data-dismiss="modal" id="close-modal">×</button>
                  <h3>¿Tienes un minuto?</h3>
                </div>
                <div class="modal-body">
                  <!-- <iframe id="gform" src="" height="250" frameborder="0"></iframe> -->
                  <img src="/assets_v2/img/gob_cl.png" class="hide">
                  <form id="gform" 
                        class="form" 
                        target="hidden_iframe"
                        onsubmit="submitSurvey('<?php echo $ficha->maestro_id? "ficha".$ficha->maestro_id : "Home" ?>')"
                        action="https://docs.google.com/forms/d/e/1FAIpQLSdvAUG_4qXXNq17BC9q1dqt1yKKk42eICw8WuClElXs78LdZw/formResponse">
                    <h4>Déjanos tu email para contactarte y conocer tu opinión sobre el portal ChileAtiende.gob.cl</h4>
                    <div class="form-group">
                      <label class="text-left">Correo electrónico:</label>
                      <input class="input" id="gform-email" name="entry.175042737" type="email" required placeholder="ejemplo@dominio.com"/>
                      <input class="hidden" id="gform-origin" name="entry.1240825932" value="<?php echo $ficha->maestro_id? 'ficha'.$ficha->maestro_id : 'Home' ?>" />
                    </div>
                    <div class="form-group">
                      <label class="text-left">Región:</label>
                      <select class="input" name="entry.879761844">
                        <option value="Región Metropolitana" selected="selected">Región Metropolitana</option>
                        <option value="Arica y Parinacota">Arica y Parinacota</option>
                        <option value="Tarapacá">Tarapacá</option>
                        <option value="Antofagasta">Antofagasta</option>
                        <option value="Atacama">Atacama</option>
                        <option value="Coquimbo">Coquimbo</option>
                        <option value="Valparaiso">Valparaiso</option>
                        <option value="O'Higgins">O'Higgins</option>
                        <option value="Tarapacá">Maule</option>
                        <option value="Biobío">Biobío</option>
                        <option value="La Araucanía">La Araucanía</option>
                        <option value="Los Ríos">Los Ríos</option>
                        <option value="Los Lagos">Los Lagos</option>
                        <option value="Aysen">Aysén</option>
                        <option value="Magallanes y Antártica">Magallanes y Antártica</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input class="form-submit btn btn-primary" id="gform-submit" type="submit" value="Deseo participar"/>
                      <!-- <input class="form-submit btn btn-secondary" data-dismiss="modal" type="button" value="No deseo participar"/> -->
                    </div>
                  </form>

                </div>
              <!-- <div class="modal-footer">
                <button class="btn" data-dismiss="modal">Cerrar</button>
              </div> -->
              </div>
