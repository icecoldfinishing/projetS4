<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
<!--                    <a href="--><?php //= Flight::base() ?><!--/"><img style="width: 250px; height:auto" src="--><?php //= Flight::base() ?><!--/public/assets/compiled/svg/favicon.svg" alt="logo" srcset=""></a>-->
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu"> 
                <li class="sidebar-title">Statistiques</li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/demographie" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>démographie</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/abonnement" class='sidebar-link'>
                        <i class="bi bi-receipt"></i>
                        <span>abonnement</span>
                    </a>
                </li>

                <li class="sidebar-title">Suivi</li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/presence" class='sidebar-link'>
                        <i class="bi bi-calendar-check"></i>
                        <span>présence</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/personnel" class='sidebar-link'>
                        <i class="bi bi-person-badge"></i>
                        <span>personnels</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/club" class='sidebar-link'>
                        <i class="bi bi-person-lines-fill"></i>
                        <span>club</span>
                    </a>
                </li>

                <li class="sidebar-title">Gestion</li>   
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/tarif" class='sidebar-link'>
                        <i class="bi bi-tag"></i>
                        <span>tarifs</span>
                    </a>
                </li>
                
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/finance" class='sidebar-link'>
                        <i class="bi bi-bank"></i>
                        <span>finance</span>
                    </a>
                </li>
        
                <li class="sidebar-item  has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-person-arms-up"></i>
                        <span>le dojo</span>
                    </a>
                
                    <ul class="submenu submenu-closed" style="--submenu-height: 86px;">
                        <li class="submenu-item">
                            <a href="<?= Flight::base() ?>/listeCours" class="submenu-link">cours</a>
                        </li>
                        <li class="submenu-item">
                            <a href="<?= Flight::base() ?>/calendrier" class="submenu-link">emploi du temps</a>
                        </li>
                        <li class="submenu-item">
                            <a href="<?= Flight::base() ?>/listeSeances" class="submenu-link">séances</a>
                        </li>
                    </ul>
                </li>  

                <li class="sidebar-item  has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-building"></i>
                        <span>salle</span>
                    </a>
                
                    <ul class="submenu submenu-closed" style="--submenu-height: 86px;">
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/dashboard" class="submenu-link">dashboard</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/materiel" class="submenu-link">matériel</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/stock" class="submenu-link">stock matériel</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/suivi-salle" class="submenu-link">suivi salle</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/facturation/liste" class="submenu-link">facturation</a>
                        </li>
                    </ul>
                </li>  

                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/reservations" class='sidebar-link'>
                        <i class="bi bi-journal-bookmark"></i>
                        <span>réservations</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/edt" class='sidebar-link'>
                        <i class="bi bi-clock-history"></i>
                        <span>emploi du temps</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="<?= Flight::base() ?>/eleves" class='sidebar-link'>
                        <i class="bi bi-people-fill"></i>
                        <span>liste des individus</span>
                    </a>
                </li>

                <!-- <li class="sidebar-item  has-sub">
                    <a href="#" class="sidebar-link">
                        <i class="bi bi-table"></i>
                        <span>Table des suivis</span>
                    </a>
                
                    <ul class="submenu submenu-closed" style="--submenu-height: 86px;">
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/liste/District" class="submenu-link">districtes</a>
                        </li>
                        <li class="submenu-item  ">
                            <a href="<?= Flight::base() ?>/liste/Commune" class="submenu-link">communes</a>
                        </li>
                    </ul>
                </li>   -->
            </ul>
        </div>
    </div>
</div>
