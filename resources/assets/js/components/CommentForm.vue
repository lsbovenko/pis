<template>
    <div>
        <preloader-page v-if="preloader"></preloader-page>
        <form @submit.prevent="onSubmit">
            <button type="submit" class="arrow button-comment" :disabled="disabled"></button>
            <at :members="mentionItems" v-model="body" name-key="username">
                <template slot="item" slot-scope="s">
                    <span v-html="s.item.userlogo"></span>
                    <span v-text="s.item.username"></span>
                </template>
                <span v-if="false">Warning! Class js-mention is used in regular expression in file IdeaComment.php</span>
                <span slot="embeddedItem" slot-scope="s">
                    <span class="js-mention">@{{ s.current.username }}</span>
                </span>
                <div class="form-control comment-area"
                     contenteditable
                     @focus="onFocusComment"
                     @blur="onOutFocusComment"
                     v-on:keyup.ctrl.enter="onSubmit"
                >
                </div>
            </at>
        </form>
        <div v-if="result.status === 'success'">
            <div class="alert alert-success mg-top-10" v-show="visible">{{result.message}}</div>
        </div>
        <div v-else-if="result.status === 'error'">
            <div class="alert alert-danger mg-top-10" v-show="visible">{{result.message}}</div>
        </div>
    </div>
</template>

<script>
    import PreloaderPage from './preloader/PreloaderPage';
    import At from 'vue-at';
    import Vue from 'vue';

    export default {
        name: "CommentForm",
        components: {PreloaderPage, At},
        props: ['ideas'],
        data(){
            return {
                body: '',
                result: {
                    status: '',
                    message: '',
                },
                visible: true,
                preloader: false,
                disabled: false,
                placeholder: '<span style="color: #9c9c9c;">Add a comment</span>',  //it`s used as placeholder for div contenteditable
                users: []
            }
        },
        mounted() {
            this.body = this.placeholder;
            axios.get('/active-users')
                .then((res) => {
                    Vue.set(this.$data, 'users', res.data.users);
                });
        },
        computed: {
            mentionItems() {
               var items = [];
               this.$data.users.forEach(function (user) {
                   if (user.name && user.last_name) {
                       var mentionItem = [];
                       var userLetters = user.name[0] + user.last_name[0];
                       mentionItem['userlogo'] =
                           '<span class="mention-logo" style="background-color:' + user.icon_color + ';">'
                           + userLetters + '</span>';
                       mentionItem['username'] = user.name + " " + user.last_name;
                       items.push(mentionItem);
                   }
               });

                return items;
            }
        },
        methods: {
            onFocusComment() {
                if (this.body == this.placeholder) {
                    this.body = '';
                }
            },
            onOutFocusComment() {
                if (this.body == '') {
                    this.body = this.placeholder;
                }
            },
            onSubmit() {
                this.preloader = true;
                this.disabled = true;
                //this validation is necessary because div contenteditable is used and unwanted tags are inserted into comment
                this.body = this.body.replace(/&nbsp;|<\/div>|<span data-at-embedded="" contenteditable="false">| <\/span>/g, '');
                this.body = this.body.replace(/<div>/g, ' ');
                axios.post('/add-comment/'+ideaId, {message: this.body})
                    .then((result) => {
                        if (result.data.status === 'success') {
                            this.result.status = result.data.status;
                            this.result.message = result.data.message;
                            this.visible = true;
                            this.body = '';

                            this.$root.$emit('renderList', true);

                            let cnt = document.getElementById('count_comment');
                            cnt.innerHTML = parseInt(cnt.innerHTML) + 1;

                            this.disabled = false;
                            this.preloader = false;
                        }
                    })
                    .catch(error => {
                        this.preloader = false;
                        if (typeof error.response === 'object') {
                            this.result.status = 'error';
                            this.result.message = error.response.data.message[0];
                            this.disabled = false;
                        } else {
                            console.log('Something went wrong. Please try again.');
                        }
                    });

                setTimeout( () => {
                    this.visible = false;
                }, 2500);
            }
        }
    }
</script>