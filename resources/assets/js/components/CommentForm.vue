<template>
    <div>
        <preloader-page v-if="preloader"></preloader-page>
        <form @submit.prevent="onSubmit">
            <button type="submit" class="arrow button-comment" :disabled="disabled"></button>
            <textarea class="form-control" v-bind:placeholder="ideas.add_comment"
                      v-model="body"
                      v-on:keyup.ctrl.enter="onSubmit">
            </textarea>
        </form>
        <div v-if="result.status === 'success'">
            <div class="alert alert-success mg-top-10" v-show="visible">{{result.message}}</div>
        </div>
        <div v-else-if="result.status === 'error'">
            <div class="alert alert-danger mg-top-10" v-show="visible">{{result.message}}</div>
        </div>
    </div>
</template>

<script>
    import PreloaderPage from './preloader/PreloaderPage';

    export default {
        name: "CommentForm",
        components: {PreloaderPage},
        props: ['ideas'],
        data(){
            return {
                body: '',
                result: {
                    status: '',
                    message: '',
                },
                visible: true,
                preloader: false,
                disabled: false,
            }
        },
        methods: {
            onSubmit() {
                this.preloader = true;
                this.disabled = true;
                axios.post('/add-comment/'+ideaId, {message: this.body})
                    .then((result) => {
                        if (result.data.status === 'success') {
                            this.result.status = result.data.status;
                            this.result.message = result.data.message;
                            this.visible = true;
                            this.body = '';

                            this.$root.$emit('renderList', true);

                            let cnt = document.getElementById('count_comment');
                            cnt.innerHTML = parseInt(cnt.innerHTML) + 1;

                            this.disabled = false;
                            this.preloader = false;
                        }
                    })
                    .catch(error => {
                        this.preloader = false;
                        if (typeof error.response === 'object') {
                            this.result.status = 'error';
                            this.result.message = error.response.data.message[0];
                            this.disabled = false;
                        } else {
                            console.log('Something went wrong. Please try again.');
                        }
                    });

                setTimeout( () => {
                    this.visible = false;
                }, 2500);
            }
        }
    }
</script>