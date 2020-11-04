<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <title>Rezervace</title>
    <meta name="author" content="Martin Opravil">
    <meta name="description" content="Rezervační systém">
    <link rel="shortcut icon" type="image/x-icon" href="./assets/favicon.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="media/css/styles.css">
    <link href="media/fontawesome/css/all.min.css" rel="stylesheet">
  </head>

  <body>
    <div id="infographic" class="popupform">
        <form class="content infographics animate" action="" method="post">
            <div class="imgcontainer">
                <img src="media/img/Infografika.PNG" alt="Infografika">
                <span onclick="document.getElementById('infographic').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <div id="order_success" class="popupform">
        <form class="content contentsuccess animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Vaše objednávka proběhla v pořádku.</h2>
                <p>Prosíme, zkontrolujte si v emailu složku SPAM, odeslaný email se může nacházet právě tam.<br><br>Děkujeme.</p>
                <span onclick="document.getElementById('order_success').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <div id="order_failed" class="popupform">
        <form class="content contenterror animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Objednání se nezdařilo.</h2>
                <p>Pravděpodobně vám někdo během objednávání, některé z vašich vybraných míst právě obsadil.<br>Omlouváme se za tuto nepříjemnost. Vyberte si prosím znovu.<br><br>Děkujeme za pochopení.</p>
                <span onclick="document.getElementById('order_failed').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <div id="order_failed_empty" class="popupform">
        <form class="content contenterror animate" action="" method="post">
            <div class="imgcontainer">
                <h2>Objednání se nezdařilo.</h2>
                <p>Pravděpodobně jste si nevybrali ani jedno místo.</p>
                <span onclick="document.getElementById('order_failed_empty').style.display='none'" class="close" title="Zavřít">&times;</span>
            </div>
        </form>
    </div>
    <?php
        session_name ("aplikaceples");
        session_start();
        // Potvrzení objednání
        if (isset($_SESSION['ordered'])) {
            if ($_SESSION['ordered'] == true) {
                ?>
                    <script>
                        //console.log("Úspěšně objednáno.");
                        document.getElementById('order_success').style.display='flex';
                    </script>
                <?php
            } else if ($_SESSION['ordered'] == false) {
                ?>
                    <script>
                        //console.log("Chyba při objednání.");
                        document.getElementById('order_failed').style.display='flex';
                    </script>
                <?php
            }
            $_SESSION['ordered'] = NULL;
        }
        if (isset($_SESSION['empty'])) {
            if ($_SESSION['empty'] == true) {
                ?>
                    <script>
                        console.log("Chyba při objednání - prázdné.");
                        document.getElementById('order_failed_empty').style.display='flex';
                    </script>
                <?php
            }
            $_SESSION['empty'] = NULL;
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>

    <div class="help-container-description">
        <div>Obsazenost</div>
        <div style="display:flex;">
        <button id="order_window_button" class="order-button" onclick="order();document.getElementById('popupform').style.display='flex'" style="width:auto;"><i class="fas fa-shopping-cart" style="margin-right: 10px;"></i> Objednat</button>
        </div>
        <div>Legenda</div>
    </div>

    <div id="help-container-row">

        <div id="info" class="info guest-margin-top">
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
                <li>
                    <div class="helpDivider" style="margin-left: 0px;"></div>
                </li>
                <li>
                    <span class="output" style="text-align:center;width: 100%;">
                        Povoleno objednat
                    </span>
                </li>
                <li style="color: #FB4D3D;">
                    <span class="output" style="text-align:center;width: 100%;">
                        max 4 místa/osobu
                    </span>
                </li>
                <li>
                    <div class="helpDivider" style="margin-left: 0px;"></div>
                </li>
                <li>
                    <div class="output" style="text-align:center;">
                        V případě zájmu o více míst, volejte prosím na: <br> <div style="color: #79B772;margin-top: 5px;">654 123 457</div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="help-container guest-margin-top">
            <a id="info-toggle" href="#" onclick="toggleInfo()">
                <i class="fas fa-info-circle"></i>
            </a>
            <!--<p id="output">Počet míst:</p>-->
        </div>
        <div style="display:flex;">
            <div id="help_with_order" onclick="document.getElementById('infographic').style.display='flex';">Jak objednat?</div>
        </div>
        <div id="help" class="help guest-margin-top">
            <ul>
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
        <div class="help-container guest-margin-top">
            <a id="help-toggle" href="#" onclick="toggleHelp()">
                <i class="fas fa-question-circle"></i>
            </a>
        </div>
    </div>

    <div id="popupform" class="orderform">
        <form class="content animate" action="components/guest/order.php" method="post">

            <div class="imgcontainer">
                <h1>Objednávka</h1> 
                <span onclick="document.getElementById('popupform').style.display='none'" class="close" title="Zavřít okno">&times;</span>
            </div>

            <div class="order-form">
                <div class="order-grid">
                    <div class="first-col">
                        <label><b>Jméno</b></label>
                        <input type="text" placeholder="Jan Novák" name="name" required>
                        <label><b>Email</b></label>
                        <input type="email" placeholder="jan.novak@seznam.cz" name="email" required>
                        <br><br><br>
                        <button id="submit-button" type="submit" name="order"><i class="fas fa-shopping-cart" style="margin-right: 10px;"></i>Závazně objednat</button>   
                    </div>
                
                    <div class="second-col">
                        <label><b>Vybraná místa:</b></label>
                        <br>
                        <div id="order-form-seats"></div>
                        <br><br>
                        
                        <a title="Davidgothberg / Public domain" href="https://commons.wikimedia.org/wiki/File:Ballroom.svg"><img width="128" alt="Ballroom" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5a/Ballroom.svg/128px-Ballroom.svg.png"></a>
                    </div>
                </div>
            </div>
        </form>
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

    <!-- Spodní přepínač -->
    <div class="dot-container" style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
    </div>

    <?php
        include("components/_access/mysqli_connect.php");
        include("settings/settings.php");

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

        // Zobraz obsazenost
        const showOccupancy = getCookie("showOccupancy");
        if (showOccupancy == "" || showOccupancy == "true") {
            $(document.getElementById("info")).slideToggle();
        }

        // Přepínej obsazenost
        function toggleInfo() {
            const showOccupancy = getCookie("showOccupancy");
            if (showOccupancy == "" || showOccupancy == "true") {
                setCookie("showOccupancy", "false", 1);
                $(document.getElementById("info")).slideToggle();
            } else {
                setCookie("showOccupancy", "true", 1);
                $(document.getElementById("info")).slideToggle();
            }
        }

        // Přepínej legendu
        function toggleHelp() {
            $(document.getElementById("help")).slideToggle();
        }

        // Vyskakovací okno
        const popupwindow = document.getElementById('popupform');
        window.onclick = function(event) {
            if (event.target == popupwindow) {
                popupwindow.style.display = "none";
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
                const direction = stoly[i]["direction"];
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
                const icon = document.createElement("SPAN");
                icon.innerHTML = container_table.data.number;
                container_number.appendChild(icon);
                container_table.appendChild(container_number);

                // Vyfiltruje sedadla patřící tomuto stolu
                const seats = sedadla.filter(function(seat) {
                    return seat["table_id"] == container_table.data.id;
                })

                // Přiřadí správný směr stolu
                if (direction == "T" || direction == "D") {
                    container_table.className = "container-table-TD";
                } else {
                    container_table.className = "container-table-LR";

                    let size = 25 + (25 * (seats.length/2));
                    if (seats.length % 2) {
                        size += 12.5;
                    }
                    container_table.style.width = size + "px";
                }

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
                        const selected = document.querySelectorAll(".selected").length;
                        if (this.classList.contains("seat-free")) {
                            if (this.classList.contains("selected")) {
                                this.classList.remove("selected");
                            } else if (selected < <?php echo json_encode($max_number_of_selected_seats) ?>) {
                                this.classList.add("selected");
                            }
                        }
                    }

                    container_table.appendChild(container_seat);
                }

                // Podle směru přehodí číslo stolu
                if (direction == "D" || direction == "R") {
                    container_table.appendChild(container_number);
                }
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
        // Vyplní objednávku
        function order() {
            const selected = document.querySelectorAll(".selected");
            const order_from_seats = document.getElementById("order-form-seats");
            order_from_seats.innerHTML = "";
            if (selected.length == 0) {
                order_from_seats.style.color = "red";
                order_from_seats.innerHTML = "Vyberte si prosím nějaká místa :)";
            } else {
                order_from_seats.style.color = "black";
                selected.forEach((seat) => {
                    const table = seat.parentElement;
                    const table_number = table.data.number;

                    const element = document.createElement("LABEL");
                    element.className = "seat-text";
                    element.innerHTML = table_number + "-" + seat.innerHTML; //element.innerHTML = seat.data.id;
                    
                    const hidden_id = document.createElement("INPUT");
                    hidden_id.value = seat.data.id;
                    hidden_id.name = "seats_id[]";
                    hidden_id.type = "hidden";
                    const hidden_text = document.createElement("INPUT");
                    hidden_text.value = table_number + "-" + seat.innerHTML;
                    hidden_text.name = "seats_text[]";
                    hidden_text.type = "hidden";

                    order_from_seats.appendChild(element);
                    order_from_seats.appendChild(hidden_id);
                    order_from_seats.appendChild(hidden_text);
                })
            }
        }

        // Změní css prvků (kvůli adminovi)
        function resetCss() {
            const seats = document.querySelectorAll(".container-seat");
            for (let i=0; i < seats.length; i++) {
                seats[i].style.cursor = "pointer";
            }
            let numbers = document.querySelectorAll(".container-button-graphic");
            for (let i=0; i < numbers.length; i++) {
                numbers[i].style.cursor = "default";
            }
        }

        // Aktualizuje výpisy
        function updateOutput() {
            document.getElementById("output-all").innerHTML = document.querySelectorAll(".container-seat").length;
            document.getElementById("output-free").innerHTML = document.querySelectorAll(".seat-free").length;
            document.getElementById("output-reserved").innerHTML = document.querySelectorAll(".seat-reserved").length;
            document.getElementById("output-bought").innerHTML = document.querySelectorAll(".seat-bought").length;
        }

        // Načte se po načtení dokumentu
        $(document).ready(function() {
            updateOutput();
            resetCss();
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
                slideIndex = 1;
            }
            if (n < 1) {
                slideIndex = slides.length;
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
    </script>
  </body>
</html>