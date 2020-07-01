<template>
    <div>
        <ul class="without-list-style">
            <li v-if="count > 0" v-for="item in comments">
                <div class="image" v-bind:style="'background-color: ' + item.user.icon_color">
                    {{ item.user.name.substring(0,1) }}{{ item.user.last_name.substring(0,1) }}
                </div>
                <div class="text-reviews">
                    <b>
                        {{ item.user.name }}
                        {{ item.user.last_name }}
                    </b>
                    <span v-html="item.message + '.'"></span><br>
                    <i>
                        <b :id="'count_like_' + item.id" v-show="item.likesCount">{{ item.likesCount }} likes </b>
                        {{ item.created_at }}
                    </i>
                </div>
                <div>
                    <input
                        type="checkbox"
                        :id="'comment_like_' + item.id"
                        class="like-checkbox"
                        @change="changeLike(item.id)"
                        :checked="currentUserLikedCommentsIds.includes(item.id)"
                    >
                    <label :for="'comment_like_' + item.id" class="like-label"></label>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "CommentBlock",
        props: ['comments', 'count', 'currentUserLikedCommentsIds'],
        methods: {
            changeLike(commentId) {
                var isChecked = document.getElementById('comment_like_' + commentId).checked;

                if (isChecked) {
                    axios.post('/add-like-comment', {id: commentId})
                        .then((result) => {
                            var likeCounter = document.getElementById('count_like_' + commentId);
                            likeCounter.style.display = 'inline';
                            likeCounter.innerHTML = parseInt(likeCounter.innerHTML) + 1 + ' likes';
                        })
                        .catch(error => {
                            alert('Something went wrong. Please reload page and try again.');
                        });
                } else {
                    axios.post('/remove-like-comment', {id: commentId})
                        .then((result) => {
                            var likeCounter = document.getElementById('count_like_' + commentId);
                            likeCounter.innerHTML = parseInt(likeCounter.innerHTML) - 1 + ' likes';
                            if (parseInt(likeCounter.innerHTML) == 0) {
                                likeCounter.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            alert('Something went wrong. Please reload page and try again.');
                        });
                }
            },
        },
    }
</script>