<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3 mobile-menu">
                <main-filter-block :filters="filters"></main-filter-block>
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
    export default {
        name: "MainPage",
        components: {MainContentBlock, MainFilterBlock},
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
                }
            }
        },
        mounted() {
            this.fetchFilter();
        },
        methods: {
            fetchFilter() {
                axios.get('/get-idea/filter')
                    .then((res) => {
                        this.filters = res.data.filter;
                        this.statuses = res.data.status.status;
                    })
                    .catch( (error) => {} );
            }
        },
    }
</script>

<style scoped>

</style>