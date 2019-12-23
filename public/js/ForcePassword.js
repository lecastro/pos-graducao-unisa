  //configurando os gatilhos de evento
  $('#password').keyup(function() {
    const pswd = $(this).val();
    //Validando o comprimento
    getLength(pswd);

    // Pelo menos uma letra minúscula
    getLetter(pswd);

    // valide Pelo menos uma letra maiúscula
    getCapital(pswd);

    // validar Pelo menos um numero
    getNumber(pswd);

    //Validando Pelo menos um caractere especial
    getSpecialCharacters(pswd);

    console.log(pswd);
  }).focus(function() {
    // dispara sempre que o campo de senha é selecionado pelo usuário
    $('.pswd_info').show();
  }).blur(function() {
    // dispara sempre que o campo de senha é desmarcado
    $('.pswd_info').hide();
  });

  const getLength = (val) => {
    if (val.length < 8) {
      $('#length').removeClass('valid').addClass('invalid');
    } else {
      $('#length').removeClass('invalid').addClass('valid');
    }
  }

  const getLetter = (val) => {
    if (val.match(/[a-z]/)) {
      $('#letter').removeClass('invalid').addClass('valid');
    } else {
      $('#letter').removeClass('valid').addClass('invalid');
    }
  }

  const getCapital = (val) => {
    if (val.match(/[A-Z]/)) {
      $('#capital').removeClass('invalid').addClass('valid');
    } else {
      $('#capital').removeClass('valid').addClass('invalid');
    }
  }

  const getNumber = (val) => {
    if (val.match(/[0-9]/)) {
      $('#number').removeClass('invalid').addClass('valid');
    } else {
      $('#number').removeClass('valid').addClass('invalid');
    }
  }

  const getSpecialCharacters = (val) => {
    if (val.match(/[^a-zA-Z 0-9]+/g)) {
      $('#specialCharacters').removeClass('invalid').addClass('valid');
    } else {
      $('#specialCharacters').removeClass('valid').addClass('invalid');
    }
  }
