class FormValidator {
    constructor(formId, rules) {
        this.form = document.getElementById(formId);
        this.rules = rules;
    }

    validate() {
        this.errors = {}; // Limpiar errores previos

        Object.keys(this.rules).forEach((field) => {
            const fieldElement = this.form.querySelector(`[name="${field}"]`);
            const fieldRules = this.rules[field];
            const fieldValue = fieldElement.value.trim();

            fieldRules.forEach((rule) => {
                let ruleName, ruleValue;
                if (typeof rule === 'string') {
                    ruleName = rule;
                    ruleValue = null;
                } else {
                    ruleName = Object.keys(rule)[0];
                    ruleValue = rule[ruleName];
                }

                if (!this[ruleName](fieldValue, ruleValue, fieldElement)) {
                    if (!this.errors[field]) {
                        this.errors[field] = [];
                    }
                    this.errors[field].push(this.getErrorMessage(ruleName, ruleValue));
                }
            });
        });

        if (Object.keys(this.errors).length > 0) {
            return { valid: false, errors: this.errors };
        } else {
            return { valid: true };
        }
    }

    getErrorMessage(rule, value) {
        const messages = {
            required: 'este campo es obligatorio',
            validEmail: 'este campo debe ser un email válido',
            minLength: `este campo debe tener al menos ${value} caracteres`,
            maxLength: `este campo no debe exceder de ${value} caracteres`,
            validNumber: 'este campo debe ser un número válido',
            min: `el número debe ser mayor o igual a ${value}`,
            max: `el número debe ser menor o igual a ${value}`,
            selectRequired: 'debe seleccionar una opción'
        };
        return messages[rule];
    }

    required(value) {
        return value !== '';
    }

    validEmail(value) {
        const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        return re.test(value);
    }

    minLength(value, length) {
        return value.length >= length;
    }

    maxLength(value, length) {
        return value.length <= length;
    }

    validNumber(value) {
        return !isNaN(value) && value !== '';
    }

    min(value, minValue) {
        return parseFloat(value) >= minValue;
    }

    max(value, maxValue) {
        return parseFloat(value) <= maxValue;
    }

    selectRequired(value, _, fieldElement) {
        return fieldElement.selectedIndex !== 0;
    }
}