class AjaxForm {
    constructor(options = {}) {
        this.form = options.form;
        this.method = options.method || 'POST';;
        this.submitCallback = options.submitCallback || null;
    }

    async sendRequest() {
        try {
            const formData = new FormData(this.form);

            const response = await fetch(this.form.action, {
                method: this.method,
                headers: {
                    "X-CSRF-Token": formData.get('_token') || CSRF_TOKEN,
                },
                body: formData,
            });

            if(!response.ok) {
                throw new Error('Request failed!');
            }

            const json = await response.json();

            this.form.reset();

            alert('Success!');

            return json;
        } catch(error) {
            console.error(error);
        }
    }

    listen() {
        this.form.addEventListener('submit', (e) => {
            e.preventDefault();

            if (this.submitCallback) {
                this.submitCallback();
            }

            this.sendRequest();
        });
    }
}