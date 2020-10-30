<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Rezervace - administrace</title>
    <meta name="author" content="Martin Opravil">
    <meta name="description" content="Rezervační systém">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="media/css/styles.css">
    <link href="media/fontawesome/css/all.min.css" rel="stylesheet">
  </head>

  <body>
    <div id="wrong_login" class="popupform">
        <form class="content contenterror animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Nejste přihlášen/a.</h2>
                <a href="index.php"><span class="close" title="Zavřít">&times;</span></a>
            </div>
        </form>
    </div>
    <div id="wrong_code" class="popupform">
        <form class="content contenterror animate" action="" method="post">
            <div class="imgcontainer">
                <h2>K zadanému kódu neexistují žádná místa.</h2>
                <span onclick="document.getElementById('wrong_code').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <div id="right_code" class="popupform">
        <form class="content contentsuccess animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Sedadla úspěšně aktualizována.</h2>
                <span>K zaplacení: <span id="to_pay">0</span> Kč</span>
                <span onclick="document.getElementById('right_code').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <div id="table_added" class="popupform">
        <form class="content contentsuccess animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Nový stůl úspěšně vložen.</h2>
                <span onclick="document.getElementById('table_added').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <div id="table_updated" class="popupform">
        <form class="content contentsuccess animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Stůl úspěšně aktualizován.</h2>
                <span onclick="document.getElementById('table_updated').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <div id="table_erased" class="popupform">
        <form class="content contentsuccess animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Stůl byl úspěšně smazán.</h2>
                <span onclick="document.getElementById('table_erased').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>

    <?php
        session_name ("aplikaceples");
        session_start();
        // Zkontrolování přihlášení
        if (isset($_SESSION['id']) && isset($_SESSION['nick'])) {
            // Zadávání kódu
            if (isset($_SESSION['code_error'])) {
                if ($_SESSION['code_error'] == true) {
                    ?>
                    <script>
                        //console.log("Špatný kód");
                        document.getElementById('wrong_code').style.display='flex';
                    </script>
                    <?php
                } else if ($_SESSION['code_error'] == false) {
                    $quantity = $_SESSION['code_seat_quantity'];
                    ?>
                    <script>
                        const cena = 150;
                        let quantity = <?php echo json_encode($quantity) ?>;
                        let zaplatit = cena * quantity;
                        //console.log("Spravný kód - " + zaplatit);
                        document.getElementById('to_pay').innerHTML = zaplatit;
                        document.getElementById('right_code').style.display='flex';
                    </script>
                    <?php
                }
                $_SESSION['code_error'] = NULL;
            }
            // Přidání stolu
            if (isset($_SESSION['table_add_error'])) {
                if ($_SESSION['table_add_error'] == false) {
                    ?>
                    <script>
                        //console.log("Stůl přidán.");
                        document.getElementById('table_added').style.display='flex';
                    </script>
                    <?php
                }
                $_SESSION['table_add_error'] = NULL;
            }
            // Aktualizace stolu
            if (isset($_SESSION['table_update_error'])) {
                ?>
                    <script>
                        //console.log("UPDATE MSG");
                    </script>
                <?php
                if ($_SESSION['table_update_error'] == "aktualizovat") {
                    ?>
                    <script>
                        //console.log("Stůl aktualizován.");
                        document.getElementById('table_updated').style.display='flex';
                    </script>
                    <?php
                } else if ($_SESSION['table_update_error'] == "odstranit") {
                    ?>
                    <script>
                        //console.log("Stůl smazán.");
                        document.getElementById('table_erased').style.display='flex';
                    </script>
                    <?php
                }
                $_SESSION['table_update_error'] = NULL;
            }
    ?>
    
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

    <div id="menu-container">
        <div id="menu-save-container">
            <form id="save_form" action="components/admin/save.php" method="post" onsubmit="save_this()">
                <input type="hidden" id="data_graphic" name="data_graphic" value="">
                <input type="hidden" id="data_tables" name="data_tables" value="">
                <input type="hidden" id="data_seats" name="data_seats" value="">
                <button id="save_submit" type="submit" class="save-button" name="save"><i class="fas fa-save" style="margin-right: 10px;"></i>Uložit</button>
            </form>
        </div>
        <div id="menu-control-container">
            <label class="menu" onclick="document.getElementById('password-form-container').style.display='flex';">
                <input type="radio" name="mode-add" id="menu-input-password" class="radio-button-input">
                <i class="fas fa-keyboard"></i>
            </label>
            <label class="menu" onclick="document.getElementById('add-form-container').style.display='flex';">
                <input type="radio" name="mode-add" id="menu-add" class="radio-button-input">
                <i class="fas fa-plus-square"></i>
            </label>
            <div class="headerDivider"></div>
            <label class="menu">
                <input type="radio" name="mode" id="menu-state" class="radio-button" value="state">
                <i class="fas fa-toggle-on"></i>
            </label>
            <label class="menu">
                <input type="radio" name="mode" id="menu-edit" class="radio-button" value="edit">
                <i class="fas fa-pen-square"></i>
            </label>
            <label class="menu">
                <input type="radio" name="mode" id="menu-move" class="radio-button" value="move">
                <i class="fas fa-arrows-alt"></i>
            </label>
            <div class="headerDivider"></div>
            <label class="menu">
                <a href="components/_access/logout.php"><i class="fas fa-sign-out-alt"></i></a>
            </label>
        </div>
    </div>

    <div class="help-container-description">
        <div>Obsazenost</div>
        <div>Legenda</div>
    </div>

    <div id="help-container-row">

        <div id="info" class="info">
            <ul>
                <li style="color: white;">
                    <span id="output-all" class="output">
                        0
                    </span>
                    <span>
                        - Počet míst
                    </span>
                </li>
                <li style="color: #79B772;">
                    <span id="output-free" class="output">
                        0
                    </span>
                    <span>
                        - volných
                    </span>
                </li>
                <li style="color: #F7F052;">
                    <span id="output-reserved" class="output">
                        0
                    </span>
                    <span>
                        - rezervovaných
                    </span>
                </li>
                <li style="color: #FB4D3D;">
                    <span id="output-bought" class="output">
                        0
                    </span>
                    <span>
                        - zaplacených
                    </span>
                </li>
            </ul>
        </div>
        <div class="help-container">
            <a id="info-toggle" href="#" onclick="toggleInfo()">
                <i class="fas fa-info-circle"></i>
            </a>
            <!--<p id="output">Počet míst:</p>-->
        </div>

        <div id="help" class="help">
            <ul>
                <li>
                    <span>Vkládání kódu</span>
                    <i class="fas fa-keyboard"></i>
                </li>
                <li>
                    <span>Přidání stolu</span>
                    <i class="fas fa-plus-square"></i>
                </li>
                <li>
                    <span>Rychlá změna stavu</span>
                    <i class="fas fa-toggle-on"></i>
                </li>
                <li>
                    <span>Editace stolu</span>
                    <i class="fas fa-pen-square"></i>
                </li>
                <li>
                    <span>Pohyb stolem</span>
                    <i class="fas fa-arrows-alt"></i>
                </li>
                <li>
                    <span>Odhlášení</span>
                    <i class="fas fa-sign-out-alt"></i>
                </li>
                <li>
                    <span></span>
                    <div class="helpDivider"></div>
                </li>
                <li>
                    <span>Vchod/Východ</span>
                    <i class="fas fa-door-open"></i>
                </li>
                <li>
                    <span>Tombola</span>
                    <i class="fas fa-ticket-alt"></i>
                </li>
                <li>
                    <span>Pódium</span>
                    <i class="fas fa-theater-masks"></i>
                </li>
                <li>
                    <span>Jídlo</span>
                    <i class="fas fa-utensils"></i>
                </li>
                <li>
                    <span>Pití</span>
                    <i class="fas fa-wine-glass"></i>
                </li>
                <li>
                    <span>Kapela</span>
                    <i class="fas fa-guitar"></i>
                </li>
                <li>
                    <span>Bar</span>
                    <i class="fas fa-beer"></i>
                </li>
                <li>
                    <span>Taneční prostor</span>
                    <i class="fas fa-walking"><i class="fas fa-music"></i></i>
                </li>
            </ul>
        </div>
        <div class="help-container">
            <a id="help-toggle" href="#" onclick="toggleHelp()">
                <i class="fas fa-question-circle"></i>
            </a>
        </div>
    </div>

    <!-- Plátna tělocvičen -->
    <div class="slideshow-container">
        <div id="canvas-container">
            <div id="gymA" class="canvas" style="width: 850px; height: 600px;"></div>
            <div id="gymB" class="canvas" style="width: 850px; height: 600px;"></div>
            <div id="gymC" class="canvas" style="width: 800px; height: 450px;"></div>
        </div>
        <div class="mySlides fade">
            <div class="text">A - parketová tělocvična</div>
        </div>
        <div class="mySlides fade">
            <div class="text">B - japexová tělocvična</div>
        </div>
        <div class="mySlides fade">
            <div class="text" style="margin-top:35px;">C - malá tělocvična</div>
        </div>
        <!-- Tlačítka na přepínání -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(+1)">&#10095;</a>
    </div>

    <!-- Tečky přepínače -->
    <div style="text-align:center" class="dot-container">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>

    <div id="add-form-container" class="popupform">
        <form class="content animate" action="components/admin/add_table.php" method="post">

            <div class="imgcontainer">
                <h1>Přidat stůl</h1>
                <span onclick="closeForm()" class="close" title="Zavřít okno">&times;</span>
            </div>

            <div class="order-form">
                <div class="container-input">
                    <i class="fas fa-chair"></i>
                    <label>Počet míst:</label>
                    <select class="add-select" name="count">
                        <option value="2">2</option>
                        <option value="4">4</option>
                        <option value="6">6</option>
                        <option value="8">8</option>
                        <option value="10">10</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="container-input">
                    <i class="fas fa-layer-group"></i>
                    <label>Tělocvična:</label>
                    <select class="add-select" name="canvas">
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                    </select>
                </div>
                <div class="container-input">
                    <i class="fas fa-sync-alt"></i>
                    <label>Natočení:</label>
                    <select class="add-direction" name="direction">
                        <option value="T">Nahoru</option>
                        <option value="D">Dolů</option>
                        <option value="L">Doleva</option>
                        <option value="R">Doprava</option>
                    </select>
                </div>
                <div class="container-input">
                    <i class="fas fa-tag"></i>
                    <label>Číslo stolu:</label>
                    <input type="number" name="number" required>
                </div>

                <button class="submit-button" type="submit" name="add-table"><i class="fas fa-plus-square" style="margin-right: 10px;"></i>Přidat</button>
            </div>
        </form>
    </div>

    <div id="update-form-container" class="popupform">
        <form class="content animate" action="components/admin/update_table.php" method="post">

            <div class="imgcontainer">
                <h1>Úprava stolu</h1>
                <span onclick="closeForm()" class="close" title="Zavřít okno">&times;</span>
            </div>

            <div class="order-form">
                <label><b>Sedadla:</b></label>
                <div id="order-form-seats"></div>
                <div style="padding-top: 20px;"><div id="add-button" onclick="addRow();"><span class="row-span">+</span></div></div>
                <br><br>
                <div class="container-inputs">
                    <div class="container-input">
                        <i class="fas fa-sync-alt"></i>
                        <label><b>Natočení:</b></label>
                        <select class="add-direction" name="direction">
                            <option value="T">Nahoru</option>
                            <option value="D">Dolů</option>
                            <option value="L">Doleva</option>
                            <option value="R">Doprava</option>
                        </select>
                    </div>
                    <div class="container-input">
                        <i class="fas fa-tag"></i>
                        <label><b>Číslo stolu:</b></label>
                        <input type="number" name="number" style="width:50px;" required>
                    </div>
                    <div class="container-input">
                        <i class="fas fa-layer-group"></i>
                        <label><b>Tělocvična:</b></label>
                        <select class="add-select" name="canvas" style="width:50px;">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="data_table_id" value="">
                <br><br><br>
                <button class="submit-button" type="submit" name="update-table"><i class="fas fa-pen-square" style="margin-right: 10px;"></i>Aktualizovat</button>
            </div>
        </form>
    </div>

    <div id="password-form-container" class="popupform">
        <form class="content animate" action="components/admin/code_check.php" method="post">

            <div class="imgcontainer">
                <h1>Zadejte kód</h1>
                <span onclick="closeForm()" class="close" title="Zavřít okno">&times;</span>
            </div>

            <div class="order-form">
                <br>
                <input type="text" name="code" placeholder="- - - -" maxlength="4" style="width:150px; text-align: center; font-size:large;border: 1px solid #345995;" required>
                <br><br><br>
                <button class="submit-button" type="submit" name="code_submit"><i class="fas fa-keyboard" style="margin-right: 10px;"></i>Potvrdit</button>
            </div>
        </form>
    </div>
    <?php
        include("components/_access/mysqli_connect.php");

        // Grafika
        class graphic
        {
            public $id;
            public $x;
            public $y;
            public $width;
            public $height;
            public $icon;
            public $canvas;
            
            function __construct($id,$x,$y,$width,$height,$icon,$canvas)
            {
                $this->id = $id;
                $this->x = $x;
                $this->y = $y;
                $this->width = $width;
                $this->height = $height;
                $this->icon = $icon;
                $this->canvas = $canvas;
            }
        }

        $grafika = [];  // Drží objekty pro grafiku

        // GRAFIKA
        $sql = "SELECT * FROM grafika";
        mysqli_query($link,$sql);
   
        if($vysledek = mysqli_query($link,$sql)) {
            while ($radek = mysqli_fetch_assoc($vysledek)) {
                // Vytvoř objekt grafiky
                $graphic = new graphic($radek["id"],$radek["x"],$radek["y"],
                                $radek["width"],$radek["height"],
                                $radek["icon"],$radek["canvas"]);
                array_push($grafika, $graphic);
            }
        } else { 
            echo mysqli_error($link); 
        }

        // STOLY
        class table
        {
            public $id;
            public $x;
            public $y;
            public $direction;
            public $canvas;
            public $number;
            
            function __construct($id,$x,$y,$direction,$canvas,$number)
            {
                $this->id = $id;
                $this->x = $x;
                $this->y = $y;
                $this->direction = $direction;
                $this->canvas = $canvas;
                $this->number = $number;
            }
        }

        $stoly = [];  // Drží objekty pro stoly

        // STOLY
        $sql = "SELECT * FROM stoly";
        mysqli_query($link,$sql);
   
        if($vysledek = mysqli_query($link,$sql)) {
            while ($radek = mysqli_fetch_assoc($vysledek)) {
                // Vytvoř objekt grafiky
                $table = new table($radek["id"],$radek["x"],$radek["y"],
                                $radek["direction"],$radek["canvas"],
                                $radek["number"]);
                array_push($stoly, $table);
            }
        } else { 
            echo mysqli_error($link); 
        }

        // SEDADLA
        class seat
        {
            public $id;
            public $state;
            public $name;
            public $email;
            public $order_date;
            public $table_id;
            
            function __construct($id,$state,$name,$email,$order_date,$table_id)
            {
                $this->id = $id;
                $this->state = $state;
                $this->name = $name;
                $this->email = $email;
                $this->order_date = $order_date;
                $this->table_id = $table_id;
            }
        }

        $sedadla = [];  // Drží objekty pro sedadla

        // STOLY
        $sql = "SELECT * FROM sedadla ORDER BY id";
        mysqli_query($link,$sql);
   
        if($vysledek = mysqli_query($link,$sql)) {
            while ($radek = mysqli_fetch_assoc($vysledek)) {
                // Vytvoř objekt grafiky
                $seat = new seat($radek["id"],$radek["state"],$radek["name"],
                                $radek["email"],$radek["order_date"],
                                $radek["table_id"]);
                array_push($sedadla, $seat);
            }
        } else { 
            echo mysqli_error($link); 
        }
    ?>

    <script>
        // Uložit vše do Save buttonu
        function save_this() {
            generate_list_of_graphics();
            generate_list_of_tables();
            generate_list_of_seats();
        }
        // Přepínej obsazenost
        function toggleInfo() {
            $(document.getElementById("info")).slideToggle();
        }
        // Přepínej legendu
        function toggleHelp() {
            $(document.getElementById("help")).slideToggle();
        }
        
        function closeForm() {
            document.getElementById('add-form-container').style.display='none';
            document.getElementById('menu-add').checked = false;
            document.getElementById('update-form-container').style.display='none';
            document.getElementById('menu-input-password').checked = false;
            document.getElementById('password-form-container').style.display='none';
        }

        // Přepínání režimů
        $('.radio-button').click(function() {
            // Dát cookině svoji hodnotu
            setCookie("mode", this.value, 1);
            checkModeCookie();
        });

        function switchEdit(turnon) {
            const divs = document.getElementsByClassName("edit-bg");
            if (turnon) {
                for (let i = 0; i < divs.length; i++) {
                    divs[i].style.display = "flex";
                }
            } else {
                for (let i = 0; i < divs.length; i++) {
                    divs[i].style.display = "none";
                }
            }
        }

        function switchMoveCursor(turnon) {
            const divs = document.getElementsByClassName("container-button-graphic");
            if (turnon) {
                for (let i = 0; i < divs.length; i++) {
                    divs[i].style.cursor = "move";
                }
            } else {
                for (let i = 0; i < divs.length; i++) {
                    divs[i].style.cursor = "default";
                }
            }
        }

        function switchStateCursor(turnon) {
            const divs = document.getElementsByClassName("container-seat");
            if (turnon) {
                for (let i = 0; i < divs.length; i++) {
                    divs[i].style.cursor = "pointer";
                }
            } else {
                for (let i = 0; i < divs.length; i++) {
                    divs[i].style.cursor = "default";
                }
            }
        }

        let mode = "";
        // Aktualizuj vybraný mód
        function checkModeCookie() {
            const mode_temp = getCookie("mode");
            if (mode_temp == "") {
                mode = "edit";
            } else {
                mode = mode_temp;
            }

            if (mode == "state") {
                document.getElementById("menu-state").checked = true;
                switchEdit(false);
                switchMoveCursor(false);
                switchStateCursor(true);
            } else if (mode == "edit") {
                document.getElementById("menu-edit").checked = true;
                switchEdit(true);
            } else { // move
                document.getElementById("menu-move").checked = true;
                switchEdit(false);
                switchMoveCursor(true);
                switchStateCursor(false);
            }
        }

        /* Zobrazení obsahu */
        // Převzatá pole objektů z PHP
        const grafika = <?php echo json_encode($grafika) ?>;
        const stoly = <?php echo json_encode($stoly) ?>;
        const sedadla = <?php echo json_encode($sedadla) ?>;

        const abeceda = ["A","B","C","D","E","F","G","H","I","J","K","L"];

        // Proveď
        generate_graphics();
        generate_tables();

        // Přidá do editačního okna další řádek
        function addRow(row_id, row_label, row_name, row_email, row_date, row_state) {
            const order_from_seats = document.getElementById("order-form-seats");

            const seat_container = document.createElement("DIV");
            seat_container.className = "edit-seat-row";
            const label = document.createElement("LABEL");
            //let label_insert = row_label ? row_label : "#";
            label.innerHTML = row_label ? row_label : "#";
            seat_container.appendChild(label);

            const name = document.createElement("INPUT");
            name.value = row_name ? row_name : "";
            name.placeholder = "Prázdné";
            name.name = "names[]";
            seat_container.appendChild(name);

            const email = document.createElement("INPUT");
            email.value = row_email ? row_email : "";
            email.placeholder = "Prázdné";
            email.name = "emails[]";
            seat_container.appendChild(email);

            const date = document.createElement("INPUT");
            date.setAttribute("type", "date");
            date.value = row_date;
            date.placeholder = "Prázdné";
            date.name = "dates[]";
            seat_container.appendChild(date);

            const state = document.createElement("SELECT");
            state.name = "states[]";
            let free = document.createElement("OPTION");
            free.setAttribute("value", "free");
            let text = document.createTextNode("Volné");
            free.appendChild(text);
            let reserved = document.createElement("OPTION");
            reserved.setAttribute("value", "reserved");
            text = document.createTextNode("Rezervované");
            reserved.appendChild(text);
            let bought = document.createElement("OPTION");
            bought.setAttribute("value", "bought");
            text = document.createTextNode("Zaplaceno");
            bought.appendChild(text);

            state.appendChild(free);
            state.appendChild(reserved);
            state.appendChild(bought);
            state.value = row_state ? row_state : "free";

            seat_container.appendChild(state);
            
            const id_hidden = document.createElement("INPUT");
            id_hidden.value = row_id;
            id_hidden.type = "hidden";
            id_hidden.name = "ids[]";
            seat_container.appendChild(id_hidden);

            
            const delete_container = document.createElement("DIV");
            delete_container.className = "remove-button";
            //delete_container.innerHTML = "-";
            delete_container.onclick = function() {
                if (row_id) {
                    let id_hidden = document.createElement("INPUT");
                    id_hidden.value = row_id;
                    id_hidden.type = "hidden";
                    id_hidden.name = "ids_to_remove[]";
                    order_from_seats.appendChild(id_hidden);
                }
                
                seat_container.remove();
            }

            const delete_span = document.createElement("SPAN");
            delete_span.className = "row-span";
            delete_span.innerHTML = "-";

            delete_container.appendChild(delete_span);

            seat_container.appendChild(delete_container);

            order_from_seats.appendChild(seat_container);
        }

        // Generování grafiky
        function generate_graphics() {
            const length = grafika.length;
            for (let i = 0; i < length; i++) {
                // objekt GRAPHIC
                const graphic = grafika[i];

                const container_graphic = document.createElement("DIV");
                container_graphic.className = "container-graphic";
                container_graphic.data = graphic;

                // Ikona
                const icon = document.createElement("SPAN");
                icon.innerHTML = container_graphic.data.icon;
                container_graphic.appendChild(icon);
                // Přidá grafice pozici + "px"
                let temp_x = container_graphic.data.x + "px";
                let temp_y = container_graphic.data.y + "px";
                let temp_width = container_graphic.data.width + "px";
                let temp_height = container_graphic.data.height + "px";
                container_graphic.style.left = temp_x;
                container_graphic.style.top = temp_y;
                container_graphic.style.width = temp_width;
                container_graphic.style.height = temp_height;

                // Přiřaď na správný canvas
                switch (container_graphic.data.canvas) {
                    case "A":
                        document.getElementById("gymA").appendChild(container_graphic);
                        break;
                    case "B":
                        document.getElementById("gymB").appendChild(container_graphic);
                        break;
                    case "C":
                        document.getElementById("gymC").appendChild(container_graphic);
                        break;
                }
            }
        }
        //Generování stolů
        function generate_tables() {
            const length = stoly.length;
            for (let i = 0; i < length; i++) {
                let direction = stoly[i]["direction"];
                // objekt TABLE
                const table = stoly[i];

                const container_table = document.createElement("DIV");
                container_table.className = "container-table";
                container_table.data = table;
                // Přidá stolu pozici + "px"
                let temp_x = container_table.data.x + "px";
                let temp_y = container_table.data.y + "px";
                container_table.style.left = temp_x;
                container_table.style.top = temp_y;

                // Číslo stolu
                const container_number = document.createElement("DIV");
                container_number.className = "container-button-graphic";
                const number = document.createElement("SPAN");
                number.innerHTML = container_table.data.number;
                container_number.appendChild(number);
                container_table.appendChild(container_number);

                
                // Vyfiltruje sedadla patřící tomuto stolu
                const seats = sedadla.filter(function(seat) {
                    return seat["table_id"] == container_table.data.id;
                })

                // Sedadlo
                for (let i=0; i < seats.length; i++) {
                    const container_seat = document.createElement("DIV");
                    container_seat.className = "container-seat";
                    container_seat.data = seats[i];

                    const seat_span = document.createElement("SPAN");
                    seat_span.innerHTML = abeceda[i];
                    container_seat.appendChild(seat_span);

                    // Obarvi správně tlačítko
                    switch (seats[i]["state"]) {
                        case "free":
                            container_seat.classList.add("seat-free");
                            break;
                        case "reserved":
                            container_seat.classList.add("seat-reserved");
                            break;
                        case "bought":
                            container_seat.classList.add("seat-bought");
                            break;
                    }

                    container_seat.onclick = function() {
                        if (mode == "state") {
                            // Obarvi správně tlačítko
                            if (this.classList.contains("seat-free")){
                                this.classList.add("seat-reserved");
                                this.classList.remove("seat-free");
                                this.data.state = "reserved";
                            } else if (this.classList.contains("seat-reserved")){
                                this.classList.add("seat-bought");
                                this.classList.remove("seat-reserved");
                                this.data.state = "bought";
                            } else {
                                this.classList.add("seat-free");
                                this.classList.remove("seat-bought");
                                this.data.state = "free";
                            }
                        }
                    }

                    container_table.appendChild(container_seat);
                }

                // Editace
                const edit_bg = document.createElement("DIV");
                edit_bg.className = "edit-bg";
                const icon = document.createElement("SPAN");
                icon.innerHTML = "<i class='fas fa-pen-square'></i>";
                edit_bg.appendChild(icon);

                edit_bg.onclick = function() {
                    const table = this.parentElement;
                    const table_data = table.data; //id,(direction,canvas,number)
                    const seats = table.querySelectorAll(".container-seat");
                    
                    const order_from_seats = document.getElementById("order-form-seats");
                    order_from_seats.innerHTML = "";

                    for (let i=0; i < seats.length; i++) {
                        const seat_data = seats[i].data; //id,(state,name,email, order_date)

                        let row_id = seat_data.id;
                        let row_label = seats[i].innerHTML;
                        let row_name = seat_data.name;
                        let row_email = seat_data.email;
                        let row_date = seat_data.order_date;
                        let row_state = seat_data.state;

                        addRow(row_id, row_label, row_name, row_email, row_date, row_state);
                    }
                    
                    const updateform = document.getElementById('update-form-container');
                    updateform.style.display='flex';
                    const direction = document.getElementsByName("direction")[1];
                    direction.value = table_data.direction;
                    const number = document.getElementsByName("number")[1];
                    number.value = table_data.number;
                    const canvas = document.getElementsByName("canvas")[1];
                    canvas.value = table_data.canvas;
                    const data_table_id = document.getElementsByName("data_table_id")[0];
                    data_table_id.value = table_data.id;
                }

                let size = 25 + (25 * (seats.length/2));
                if (seats.length % 2) {
                    size += 12.5;
                }
                // Přiřadí správný směr stolu
                if (direction == "T" || direction == "D") {
                    container_table.className = "container-table-TD";
                    edit_bg.style.width = "50px";
                    edit_bg.style.height = size-2 + "px";
                } else {
                    container_table.className = "container-table-LR";
                    edit_bg.style.width = size-1 + "px";
                    edit_bg.style.height = "50px";

                    container_table.style.width = size + "px";
                }

                // Podle směru přehodí číslo stolu
                if (direction == "D" || direction == "R") {
                    container_table.appendChild(container_number);
                }

                container_table.appendChild(edit_bg);

                // Přiřaď na správný canvas
                switch (container_table.data.canvas) {
                    case "A":
                        document.getElementById("gymA").appendChild(container_table);
                        break;
                    case "B":
                        document.getElementById("gymB").appendChild(container_table);
                        break;
                    case "C":
                        document.getElementById("gymC").appendChild(container_table);
                        break;
                }
            }
        }

        // Aktualizuje výpisy
        function updateOutput() {
            document.getElementById("output-all").innerHTML = document.querySelectorAll(".container-seat").length;
            document.getElementById("output-free").innerHTML = document.querySelectorAll(".seat-free").length;
            document.getElementById("output-reserved").innerHTML = document.querySelectorAll(".seat-reserved").length;
            document.getElementById("output-bought").innerHTML = document.querySelectorAll(".seat-bought").length;
        }

        /* UKLÁDÁNÍ */
        function generate_list_of_graphics() {
            const graphics = document.querySelectorAll('.container-graphic');
            let array_of_graphics = [];
            for (let i = 0; i < graphics.length; i++) {
                const graphic = graphics[i];
                const graphic_data = graphic.data;
                const position = $(graphics[i]).position();

                // Aktualizuj pozici tlačítka
                graphic_data.x = position.left;
                graphic_data.y = position.top;

                let dimensions = graphic.getBoundingClientRect();

                graphic_data.width = dimensions.width;
                graphic_data.height = dimensions.height;

                array_of_graphics.push(graphic_data);
            }

            document.getElementById("data_graphic").value = JSON.stringify(array_of_graphics);
        }
        function generate_list_of_tables() {
            const tables = document.querySelectorAll('.container-table-TD,.container-table-LR');
            let array_of_tables = [];
            for (let i = 0; i < tables.length; i++) {
                const table = tables[i];
                const table_data = table.data;
                const position = $(tables[i]).position();

                // Aktualizuj pozici stolu
                table_data.x = position.left;
                table_data.y = position.top;

                array_of_tables.push(table_data);
            }

            document.getElementById("data_tables").value = JSON.stringify(array_of_tables);
        }
        function generate_list_of_seats() {
            const seats = document.querySelectorAll('.container-seat');
            let array_of_seats = [];
            for (let i = 0; i < seats.length; i++) {
                const seat = seats[i];
                const seat_data = seat.data;

                //seat_data.state = 

                array_of_seats.push(seat_data);
            }

            document.getElementById("data_seats").value = JSON.stringify(array_of_seats);
        }

        // Načte se po načtení dokumentu
        $(document).ready(function() {
            updateOutput();
            checkModeCookie();
            generate_list_of_graphics();
            generate_list_of_tables();
            generate_list_of_seats();
        });

        // Aktivní canvas
        const active_gym_temp = getCookie("active_gym");
        let slideIndex;
        if (active_gym_temp != "") {
            slideIndex = active_gym_temp;
        } else {
            slideIndex = 1;
        }
        showSlides(slideIndex);

        // Ovládání Vpřed/Zpět kláves
        function plusSlides(n) {
            if (n > 0) {
                slideIndex++;
                showSlides(slideIndex);
            } else {
                slideIndex--;
                showSlides(slideIndex);
            }
        }
        // Ovládání spodními tlačítky
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {

            const slides = document.getElementsByClassName("mySlides");
            const dots = document.getElementsByClassName("dot");

            if (n > slides.length) {
                //console.log("Provedl jsem se! (1)");
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
                //console.log("Provedl jsem se! (LENGTH)");
            }

            const gyms = document.getElementById("canvas-container");

            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
                gyms.children[i].style.zIndex = 500;
            }
            for (let i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "flex";
            gyms.children[slideIndex - 1].style.zIndex = 600;

            dots[slideIndex - 1].className += " active";

            setCookie("active_gym", slideIndex, 1);
            //set_active_gym(slideIndex); //////////
        }

        // COOKIES
        function setCookie(cname, cvalue, exdays) {
            let d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for (let i = 0; i < ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }


        // INTERACT.JS
        // Ovládání křesel //
        interact('.container-table-TD,.container-table-LR')
            .draggable({
                origin: 'parent',
                allowFrom: '.container-button-graphic',
                cursorChecker: (action, interactable, element, interacting) => {
                    switch (action.axis) {
                    case 'x': return 'ew-resize'
                    case 'y': return 'ns-resize'
                    default: return interacting ? 'grabbing' : 'grab'
                    }
                },
                modifiers: [
                    interact.modifiers.snap({
                        targets: [
                            interact.createSnapGrid({
                                x: 25,
                                y: 25
                            })
                        ],
                        range: Infinity,
                        //
                        relativePoints: [{
                            x: 0,
                            y: 0
                        }]
                        //
                    }),
                    // omezení pohybu na parenta
                    interact.modifiers.restrictRect({
                        restriction: 'parent'
                    }),

                ],

                // enable inertial throwing
                inertia: false,
                
                // enable autoScroll
                autoScroll: false,
                // call this function on every dragmove event
                onmove: dragMoveListener,
            })

        interact('.container-graphic')
            .draggable({
                origin: 'parent',
                modifiers: [
                    interact.modifiers.snap({
                        targets: [
                            interact.createSnapGrid({
                                x: 25,
                                y: 25
                            })
                        ],
                        range: Infinity,
                        relativePoints: [{
                            x: 0,
                            y: 0
                        }]
                    }),
                    // omezení pohybu na parenta
                    interact.modifiers.restrictRect({
                        restriction: 'parent'
                    }),

                ],

                // enable inertial throwing
                inertia: false,
                // keep the element within the area of it's parent
                restrict: {
                    restriction: "parent",
                    endOnly: true,
                    elementRect: {
                        top: 0,
                        left: 0,
                        bottom: 1,
                        right: 1
                    }
                },

                // enable autoScroll
                autoScroll: false,
                // call this function on every dragmove event
                onmove: dragMoveListener,
            })

            .resizable({
                /*origin: 'parent',*/
                // resize from all edges and corners
                edges: {
                    left: true,
                    right: true,
                    bottom: true,
                    top: true
                },
                modifiers: [
                    // minimum size
                    interact.modifiers.restrictSize({
                        min: {
                            width: 25,
                            height: 25
                        }
                    }),
                    // Snapování
                    interact.modifiers.snapSize({
                        targets: [{
                                width: 25
                            },
                            interact.createSnapGrid({
                                width: 25,
                                height: 25
                            })
                        ]
                    }),
                    // omezení pohybu na parenta
                    interact.modifiers.restrictRect({
                        restriction: 'parent'
                    })
                ],

                inertia: false
            })
            .on('resizemove', function(event) {
                if (mode == "move") {
                    let target = event.target
                    let x = (parseFloat(target.getAttribute('data-x')) || 0)
                    let y = (parseFloat(target.getAttribute('data-y')) || 0)

                    // update the element's style
                    target.style.width = event.rect.width + 'px'
                    target.style.height = event.rect.height + 'px'

                    // translate when resizing from top or left edges
                    x += event.deltaRect.left
                    y += event.deltaRect.top

                    target.style.webkitTransform = target.style.transform =
                        'translate(' + x + 'px,' + y + 'px)'

                    target.setAttribute('data-x', x)
                    target.setAttribute('data-y', y)
                    /*
                    target.textContent = Math.round(event.rect.width) + '\u00D7' + Math.round(event.rect.height)
                    */
                }
            })

            function dragMoveListener(event) {
            if (mode == "move") {
                let target = event.target,
                    // keep the dragged position in the data-x/data-y attributes
                    x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                    y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

                // translate the element
                target.style.webkitTransform =
                    target.style.transform =
                    'translate(' + x + 'px, ' + y + 'px)';

                // update the posiion attributes
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            }
        }
        interact('.container-button-graphic').styleCursor(false);
    </script>

    <?php
        } else {
    ?>
            <script>
                //console.log("Nejste přihlášen/a.");
                document.getElementById('wrong_login').style.display='flex';
            </script>
    <?php
        }
    ?>
  </body>
</html>