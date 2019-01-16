<template>
    <div>
        <div class="title">Комментариев: {{ query.count }}</div>
        <comment-form></comment-form>

        <comment-block :comments="comments"></comment-block>
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
            this.fetchComment()
        },
        methods: {
            fetchComment() {
                axios.post('/comments/'+ideaId)
                    .then((result) => {
                        this.comments = result.data.comments;
                        this.query.count = result.data.count;
                    })
                    .catch((error) => {})
            }
        }
    }
</script>