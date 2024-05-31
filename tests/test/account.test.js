const assert = require('assert');

global.document = {
    getElementById: function (id) {
        if (id === 'registration-form') {
            return formElement;
        } else if (id === 'response-message') {
            return responseMessageElement;
        }
        return null;
    }
};

global.FormData = function () { };

global.fetch = async function (url, options) {
    return fetchResponse;
};

const formElement = {
    addEventListener: function (event, callback) {
        this.submitHandler = callback;
    },
    submit: function () {
        this.submitHandler({ preventDefault: preventDefaultSpy });
    }
};

const responseMessageElement = {
    innerHTML: ''
};

let preventDefaultCalled = false;
const preventDefaultSpy = () => { preventDefaultCalled = true; };

let fetchResponse;

global.window = {
    location: {
        href: ''
    }
};

require('../account.js');

describe('Registration form submission', function () {
    beforeEach(function () {
        responseMessageElement.innerHTML = '';
        fetchResponse = {
            ok: false,
            text: async function () { return 'Error'; }
        };
        preventDefaultCalled = false;
        global.window.location.href = '';
    });

    it('should prevent default form submission', async function () {
        await formElement.submitHandler({ preventDefault: preventDefaultSpy });
        assert.strictEqual(preventDefaultCalled, true);
    });

    it('should display success message on successful registration', async function () {
        fetchResponse.ok = true;
        fetchResponse.text = async function () { return 'Success'; };

        await formElement.submitHandler({ preventDefault: preventDefaultSpy });

        assert.strictEqual(responseMessageElement.innerHTML, 'Регистрация прошла успешно!');
        assert.strictEqual(global.window.location.href, '../index.php');
    });

    it('should display error message on registration error', async function () {
        await formElement.submitHandler({ preventDefault: preventDefaultSpy });

        assert.strictEqual(responseMessageElement.innerHTML, 'Ошибка регистрации. Попробуйте снова.');
    });

    it('should display error message on fetch exception', async function () {
        global.fetch = async function (url, options) {
            throw new Error('Fetch error');
        };

        await formElement.submitHandler({ preventDefault: preventDefaultSpy });

        assert.strictEqual(responseMessageElement.innerHTML, 'Ошибка регистрации. Попробуйте снова.');
    });
});