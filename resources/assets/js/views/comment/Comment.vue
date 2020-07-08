<template>
    <div>
        <div class="title">{{ideas.comments}}: <span id="count_comment">{{ query.count }}</span></div>

        <comment-block
            :comments="comments"
            :count="query.count"
            :currentUserLikedCommentsIds="currentUserLikedCommentsIds"
        >
        </comment-block>
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
                ideas: {},
                currentUserId: 0,
                commentsLikes: [],
                currentUserLikedCommentsIds: []

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
                        this.currentUserId = result.data.currentUserId;
                        this.commentsLikes = result.data.commentsLikes;
                        this.currentUserLikedCommentsIds = this.getCurrentUserLikedCommentsIds();
                        var commentsLikes = this.commentsLikes;

                        this.comments.forEach(function (comment) {
                            comment.likesCount = 0;
                            commentsLikes.forEach(function (like) {
                                if (like.comment_id == comment.id) {
                                    ++comment.likesCount;
                                }
                            });
                        });
                    })
                    .catch((error) => { });
            },
            getCurrentUserLikedCommentsIds() {
                var ids = [];
                var currentUserId = this.currentUserId;
                this.commentsLikes.forEach(function (item) {
                    if (item.user_id == currentUserId) {
                        ids.push(item.comment_id);
                    }
                });
                return ids;
            }
        }
    }
</script>