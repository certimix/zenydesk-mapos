function getCookie(name) {
    if (!name) return null;
    var match = document.cookie.match(new RegExp('(^|;\\s*)' + name + '=([^;]+)'));
    if (match) {
        return decodeURIComponent(match[2]);
    }
    return null;
}

function getCsrfTokenName() {
    var meta = document.querySelector('meta[name="csrf-token-name"]');
    if (meta && meta.content) return meta.content;
    return 'MAPOS_CSRF_TOKEN';
}

function getCsrfCookieName() {
    var meta = document.querySelector('meta[name="csrf-cookie-name"]');
    if (meta && meta.content) return meta.content;
    return 'MAPOS_CSRF_COOKIE';
}

function getCsrfToken() {
    var cookieName = getCsrfCookieName();
    var tokenName = getCsrfTokenName();

    // 1. Tentar ler da meta tag gerada pelo CodeIgniter no PHP (fonte primaria mais confiavel)
    var metaHash = document.querySelector('meta[name="csrf-token-hash"]');
    if (metaHash && metaHash.content && metaHash.content.length > 5) {
        return metaHash.content;
    }

    // 2. Tentar ler do cookie
    var cookieVal = getCookie(cookieName) || getCookie('MAPOS_CSRF_COOKIE') || getCookie('MAPOS_COOKIE') || getCookie('csrf_cookie_name');
    if (cookieVal && cookieVal.length > 5) {
        return cookieVal;
    }

    // 3. Tentar ler de qualquer input hidden existente
    var existingInput = document.querySelector('input[name="' + tokenName + '"]');
    if (existingInput && existingInput.value && existingInput.value.length > 5) {
        return existingInput.value;
    }

    return null;
}

function updateCsrfMeta(newToken) {
    if (!newToken) return;
    var metaHash = document.querySelector('meta[name="csrf-token-hash"]');
    if (metaHash) {
        metaHash.setAttribute('content', newToken);
    }
}

function setCsrfTokenInAllForms() {
    var csrfTokenName = getCsrfTokenName();
    var tokenVal = getCsrfToken();
    if (!tokenVal || !csrfTokenName) return;

    var forms = document.querySelectorAll("form");
    forms.forEach(function (form) {
        var method = (form.getAttribute("method") || "GET").toUpperCase();
        if (method !== "POST") return;

        var existing = form.querySelector('input[name="' + csrfTokenName + '"]');
        if (!existing) {
            var csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = csrfTokenName;
            csrfInput.value = tokenVal;
            form.prepend(csrfInput);
        } else {
            existing.value = tokenVal;
        }
    });
}

$(document).ready(function () {
    var csrfTokenName = getCsrfTokenName();

    // Preenche em todos os formularios carregados
    setCsrfTokenInAllForms();

    // Garante token em formularios abertos via modais bootstrap
    $(document).on('shown.bs.modal', function () {
        setCsrfTokenInAllForms();
    });

    // Intercepta qualquer submit de formulario POST
    $(document).on('submit', 'form', function () {
        var form = $(this);
        var method = (form.attr('method') || 'GET').toUpperCase();
        if (method !== 'POST') return true;

        var tokenVal = getCsrfToken();
        if (tokenVal && csrfTokenName) {
            var input = form.find('input[name="' + csrfTokenName + '"]');
            if (input.length === 0) {
                form.prepend('<input type="hidden" name="' + csrfTokenName + '" value="' + tokenVal + '">');
            } else {
                input.val(tokenVal);
            }
        }
        return true;
    });

    // Configuracao AJAX global com jQuery
    $.ajaxSetup({
        credentials: "include",
        beforeSend: function (jqXHR, settings) {
            var tokenVal = getCsrfToken();
            if (!tokenVal || !csrfTokenName) return true;

            var type = (settings.type || 'GET').toUpperCase();
            if (type === 'POST' || type === 'PUT' || type === 'DELETE') {
                // Header customizado CSRF
                jqXHR.setRequestHeader('X-CSRF-TOKEN', tokenVal);

                if (window.FormData && settings.data instanceof FormData) {
                    if (!settings.data.has(csrfTokenName)) {
                        settings.data.append(csrfTokenName, tokenVal);
                    }
                } else if (typeof settings.data === 'object' && settings.data !== null) {
                    settings.data[csrfTokenName] = tokenVal;
                } else if (typeof settings.data === 'string') {
                    if (settings.data.indexOf(encodeURIComponent(csrfTokenName) + '=') === -1 &&
                        settings.data.indexOf(csrfTokenName + '=') === -1) {
                        settings.data += (settings.data.length ? '&' : '') +
                            encodeURIComponent(csrfTokenName) + '=' + encodeURIComponent(tokenVal);
                    }
                }
            }
            return true;
        },
        complete: function (jqXHR) {
            var headerToken = jqXHR.getResponseHeader('X-CSRF-TOKEN');
            if (headerToken) {
                updateCsrfMeta(headerToken);
            }
            setCsrfTokenInAllForms();
        }
    });
});
