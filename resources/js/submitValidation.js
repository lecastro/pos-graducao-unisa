
window.submitValidations = submitValidations;
window.validationMsgSuccess = validationMsgSuccess
window.validationErrorControl = validationErrorControl


/** Validação dos campos **/
    //remove a mensagem de erro ao editar o campo
    $(document).on('focusout', '.is-invalid', function() {
        validationRemoveMsgErros(this);
    });

    //remove a mensagem de erro ao editar o select2
    $(document).on('select2:selecting', 'select', function() {
        let elemento = $(this).next('span');
        validationRemoveMsgErros(elemento);
    });

    //função para remover a mensagens de erro do campo
    function validationRemoveMsgErros(elemento){
        $(elemento).tooltip('dispose').removeClass('is-invalid').removeClass('has-error');
    }

    //Filtro do erro retornado
    function validationError(data){
        waitingDialog.hide();

        switch(data.status){
            case 422:
                validationErrorControl(data.responseJSON.errors);
            break;
            case 403:
                swal.fire("Ação não autorizada!", "Usuário não possui autorização.", 'error');
            break;
            case 406:
                swal.fire("Atenção!", "Senha digitada não confere.", 'error');
            break;
            default:
                swal.fire("Atenção!", "Houve um problema ao enviar os dados.", 'error');
            break;
        }
    }

    //Adiciona a toolpit com mensagem de erro
    function validationPutMsgErros(elemento, msg){
        let text = msg[0];
        let container = $(elemento).closest('form');
        $(elemento).tooltip({
            html: true,
            placement: 'top',
            title: text,
            container: container
        });
    }

    //controla os erros de validação
    function validationErrorControl(errors){
        let msgRetorno = ['Atenção!', "Verifique os campos marcados em vermelho."];
        let elementoExiste = 0;

        $.each(errors, function(inputName, msg){
            let elemento = $(`#${inputName}`).filter(':not([type="hidden"])').first();

            if($(elemento).hasClass('select2-hidden-accessible')){
                elemento = $(elemento).next('span');
                $(elemento).addClass('has-error');
            }else{
                $(elemento).addClass('is-invalid');
            }

            if($(elemento).length < 1 && elementoExiste == 0){
                msgRetorno = ['Atenção!', msg];
            }else{
                validationPutMsgErros(elemento, msg);
                elementoExiste++;
            }
        });

        swal.fire(msgRetorno[0],msgRetorno[1], 'error');
    }
/** Validação dos campos **/


//executa a validação do formulário
function submitValidations(form, vBeforeSend = null,  vSuccess = null, vError = null){
    let route = form.attr('action');
    let method = form.attr('method');
    let formData = new FormData(form[0]);
    validationSendData(route, method, formData, vBeforeSend, vSuccess, vError);
}

//envia os dados
function validationSendData(route, method, formData, vBeforeSend, vSuccess, vError){

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: method,
        url: route,
        data: formData,
        dataType : "json",
        processData: false,
        contentType: false,

      

        /*beforeSend: function(){
            waitingDialog.show('Salvando...');

            (vBeforeSend) != null ? vBeforeSend() : validationBeforeSend();
        },
        complete: function(){
            waitingDialog.hide();*
        },*/
        beforeSend: function () {
            helper_loading('in');
            (vBeforeSend) != null ? vBeforeSend() : validationBeforeSend();
        },
        complete: function () {
            helper_loading('out');
        },
        success: function(data){
            helper_loading('out');
            (vSuccess) != null ? vSuccess(data) : validationSuccess(data);
        },
        error: function(data){
            helper_loading('out');
            (vError) != null ? vError(data) : validationError(data);
        }
    });
}

function helper_loading(string = null)
{
    if(string != 'in' && string != 'out'){
        alert('Parametros inválidos para a function "helper_loading". Utilize "in" ou "out".');
    } else {
        if(string == 'in') {
            $(".div-loader").show();
        } else {
            $(".div-loader").hide();
        }
    }
}


//adiciona o Spin antes de enviar os dados
function validationBeforeSend(){
   // waitingDialog.show('Salvando...');

    validationRemoveMsgErros();
}

//Adiciona uma session para mensagem de sucesso
function validationSuccess(data){
    sessionStorage.setItem('msg', data);
    setTimeout(function() {
        location.reload();
    }, 1000);
}

//Exibe a mensagem de sucesso caso exista a session
function validationMsgSuccess(){
    if(sessionStorage.getItem('msg') == 'success'){
        swal.fire('Sucesso', 'Dados gravados com sucesso!', 'success');
    }else if(sessionStorage.getItem('msg') == 'success-job'){
        swal.fire('Solicitação enviada', 'O arquivo será gerado e enviado por E-mail.', 'warning');
    }
    sessionStorage.removeItem('msg');
}

//Fecha as modals após o sucesso
function validationCloseAllModals(){
    let openModals = document.querySelectorAll(".modal.in");
    if(openModals) {
        for(let i = 0; i < openModals.length; i++) {
            //Pega o Header da modal onde esta o botao de fechar
            let modalHeader = openModals[i].getElementsByClassName("modal-header");

            if(modalHeader && modalHeader.length > 0) {
                //Pega o botao de fechar da modal
                let closeButton = modalHeader[0].getElementsByTagName("BUTTON");

                if(closeButton && closeButton.length > 0) {
                    //Força a ação de fechar o botão
                    closeButton[0].click();
                }
            }
        }
    }
}

//Reload nas tables
function validationReloadDataTable(){
    let dataTables = document.querySelectorAll(".table");
    if(dataTables) {
        for(let i = 0; i < dataTables.length; i++) {
            if(dataTables[i].id !== ''){
                $(`#${dataTables[i].id}`).DataTable().ajax.reload();
            }
        }
    }
}
