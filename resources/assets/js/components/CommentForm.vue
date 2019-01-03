<template>
    <div class="reviews col-md-12" id="app_add_comment">
        <div class="title">Комментариев: </div>
        <form @submit.prevent="onSubmit">
            <textarea class="form-control" placeholder="Добавить комментарий" v-model="body"></textarea>
            <button type="submit" class="arrow button-comment"></button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "CommentForm",
        data(){
            return {
                body: ''
            }
        },
        methods: {
            onSubmit() {

            }
        }
    }
</script>

<style scoped>

</style>