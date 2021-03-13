// Fonctions qui s'occupe du planning
$('.planning').ready(function() {
    // on charge la page du planning.
    $('.planning-page').load('planning.php');
    // on récupère la semaine courante.
    var currentWeek = $('.nextPage').attr('data-id') - 1;
    
    // Lorsque l'on clique sur un bouton de navigation...
    $('.btn').click(function() {
        // on récupère le numéro de la semaine voulu et la promo voulu.
        let id = $(this).attr('data-id');
        let p = $('.form-select').val();
        // on envoie la donnée à la page avec un get et on met à jour l'affichage et les données des boutons..
        $.get('planning.php', {week : id, promo : p},
            function(data) {
                $('.planning-page').html(data);
                $('.previousPage').attr('data-id', (currentWeek - 4 <= id - 1 ) ? id - 1 : id);
                $('.nextPage').attr('data-id', (currentWeek + 4 >= (parseInt(id) + 1)) ? (parseInt(id) + 1).toString() : id);
            }
        );
    });

    $('.form-select').change(function() {
        $.get('planning.php', {
            promo:  $('.form-select').val()
        }, 
        function(data) {
            $('.planning-page').html(data);
        });
    });
});

/** Fonction qui s'occupe de l'affichage des erreurs d'un formulaire.
 */
 function alertForm(data, id, msg) {
    res = jQuery.parseJSON(data);
    $(id + ' .form-control').removeClass('is-invalid');
    $(id + ' .alert').removeClass('alert-danger alert-success');
    $(id + ' .alert').css('display', 'none');
    if(Object.keys(res).length > 0) {
        jQuery.each(res, function(k, elt) {
            if(k == 'global') {
                $(id + ' .alert').css('display', 'block');
                $(id + ' .alert').addClass('alert-danger').text(elt);
            } else {
                $(id + ' input[name=' + k + ']').addClass('is-invalid');
                $('#'+k+' small').text(elt);
            }
        });
    } else {
        $(id + ' .alert').css('display', 'block');
        $(id + ' .alert').addClass('alert-success').text(msg);
    }
}

$('input[type=\'submit\']').click(function(e){
    $(this).addClass("clicked");
    
});

$('#form_addEvent').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();
    $.post('gestion.php', {add_event: 1, post}, (data) => {alertForm(data, '#form_addEvent' , 'Le cours a bien été ajouté !')});
});

$('#form_updateEvent').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();
    $.post('gestion.php', {update_event: 1, post}, (data) => {console.log(data);alertForm(data, '#form_updateEvent' , 'Le cours a bien été mis à jour !')});
});

$('#form_room').submit(function(e) {
    e.preventDefault();

    var post = $(this).serialize();

    if($(this).find('.clicked').attr('value') == 'Ajouter') {
        $.post('admin.php', {add_room: 1, post}, (data) => {alertForm(data, '#form_room', 'La salle a bien été ajouté !')});
    } else {
        $.post('admin.php', {remove_room: 1, post}, (data) => {alertForm(data, '#form_room', 'La salle a bien été supprimé !')});
    }
    $(this).find('input[type=\'submit\']').removeClass("clicked");
});

$('#form_addPromo').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();
    $.post('admin.php', {add_promo: 1, post}, (data) => {alertForm(data, '#form_addPromo' , 'La promotion a bien été ajouté !')});
});

$('#form_removePromo').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();
    $.post('admin.php', {remove_promo: 1, post}, (data) => {alertForm(data, '#form_removePromo' , 'La promotion a bien été supprimé !')});
});

$('#form_teachMatter').submit(function(e) {
    e.preventDefault();

    var post = $(this).serialize();

    if($(this).find('.clicked').attr('value') == 'Associer') {
        $.post('admin.php', {add_teachMatter: 1, post}, (data) => {alertForm(data, '#form_teachMatter', 'La matière a bien été associé à l\'enseignant !')});
    } else {
        $.post('admin.php', {remove_teachMatter: 1, post}, (data) => {alertForm(data, '#form_teachMatter', 'La matière a bien été dissocié de l\'enseignant !')});
    }
    $(this).find('input[type=\'submit\']').removeClass("clicked");
});

$('#form_matter').submit(function(e){
    e.preventDefault();

    var post = $(this).serialize();
    $.post('admin.php', {add_matter: 1, post}, (data) => {alertForm(data, '#form_matter', 'La matière a bien été crée !')});
});

$('#form_linkMatter').submit(function(e){
    e.preventDefault();

    var post = $(this).serialize();
    $.post('admin.php', {add_teachMatter: 1, post}, (data) => {alertForm(data, '#form_linkMatter', 'La matière a bien été associé à l\'enseignant !')});
});

$('#form_user').submit(function(e){
    e.preventDefault();

    var post = $(this).serialize();
    $.post('admin.php', {add_user: 1, post}, (data) => {alertForm(data, '#form_user', 'L\'usager a bien été ajouté !')});
});