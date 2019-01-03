class Errors {
    constructor() {
        this.errors = {};
    }

    get(field) {
        if(this.errors[field]) {
            return this.errors[field][0];
        }
    }

    record(errors) {
        this.errors = errors;
    }

    clear(field) {
        delete this.errors[field]
    }
}

new Vue({
    el: '#app_add_comment',
    data: {
        message : '',
        errors: new Errors(),
        isActive: false,
        classSuccess: 'text-success',
        classDanger: 'text-danger',
    },
    methods: {
        onSubmit(e) {
            axios.post('/add-comment/' + e.target.dataset.id, this.$data)
                .then(this.onSuccess)
                .catch(error => {
                    if (typeof error.response === 'object'){
                        this.errors.record(error.response.data)
                    }else {
                        this.errors.record('Something went wrong. Please try again.');
                    }
                })

        },
        onSuccess(response) {
            jQuery('.mg-top-10')
                .removeClass('text-danger')
                .addClass('text-success');
            jQuery('#app_add_comment')
                .find('ul')
                .append('<li>' +
                    '<div class="image avatar" style="background-color: rgb(27, 217, 114);">'+jQuery('.user_avatar_name').html()+'</div>' +
                    '<div class="text-reviews">'+this.message+'</div></li>');
            this.errors.record(response.data);
            this.message = '';
            setTimeout(function () {
                jQuery('.mg-top-10').removeClass('text-success').html('');
            },2000);
        }
    }
});