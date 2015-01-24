// Valida o número do CPF
function validaCPF(num_cpf) {
    var cpf = "";

    for (i = 0; i < num_cpf.length; i++) {
        if (num_cpf.charAt(i) != "." && num_cpf.charAt(i) != "-") {
            cpf += num_cpf.charAt(i);
        }
    }

    if (cpf.length != 11 || cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999") {
        return false;
    }

    soma = 0;

    for (i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }

    resto = 11 - (soma % 11);

    if (resto == 10 || resto == 11) {
        resto = 0;
    }

    if (resto != parseInt(cpf.charAt(9))) {
        return false;
    }

    soma = 0;

    for (i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }

    resto = 11 - (soma % 11);

    if (resto == 10 || resto == 11) {
        resto = 0;
    }

    if (resto != parseInt(cpf.charAt(10))) {
        return false;
    }

    return true;
}

// Valida o número do CNPJ
function validaCNPJ(CNPJ) {
    if (CNPJ.length < 18) { return false };

    if ((CNPJ.charAt(2) != ".") || (CNPJ.charAt(6) != ".") || (CNPJ.charAt(10) != "/") || (CNPJ.charAt(15) != "-")) {
        return false;
    }

    //substituir os caracteres que nao sao numeros
    if(document.layers && parseInt(navigator.appVersion) == 4) {
        x = CNPJ.substring(0,2);
        x += CNPJ.substring(3,6);
        x += CNPJ.substring(7,10);
        x += CNPJ.substring(11,15);
        x += CNPJ.substring(16,18);
        CNPJ = x;	
    }
    else {
        CNPJ = CNPJ.replace(".","");
        CNPJ = CNPJ.replace(".","");
        CNPJ = CNPJ.replace("-","");
        CNPJ = CNPJ.replace("/","");
    }

    var nonNumbers = /\D/;

    if (nonNumbers.test(CNPJ)) { return false; }	

    var a = [];
    var b = new Number;
    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];

    for (i=0; i<12; i++){
        a[i] = CNPJ.charAt(i);
        b += a[i] * c[i+1];
    }

    if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }

    b = 0;

    for (y=0; y<13; y++) {
        b += (a[y] * c[y]); 
    }

    if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }

    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){
        return false;
    }

    if (erro.length > 0){
        return false;
    }

    return true;
}
