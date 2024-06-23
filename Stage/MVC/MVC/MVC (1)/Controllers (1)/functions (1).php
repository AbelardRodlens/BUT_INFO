

<?php
function decouperMois($year, $month) {
    $ListeSemaines = [];
    $firstDayOfMonth = strtotime($year . '-' . $month . '-01');
    $lastDayOfMonth = strtotime('last day of ' . $year . '-' . $month);

    $currentDay = $firstDayOfMonth;
    $weekStartDate = $currentDay; // Premier jour du mois = début semaine.

    while ($currentDay <= $lastDayOfMonth) {
        
        if (date('N', $lastDayOfMonth) == 7) { //
            $lastDayOfMonth-=2;
        }
        elseif(date('N', $lastDayOfMonth) == 6){
            $lastDayOfMonth-=1;
        }
        // Si c'est le jour est lundi, on commence une nouvelle semaine.
        if (date('N', $currentDay) == 1) {
            $weekStartDate = $currentDay;
        }
        // Si c'est un vendredi ou le dernier jour du mois, c'est la fin de la semaine
        if (date('N', $currentDay) == 5 || $currentDay == $lastDayOfMonth) {
            $ListeSemaines[] = [
                date('Y-m-d', $weekStartDate),
                date('Y-m-d', $currentDay)
            ];
            $weekStartDate +=2; // Passer au lundi suivant
        }

        // Passage au jour suivant
        $currentDay = strtotime('+1 day', $currentDay);
    }

    return $ListeSemaines;
}



?>