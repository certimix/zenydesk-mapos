function getCookie(name) {
    if (!name) return null;
    var match = document.cookie.match(new RegExp('(^|;\\s*)' + name + '=([^;]+)'));
    if (match) {
        return decodeURIComponent(match[2]);
    }
    return null;
}

function setCsrfTokenInAllForms(csrfTokenName, csrfCookieName) {
    if (!csrfTokenName) return;
    var cookieVal = getCookie(csrfCookieName);
    var forms = document.querySelectorAll("form");
    forms.forEach(function (form) {
        var existing = form.querySelector('input[name="' + csrfTokenName + '"]');
        if (!existing) {
            if (cookieVal) {
                var csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = csrfTokenName;
                csrfInput.value = cookieVal;
                form.appendChild(csrfInput);
            }
        } else if (cookieVal) {
            existing.value = cookieVal;
        }
    });
}

$(document).ready(function () {
    // Add CSRF token input to each form and ajax requests
    var csrfTokenName = $('meta[name="csrf-token-name"]').attr('content');
    var csrfCookieName = $('meta[name="csrf-cookie-name"]').attr('content');

    setCsrfTokenInAllForms(csrfTokenName, csrfCookieName);

    // Garante que antes de qualquer submit de formulario o token CSRF esteja presente e atualizado
    $(document).on('submit', 'form', function () {
        if (csrfTokenName && csrfCookieName) {
            var tokenVal = getCookie(csrfCookieName);
            if (tokenVal) {
                var input = $(this).find('input[name="' + csrfTokenName + '"]');
                if (input.length === 0) {
                    $(this).prepend('<input type="hidden" name="' + csrfTokenName + '" value="' + tokenVal + '">');
                } else {
                    input.val(tokenVal);
                }
            }
        }
    });

    $.ajaxSetup({
        credentials: "include",
        beforeSend: function (jqXHR, settings) {
            if (typeof settings.data === 'object') {
                settings.data[csrfTokenName] = getCookie(csrfCookieName);
            } else {
                settings.data += '&' + $.param({
                    [csrfTokenName]: getCookie(csrfCookieName)
                });
            }

            return true;
        },
        complete: function () {
            setCsrfTokenInAllForms(csrfTokenName, csrfCookieName);
        }
    });
});
