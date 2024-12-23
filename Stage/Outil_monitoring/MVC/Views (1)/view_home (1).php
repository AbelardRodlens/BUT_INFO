<?php require "view_begin_html.php";?>
    <title>Home</title>
</head>
<body>  
    
    <div id="home-body">
        <div id="menu">
            <h1 id="Logo-Home" class="Logo">Avistel</h1>
            <div id="inputs-space">
                    <a href="#">
                        <div id="Overview" class="inputs-menu">
                            <img src="./Content/img/graph-icone.png" class="Options-Logo"><p id="Overview-text"class="Menu-Option">Overview</p>
                        </div>
                     </a>

                    <a href="index.php?Controller=adduser">
                        <div id="Chambres" class="inputs-menu">
                            <img src="./Content/img/chambre-icone.png" class="Options-Logo"><p id="Chambres-text" class="Menu-Option">Chambres</p>
                        </div>
                     </a>

                     <a href="#">
                        <div id="Factures" class="inputs-menu">
                            <img src="./Content/img/facture-icone.png" class="Options-Logo"><p id="Factures-text" class="Menu-Option">Factures</p>
                        </div>
                     </a>

                     <div id="ligne"></div>
                     <a href="#">
                        <div id="Parametres" class="inputs-menu"> 
                            <img src="./Content/img/engrenage-icone.png" class="Options-Logo" id="Option-Para-Img"><p id="Parametres-text" class="Menu-Option">Parametres</p>
                        </div>
                     </a>

                    
                    
            </div>
        </div>
            

        <div id="visuel-space">
            
            <div id="infos-entete">

                <div id="info-chambre">
                    <a href="#">
                        <div class="voirplus">
                            <div class="point left-point" ></div>
                            <div class="point mid-point" ></div>
                            <div class="point right-point" ></div>
                        </div>
                    </a>
                    <img src="./Content/img/group1.png">
                    <p class="stats">0</p>
                    <p class="info-entete-text">Chambres allouées</p>

                </div>

                <div id="info-CA">
                    <a href="#">
                        <div class="voirplus">
                            <div class="point left-point" ></div>
                            <div class="point mid-point" ></div>
                            <div class="point right-point" ></div>
                        </div>
                    </a>
                    <img src="./Content/img/group2.png">
                    <p class="stats">0</p>
                    <p class="info-entete-text">Chiffre d'affaire total</p>
                    
                </div>
            </div>

            <div id="space2">

                <div id="info-CAByAdvance">
                    <p class="info-title">Chiffre d'affaire</p>
                    <div class="infos-settings">
                        <img src="./Content/img/setting-lines.png">
                    </div>
                    <div class="graph-space">
                        <img class="extend-input" src="./Content/img/fleche-of.png">
                        <div class="graph"><canvas id="CA_chart"></canvas></div>
                    </div>
                    
                </div>

                <div id="info-RC">
                <p class="info-title Ratios_para">Ratio Chambres</p>
                    <div class="info-graph">
                        <canvas id="RC_chart"></canvas>
                    </div>

                </div>

            </div>

            <div id="space3">

                <div id="info-PMByAdvance">
                    <p class="info-title">Méthode de payement</p>
                    <div class="infos-settings">
                        <img src="./Content/img/setting-lines.png">
                    </div>
                    <div class="graph-space">
                        <img class="extend-input" src="./Content/img/fleche-of.png">
                        <div class="graph">
                            <canvas id="PM_chart"></canvas></div>
                        </div>
                
                </div>
                
                <div id="info-RA">
                    <p class="info-title Ratios_para">Ratio Abonnement TV</p>
                    <div class="info-graph">
                    <canvas id="RA_chart"></canvas>
                    </div>

                 </div>

            </div>

         </div>

        <div id="CA-Parametre" class="Page-Parametres">
            <img class="cross" src="./Content/img/cross.png">
            <p class="para-title">Parametres</p>
            <p class="para-infos"> <span class="lighter">Veuillez</span> sélectionner<span class="lighter"> le ou les </span>départements <span class="lighter">ainsi que la</span> période</br> <span class="lighter">pour laquelle vous souhaitez</span> visualiser les statistiques.</p>
                
            <form action="" method="post" id="CA-Parametre-form">
                <p class="Dep-para">Departement :</p> 

                <select name="Dep" id="CA-Select-Dep">
                   
                </select>   
            
                <p class="Periode-para">Période :</p>
                <div id="Periode">
                    <label for="input-radio-annee">Annee</label>
                    <input type="radio" name="periode" id="input-radio-annee" class="CA-radio" value="Annee">
                    </br>
                    <label for="input-radio-mois">Mois</label>
                    <input type="radio" name="periode" id="input-radio-mois" class="CA-radio" value="Mois">
                    </br>
                    <label for="input-radio-semaine">Semaine</label>
                    <input type="radio" name="periode" id="input-radio-semaine" class="CA-radio" value="Semaine">
                    </br>
                    <div class="div-radio-jour">
                    <label for="input-radio-jour">Jour</label>
                    <input type="radio" name="periode" id="input-radio-jour" class="CA-radio" value="Jour">
                    </div>
                </div>
                

                <div class="input-date-spaces">
                    <div class="inputs-date">
                        <select name="year" class="date-year CA-inputs-periode" id="CA_input_year">
                            <option value=<?=date("Y")?>><?=date("Y")?></option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select> 
                        <input type="month" name="month" value=<?=date(" Y-m")?> class="date-month CA-inputs-periode" id="CA_input_month">
                        <input type="week" name="week" class="date-week CA-inputs-periode" id="CA_input_week" min="2015-W1" max="2030-W26" />
                        <input type="date" name="date" class="date-date CA-inputs-periode" id="CA_input_date"  value=<?=date("Y-m-d")?> min="2015-01-01" max="2030-12-31" />
                        
                    </div>
                    
                </div>

                <input type="submit" class="buttons-valider" name="MP-Parametre-submit" value="Valider">
                
            </form>

        </div>

        <div id="MP-Parametre" class="Page-Parametres">
            <img class="cross" src="./Content/img/cross.png">
            <p class="para-title">Parametres</p>
            <p class="para-infos"> <span class="lighter">Veuillez</span> sélectionner<span class="lighter"> le ou les </span>sites <span class="lighter">ainsi que la</span> période</br> <span class="lighter">pour laquelle vous souhaitez</span> visualiser les statistiques.</p>
                
            <form action="" method="post" id="MP-Parametre-form">
                <p class="Dep-para">Departement :</p> 

                <select name="Dep" id="MP-Select-Dep">
                    <option value="Tout">Tout</option> 
                    
                </select>   
            
                <p class="Periode-para">Période :</p>
                <div id="Periode">
                    <label for="mp_input-radio-annee">Annee</label>
                    <input type="radio" name="periode" id="mp_input-radio-annee" class="MP-radio" value="Annee">
                    </br>
                    <label for="mp_input-radio-mois">Mois</label>
                    <input type="radio" name="periode" id="mp_input-radio-mois" class="MP-radio" value="Mois">
                    </br>
                    <label for="mp_input-radio-semaine">Semaine</label>
                    <input type="radio" name="periode" id="mp_input-radio-semaine" class="MP-radio" value="Semaine">
                    </br>
                    <div class="div-radio-jour">
                    <label for="input-radio-jour">Jour</label>
                    <input type="radio" name="periode" id="mp_input-radio-jour" class="MP-radio" value="Jour">
                    </div>
                </div>
                
                <input type="submit" class="buttons-valider" name="MP-Parametre-submit" value="Valider">
            </form>

                <div class="input-date-spaces">
                    <div class="inputs-date">
                        <select name="year" class="date-year MP-inputs-periode" id="MP_input_year">
                            <option value=<?=date("Y")?>><?=date("Y")?></option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                        </select> 
                        <input type="month" name="month" value=<?=date(" Y-m")?> class="date-month MP-inputs-periode" id="MP_input_month">
                        <input type="week" name="week" class="date-week MP-inputs-periode" id="MP_input_week" min="2015-W1" max="2030-W26" required />
                        <input type="date" class="date-date MP-inputs-periode" id="MP_input_date" name="trip-start" value=<?=date("Y-m-d")?> min="2015-01-01" max="2030-12-31" />
                        
                    </div>
                    
                </div>

        </div>

        <div class="extend-graph">
            
        </div>

        <div class="extend-graph">
            
        </div>

    <div class="blur"></div>
    <div class="zone-transparente"></div>

    </div>
    
   
   

<?php require "view_end_html.php" ?>