function deleteId(celula){
  var idCell = celula.parentNode.id.split('-')[1]
  $('#delete-id').val(idCell)
  $('#delete-vehicul').removeClass('dis-none')
}

function closeDelete(){
  $('#delete-vehicul').addClass('dis-none')
}

function closePanel(){
  $('#panou-editare').addClass('dis-none')
  $('#panel-input').html('')

}

function copyOptions(selectElement, selectedValue) {
  const source = document.getElementById(selectElement);

  return '<option value="' + selectedValue + '" selected>' + selectedValue + '</option>' + source.innerHTML;
}

function panouEditare(celula){
  var idCell = celula.id.split('-')[1]
  var categorie = celula.id.split('-')[0]
  var continut = celula.firstChild.innerHTML
  var numarInmatriculare = celula.parentNode
  numarInmatriculare = numarInmatriculare.children[0].children[0].innerHTML
  var sectionNumar = numarInmatriculare.split('-')
  $('#delete-vehicul').addClass('dis-none')

  var objectInputs = {
    "numar": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label id='numar-intreg-editabil' class='default-label numar-inmatriculare'><div>Numar de inmatriculare</div><input id='judet-editabil' name='judet-editabil' maxlength='2' placeholder='B'  value='" + sectionNumar[0] + "'><input id='numar-editabil' name='numar-editabil' maxlength='3' placeholder='123'  value='" + sectionNumar[1] + "'><input name='litere-editabile' id='litere-editabile' maxlength='3' placeholder='VJV'  value='" + sectionNumar[2] + "'></label>",
    "categorie_vehicul": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>Vehicul</div><select  name='" + categorie + "'>" + copyOptions('categorie-vehicule', continut) + "</select></label>",
    "vechime": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>Vechime vehicul</div><select name='" + categorie + "'>" + copyOptions('vechime-masina', continut) + "</select></label>",
    "tip_transport": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>Tip de transport</div><select  name='" + categorie + "'>" + copyOptions('tip-transport', continut) + "</select></label>",
    "asigurare": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>RCA - data de expirare</div><input type='date' name='" + categorie + "' value='" + continut + "'></label>",
    "inspectie_tehnica": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>ITP - data de expirare</div><input type='date' name='" + categorie + "' value='" + continut + "'></label>",
    "vigneta": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>Taxa de drum (vigneta)</div><input type='date' name='" + categorie + "' value='" + continut + "'></label>",
    "numar_km": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>Numar km</div><input id='km-editabil' name='" + categorie + "' type='number' min='0' value='" + continut + "'></label>",
    "schimb_ulei": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>Schimb ulei</div><input id='ulei-editabil' name='" + categorie + "' type='number' min='0' value='" + continut + "'></label>",
    "pret_euro": "<div class='numar-editare'>Modificari pentru: " + numarInmatriculare + "</div><label class='default-label'><div>Pret(€)</div><input id='pret-editabil' name='" + categorie + "' type='number' min='0' value='" + continut + "'></label>"
  }

  $('#panou-editare').removeClass('dis-none')
  $('#panel-input').html(objectInputs[categorie] + '<button>Modifica</button>')

  $('#km-editabil, #pret-editabil, #ulei-editabil, #numar-editabil').on('input', function () {
    let value = $(this).val().replace(/[^0-9]/g, '');
    $(this).val(value);
  });

  $('#judet-editabil, #litere-editabile').on('input', function () {
    let value = $(this).val().replace(/[^a-zA-Z]/g, '');
    $(this).val(value.toUpperCase());
  });

  $('#panel-input').off('submit').on('submit', function (event) {
    if (preventSign == 0) {
      $('#loading-id').removeClass('dis-none')
      preventSign = 1
      event.preventDefault();

      var formData = new FormData(this);
      formData.append('edite-table','true')
      formData.append('id', idCell)

      $.ajax({
        type: "POST",
        url: "../../../included/function/exe/add.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (result) {
          result = result.trim()
          if(result === 'ok'){
            preventSign = 0
            checkBd()
            $('#display-message').removeClass('dis-none')
            $('#display-message').text('Modificat cu succes!');
          } else {
            $('#display-message').removeClass('dis-none')
            $('#display-message').text(result);
            preventSign = 0
            setTimeout(() => $('#loading-id').addClass('dis-none'), 1000);
          }
        },
        error: function() {
          $('#display-message').removeClass('dis-none')
          $('#display-message').text("A apărut o eroare. Vă rugăm să încercați din nou mai târziu.");
          preventSign = 0;
          setTimeout(() => $('#loading-id').addClass('dis-none'), 1000);
        }
      })
    }
});
}

function checkBd(){
    if(preventSign == 0){
      $('#loading-id').removeClass('dis-none')
      preventSign = 1
      var formData = new FormData();
      formData.append('check-base-date', "check");

      $.ajax({
        type: "POST",
        url: "../../../included/function/exe/add.php",
        data: formData,
        contentType: false,
        processData: false,
                
        success: function (result) {
          result = result.trim()
          if(result == 'eroare'){
            $('body').html('<button onclick="location.reload()" class="pos-abs centrare-x-y">Reincarca pagina</button>')
          }
          else{
            try {
              result = JSON.parse(result)
              var numarLinii = result.length
              var linie = '';
              var celule = ''
              const exclude = ["id", "data_adaugarii"];
              var classMarker = ''

              for (let index = 0; index < numarLinii; index++) {
                if (index % 2 === 0) {
                  classMarker = ''
                } 
                else {
                  classMarker = 'marker'
                }
                celule = ''

                Object.entries(result[index]).forEach(([key, val]) => {
                  if (!exclude.includes(key)) {
                    celule += '<div id="' + key + '-' + result[index]['id'] + '" onclick="panouEditare(this)" class="celula"><span>' + val + '</span><span class="material-symbols-outlined editare">edit</span></div>'
                  }
                });
                var butonDelete = '<span class="material-symbols-outlined">delete</span>'
                linie += '<div id="vehicul-' + result[index]['id'] + '" class="vehicul ' + classMarker + '">' + celule + '<div class="delete-buton" onclick="deleteId(this)">' + butonDelete + '</div></div>'
              }
              
              $('#continut-tabel').html(linie)
            }
            catch (e) {
              if(result.trim() != ''){
                $('body').html('<button onclick="location.reload()" class="pos-abs centrare-x-y">Reîncarcă pagina</button>')
              }
            }
            preventSign = 0
            setTimeout(function() {
              $('#loading-id').addClass('dis-none');
            }, 1000);
          }
        },
                
        error: function(xhr, status, error) {
          $('#display-message').removeClass('dis-none')
          $('#display-message').text("A apărut o eroare. Vă rugăm să încercați din nou mai târziu.");
          preventSign = 0;
          setTimeout(function() {
            $('#loading-id').addClass('dis-none');
          }, 1000);
          }
      })
    }
}


$(document).ready(function () {

  $('#judet, #litere').on('input', function () {
    let value = $(this).val().replace(/[^a-zA-Z]/g, '');
    $(this).val(value.toUpperCase());
  });

  $('#pretul, #ulei-km, #numar-km, #numar').on('input', function () {
    let value = $(this).val().replace(/[^0-9]/g, '');
    $(this).val(value);
  });


  $('#vehicul-date').submit(function (event) {

    if(preventSign == 0){

      $('#loading-id').removeClass('dis-none')
      preventSign = 1
      event.preventDefault();
      var formData = new FormData(this);

      $.ajax({
        type: "POST",
        url: "../../../included/function/exe/add.php",
        data: formData,
        contentType: false,
        processData: false,
                
        success: function (result) {
          result = result.trim()
          if(result === 'ok'){
              preventSign = 0
              checkBd()
          }
          else{
              $('#display-message').removeClass('dis-none')
              $('#display-message').text(result);
              preventSign = 0
              setTimeout(function() {
                $('#loading-id').addClass('dis-none');
              }, 1000);
            }
        },
                
        error: function(xhr, status, error) {
          $('#display-message').removeClass('dis-none')
          $('#display-message').text("A apărut o eroare. Vă rugăm să încercați din nou mai târziu.");
          preventSign = 0;
          setTimeout(function() {
            $('#loading-id').addClass('dis-none');
          }, 1000);
        }
      })
    }
  })
  checkBd()
});

function sendDelete(){
      if(preventSign == 0){
        $('#loading-id').removeClass('dis-none')
        preventSign = 1

        var formData = new FormData();
        var idSters = $('#delete-id').val()
        formData.append('id-delete', idSters);

        $.ajax({
          type: "POST",
          url: "../../../included/function/exe/add.php",
          data: formData,
          contentType: false,
          processData: false,
                  
          success: function (result) {
            result = result.trim()
            if(result === 'ok'){
                preventSign = 0
                checkBd()
                $('#delete-vehicul').addClass('dis-none')
            }
            else{
                $('#display-message').removeClass('dis-none')
                $('#display-message').text(result);
                preventSign = 0
                setTimeout(function() {
                  $('#loading-id').addClass('dis-none');
                }, 1000);
              }
          },
                  
          error: function(xhr, status, error) {
            $('#display-message').removeClass('dis-none')
            $('#display-message').text("A apărut o eroare. Vă rugăm să încercați din nou mai târziu.");
            preventSign = 0;
            setTimeout(function() {
              $('#loading-id').addClass('dis-none');
            }, 1000);
          }
        })
      }
}