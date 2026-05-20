document.addEventListener('DOMContentLoaded', function () {
    const trigger = document.querySelector('.nav-toggle');
    const menu = document.querySelector('.navbar');

    if (trigger && menu) {
        trigger.addEventListener('click', function () {
            menu.classList.toggle('navbar-open');
        });
    }

    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const inputs = Array.from(form.querySelectorAll('input[required], textarea[required], select[required]'));
            let valid = true;

            inputs.forEach(function (input) {
                if (!input.value.trim()) {
                    valid = false;
                    input.classList.add('input-invalid');
                } else {
                    input.classList.remove('input-invalid');
                }
            });

            if (!valid) {
                event.preventDefault();
            }
        });
    });
});
