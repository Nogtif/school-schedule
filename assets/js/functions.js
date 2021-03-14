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
    $.post('config.php', {add_event: 1, post}, (data) => {alertForm(data, '#form_addEvent' , 'Le cours a bien été ajouté !')});
});

$('#form_updateEvent').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {update_event: 1, post}, (data) => {console.log(data);alertForm(data, '#form_updateEvent' , 'Le cours a bien été mis à jour !')});
});

$('#form_room').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();

    if($(this).find('.clicked').attr('value') == 'Ajouter') {
        $.post('config.php', {add_room: 1, post}, (data) => {alertForm(data, '#form_room', 'La salle a bien été ajouté !')});
    } else {
        $.post('config.php', {remove_room: 1, post}, (data) => {alertForm(data, '#form_room', 'La salle a bien été supprimé !')});
    }
    $(this).find('input[type=\'submit\']').removeClass("clicked");
});

$('#form_addPromo').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {add_promo: 1, post}, (data) => {alertForm(data, '#form_addPromo' , 'La promotion a bien été ajouté !')});
});

$('#form_removePromo').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {remove_promo: 1, post}, (data) => {alertForm(data, '#form_removePromo' , 'La promotion a bien été supprimé !')});
});

$('#form_teachMatter').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();

    if($(this).find('.clicked').attr('value') == 'Associer') {
        $.post('config.php', {add_teachMatter: 1, post}, (data) => {alertForm(data, '#form_teachMatter', 'La matière a bien été associé à l\'enseignant !')});
    } else {
        $.post('config.php', {remove_teachMatter: 1, post}, (data) => {alertForm(data, '#form_teachMatter', 'La matière a bien été dissocié de l\'enseignant !')});
    }
    $(this).find('input[type=\'submit\']').removeClass("clicked");
});

$('#form_addMatter').submit(function(e){
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {add_matter: 1, post}, (data) => {alertForm(data, '#form_addMatter', 'La matière a bien été crée !')});
});

$('#form_updateMatter').submit(function(e){
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {update_matter: 1, post}, (data) => {console.log(data);alertForm(data, '#form_updateMatter', 'La matière a bien été mise à jour !')});
});

$('#form_linkMatter').submit(function(e){
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {add_teachMatter: 1, post}, (data) => {alertForm(data, '#form_linkMatter', 'La matière a bien été associé à l\'enseignant !')});
});

$('#form_addUser').submit(function(e){
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {add_user: 1, post}, (data) => {alertForm(data, '#form_addUser', 'L\'usager a bien été ajouté !')});
});

$('#form_updateUser').submit(function(e){
    e.preventDefault();
    var post = $(this).serialize();
    $.post('config.php', {update_user: 1, post}, (data) => {alertForm(data, '#form_updateUser', 'L\'usager a bien été mise à jour !')});
});

$('#form_userPromo').submit(function(e) {
    e.preventDefault();
    var post = $(this).serialize();

    if($(this).find('.clicked').attr('value') == 'Associer') {
        $.post('config.php', {add_userPromo: 1, post}, (data) => {alertForm(data, '#form_userPromo', 'L\'étudiant étudie désormais dans cette promotion !')});
    } else {
        $.post('config.php', {remove_userPromo: 1, post}, (data) => {alertForm(data, '#form_userPromo', 'L\'étudiant n\'étudie plus dans cette promotion !')});
    }
    $(this).find('input[type=\'submit\']').removeClass("clicked");
});