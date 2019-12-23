<script>
    function getEndereco(cep, rua, bairro, cidade, uf, ibge = null){
        let n_cep = cep.val().replace(/\D/g, '');

        cidade.prop("readonly", true);
        uf.addClass("select-box-readonly");

        if(n_cep != ''){
            limparEndereco(rua, bairro, cidade, uf, ibge);

            let validaCep = /^[0-9]{8}$/;
            if(validaCep.test(n_cep)) {
                var url = "{{ url('cep') }}" + "/" + n_cep;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data){
                        if(Object.keys(data).length > 0){
                            //Atualiza os campos com os valores da consulta.
                            rua.val(data.logradouro);
                            bairro.val(data.bairro);
                            cidade.val(data.localidade);
                            uf.val(data.uf);
                            if(ibge){
                                ibge.val(data.ibge);
                            }

                            if(data.localidade == ''){
                                cidade.prop("readonly", false);
                            }
                            if(data.uf == ''){
                                uf.removeClass("select-box-readonly");
                            }
                        } else {
                            //CEP pesquisado não foi encontrado.
                            limparEndereco(rua, bairro, cidade, uf, ibge);
                            swal.fire('Não localizamos o CEP informado. Preencha novamente.', '', 'warning');
                        }
                    }
                })
            } //end if.
            else {
                //cep é inválido.
                limparEndereco(rua, bairro, cidade, uf, ibge);
                swal.fire('Formato de CEP inválido.', '', 'error')
            }
        }

    }
    function limparEndereco(rua, bairro, cidade, uf, ibge = null) {
        // Limpa valores do formulário de cep.
        rua.val("");
        bairro.val("");
        cidade.val("");
        uf.val("");
        if(ibge){
            ibge.val("");
        }
    }

</script>
