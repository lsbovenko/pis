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
                    <span v-html="item.message + '.'"></span>
                    <i>{{ item.created_at }}</i>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "CommentBlock",
        props: ['comments', 'count'],
    }
</script>