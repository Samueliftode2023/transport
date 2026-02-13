var preventIndexare = 0;
var nrIndex = {
    'tur': 0,
    'retur': 0,
    'combustibil': 0
}

function creeazaLinie(parinte, nrIndex) {

    var index = nrIndex[parinte];

    var html = `
        <div id="${parinte}-linie-${index}" class="linie">
            <label class="default-label">
                Incarcare / descarcare:
                <select id="${parinte}-actiune-${index}" name="${parinte}-actiune-${index}">
                    <option value='0'>...</option>
                    <option value="incarcare">Incarcare</option>
                    <option value="descarcare">Descarcare</option>
                </select>
            </label>

            <label class="default-label">
                Nume firma:
                <input id="${parinte}-nume-firma-${index}" name="${parinte}-nume-firma-${index}">
            </label>

            <label class="default-label">
                Localitatea:
                <input id="${parinte}-nume-localitate-${index}" name="${parinte}-nume-localitate-${index}">
            </label>

            <label class="default-label">
                Observatii:
                <input id="${parinte}-observatii-${index}" name="${parinte}-observatii-${index}">
            </label>
        </div>
    `;

    $("#" + parinte + ' .linii').append(html);
}

function creeazaLinieAlimentare(parinte, nrIndex) {
    var index = nrIndex[parinte];

    var html = `
        <div id="${parinte}-linie-${index}" class="linie">
            <label class="default-label">
                <div>Localitate</div>
                <input id="localitate-alimentare-${index}" type="text" name="localitate-alimentare-${index}">
            </label>
            <label class="default-label">
                <div>Data alimentarii</div>
                <input id="data-alimentare-${index}" type="date" name="data-alimentare-${index}">
            </label>
            <label class="default-label">
                <div>Kilometraj</div>
                <input value='0' min='0' id="km-alimentare-${index}" type="number" name="km-alimentare-${index}">
            </label>
            <label class="default-label">
                <div>Litri</div>
                <input value='0' min='0' id="litri-alimentare-${index}" type="number" name="litri-alimentare-${index}">
            </label>
            <label class="default-label">
                <div>Observatii</div>
                <input id="observatii-alimentare-${index}" type="text" name="observatii-alimentare-${index}">
            </label>
        </div>
    `;

    $("#" + parinte + ' .linii').append(html);
}


function primaLiteraMare(text) {
    if (!text) return '';
    return text.charAt(0).toUpperCase() + text.slice(1);
}

$(document).ready(function () {
    $('.derulare-sageti span').on('click', function() {
        if(preventIndexare == 0){
            preventIndexare = 1
            var parinte = $(this).parent().parent().attr('id');
            var spanDirectie = $(this).index();

            if(spanDirectie == 0 && nrIndex[parinte] > 0){
                $('#' + parinte + '-linie-' + nrIndex[parinte]).addClass('dis-none')
                nrIndex[parinte]--
                $("#" + parinte + ' h2').html(primaLiteraMare(parinte) + ' ' + nrIndex[parinte])
                $('#' + parinte + '-linie-' + nrIndex[parinte]).removeClass('dis-none')
            }
            else if(spanDirectie == 1 && nrIndex[parinte] < 30){
                $("#" + parinte + ' .linie').addClass('dis-none')
                nrIndex[parinte]++
                $("#" + parinte + ' h2').html(primaLiteraMare(parinte) + ' ' + nrIndex[parinte])

                if(!$('#' + parinte + '-linie-' + nrIndex[parinte]).length){
                    if(parinte == 'tur' || parinte == 'retur'){
                        creeazaLinie(parinte, nrIndex)
                    }
                    else if(parinte == 'combustibil'){
                        creeazaLinieAlimentare(parinte, nrIndex)
                    }
                }
                else{
                    $('#' + parinte + '-linie-' + nrIndex[parinte]).removeClass('dis-none')
                }
            }
            preventIndexare = 0
        }
    });
    $('#fisa-raport').off('submit').on('submit', function (event) {
        if (preventSign == 0) {
            $('#loading-id').removeClass('dis-none')
            preventSign = 1
            event.preventDefault();

            var formData = new FormData(this);
            $.ajax({
            type: "POST",
            url: "../../../included/function/exe/raport.php",
            data: formData,
            contentType: false,
            processData: false,
                    
            success: function (result) {
                result = result.trim()
                if(result === 'ok'){
                    location.reload()
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
})