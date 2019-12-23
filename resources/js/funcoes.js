window.getDadosComParametros = getDadosComParametros;
window.alterarDados = alterarDados;

function deletar() {
    let rota = $(this).data('rota');
    if (rota) {
        swal.fire({
            title: 'Deletar registro?',
            text: 'Você tem certeza que deseja deletar este registro!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: rota,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        type: 'DELETE',
                        dataType: 'json',
                        success: function(result) {
                            table.ajax.reload();
                            swal.fire('Deletado!', result.message, 'success');
                        },
                        error: function(result) {
                            let jsonData = JSON.parse(result.responseText);
                            swal.fire('Ação cancelada!', jsonData.message, 'error');
                        },
                    });
                } else {
                    swal.fire('Ação cancelada!', 'Ação cancelada pelo usuario!', 'warning');
                }
            });
    } else {
        swal.fire('Ops!', 'Não foi possivel realizar a ação!', 'error');
    }
}

function getDados(rota, functionSuccess, functionError = null, vBeforeSend = null){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $.ajax({
        url: rota,
        type: 'GET',
        dataType: 'JSON',
        beforeSend: function(){
            (vBeforeSend) != null ? vBeforeSend() : waitingDialog.show('Carregando...');
        },
        complete: function () {
            waitingDialog.hide();
        },
        success: function(data){
            if(data.status == 'error'){
                (functionError) != null ? functionError(data) : functionErrorPattern(data);
            }else{
                functionSuccess(data);
            }
        },
        error: function(data){
            if(data.status == 403){
                ajaxMensagemErroPremissao();
            }else{
                functionErrorPattern(data);
            }
        }
    });
}

function getDadosComParametros(rota, json, functionSuccess, functionError = null, vBeforeSend = null){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $.ajax({
        url: rota,
        type: 'GET',
        dataType: 'JSON',
        data: json,
        beforeSend: function(){
            (vBeforeSend) != null ? vBeforeSend() : waitingDialog.show('Carregando...');
        },
        complete: function () {
            waitingDialog.hide();
        },
        success: function(data){
            if(data.status == 'error'){
                (functionError) != null ? functionError(data) : functionErrorPattern(data);
            }else{
                waitingDialog.hide();

                functionSuccess(data);
            }
        },
        error: function(data){
            if(data.status == 403){
                ajaxMensagemErroPremissao();
            }else{
                functionErrorPattern(data);
            }
        }
    });
}

function criarDados(rota, json, functionSuccess = null, functionError = null, vBeforeSend = null){

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $.ajax({
        url: rota,
        type: 'POST',
        dataType: 'JSON',
        data: json,
        beforeSend: function(){
            (vBeforeSend) != null ? vBeforeSend() : waitingDialog.show('Carregando...');
        },
        complete: function () {
            waitingDialog.hide();
        },
        success: function(data){
            if(data.status == 'error'){
                (functionError) != null ? functionError(data) : functionErrorPattern(data);
            }else{
                (functionSuccess) != null ? functionSuccess(data) : functionSuccessPattern(data);
            }
        },
        error: function(data){
            if(data.status == 403){
                ajaxMensagemErroPremissao();
            }else{
                functionErrorPattern(data);
            }
        }
    });
}

function alterarDados(rota, json, functionSuccess = null, functionError = null, vBeforeSend = null){
    json["_method"] = "PUT";
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $.ajax({
        url: rota,
        type: 'POST',
        dataType: 'json',
        data: json,
        beforeSend: function(){
            (vBeforeSend) != null ? vBeforeSend() : waitingDialog.show('Carregando...');
        },
        complete: function () {
            waitingDialog.hide();
        },
        success: function(data){
            if(data.status == 'error'){
                (functionError) != null ? functionError(data) : functionErrorPattern(data);
            }else{
                (functionSuccess) != null ? functionSuccess(data) : functionSuccessPattern(data);
            }
        },
        error: function(data){
            if(data.status == 403){
                ajaxMensagemErroPremissao();
            }else{
                functionErrorPattern(data);
            }
        }
    });
}

function deletarDados(rota, json, functionSuccess = null, functionError = null, vBeforeSend = null){
    let json_str = '';
    let jsonDelete = '';
    if(json == ''){
        let json_str = '{ "_method":"delete" }';
        jsonDelete = JSON.parse(json_str);
    }else{
        json["_method"] = "PUT";
        jsonDelete = json;
    }

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $.ajax({
        url: rota,
        type: 'delete',
        dataType: 'JSON',
        data: jsonDelete,
        beforeSend: function(){
            (vBeforeSend) != null ? vBeforeSend() : waitingDialog.show('Carregando...');
        },
        complete: function () {
            waitingDialog.hide();
        },
        success: function(data){
            if(data.status == 'error'){
                (functionError) != null ? functionError(data) : functionErrorPattern(data);
            }else if(data.status == 'warning'){
                swal.fire("Exclusão não permitida", "Há itens vinculados ao registro!", "info");
            }else{
                (functionSuccess) != null ? functionSuccess(data) : functionSuccessPattern(data);
            }
        },
        error: function(data){
            if(data.status == 403){
                ajaxMensagemErroPremissao();
            }else{
                functionErrorPattern(data);
            }
        }
    });
}

function ajaxMensagemErroPremissao(){
    swal.fire('Sem permissão', 'Favor entrar em contato com o administrador.', 'warning');
}
function functionErrorPattern(data){
    swal.fire('Falha', 'Houve um erro ao executar a tarefa', 'error')
}
function functionSuccessPattern(data){
    exibirMensagemSucesso('Tarefa realizada com sucesso!', '', 'success');
}

$(document)
    .on('click', '.deletar', deletar);

$.extend( true, $.fn.dataTable.defaults, {
    language: {
        url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json",
        decimal: ",",
        thousands: "."
    }
});

$(function() {
    $('.mask_date').mask('00/00/0000');
    $('.mask_time').mask('00:00');
    $('.mask_cpf').mask('000.000.000-00', { reverse: true });
    $('.mask_cep').mask('00000-000');
    $('.mask_preco').mask("###0,00", {reverse: true});
    $('.mask_decimal').mask("#0,00", {reverse: true});
    $('.mask_percentual').mask("000,00", {reverse: true});
    $('.mask_dinheiro').mask('000.000.000.000,00', {reverse: true});
    $('.mask_telefone_fixo').mask('(00) 0000-0000');

    $('.mask_dec').mask('00.00', {reverse: true}, 'Regex');
    let behavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    options = {
        onKeyPress: function (val, e, field, options) {
            field.mask(behavior.apply({}, arguments), options);
        }
    };
    $('.mask_telefone').mask(behavior, options);


});

$(document).ready(function() {
    $('select:not(.ignoreSelect2, .selectpicker, .dual_select, .swal2-select)').select2({
        dropdownAutoWidth : true,
        width: '100%',
        theme: "bootstrap"
    });
});
