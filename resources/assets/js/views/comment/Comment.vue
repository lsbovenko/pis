<template>
    <div>
        <div class="title">{{ideas.comments}}: <span id="count_comment">{{ query.count }}</span></div>

        <comment-block :comments="comments" :count="query.count"></comment-block>
        <hr>
        <div class="mg-top-10">
            <comment-form :ideas="ideas"></comment-form>
        </div>
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
                },
                ideas: {}
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
                        this.ideas = result.data.ideas;
                    })
                    .catch((error) => { })
            }
        }
    }
</script>