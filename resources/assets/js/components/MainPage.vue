<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3 mobile-menu">
                <main-filter-block></main-filter-block>
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
        components: {MainContentBlock, MainFilterBlock}
    }
</script>

<style scoped>

</style>