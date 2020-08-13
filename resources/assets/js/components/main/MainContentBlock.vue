<template>
    <div class="content-idea">
        <div class="row info-row">
            <div class="col-md-3 col-sm-6">
                <div class="item item-block">
                    <ul class="without-list-style">
                        <li>{{ideas.total}}</li>
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
                <div class="item item-block">
                    <ul class="without-list-style">
                        <li>{{ideas.total_completed}}</li>
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
                <div class="item item-block">
                    <ul class="without-list-style">
                        <li>{{ideas.total_for_90_days}}</li>
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
                <div class="item item-block">
                    <ul class="without-list-style">
                        <li>{{ideas.completed_for_90_days}}</li>
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
                    <div class="text" v-for="(list, index) in ideas.list_menu"
                        v-if="listMenu[index] === pathUrl">
                        {{list}}
                        <span>({{ query.count }})</span>
                    </div>
                    <div class="filter-row">
                        <ul class="without-list-style" id="idea-status" ref="ideaStatus">
                            <li v-for="(itemStatus, index) in statuses"
                                v-on:click="ideaStatus(`${index}`); selected = index"
                                :class="{active:index == selected}"
                                v-bind:data-slug="index"
                            >
                                {{ itemStatus }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="pull-right" id="order-dir">
                    <div class="dropdown customer-select">
                        <button class="btn btn-default dropdown-toggle home" type="button" id="dropdownMenuOrder"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="true"
                        >
                            <em> {{selectedOrderDir}} </em>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuOrder" v-model="query.filter_match">
                            <li ref="newFirst" v-bind:orderSort="query.newFirst" class="order-list" @click="orderSort(`${query.newFirst}`)"><a class="pointer">{{ideas.new_first}}</a></li>
                            <li ref="oldFirst" v-bind:orderSort="query.oldFirst" class="order-list" @click="orderSort(`${query.oldFirst}`)"><a class="pointer">{{ideas.old_first}}</a></li>
                            <li ref="likes" v-bind:orderSort="query.likes" class="order-list" @click="orderSort(`${query.likes}`)"><a class="pointer">{{ideas.likes}}</a></li>
                            <li ref="comments" v-bind:orderSort="query.comments" class="order-list" @click="orderSort(`${query.comments}`)"><a class="pointer">{{ideas.commentaries}}</a></li>
                            <li ref="likesComments" v-bind:orderSort="query.likesComments" class="order-list" @click="orderSort(`${query.likesComments}`)"><a class="pointer">{{ideas.likes_comments}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="list-idea without-list-style">
                    <li>
                        <div class="item" v-if="collection.data && collection.data.length"
                        v-for="item in collection.data">
                            <a :href="`/review-idea/${item.id}`" class="title">
                                <span class="text">{{ item.title}}</span>
                                <span v-if="item.approve_status === 0" class="approve_status not_approved">{{ideas.pending}}</span>
                                <span v-bind:class="item.status.slug" class="status">{{ item.status.name }}</span>
                            </a>
                            <p v-html="item.description"></p>
                            <a :href="`/review-idea/${item.id}`">{{ideas.read_more}}</a>
                            <br><br>
                            <div class="mg-bottom-5" v-if="item.completed_at"><strong>{{ideas.idea_implementation_date}}:</strong> {{ getCompletedAt(item.completed_at) }}</div>
                            <div v-if="item.completed_at"><strong>{{ideas.implemented_in_days}}:</strong>
                                {{ getCompletedDays(item.completed_at, item.created_at) }}</div>
                            <div class="row">
                                <div class="col-md-9">
                                    <div v-if="item.user">
                                        <div v-if="item.executors && item.executors.length" v-for="executor in item.executors">
                                            <div class="user-info">
                                                <span class="avatar" v-bind:style="'background-color: ' + executor.icon_color">
                                                    {{ executor.name.substring(0,1) }}{{executor.last_name.substring(0,1) }}
                                                </span>
                                                <span class="user-name">
                                                    {{ executor.name }}
                                                    {{ executor.last_name }},
                                                </span>
                                                <span class="user-name">
                                                    owner
                                                </span>
                                            </div>
                                        </div>
                                        <div class="user-info">
                                            <span class="avatar" v-bind:style="'background-color: ' + item.user.icon_color">
                                                {{ item.user.name.substring(0,1) }}{{ item.user.last_name.substring(0,1) }}
                                            </span>
                                            <span class="user-name">
                                                {{ item.user.name }}
                                                {{ item.user.last_name }},
                                            </span>
                                            <span class="user-name">
                                                submitter,
                                            </span>
                                            <span class="date">{{ item.created_at }}</span>
                                        </div>
                                    </div>
                                    <div class="user-info" v-else>
                                        <span class="date">{{ item.created_at }}</span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-right statistics">
                                    <span class="favorite"><i class="zmdi zmdi-favorite"></i> {{ item.likes_num }}</span>
                                    <span class="coomment"><i class="zmdi zmdi-comment-alt"></i> {{ item.comments_count}}</span>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row paginaton">
                <div v-if="viewBlock">
                <div class="col-md-3 col-sm-3 col-xs-6">
                    <div class="dropdown customer-select">
                        <select class="page-count-select form-control no-border-shadow" v-model="query.limit" :disabled="loading" @change="updateLimit">
                            <option>15</option>
                            <option>25</option>
                            <option>50</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 text-center hidden-xs">
                    <div>
                        <a class="btn btn-primary" :disabled="!collection.prev_page_url || loading" @click="prevPage"><i class="zmdi zmdi-long-arrow-left"></i> {{ideas.previous}}</a>
                        <span class="btn btn-default current_page">{{ collection.current_page }}</span>
                        <a class="btn btn-primary" :disabled="!collection.next_page_url || loading" @click="nextPage">{{ideas.next}} <i class="zmdi zmdi-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 text-right">
                    <ul>
                        <li>{{ collection.from }} - </li>
                        <li>{{ collection.to }}</li>
                        <li title="total">({{ collection.total }})</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12" v-if="ideaEmpty">
                <h4 class="text-center">{{ideas.nothing_found}}</h4>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';

    export default {
        name: "MainContentBlock",
        reviewidea: null,
        props: ['statuses', 'ideas'],
        data() {
            return {
                pathUrl: pathUrl,
                selected: this.$route.query.statusId || 'active',
                loading: true,
                viewBlock: false,
                ideaEmpty: false,
                query: {
                    limit: this.$route.query.limit || 15,
                    count: 0,
                    newFirst: 'new',
                    oldFirst: 'old',
                    likes: 'likes',
                    comments: 'comments',
                    likesComments: 'likes_comments',
                    statusId: this.$route.query.statusId || 'active',
                    orderDir: this.$route.query.orderDir || 'new',
                    page: this.$route.query.page || 1,
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
                resultFilters: '',
                listMenu: ['/', '/priority-board', '/my-ideas', '/pending-review', '/declined'],
                url: (window.location.pathname === '/') ? '/get-idea/all' : '/get-idea' + pathUrl
            }
        },
        computed: {
            selectedOrderDir: function () {
                switch (this.query.orderDir) {
                    case this.query.newFirst:
                        return this.ideas.new_first;
                    case this.query.oldFirst:
                        return this.ideas.old_first;
                    case this.query.likes:
                        return this.ideas.likes;
                    case this.query.comments:
                        return this.ideas.commentaries;
                    case this.query.likesComments:
                        return this.ideas.likes_comments;
                }
            },
        },
        watch: {
            selectedOrderDir: function () {
                switch (this.query.orderDir) {
                    case this.$refs.newFirst.getAttribute('orderSort'):
                        this.$refs.newFirst.setAttribute('class', 'order-list active');
                        break;
                    case this.$refs.oldFirst.getAttribute('orderSort'):
                        this.$refs.oldFirst.setAttribute('class', 'order-list active');
                        break;
                    case this.$refs.likes.getAttribute('orderSort'):
                        this.$refs.likes.setAttribute('class', 'order-list active');
                        break;
                    case this.$refs.comments.getAttribute('orderSort'):
                        this.$refs.comments.setAttribute('class', 'order-list active');
                        break;
                    case this.$refs.likesComments.getAttribute('orderSort'):
                        this.$refs.likesComments.setAttribute('class', 'order-list active');
                        break;
                }
            }
        },
        mounted() {
            this.fetch();

            this.$root.$on('resultFilter', (result) => {
                Vue.set(this.$data, 'collection', result.data.ideas);
                this.query.page = result.data.ideas.current_page;
                this.query.count = result.data.ideas.total;
                this.filter = result.data.filter;

                this.viewPaginateBlock(result.data.ideas.total);

                this.$root.$emit('preloaderPage', false);
            });

            this.$root.$on('resultChecked', (result) => {
                this.resultFilters = result.data;
                this.query.statusId = result.statusId;
                this.query.orderDir = result.orderDir;

                if (result.orderResult === 'removed'){
                    let orderMenu = document.getElementById('dropdownMenuOrder');
                    orderMenu.getElementsByTagName('em')[0].innerHTML = this.ideas.new_first;
                    this.querySelectorMenuOrder();
                }

                this.viewBlock = true;
                this.ideaEmpty = false;
            });

            this.$root.$on('resetAllFilterParams', (result) => {
                this.query.limit = result.limit;
                this.query.statusId = result.statusId;
                this.query.orderDir = 'new';
                this.selected = result.selected;
            })
        },
        methods: {
            orderSort(sort) {
                switch (sort) {
                    case this.query.oldFirst:
                        this.query.orderDir = this.query.oldFirst;
                        break;
                    case this.query.likes:
                        this.query.orderDir = this.query.likes;
                        this.ideaStatus('active');
                        break;
                    case this.query.comments:
                        this.query.orderDir = this.query.comments;
                        this.ideaStatus('active');
                        break;
                    case this.query.likesComments:
                        this.query.orderDir = this.query.likesComments;
                        this.ideaStatus('active');
                        break;
                    default:
                        this.query.orderDir = this.query.newFirst;
                }

                if (this.query.orderDir == this.query.oldFirst || this.query.orderDir == this.query.newFirst) {  // function ideaStatus() has this code for other options
                    this.query.page = 1;
                    this.$root.$emit('checkStatusIdAndOrderDir', this.query);
                    this.applyChange();
                }
            },
            ideaStatus(param) {
                let ideaStatuses = this.$refs.ideaStatus.childNodes;
                ideaStatuses.forEach(function (el, i) {
                    if (el.dataset.slug == param) {
                        el.classList.add('active');
                    } else {
                        el.classList.remove('active');
                    }
                });

                this.query.statusId = param;
                this.query.page = 1;
                this.$root.$emit('checkStatusIdAndOrderDir', this.query);

                this.active = 'active';
                this.applyChange();
            },
            applyChange() {
                this.fetch();
            },
            updateLimit() {
                this.query.page = 1;
                this.$root.$emit('checkStatusIdAndOrderDir', this.query);
                this.applyChange();
            },

            prevPage() {
                if(this.collection.prev_page_url) {
                    this.query.page = Number(this.query.page) - 1;
                    this.$root.$emit('checkStatusIdAndOrderDir', this.query);
                    this.applyChange();
                }
            },
            nextPage() {
                if (this.collection.next_page_url){
                    this.query.page = Number(this.query.page) + 1;
                    this.$root.$emit('checkStatusIdAndOrderDir', this.query);
                    this.applyChange();
                }
            },
            fetch() {
                this.$root.$emit('preloaderPage', true);
                const params = {
                    ...this.query
                };

                axios.get(this.url + '?' + this.resultFilters, {params: params})
                    .then((res) => {
                        Vue.set(this.$data, 'collection', res.data.ideas);
                        Vue.set(this.$data, 'topUsers', res.data.topUsers);
                        Vue.set(this.$data, 'topUsersByCompletedIdeas', res.data.topUsersByCompletedIdeas);
                        Vue.set(this.$data, 'topUsersLast3Month', res.data.topUsersLast3Month);
                        Vue.set(this.$data, 'topUsersByCompletedIdeasLast3Month', res.data.topUsersByCompletedIdeasLast3Month);
                        this.query.page = res.data.ideas.current_page;
                        this.query.count = res.data.ideas.total;

                        this.viewPaginateBlock(this.query.count);

                        this.scrollUpTo();
                        this.$root.$emit('preloaderPage', false);
                    })
                    .catch((error) => {})
                    .finally(() => {
                        this.loading = false;
                    })
            },
            scrollUpTo() {
                const scrollToTop = () => {
                    const c = document.documentElement.scrollTop || document.body.scrollTop;
                    if (c > 0) {
                        window.requestAnimationFrame(scrollToTop);
                        window.scrollTo(0, c - c / 8);
                    }
                };
                scrollToTop();
            },
            viewPaginateBlock (count) {
                if (parseInt(count) === 0) {
                    this.viewBlock = false;
                    this.ideaEmpty = true;
                } else {
                    this.viewBlock = true;
                    this.ideaEmpty = false;
                }
            },
            removedClassOrder(elements) {
                for (var i = 0; i < elements.length; i++) {
                    elements[i].classList.remove('active');
                }
            },
            querySelectorMenuOrder() {
                let elements = document.querySelectorAll('.order-list');
                for (let i = 0; i < elements.length; i++) {
                    elements[i].classList.remove('active');
                    elements[i].onclick = (event) => {
                        this.removedClassOrder(elements);
                        if (event.target.innerHTML === this.innerHTML) {
                            this.classList.add("active");
                        }
                    };
                }
            },
            getCompletedAt(completedAt) {
                var items = completedAt.split(' ');

                return items[0];
            },
            getCompletedDays(completedAt, createdAt) {
                var dateCompleted = new Date(completedAt);
                var dateCreated = new Date(createdAt);
                var completedDays = Math.floor((dateCompleted.getTime() - dateCreated.getTime())/(24*60*60*1000));

                return completedDays;
            }
        }
    }
</script>

<style scoped>
    [v-cloak] {
        display:none;
    }

.current_page {
    min-width: 25px;
    height: 25px;
    padding: 3px;
    border-radius: 30px;
}
</style>
