<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3 mobile-menu">
                <main-filter-block :filters="filters"></main-filter-block>
            </div>
            <div class="col-md-9 main-content sameblock">
                <main-content-block></main-content-block>
            </div>
        </div>
    </div>
</template>

<script>
    import MainFilterBlock from './main/MainFilterBlock';
    import MainContentBlock from './main/MainContentBlock';
    export default {
        name: "MainPage",
        data() {
            return {
                filters: {
                    data: []
                }
            }
        },
        mounted() {
            this.fetchFilter()
        },
        methods: {
            fetchFilter() {
                axios.get('/get-idea/filter')
                    .then((res) => {
                        console.log(res);
                        //Vue.set(this.$data, 'filters', res.data.filter);
                        this.filters = res.data.filter;
                    })
                    .catch( (error) => {} );
            }
        },
        components: {MainContentBlock, MainFilterBlock},
    }
</script>

<style scoped>

</style>