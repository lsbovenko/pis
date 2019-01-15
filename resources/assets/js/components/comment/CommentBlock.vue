<template>
    <div>
        <ul>
            <li v-for="item in comments">
                {{item}}
            </li>
        </ul>
    </div>
</template>

<script>

    export default {
        name: "CommentBlock",
        props: {
            comments: {}
        }
    }
</script>