<template>
    <div class="content-idea">
        <div class="row info-row">
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего</li>
                        <li v-if="topUser"
                            v-for="topUser in topUsers">
                            {{ topUser.name }}
                            {{ topUser.last_name }}
                            ({{ topUser.number }})
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего реализовано</li>
                        <li v-if="topUsersByCompletedIdeas"
                            v-for="topUsersByCompletedIdea in topUsersByCompletedIdeas">
                            {{ topUsersByCompletedIdea.name }}
                            {{ topUsersByCompletedIdea.last_name }}
                            ({{ topUsersByCompletedIdea.number }})
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего за 90 дней</li>
                        <li v-if="topUsersLast3Month"
                            v-for="topUsersLast3M in topUsersLast3Month">
                            {{ topUsersLast3M.name }}
                            {{ topUsersLast3M.last_name }}
                            ({{ topUsersLast3M.number }})
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="item">
                    <ul>
                        <li>Всего за 90 дней</li>
                        <li v-if="topUsersByCompletedIdeasLast3Month"
                            v-for="topUsersByCompletedIdeasLast3M in topUsersByCompletedIdeasLast3Month">
                            {{ topUsersByCompletedIdeasLast3M.name }}
                            {{ topUsersByCompletedIdeasLast3M.last_name }}
                            ({{ topUsersByCompletedIdeasLast3M.number }})
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row page-title">
            <div class="col-md-12">
                <div class="pull-left">
                    <div class="text">Идеи <span>({{ query.count }})</span></div>
                    <div class="filter-row">
                        <ul>
                            <li class="active">Все</li>
                            <li v-for="itemStatus in statuses">
                                {{ itemStatus }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pull-right">
                    <div class="dropdown customer-select">
                        <button class="btn btn-default dropdown-toggle home" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <em> Сначала новые </em>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" v-model="query.filter_match">
                            <li class="active"><a href="#">Сначала новые </a></li>
                            <li><a href="#">Сначала старые</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-idea">
                    <li>
                        <div class="item" v-if="collection.data && collection.data.length"
                        v-for="item in collection.data">
                            <a :href="`/review-idea/${item.id}`" class="title">
                                <span class="text">{{ item.title}}</span>
                                <span v-bind:class="item.status.slug" class="status">{{ item.status.name }}</span>
                            </a>
                            <p v-html="item.description"></p>
                            <a :href="`/review-idea/${item.id}`">Read more</a>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="user-info">
                                        <span class="avatar">
                                            {{ item.user.name.substring(0,1) }}{{ item.user.last_name.substring(0,1) }}
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
                    <select class="form-control no-border-shadow" v-model="query.limit" :disabled="loading" @change="updateLimit">
                        <option>15</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 text-center hidden-xs">
                <a href="#" class="btn btn-primary" :disabled="!collection.prev_page_url || loading" @click="prevPage"><i class="zmdi zmdi-long-arrow-left"></i> Назад</a>
                <span class="btn btn-default current_page">{{ collection.current_page }}</span>
                <a href="#" class="btn btn-primary" :disabled="!collection.next_page_url || loading" @click="nextPage">Далее <i class="zmdi zmdi-long-arrow-right"></i></a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                <ul>
                    <li><a href="#">{{ collection.from }} - </a></li>
                    <li><a href="#">{{ collection.to }}</a></li>
                    <li><a href="#" title="total">({{ collection.total }})</a></li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';

    export default {
        name: "MainContentBlock",
        reviewidea: null,
        checkedNames: [],
        props: {
            url: String,
            statuses: Object
        },
        data() {
            return {
                loading: true,
                query: {
                    limit: 15,
                    page: 1,
                    count: 0,
                    filterDesc: 'desc',
                    filterAsc: 'asc'
                },
                collection: {
                    data: [],
                },
                topUsers: {
                    data: []
                },
                topUsersByCompletedIdeas: {
                    data: []
                },
                topUsersLast3Month: {
                    data: []
                },
                topUsersByCompletedIdeasLast3Month: {
                    data: []
                },
            }
        },
        mounted() {
            this.fetch();
            this.$root.$on('input', function (data) {
                this.checkedNames = data;
            });
        },
        methods: {
            activeIdea() {

            },
            applyChange() {
                this.fetch();
            },
            updateLimit() {
                this.query.page = 1;
                this.applyChange()
            },

            prevPage() {
                if(this.collection.prev_page_url) {
                    this.query.page = Number(this.query.page) - 1;
                    this.applyChange()
                }
            },
            nextPage() {
                if(this.collection.next_page_url) {
                    this.query.page = Number(this.query.page) + 1;
                    this.applyChange();
                }
            },
            fetch() {
                const params = {
                    ...this.checkedNames,
                    ...this.query
                };

                axios.get('/get-idea/all', {params: params})
                    .then((res) => {
                        Vue.set(this.$data, 'collection', res.data.ideas);
                        Vue.set(this.$data, 'topUsers', res.data.topUsers);
                        Vue.set(this.$data, 'topUsersByCompletedIdeas', res.data.topUsersByCompletedIdeas);
                        Vue.set(this.$data, 'topUsersLast3Month', res.data.topUsersLast3Month);
                        Vue.set(this.$data, 'topUsersByCompletedIdeasLast3Month', res.data.topUsersByCompletedIdeasLast3Month);
                        this.query.page = res.data.ideas.current_page;
                        this.query.count = res.data.totalIdeas;
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
.current_page {
    min-width: 25px;
    height: 25px;
    padding: 3px;
    border-radius: 30px;
}
</style>