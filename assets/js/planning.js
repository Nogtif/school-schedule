$(function() {
    // on charge la page du planning.
    $(".planning-page").load("planning.php");
    // on récupère la semaine courante.
    var currentWeek = $(".nextPage").attr("data-id") - 1;
    
    // Lorsque l'on clique sur un bouton de navigation...
    $(".btn").click(function() {
        // on récupère le numéro de la semaine voulu.
        let id = $(this).attr("data-id");
        // on envoie la donnée à la page avec un get et on met à jour l'affichage et les données des boutons..
        $.get('planning.php', {week : id, promo : 10},
            function(dataResult) {
                $(".planning-page").html(dataResult);
                $(".previousPage").attr("data-id", (currentWeek - 4 <= id - 1 ) ? id - 1 : id);
                $(".nextPage").attr("data-id", (currentWeek + 4 >= (parseInt(id) + 1)) ? (parseInt(id) + 1).toString() : id);
            }
        );
    });
});