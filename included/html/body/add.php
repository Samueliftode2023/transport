<div id='container-adaugare'>
    <form id='vehicul-date' class='pos-rel centrare-x-y'>
        <h2>Adauga un vehicul</h2>
        <label class='default-label'>
            <div>Vehicul</div>
            <select id="categorie-vehicule" name="categorie-vehicule">
                <option value="NEDEFINITĂ">Nedefinit</option>

                <optgroup label="Categorii principale">
                    <option value="Motocicletă (A)">Motocicletă (A)</option>
                    <option value="Autoturism (B)">Autoturism (B)</option>
                    <option value="Autocamion (C)">Autocamion (C)</option>
                    <option value="Autobuz (D)">Autobuz (D)</option>
                    <option value="Autoturism cu remorcă (BE)">Autoturism cu remorcă (BE)</option>
                    <option value="Autocamion cu remorcă (CE)">Autocamion cu remorcă (CE)</option>
                    <option value="Autobuz cu remorcă (DE)">Autobuz cu remorcă (DE)</option>
                </optgroup>

                <optgroup label="Subcategorii">
                    <option value="Motocicletă ușoară (A1)">Motocicletă ușoară (A1)</option>
                    <option value="Quadriciclu (B1">Quadriciclu (B1)</option>
                    <option value="Camion ușor (C1)">Camion ușor (C1)</option>
                    <option value="Microbuz (D1)">Microbuz (D1)</option>
                    <option value="Camion ușor cu remorcă (C1E)">Camion ușor cu remorcă (C1E)</option>
                    <option value="Microbuz cu remorcă (D1E)">Microbuz cu remorcă (D1E)</option>
                </optgroup>
            </select>
        </label>
        <label class='default-label'>
            <div>Vechime vehicul</div>
            <select id='vechime-masina' name='vechime-masina'>
                <option value="NEDEFINITĂ">Nedefinit</option>
                <option value="între 0 și 3 ani">între 0 și 3 ani</option>
                <option value="între 4 și 12 ani">între 4 și 12 ani</option>
                <option value="mai mult de 12 ani">mai mult de 12 ani</option>
            </select>
        </label>
        <label class='default-label'>
            <div>Tipul de transport:</div>
            <select id="tip-transport" name="tip-transport">
                <option value="NEDEFINITĂ">Nedefinit</option>
                <option value="Taxi">Taxi</option>
                <option value="Școală de șoferi">Școală de șoferi</option>
                <option value="Transport marfă">Transport marfă</option>
                <option value="Transport persoane">Transport persoane</option>
                <option value="Transport public">Transport public</option>
                <option value="Vehicul personal">Vehicul personal</option>
            </select>
        </label>
        <?php
            create_labels($obj_labels);
        ?>
        <button class='pos-rel centrare-x'>Adauga</button>
    </form>
    <div id='table-vehicule' class='pos-rel centrare-x-y'>
        <div id='cap-tabel'>
            <div class="celula">numar</div>
            <div class="celula">categorie</div>
            <div class="celula">vechime</div>
            <div class="celula">transport</div>
            <div class="celula">asigurare</div>
            <div class="celula">inspectie</div>
            <div class="celula">vigneta</div>
            <div class="celula">km</div>
            <div class="celula">schimb ulei</div>
            <div class="celula">pret(€)</div>
        </div>
        <div id='continut-tabel'></div>
    </div>
</div>

<div id='panou-editare' class='dis-none'>
    <div class='close-button' onclick='closePanel()' >
        <span class="material-symbols-outlined">
            close
        </span>
    </div>
    <form id='panel-input' class='pos-abs centrare-x-y'></form>
</div>

<form id='delete-vehicul' class='dis-none'>
    Dorest sa stergi acest vehicul?
    <br>
    <input type='hidden' name='id-delete' id='delete-id'>
    <br>
    <div class='org-butons'>
        <div onclick='sendDelete()' class='sterge-sterge'>Da</div>
        <div onclick='closeDelete()' class='close-close'>Nu</div>
    </div>
</form>