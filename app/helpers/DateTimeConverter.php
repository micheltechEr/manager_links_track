<?php
class DateTimeConverter{
    public static function lapsedTimeConversor($date){
        $now = new DateTime();
        $past = new DateTime($date);
        $difference = $now->diff($past);

        if($difference->y > 0){
            return 'há ' . $difference->y . ' ano' . ($difference->y > 1 ? 's' : '');
        }
        else if($difference->m > 0){
            return 'há ' . $difference->m . ' mês' . ($difference->m > 1 ? 'es' : '');
        }
        else if($difference->d > 0){
            return 'há ' . $difference->d . ' dia' . ($difference->d > 1 ? 's' : '');
        }
        else if($difference->h > 0){
            return 'há ' . $difference->h . ' hora' . ($difference->h > 1 ? 's' : '');
        }
        else if($difference->i > 0){
            return 'há ' . $difference->i . ' minuto' . ($difference->i > 1 ? 's' : '');
        }
        else {
            return 'agora mesmo';
        }
    }
}
?>