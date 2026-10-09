$(function () {
    $("#celular").mask("(00) 00000-0000")
    $("#cep").mask("00000-000")
    
    // Máscara dinâmica CPF (11 dígitos) e CNPJ (14 dígitos) para usuários
    var cpfCnpjUserMask = function (val) {
        return val.replace(/\D/g, '').length > 11 ? '00.000.000/0000-00' : '000.000.000-009';
    },
    cpfCnpjUserOptions = {
        onKeyPress: function (val, e, field, options) {
            field.mask(cpfCnpjUserMask.apply({}, arguments), options);
        }
    };
    $('#cpfUser, .cpfUser').mask(cpfCnpjUserMask, cpfCnpjUserOptions);
    $('.cnpjEmitente').mask('00.000.000/0000-00', { reverse: true });
});


$(function () {
    if ($('.cpfcnpjmine').val() != null) {
        if ($('.cpfcnpjmine').val() != "") {
            $(".cpfcnpjmine").prop('readonly', true);
        }
    }
    // Campos de usuários 100% editáveis - sem bloqueio readonly
});

$(function () {
    var telefoneN = function (val) {
        return val.replace(/\D/g, '').length > 10 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
        telefoneOptions = {
            onKeyPress: function (val, e, field, options) {
                field.mask(telefoneN.apply({}, arguments), options);
            },
        };
    $('#telefone').mask(telefoneN, telefoneOptions);
    $('#telefone').on('paste', function (e) {
        e.preventDefault();
        var clipboardCurrentData = (e.originalEvent || e).clipboardData.getData('text/plain');
        $('#telefone').val(clipboardCurrentData);
    });

});

$(document).ready(function () {
    if ($("[name='idClientes']").val()) {
        $("#nomeCliente").focus();
    } else {
        $("#documento").focus();
    }

    // INICIO FUNÇÃO DE MASCARA CPF/CNPJ
    if ($("[name='idClientes']").val()) {
        $("#nomeCliente").focus();
    } else {
        $("#documento").focus();
    }

    // Máscara dinâmica para CPF, CNPJ tradicional e CNPJ alfanumérico
    $('#documento').on('input', function () {
        let v = $(this).val().replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
        let result = '';
        // CPF: 11 dígitos numéricos
        if (/^\d{0,11}$/.test(v)) {
            for (let i = 0; i < v.length && i < 11; i++) {
                if (i === 3 || i === 6) result += '.';
                if (i === 9) result += '-';
                result += v[i];
            }
        }
        // CNPJ tradicional: 14 dígitos numéricos
        else if (/^\d{12,14}$/.test(v) && !/[A-Z]/.test(v)) {
            for (let i = 0; i < v.length && i < 14; i++) {
                if (i === 2 || i === 5) result += '.';
                if (i === 8) result += '/';
                if (i === 12) result += '-';
                result += v[i];
            }
        }
        // CNPJ alfanumérico: 14 caracteres (letras e números)
        else {
            for (let i = 0; i < v.length && i < 14; i++) {
                if (i === 2 || i === 5) result += '.';
                if (i === 8) result += '/';
                if (i === 12) result += '-';
                result += v[i];
            }
        }
        $(this).val(result);
         // FIM FUNÇÃO DE MASCARA CPF/CNPJ
    });

    function limpa_formulario_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
    }

    function capitalizeFirstLetter(string) {
        if (typeof string === 'undefined') {
            return;
        }

        return string.charAt(0).toUpperCase() + string.slice(1).toLocaleLowerCase();
    }

    function capital_letter(str) {
        if (typeof str === 'undefined' || str === null || !str) {
            return '';
        }
        var words = str.toString().trim().toLocaleLowerCase().split(/\s+/);
        var preps = ['de', 'da', 'do', 'dos', 'das', 'e', 'em', 'para', 'com', 'por', 'a', 'o', 'as', 'os'];

        for (var i = 0; i < words.length; i++) {
            var word = words[i];
            if (word.length > 0) {
                if (i > 0 && preps.indexOf(word) !== -1) {
                    words[i] = word;
                } else {
                    words[i] = word.charAt(0).toUpperCase() + word.slice(1);
                }
            }
        }

        return words.join(" ");
    }

    // Valida CNPJ
    // Função auxiliar para calcular o DV alfanumérico
    function valorCharAlfanumerico(char) {
        const ascii = char.charCodeAt(0);
        return ascii - 48;
    }

    // Função auxiliar para calcular o DV alfanumérico
    function calcularDVAlfanumerico(cnpjBase) {
        let valores = cnpjBase.split('').map(valorCharAlfanumerico);

        // Cálculo do 1º DV
        let pesos1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        let soma1 = valores.reduce((acc, val, i) => acc + val * pesos1[i], 0);
        let resto1 = soma1 % 11;
        let dv1 = (resto1 === 0 || resto1 === 1) ? 0 : 11 - resto1;

        // Cálculo do 2º DV
        valores.push(dv1);
        let pesos2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        let soma2 = valores.reduce((acc, val, i) => acc + val * pesos2[i], 0);
        let resto2 = soma2 % 11;
        let dv2 = (resto2 === 0 || resto2 === 1) ? 0 : 11 - resto2;

        return `${dv1}${dv2}`;
    }

    function validarCNPJ(cnpj) {
        if (!cnpj) return false;
        cnpj = cnpj.toString().replace(/[^\w]/g, '').toUpperCase();

        // CNPJ numérico tradicional
        if (/^\d{14}$/.test(cnpj)) {
            if (/^(\d)\1{13}$/.test(cnpj)) {
                return false;
            }

            let tamanho = cnpj.length - 2;
            let numeros = cnpj.substring(0, tamanho);
            let digitos = cnpj.substring(tamanho);

            let soma = 0;
            let pos = tamanho - 7;
            for (let i = tamanho; i >= 1; i--) {
                soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
                if (pos < 2) pos = 9;
            }

            let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
            if (resultado != parseInt(digitos.charAt(0))) {
                return false;
            }

            tamanho = tamanho + 1;
            numeros = cnpj.substring(0, tamanho);
            soma = 0;
            pos = tamanho - 7;
            for (let i = tamanho; i >= 1; i--) {
                soma += parseInt(numeros.charAt(tamanho - i)) * pos--;
                if (pos < 2) pos = 9;
            }
            resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

            return resultado == parseInt(digitos.charAt(1));
        }

        // CNPJ alfanumérico
        if (/^[A-Z0-9]{12}\d{2}$/.test(cnpj)) {
            let base = cnpj.substring(0, 12);
            let dv = cnpj.substring(12, 14);
            const calculado = calcularDVAlfanumerico(base);
            return calculado === dv;
        }

        return false;
    }
    // Finaliza a validação do CNPJ

    $('#buscar_info_cnpj').on('click', function () {
        var rawDoc = ($('#documento').val() || '').trim();
        var cleanDoc = rawDoc.replace(/\D/g, '');

        if (!cleanDoc) {
            Swal.fire({
                icon: "warning",
                title: "Atenção",
                text: "Por favor, digite o CPF ou CNPJ antes de buscar."
            });
            return;
        }

        // Orientação clara caso o usuário informe CPF (Pessoa Física)
        if (cleanDoc.length === 11) {
            Swal.fire({
                icon: "info",
                title: "Consulta Indisponível para CPF",
                text: "A consulta automática via Receita Federal está disponível apenas para empresas (CNPJ). Para pessoas físicas (CPF), por favor preencha os dados cadastrais manualmente."
            });
            return;
        }

        // Se for CNPJ alfanumérico contendo letras
        if (/[A-Z]/.test(rawDoc.replace(/[^A-Z0-9]/g, ''))) {
            Swal.fire({
                icon: "info",
                title: "Atenção",
                text: "A consulta automática ainda não está disponível para o formato alfanumérico. Preencha os dados manualmente."
            });
            return;
        }

        // Validação de comprimento do CNPJ
        if (cleanDoc.length !== 14) {
            Swal.fire({
                icon: "warning",
                title: "Dígitos Incompletos",
                text: "O CNPJ precisa conter exatamente 14 dígitos (foram informados apenas " + cleanDoc.length + " dígitos). Verifique o número digitado."
            });
            return;
        }

        // Validação dos dígitos verificadores da Receita Federal
        if (!validarCNPJ(cleanDoc)) {
            Swal.fire({
                icon: "warning",
                title: "CNPJ Inválido",
                text: "Os dígitos verificadores do CNPJ informado não conferem. Verifique e tente novamente."
            });
            return;
        }

        // Backup dos valores existentes para evitar campos presos com '...' caso não encontre
        var previousValues = {
            nomeCliente: $('#nomeCliente').val() || '',
            nomeEmitente: $('#nomeEmitente').val() || '',
            contato: $('.contato').val() || '',
            cep: $('#cep').val() || '',
            rua: $('#rua').val() || '',
            numero: $('#numero').val() || '',
            complemento: $('#complemento').val() || '',
            bairro: $('#bairro').val() || '',
            cidade: $('#cidade').val() || '',
            estado: $('#estado').val() || '',
            email: $('#email').val() || '',
            telefone: $('#telefone').val() || '',
            celular: $('#celular').val() || ''
        };

        var $btn = $('#buscar_info_cnpj');
        var btnOriginalContent = $btn.html();
        $btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin"></i> Buscando...');

        // Feedback visual amigável enquanto consulta os servidores
        if ($('#nomeCliente').length) $('#nomeCliente').val("Buscando dados na Receita...");
        if ($('#nomeEmitente').length) $('#nomeEmitente').val("Buscando dados na Receita...");
        if ($('#cep').length) $('#cep').val("...");
        if ($('#rua').length) $('#rua').val("...");
        if ($('#numero').length) $('#numero').val("...");
        if ($('#complemento').length) $('#complemento').val("...");
        if ($('#bairro').length) $('#bairro').val("...");
        if ($('#cidade').length) $('#cidade').val("...");
        if ($('#telefone').length) $('#telefone').val("...");
        if ($('#email').length) $('#email').val("...");

        function preencherCampos(dados) {
            if (!dados) {
                falhaConsulta();
                return;
            }

            var razaoSocial = dados.razao_social || dados.nome || '';
            var nomeFantasia = dados.nome_fantasia || dados.fantasia || '';
            var logradouro = (dados.logradouro || '').toString().trim();
            var tipoLogr = (dados.descricao_tipo_de_logradouro || '').toString().trim();
            if (tipoLogr && !logradouro.toLowerCase().startsWith(tipoLogr.toLowerCase())) {
                logradouro = tipoLogr + ' ' + logradouro;
            }
            var numero = (dados.numero || '').toString().trim();
            if (!numero) numero = 'S/N';
            var complemento = (dados.complemento || '').toString().trim();
            var bairro = (dados.bairro || '').toString().trim();
            var municipio = (dados.municipio || '').toString().trim();
            var uf = (dados.uf || '').toString().trim().toUpperCase();

            var rawCep = (dados.cep || '').toString().replace(/\D/g, '');
            var cep = rawCep;
            if (rawCep.length === 8) {
                cep = rawCep.substring(0, 5) + '-' + rawCep.substring(5);
            }

            var tel = (dados.ddd_telefone_1 || dados.telefone || '').toString().trim();
            if (tel && tel.indexOf('/') !== -1) {
                tel = tel.split('/')[0].trim();
            }
            var cleanTel = tel.replace(/\D/g, '');
            if (cleanTel.length === 10) {
                tel = '(' + cleanTel.substring(0, 2) + ') ' + cleanTel.substring(2, 6) + '-' + cleanTel.substring(6);
            } else if (cleanTel.length === 11) {
                tel = '(' + cleanTel.substring(0, 2) + ') ' + cleanTel.substring(2, 7) + '-' + cleanTel.substring(7);
            }

            var cel = (dados.ddd_telefone_2 || '').toString().trim();
            var cleanCel = cel.replace(/\D/g, '');
            if (cleanCel.length === 11) {
                cel = '(' + cleanCel.substring(0, 2) + ') ' + cleanCel.substring(2, 7) + '-' + cleanCel.substring(7);
            } else if (cleanCel.length === 10) {
                cel = '(' + cleanCel.substring(0, 2) + ') ' + cleanCel.substring(2, 6) + '-' + cleanCel.substring(6);
            }

            var email = (dados.email || '').toString().trim().toLowerCase();

            var contato = '';
            if (dados.qsa && Array.isArray(dados.qsa) && dados.qsa.length > 0) {
                contato = (dados.qsa[0].nome_socio || dados.qsa[0].nome || '').toString().trim();
            }

            // Popula os campos do formulário
            if ($('#nomeCliente').length) $('#nomeCliente').val(capital_letter(razaoSocial));
            if ($('#nomeEmitente').length) $('#nomeEmitente').val(capital_letter(razaoSocial));
            if ($('.contato').length && contato) $('.contato').val(capital_letter(contato));
            if ($('#cep').length) $('#cep').val(cep).trigger('input');
            if ($('#rua').length) $('#rua').val(capital_letter(logradouro));
            if ($('#numero').length) $('#numero').val(numero);
            if ($('#complemento').length) $('#complemento').val(capital_letter(complemento));
            if ($('#bairro').length) $('#bairro').val(capital_letter(bairro));
            if ($('#cidade').length) $('#cidade').val(capital_letter(municipio));
            if ($('#telefone').length && tel) $('#telefone').val(tel).trigger('input');
            if ($('#celular').length && cel) $('#celular').val(cel).trigger('input');
            if ($('#email').length && email) $('#email').val(email);

            // Popula e sincroniza estado
            if ($('#estado').length && uf) {
                if (!$('#estado option[value="' + uf + '"]').length) {
                    $('#estado').append(new Option(uf, uf));
                }
                $('#estado').val(uf).trigger('change');
            }

            $btn.prop('disabled', false).html(btnOriginalContent);

            Swal.fire({
                icon: "success",
                title: "Empresa Localizada!",
                text: capital_letter(razaoSocial) + (nomeFantasia ? ' (' + capital_letter(nomeFantasia) + ')' : ''),
                timer: 3000,
                showConfirmButton: false
            });

            if ($('#nomeCliente').length) $('#nomeCliente').focus();
            else if ($('#nomeEmitente').length) $('#nomeEmitente').focus();
        }

        function falhaConsulta(mensagem) {
            // Restaura campos para evitar que fiquem com "..."
            if ($('#nomeCliente').length) $('#nomeCliente').val(previousValues.nomeCliente);
            if ($('#nomeEmitente').length) $('#nomeEmitente').val(previousValues.nomeEmitente);
            if ($('.contato').length) $('.contato').val(previousValues.contato);
            if ($('#cep').length) $('#cep').val(previousValues.cep);
            if ($('#rua').length) $('#rua').val(previousValues.rua);
            if ($('#numero').length) $('#numero').val(previousValues.numero);
            if ($('#complemento').length) $('#complemento').val(previousValues.complemento);
            if ($('#bairro').length) $('#bairro').val(previousValues.bairro);
            if ($('#cidade').length) $('#cidade').val(previousValues.cidade);
            if ($('#estado').length) $('#estado').val(previousValues.estado);
            if ($('#telefone').length) $('#telefone').val(previousValues.telefone);
            if ($('#celular').length) $('#celular').val(previousValues.celular);
            if ($('#email').length) $('#email').val(previousValues.email);

            $btn.prop('disabled', false).html(btnOriginalContent);

            Swal.fire({
                icon: "warning",
                title: "CNPJ Não Encontrado",
                text: mensagem || "Não foi possível localizar os dados deste CNPJ na Receita Federal. Verifique o número ou preencha manualmente."
            });
        }

        // TENTATIVA 1: BrasilAPI (Direta, alta performance, CORS habilitado nativamente)
        $.ajax({
            url: "https://brasilapi.com.br/api/cnpj/v1/" + cleanDoc,
            type: "GET",
            dataType: "json",
            timeout: 5500
        }).done(function (data) {
            if (data && (data.razao_social || data.nome_fantasia)) {
                preencherCampos(data);
            } else {
                tentarMinhaReceita();
            }
        }).fail(function () {
            tentarMinhaReceita();
        });

        // TENTATIVA 2: Minha Receita (Fallback 1 público)
        function tentarMinhaReceita() {
            $.ajax({
                url: "https://minhareceita.org/" + cleanDoc,
                type: "GET",
                dataType: "json",
                timeout: 5500
            }).done(function (data) {
                if (data && (data.razao_social || data.nome_fantasia)) {
                    preencherCampos(data);
                } else {
                    tentarProxyInterno();
                }
            }).fail(function () {
                tentarProxyInterno();
            });
        }

        // TENTATIVA 3: Proxy Interno no Servidor ZenyDesk (Supera bloqueios locais de rede, adblock e extensões)
        function tentarProxyInterno() {
            var urlBase = window.BaseUrl || '';
            if (urlBase && !urlBase.endsWith('/')) urlBase += '/';
            var proxyUrl = urlBase + 'index.php/clientes/consultaCnpj/' + cleanDoc;

            $.ajax({
                url: proxyUrl,
                type: "GET",
                dataType: "json",
                timeout: 7500
            }).done(function (res) {
                if (res && res.status === 'OK' && res.data) {
                    preencherCampos(res.data);
                } else {
                    tentarReceitaWs();
                }
            }).fail(function () {
                tentarReceitaWs();
            });
        }

        // TENTATIVA 4: ReceitaWS via JSONP (Fallback clássico)
        function tentarReceitaWs() {
            $.ajax({
                url: "https://www.receitaws.com.br/v1/cnpj/" + cleanDoc,
                dataType: 'jsonp',
                crossDomain: true,
                contentType: "text/javascript",
                timeout: 8000,
                success: function (data) {
                    if (data && data.status === "OK") {
                        preencherCampos(data);
                    } else {
                        falhaConsulta(data && data.message ? data.message : "CNPJ não encontrado na base da Receita Federal.");
                    }
                },
                error: function () {
                    falhaConsulta("Não foi possível conectar aos servidores da Receita Federal no momento. Verifique sua conexão ou preencha os dados manualmente.");
                }
            });
        }
    });

    // Pressionar ENTER no campo documento dispara a busca automaticamente
    $('#documento').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#buscar_info_cnpj').click();
        }
    });

    //Quando o campo cep perde o foco.
    $("#cep").blur(function () {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.

            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.

            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#estado").val("...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep.replace(/\./g, '') + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulario_cep();
                        Swal.fire({
                            type: "warning",
                            title: "Atenção",
                            text: "CEP não encontrado."
                        });
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulario_cep();
                Swal.fire({
                    type: "error",
                    title: "Atenção",
                    text: "Formato de CEP inválido."
                });
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulario_cep();
        }
    });
}); 
