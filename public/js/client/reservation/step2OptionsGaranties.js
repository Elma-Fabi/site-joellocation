var btnToStep3InfosClientElem;

getElements();
addEventListener();

function getElements() {
    btnToStep3InfosClientElem = document.getElementById('btnToStep3InfosClient');
    console.log(btnToStep3InfosClientElem);
}

function addEventListener() {
    btnToStep3InfosClientElem.addEventListener('click', redirectController, false);
}

function redirectController(e) {

    e.preventDefault();
    alert('ato le izy zao ');
    $.ajax({
        type: 'POST',
        url: '/espaceclient/infosClient',
        data: {

        },
        headear: xhr.setRequestHeader,
        Type: "json",
        beforeSend: function (xhr) {

            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')


        },
        success: function (data) {

            window.location = "/espaceclient/infosClient";
        },
        error: function (erreur) {
            // alert('La requête n\'a pas abouti' + erreur);
            console.log(erreur.responseText);
        }
    });

}