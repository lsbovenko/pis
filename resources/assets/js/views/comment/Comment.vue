<template>
    <div>
        <div class="title">Комментариев: <span id="count_comment">{{ query.count }}</span></div>
        <comment-form></comment-form>

        <comment-block :comments="comments" :count="query.count"></comment-block>
    </div>
</template>

<script>
    import CommentForm from '../../components/CommentForm';
    import CommentBlock from "../../components/comment/CommentBlock";

    export default {
        name: "Comment",
        components: {CommentBlock, CommentForm},
        data() {
            return {
                comments: {
                    data: []
                },
                query: {
                    count: 0
                }
            }
        },
        mounted () {
            this.fetchComment();
            this.$root.$on('renderList', (res) => {
                if (res == true) {
                    this.fetchComment();
                }
            })
        },
        methods: {
            fetchComment() {
                axios.get('/comments/'+ideaId)
                    .then((result) => {
                        this.comments = result.data.comments;
                        this.query.count = result.data.count;
                    })
                    .catch((error) => { })
            }
        }
    }
</script>