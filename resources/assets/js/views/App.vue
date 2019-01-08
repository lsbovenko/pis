<template>
    <comment-form v-bind="commentform"></comment-form>
</template>

<script>
    import CommentForm from './components/CommentForm';
    export default {
        components: {
            CommentForm
        },
        data() {
            return {
                commentform: {
                    url: '/review-idea/',
                }
            }
        }
    }
</script>

<style scoped>

</style>