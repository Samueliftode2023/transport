<form id='fisa-raport'>
    <div id='id-fisa'>
        Fisa numarul: <?php create_table_raport($conectareDB);?>
    </div>
    <div>
        <?php
            create_select($obj_vehicule, $conectareDB); 
        ?>
    </div>

    <div id='cotnainer-raport'>
        <div id='sectiune-date'>
            <h2>Date</h2>
            <?php
                create_labels($obj_deplasare);
            ?>
        </div>

        <div id='sectiune-documente'>
            <h2>Documente</h2>
            <?php
                create_labels($obj_document);  
            ?>
        </div>

        <div id='tur'>
            <h2>Tur 0</h2>
            <div id='sageti-tur' class='derulare-sageti'>
                <?php google_icons(['arrow_circle_left','arrow_circle_right']); ?>
            </div>
            <div class='linii'>
                <div id='tur-linie-0' class='linie'>
                    <label class='default-label'>
                        Incarcare / descarcare:
                        <select id='tur-actiune-0' name='tur-actiune-0'>
                            <option value='0'>...</option>  
                            <option value='incarcare'>Incarcare</option>
                            <option value='descarcare'>descarcare</option>
                        </select>
                    </label>

                    <label class='default-label'>
                        Nume firma:
                        <input id='tur-nume-firma-0' name='tur-nume-firma-0'>
                    </label>

                    <label class='default-label'>
                        Localitatea:
                        <input id='tur-nume-localitate-0' name='tur-nume-localitate-0'>
                    </label>

                    <label class='default-label'>
                        Observatii:
                        <input id='tur-observatii-0' name='tur-observatii-0'>
                    </label>
                </div>
            </div>
        </div>

        <div id='retur'>
            <h2>Retur 0</h2>
            <div id='sageti-retur' class='derulare-sageti'>
                <?php google_icons(['arrow_circle_left','arrow_circle_right']); ?>
            </div>
            <div class='linii'>
                <div id='retur-linie-0' class='linie'>
                    <label class='default-label'>
                        Incarcare / descarcare:
                        <select id='retur-actiune-0' name='retur-actiune-0'>
                            <option value='0'>...</option>  
                            <option value='incarcare'>Incarcare</option>
                            <option value='descarcare'>descarcare</option>
                        </select>
                    </label>

                    <label class='default-label'>
                        Nume firma:
                        <input id='retur-nume-firma-0' name='retur-nume-firma-0'>
                    </label>

                    <label class='default-label'>
                        Localitatea:
                        <input id='retur-nume-localitate-0' name='retur-nume-localitate-0'>
                    </label>

                    <label class='default-label'>
                        Observatii:
                        <input id='retur-observatii-0' name='retur-observatii-0'>
                    </label>
                </div>
            </div>
        </div>    

        <div id='combustibil'>
            <h2>Combustibil 0</h2>
            <div id='sageti-alimenare' class='derulare-sageti'>
                <?php google_icons(['arrow_circle_left','arrow_circle_right']); ?>
            </div>
            <div class='linii'>
                <div id='combustibil-linie-0' class='linie'>
                    <?php
                        create_labels($obj_alimentare);  
                    ?>
                </div>
            </div>        
        </div>

    </div>
    <button>Salveaza</button>    
</form>