<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>titre</title>
    <link rel="shortcut icon" href="<?= Flight::base() ?>/public/assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRpZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/app.css">

    <!-- modul css -->    
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="<?= Flight::base() ?>/public/css/gestion/edt.css">
</head>
<body>
    <div id="app">
        <?= Flight::menuAdmin() ?>
        <div id="main">
            <main class="dashboard">
                <div class="schedule-dashboard">
                    <div class="schedule-header">
                        <div class="week-navigation">
                            <button class="nav-btn" id="prevWeek"><i class="bi bi-chevron-left"></i></button>
                            <div class="current-week">
                                <h2 id="weekTitle">Semaine en cours</h2>
                                <div class="week-dates">
                                    <span>Du <strong id="startDate">24 Juin 2025</strong> au <strong id="endDate">30 Juin 2025</strong></span>
                                </div>
                            </div>
                            <button class="nav-btn" id="nextWeek"><i class="bi bi-chevron-right"></i></button>
                        </div>
                    </div>

                    <div class="schedule-container">
                        <div class="days-header">
                            <div class="day-header">
                                <h3>Lundi</h3>
                                <span class="day-date" id="lundi-date">24 Juin</span>
                            </div>
                            <div class="day-header">
                                <h3>Mardi</h3>
                                <span class="day-date" id="mardi-date">25 Juin</span>
                            </div>
                            <div class="day-header">
                                <h3>Mercredi</h3>
                                <span class="day-date" id="mercredi-date">26 Juin</span>
                            </div>
                            <div class="day-header">
                                <h3>Jeudi</h3>
                                <span class="day-date" id="jeudi-date">27 Juin</span>
                            </div>
                            <div class="day-header">
                                <h3>Vendredi</h3>
                                <span class="day-date" id="vendredi-date">28 Juin</span>
                            </div>
                            <div class="day-header">
                                <h3>Samedi</h3>
                                <span class="day-date" id="samedi-date">29 Juin</span>
                            </div>
                            <div class="day-header">
                                <h3>Dimanche</h3>
                                <span class="day-date" id="dimanche-date">30 Juin</span>
                            </div>
                        </div>

                        <div class="schedule-grid">
                            <div class="day-schedule">
                                <div class="time-slot slot-danse" data-details='{"leader":"Mr Norbert","club":"Club de Danse","time":"13h-15h","participants":"11"}'>
                                    <div class="slot-time">13h-15h</div>
                                    <div class="slot-name">Club de Danse</div>
                                </div>
                                <div class="time-slot slot-fitness" data-details='{"leader":"Mme Sarah","club":"Fitness","time":"16h-17h30","participants":"8"}'>
                                    <div class="slot-time">16h-17h30</div>
                                    <div class="slot-name">Fitness</div>
                                </div>
                            </div>

                            <div class="day-schedule">
                                <div class="time-slot slot-jjb" data-details='{"leader":"Mr Jean","club":"JJB","time":"08h-10h","participants":"15"}'>
                                    <div class="slot-time">08h-10h</div>
                                    <div class="slot-name">JJB</div>
                                </div>
                                <div class="time-slot slot-yoga" data-details='{"leader":"Mme Marie","club":"Yoga","time":"18h-19h30","participants":"12"}'>
                                    <div class="slot-time">18h-19h30</div>
                                    <div class="slot-name">Yoga</div>
                                </div>
                            </div>

                            <div class="day-schedule">
                                <div class="time-slot slot-karate" data-details='{"leader":"Mr Takeshi","club":"Karaté","time":"14h-16h","participants":"20"}'>
                                    <div class="slot-time">14h-16h</div>
                                    <div class="slot-name">Karaté</div>
                                </div>
                            </div>

                            <div class="day-schedule">
                                <div class="time-slot slot-natation" data-details='{"leader":"Mme Claire","club":"Natation","time":"09h-11h","participants":"10"}'>
                                    <div class="slot-time">09h-11h</div>
                                    <div class="slot-name">Natation</div>
                                </div>
                                <div class="time-slot slot-danse" data-details='{"leader":"Mr Norbert","club":"Club de Danse","time":"17h-19h","participants":"14"}'>
                                    <div class="slot-time">17h-19h</div>
                                    <div class="slot-name">Club de Danse</div>
                                </div>
                            </div>

                            <div class="day-schedule">
                                <div class="time-slot slot-fitness" data-details='{"leader":"Mme Sarah","club":"Fitness","time":"07h-08h30","participants":"6"}'>
                                    <div class="slot-time">07h-08h30</div>
                                    <div class="slot-name">Fitness</div>
                                </div>
                                <div class="time-slot slot-jjb" data-details='{"leader":"Mr Jean","club":"JJB","time":"19h-21h","participants":"18"}'>
                                    <div class="slot-time">19h-21h</div>
                                    <div class="slot-name">JJB</div>
                                </div>
                            </div>

                            <div class="day-schedule">
                                <div class="time-slot slot-yoga" data-details='{"leader":"Mme Marie","club":"Yoga","time":"10h-11h30","participants":"9"}'>
                                    <div class="slot-time">10h-11h30</div>
                                    <div class="slot-name">Yoga</div>
                                </div>
                                <div class="time-slot slot-karate" data-details='{"leader":"Mr Takeshi","club":"Karaté","time":"15h-17h","participants":"16"}'>
                                    <div class="slot-time">15h-17h</div>
                                    <div class="slot-name">Karaté</div>
                                </div>
                            </div>

                            <div class="day-schedule">
                                <div class="time-slot slot-natation" data-details='{"leader":"Mme Claire","club":"Natation","time":"11h-13h","participants":"7"}'>
                                    <div class="slot-time">11h-13h</div>
                                    <div class="slot-name">Natation</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tooltip pour afficher les détails -->
                <div class="schedule-tooltip" id="scheduleTooltip">
                    <div class="tooltip-header">
                        <strong id="tooltipClub"></strong>
                    </div>
                    <div class="tooltip-body">
                        <div class="tooltip-item">
                            <i class="fas fa-user"></i>
                            <span>Leader: </span>
                            <strong id="tooltipLeader"></strong>
                        </div>
                        <div class="tooltip-item">
                            <i class="fas fa-clock"></i>
                            <span>Horaire: </span>
                            <strong id="tooltipTime"></strong>
                        </div>
                        <div class="tooltip-item">
                            <i class="fas fa-users"></i>
                            <span>Nb de personnes: </span>
                            <strong id="tooltipParticipants"></strong>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="<?= Flight::base() ?>/public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?= Flight::base() ?>/public/assets/compiled/js/app.js"></script>
    <script>
        // Navigation des semaines
        let currentWeek = new Date();
        
        function getWeekDates(date) {
            const week = new Date(date);
            const day = week.getDay();
            const diff = week.getDate() - day + (day === 0 ? -6 : 1);
            week.setDate(diff);
            
            const weekStart = new Date(week);
            const weekEnd = new Date(week);
            weekEnd.setDate(weekEnd.getDate() + 6);
            
            return { start: weekStart, end: weekEnd };
        }
        
        function formatDate(date) {
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return date.toLocaleDateString('fr-FR', options);
        }
        
        function updateWeekDisplay() {
            const { start, end } = getWeekDates(currentWeek);
            
            document.getElementById('weekTitle').textContent = `Semaine du ${start.getDate()} - ${end.getDate()} ${end.toLocaleDateString('fr-FR', { month: 'long', year: 'numeric' })}`;
            document.getElementById('startDate').textContent = formatDate(start);
            document.getElementById('endDate').textContent = formatDate(end);
            
            const days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
            days.forEach((day, index) => {
                const dayDate = new Date(start);
                dayDate.setDate(start.getDate() + index);
                document.getElementById(`${day}-date`).textContent = `${dayDate.getDate()} ${dayDate.toLocaleDateString('fr-FR', { month: 'short' })}`;
            });
        }
        
        document.getElementById('prevWeek').addEventListener('click', () => {
            currentWeek.setDate(currentWeek.getDate() - 7);
            updateWeekDisplay();
        });
        
        document.getElementById('nextWeek').addEventListener('click', () => {
            currentWeek.setDate(currentWeek.getDate() + 7);
            updateWeekDisplay();
        });
        
        // Gestion du tooltip
        const tooltip = document.getElementById('scheduleTooltip');
        const timeSlots = document.querySelectorAll('.time-slot');
        
        timeSlots.forEach(slot => {
            slot.addEventListener('mouseenter', (e) => {
                const details = JSON.parse(e.currentTarget.dataset.details);
                
                document.getElementById('tooltipClub').textContent = details.club;
                document.getElementById('tooltipLeader').textContent = details.leader;
                document.getElementById('tooltipTime').textContent = details.time;
                document.getElementById('tooltipParticipants').textContent = details.participants;
                
                tooltip.style.display = 'block';
            });
            
            slot.addEventListener('mousemove', (e) => {
                tooltip.style.left = e.pageX + 15 + 'px';
                tooltip.style.top = e.pageY + 15 + 'px';
            });
              slot.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });
        });
        
        // Fonction pour basculer vers Superviseur
        function switchToSupervisor() {
            window.location.href = 'suivi-materiel.html';
        }
        
        // Initialiser l'affichage
        updateWeekDisplay();
    </script>
</body>
</html>