<template>
    <div>

        <form @submit.prevent="onSubmit">
            <textarea class="form-control" placeholder="Добавить комментарий и отправить можно Ctrl + Enter"
                      v-model="body"
                      v-on:keyup.ctrl.enter="onSubmit"
            ></textarea>
            <button type="submit" class="arrow button-comment"></button>
        </form>

        <div v-if="result.status === 'success'">
            <div class="alert alert-success mg-top-10">{{result.message}}</div>
        </div>
        <div v-else-if="result.status === 'error'">
            <div class="alert alert-danger mg-top-10">{{result.message}}</div>
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
                    message: ''
                }
            }
        },
        methods: {
            onSubmit() {
                axios.post('/add-comment/'+ideaId, {message: this.body})
                    .then((result) => {
                        this.body = '';
                        this.result.status = result.data.status;
                        this.result.message = result.data.message;

                    })
                    .catch(error => {
                        console.log(error);
                        if (typeof error.response === 'object') {
                            this.result.status = 'error';
                            this.result.message = error.response.data.message[0];
                        } else {
                            console.log('Something went wrong. Please try again.');
                        }
                    });
            }
        }
    }
</script>>