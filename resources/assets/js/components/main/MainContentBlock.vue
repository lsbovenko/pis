<template>
    <div class="content-idea">
        <div class="row info-row">
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего</li>
                        <li>Кукареко Александр (14)</li>
                        <li>Ивашкин Вячеслав (5)</li>
                        <li>Полюшкин Алексей (3)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего реализовано</li>
                        <li>Кукареко Александр (14)</li>
                        <li>Ивашкин Вячеслав (5)</li>
                        <li>Полюшкин Алексей (3)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего за 90 дней</li>
                        <li>Кукареко Александр (14)</li>
                        <li>Ивашкин Вячеслав (5)</li>
                        <li>Полюшкин Алексей (3)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего за 90 дней</li>
                        <li>Кукареко Александр (14)</li>
                        <li>Ивашкин Вячеслав (5)</li>
                        <li>Полюшкин Алексей (3)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row page-title">
            <div class="col-md-12">
                <div class="pull-left">
                    <div class="text">Идеи <span>(638)</span></div>
                    <div class="filter-row">
                        <ul>
                            <li class="active">Все</li>
                            <li>Активные (3)</li>
                            <li>Реализованные (3)</li>
                            <li>На паузе (3)</li>
                        </ul>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="dropdown customer-select">
                        <button class="btn btn-default dropdown-toggle home" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <em> Сначала новые </em>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li class="active"><a href="#">Сначала новые </a></li>
                            <li><a href="#">Link 3</a></li>
                            <li><a href="#">Link 4</a></li></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="tag-line"></ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-idea">
                    <li>
                        <div class="item" v-if="collection.data && collection.data.length"
                        v-for="item in collection.data">
                            <router-link :to="{name: 'idea', params: {id: item.id }}" class="title">
                                <span class="text">{{ item.title}}</span>
                                <span v-bind:class="item.status.slug" class="status">{{ item.status.name }}</span>
                            </router-link>
                            <p v-html="item.description"></p>
                            <router-link :to="{name: 'idea', params: {id: item.id }}">Read more</router-link>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="user-info">
                                        <span class="avatar">
                                            {{ item.user.name.substring(0,1) }}
                                            {{ item.user.last_name.substring(0,1) }}
                                        </span>
                                        <span class="user-name">
                                            {{ item.user.name }}
                                            {{ item.user.last_name }},
                                        </span>
                                        <span class="date">{{ item.created_at }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6 text-right statistics">
                                    <span class="favorite"><i class="zmdi zmdi-favorite"></i> {{ item.comments_count}}</span>
                                    <span class="coomment"><i class="zmdi zmdi-comment-alt"></i> {{ item.likes_num }}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row paginaton">
            <div class="col-md-3 col-sm-3 col-xs-6">

                <div class="dropdown customer-select">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuBot" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <em class="home"> 20 на странице </em>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="active"><a href="#">20 на странице </a></li>
                        <li><a href="#">30 на странице</a></li>
                        <li><a href="#">40 на странице</a></li></ul>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 text-center hidden-xs ">
                <a href="#" class="btn btn-primary">Далее <i class="zmdi zmdi-long-arrow-right"></i></a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                <ul>
                    <li class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">...</a></li>
                </ul>
            </div>
            <div class="col-xs-12 hidden-lg hidden-md hidden-sm text-center"><a href="#" class="btn btn-primary">Далее <i class="zmdi zmdi-long-arrow-right"></i></a></div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';

    export default {
        name: "MainContentBlock",
        reviewidea: null,
        props: {
            url: String
        },
        loading: true,
        data() {
            return {
                query: {
                    limit: 15,
                    page: 1
                },
                collection: {
                    data: []
                },
            }
        },
        mounted() {
            this.fetch()
        },
        methods: {
            fetch() {
                axios.get('/ideas')
                    .then((res) => {
                        Vue.set(this.$data, 'collection', res.data[0]);
                        this.query.page = res.data[0].current_page;
                        this.query.dtClass = res.data[0].status.slug;
                    })
                    .catch((error) => {

                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>

<style scoped>

</style>