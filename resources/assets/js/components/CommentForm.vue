<template>
    <div>
        <form @submit.prevent="onSubmit">
            <textarea class="form-control" placeholder="Добавить комментарий"
                      v-model="body"
                      v-on:keyup.ctrl.enter="onSubmit">
            </textarea>
            <button type="submit" class="arrow button-comment" :disabled="disabled"></button>
        </form>
        <div id="block_preload" v-if="preloader">
            <div class="preloader"></div>
            <div class="preloader"></div>
            <div class="preloader"></div>
            <div class="preloader"></div>
        </div>
        <div v-if="result.status === 'success'">
            <div class="alert alert-success mg-top-10" v-show="visible">{{result.message}}</div>
        </div>
        <div v-else-if="result.status === 'error'">
            <div class="alert alert-danger mg-top-10" v-show="visible">{{result.message}}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CommentForm",
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

                            this.preloader = false;
                            this.body = '';

                            this.$root.$emit('renderList', true);

                            let cnt = document.getElementById('count_comment');
                            cnt.innerHTML = parseInt(cnt.innerHTML) + 1;
                            this.disabled = false;
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