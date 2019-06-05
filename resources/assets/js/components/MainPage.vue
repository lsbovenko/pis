<template>
    <div class="container">
        <preloader-page v-if="preloader"></preloader-page>
        <div class="row">
            <div class="col-md-3 mobile-menu">
                <main-filter-block :filters="filters" :users="users" :activeStatusId="activeStatusId"></main-filter-block>
            </div>
            <div class="col-md-9 main-content sameblock">
                    <main-content-block :statuses="statuses"></main-content-block>
            </div>
        </div>
    </div>
</template>

<script>
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
                activeStatusId: ''
            }
        },
        mounted() {
            this.fetchFilter();
            this.$root.$on('preloaderPage', (res) => {
                this.preloader = res;
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
                    })
                    .catch( (error) => {} );
            }
        },
    }
</script>