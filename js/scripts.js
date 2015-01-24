function excluir(mensagem) {
	if (confirm(mensagem)) {
		return true;
	}
	return false;
}

function validacao(form) {
	if (form.usuario.value.length == 0) {
		alert("Informe o usuário para entrar no sistema!");
		form.usuario.focus();
		return false;
	}

	if (form.senha.value.length == 0) {
		alert("Informe a senha para  entrar no sistema!");
		form.senha.focus();
		return false;
	}
	
	return true;
}

function verifica(form) {
	if (form.descricao.value.length == 0) {
		alert("Este campo não pode ficar em branco!");
		form.descricao.focus();
		return false;
	}
	return true;
}

function verifica_empresa(form) {
	if (form.descricao.value.length == 0) {
		alert("O campo Descrição não pode ficar em branco!");
		form.descricao.focus();
		return false;
	}

	if (form.cnpj.value.length < 18) {
		alert("O campo CNPJ não foi preenchido corretamente!");
		form.cnpj.focus();
		return false;
	}

	if (form.contato.value.length == 0) {
		alert("O campo Contato não pode ficar em branco!");
		form.contato.focus();
		return false;
	}

	if (form.telefone.value.length < 14) {
		alert("O campo Telefone não foi preenchido corretamente!");
		form.telefone.focus();
		return false;
	}

	if (form.endereco.value.length == 0) {
		alert("O campo Endereço não pode ficar em branco!");
		form.endereco.focus();
		return false;
	}

	if (form.bairro.value.length == 0) {
		alert("O campo Bairro não pode ficar em branco!");
		form.bairro.focus();
		return false;
	}

	if (form.cidade.value.length == 0) {
		alert("O campo Cidade não pode ficar em branco!");
		form.cidade.focus();
		return false;
	}

	if (form.cep.value.length < 10) {
		alert("O campo CEP não foi preenchido corretamente!");
		form.cep.focus();
		return false;
	}
	
	return true;
}

function verifica_atendente(form) {
	if (form.apelido.value.length == 0) {
		alert("O campo Apelido não pode ficar em branco!");
		form.apelido.focus();
		return false;
	}

	if (form.senha.value.length < 6) {
		alert("O campo Senha deve ter no mínimo 6 caracteres!");
		form.senha.focus();
		return false;
	}

	if (form.nome.value.length == 0) {
		alert("O campo Nome não pode ficar em branco!");
		form.nome.focus();
		return false;
	}

	if (form.cpf.value.length == 0) {
		alert("O campo CPF não pode ficar em branco!");
		form.cpf.focus();
		return false;
	} else {
		if (verificaCPF(form.cpf.value)) {
			return true;
		} else {
		    alert("Número do CPF inválido!");
			return false;
		}
	}

	if (form.data_nasc.value.length < 10) {
		alert("O campo Data de Nascimento não foi preenchido corretamente!");
		form.data_nasc.focus();
		return false;
	}

	if (form.endereco.value.length == 0) {
		alert("O campo Endereço não pode ficar em branco!");
		form.endereco.focus();
		return false;
	}

	if (form.bairro.value.length == 0) {
		alert("O campo Bairro não pode ficar em branco!");
		form.bairro.focus();
		return false;
	}

	if (form.cidade.value.length == 0) {
		alert("O campo Cidade não pode ficar em branco!");
		form.cidade.focus();
		return false;
	}

	if (form.cep.value.length < 10) {
		alert("O campo CEP não foi preenchido corretamente!");
		form.cep.focus();
		return false;
	}
	
	if (form.filiacao.value.length == 0) {
		alert("O campo Filiação não foi preenchido corretamente!");
		form.filiacao.focus();
		return false;
	}
	
	if (form.inicio.value.length < 10) {
		alert("O campo Início não foi preenchido corretamente!");
		form.inicio.focus();
		return false;
	}

	if (form.termino.value.length < 10) {
		alert("O campo Término não foi preenchido corretamente!");
		form.termino.focus();
		return false;
	}

	return true;
}

function verifica_ordem_servico(form) {
	if (form.CodigoDepto.value == 0) {
		alert("O campo Localização não pode ficar em branco!");
		form.CodigoDepto.focus();
		return false;
	}

	if (form.ramal.value.length == 0) {
		alert("O campo Ramal não pode ficar em branco!");
		form.ramal.focus();
		return false;
	}

	if (form.requisitante.value.length == 0) {
		alert("O campo Requisitante não pode ficar em branco!");
		form.requisitante.focus();
		return false;
	}

	if (form.ai.value.length == 0) {
            if (form.patrimonio.value.length == 0) {
                if (form.comodato.value.length == 0) {
                    alert("O campo AI, Patrimônio ou Comodato deve ser informado!");
                    form.ai.focus();
                    return false;
                }                
            }
	}

	if (form.componente.selectedIndex == 0) {
		alert("Deve-se selecionar o Componente correspondente ao defeito!");
		form.componente.focus();
		return false;
	}

	if (form.defeito.value.length == 0) {
		alert("O campo Defeito não pode ficar em branco!");
		form.defeito.focus();
		return false;
	}

        return true;
}

function verifica_ordem_servico0(form) {
	if (form.localizacao.value.length == 0) {
		alert("O campo Localização não pode ficar em branco!");
		form.localizacao.focus();
		return false;
	}

	if (form.ramal.value.length == 0) {
		alert("O campo Ramal não pode ficar em branco!");
		form.ramal.focus();
		return false;
	}

	if (form.requisitante.value.length == 0) {
		alert("O campo Requisitante não pode ficar em branco!");
		form.requisitante.focus();
		return false;
	}

        return true;
}

function verifica_ordem_servico1(form) {
	if (form.ai.selectedIndex == 0) {
            alert("Deve-se selecionar o AI correspondente ao equipamento!");
            form.ai.focus();
            return false;
	}

	if (form.componente.selectedIndex == 0) {
		alert("Deve-se selecionar o Componente correspondente ao defeito!");
		form.componente.focus();
		return false;
	}

	if (form.defeito.value.length == 0) {
		alert("O campo Defeito não pode ficar em branco!");
		form.defeito.focus();
		return false;
	}
    return true;
}
function verifica_ordem_servico2(form) {
	if (form.op.value == 'A') {
 		if (!confirm("Verifique se o campo AI e PATRIMONIO estão preenchidos corretamente.\n Certifique de que fez uma discriminação detalhada do defeito no campo SOLUCAO.\n\n Caso estiver tudo correto, clique em OK para continuar?")) {
			form.solucao.focus();
			return false;
		}
	}
	if (form.ai.value.length == 0 || form.ai.value == '9999999999') {
		alert("O campo AI é obrigatório!");
		form.ai.focus();
		return false;
	}
	if (form.patrimonio.value.length == 0) {
		alert("O campo PATRIMONIO não pode ficar em branco!");
		form.patrimonio.focus();
		return false;
	}
	if (form.solucao.value.length == 0) {
		alert("O campo Solução não pode ficar em branco!");
		form.solucao.focus();
		return false;
	}
   	return true;
}

function verifica_ordem_servico3(form) {
/*
    if (form.btnSalvar) {
	if (form.solucao.value.length == 0) {
		alert("O campo Solução não pode ficar em branco!");
		form.solucao.focus();
		return false;
	}

	if (form.data_e.value.length < 10) {
		alert("O campo Data de Entrada não foi preenchido corretamente!");
		form.data_e.focus();
		return false;
	}

	if (form.fi.value.length < 15) {
		alert("O campo Folha de Informação não foi preenchido corretamente!");
		form.fi.focus();
		return false;
	}
    }    
*/
    return true;
}

function verifica_rel_periodo(form) {
    if (form.btnPesquisar) {
		if (form.ini.value.length < 10) {
			alert("O campo Data Inicial não foi preenchido corretamente!");
			form.dataInicial.focus();
			return false;
		}

		if (form.fim.value.length < 10) {
			alert("O campo Data Final não foi preenchido corretamente!");
			form.dataFinal.focus();
			return false;
		}
    }

    return true;
}

function verificaCPF(num_cpf) {
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
