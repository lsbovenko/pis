<template>
    <div class="custom-container">
        <preloader-page v-if="preloader"></preloader-page>
        <div class="main-wrapper">
            <div class="mobile-menu left-sidebar">
                <main-filter-block :filters="filters" :users="users" :activeStatusId="activeStatusId" :ideas="ideas"></main-filter-block>
            </div>
            <div class="main-content">
                <main-content-block :statuses="statuses" :ideas="ideas"></main-content-block>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import MainFilterBlock from './main/MainFilterBlock';
    import MainContentBlock from './main/MainContentBlock';
    import PreloaderPage from './preloader/PreloaderPage';

    export default {
        name: "MainPage",
        components: {MainContentBlock, MainFilterBlock, PreloaderPage},
        data() {
            return {
                filters: {
                    data: []
                },
                statuses: {
                    data: []
                },
                resultFilter: {
                    data: []
                },
                users: {
                    data: []
                },
                preloader: true,
                activeStatusId: '',
                ideas: {}
            }
        },
        mounted() {
            this.fetchFilter();
            this.$root.$on('preloaderPage', (res) => {
                this.preloader = res;
            });
            this.$root.$on('changeUserSelect', (result) => {
                if (result.data) {
                    axios.get('/department/' + result.data + '/users')
                        .then((res) => {
                            Vue.set(this.$data, 'users', res.data.users);
                        });
                } else {
                    axios.get('/departments/users')
                        .then((res) => {
                            Vue.set(this.$data, 'users', res.data.users);
                        });
                }
            });
        },
        methods: {
            fetchFilter() {
                axios.get('/get-idea/filter')
                    .then((res) => {
                        this.filters = res.data.filter;
                        this.statuses = res.data.status.status;
                        this.users = res.data.users;
                        this.activeStatusId = Object.keys(this.statuses)[0];
                        this.ideas = res.data.ideas;
                    })
                    .catch( (error) => {} );
            }
        },
    }
</script>
