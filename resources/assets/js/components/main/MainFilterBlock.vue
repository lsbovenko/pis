<template>
    <form action="">
        <input type="hidden" :value="activeStatusId" ref="activeStatusId">
        <input type="hidden" ref="searchIdeaVuejs" id="search-idea-vuejs" @click="changeSearchIdea()" v-bind:urlSearch="getUrlSearch()" v-bind:pageSearch="1">
        <input type="hidden" ref="datepickerDates" id="datepicker-dates" @click="changeDatepickerDates()" v-bind:urlDates="getUrlDates()" v-bind:pageDatepicker="1">
        <section class="item mg-right-12">
            <div id="datepicker"></div>
            <div @click="removeChecked" id="reset-filters" class="reset-btn">
                <i class="reset-filter"></i>
                <span>{{ideas.clear_all_filters}}</span>
            </div>

            <section class="item inbtn sidebar-section">
                <label class="filter_checkbox">
                    <input type="checkbox" name="is_anonymous" :value="1" @change="changeHandler"
                           v-bind:checked="isAnonymousChecked()">
                    <span class="inbtn__indicator"></span>
                    <span class="first">{{ideas.anonymous}}</span>
                </label>
                <label class="filter_checkbox">
                    <input type="checkbox" name="is_liked" :value="1" @change="changeHandler"
                           v-bind:checked="isLikedChecked()">
                    <span class="inbtn__indicator"></span>
                    <span class="first">{{ideas.liked}}</span>
                </label>
            </section>

            <section class="sidebar-section">
                <h4 class="block-subtitle">{{ideas.department_of_the_author}}
                    <i @click="clearDepartment" class="reset-filter"></i>
                </h4>
                <div class="btn-group-vue dropdown customer-select" id="user-department-select">
                    <div class="menu-overlay-vue" v-if="showDropdownUserDepartment" @click.stop="toggleMenuUserDepartment"></div>
                    <li @click="toggleMenuUserDepartment()" class="dropdown-toggle-vue" v-if="selectedOptionUserDepartmentId">
                        {{selectedOptionNameUserDepartmentData}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuUserDepartment()" class="dropdown-toggle-vue" v-if="selectedOptionNameUserDepartment && !selectedOptionUserDepartmentId">
                        {{selectedOptionNameUserDepartment}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuUserDepartment()" class="dropdown-toggle-vue" v-if="!selectedOptionNameUserDepartment && !selectedOptionUserDepartmentId">
                        {{ideas.choose_department}}
                        <span class="caret-menu"></span>
                    </li>
                    <ul class="dropdown-menu-vue" v-if="showDropdownUserDepartment">
                        <li v-for="(itemDepartament, index) in filters.departmentsList">
                            <a href="javascript:void(0)"
                               v-on:click="updateOptionUserDepartment(itemDepartament.name)"
                               @click="changeSelectUserDepartment(`user_department_id=${itemDepartament.id}`)">
                                {{itemDepartament.name}}
                            </a>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="sidebar-section">
                <h4 class="block-subtitle">{{ideas.author}}
                    <i @click="clearSubmitter" class="reset-filter"></i>
                </h4>
                <div class="btn-group-vue dropdown customer-select" id="customer-select">
                    <div class="menu-overlay-vue" v-if="showDropdown" @click.stop="toggleMenu"></div>
                    <li @click="toggleMenu()" class="dropdown-toggle-vue" v-if="selectedOptionUserId">
                        {{selectedOptionNameUserData}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenu()" class="dropdown-toggle-vue" v-if="selectedOptionName && !selectedOptionUserId">
                        {{selectedOptionName}}
                        <span class="caret"></span>
                    </li>

                    <li @click="toggleMenu()" class="dropdown-toggle-vue" v-if="!selectedOptionName && !selectedOptionUserId">
                        {{ideas.choose_author}}
                        <span class="caret-menu"></span>
                    </li>

                    <ul class="dropdown-menu-vue" v-if="showDropdown">
                        <li v-for="user in users">
                            <a href="javascript:void(0)"
                               v-on:click="updateOption(user.name + ' ' + user.last_name)"
                               @click="changeSelect(`user_id=${user.id}`)">
                                {{user.name}} {{user.last_name}}
                            </a>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="sidebar-section">
                <h4 class="block-subtitle">{{ideas.executor}}
                    <i @click="clearExecutor" class="reset-filter"></i>
                </h4>
                <div class="btn-group-vue dropdown customer-select" id="executor-select">
                    <div class="menu-overlay-vue" v-if="showDropdownExecutor" @click.stop="toggleMenuExecutor"></div>
                    <li @click="toggleMenuExecutor()" class="dropdown-toggle-vue" v-if="selectedOptionExecutorId">
                        {{selectedOptionNameExecutorData}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuExecutor()" class="dropdown-toggle-vue" v-if="selectedOptionNameExecutor && !selectedOptionExecutorId">
                        {{selectedOptionNameExecutor}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuExecutor()" class="dropdown-toggle-vue" v-if="!selectedOptionNameExecutor && !selectedOptionExecutorId">
                        {{ideas.choose_executor}}
                        <span class="caret-menu"></span>
                    </li>
                    <ul class="dropdown-menu-vue" v-if="showDropdownExecutor">
                        <li v-for="(itemExecutor, index) in filters.executorsList">
                            <a href="javascript:void(0)"
                               v-on:click="updateOptionExecutor(itemExecutor.name)"
                               @click="changeSelectExecutor(`executor_id=${itemExecutor.id}`)">
                                {{itemExecutor.name}}
                            </a>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="sidebar-section">
                <h4 class="block-subtitle">{{ideas.age_of_ideas}}
                    <i @click="clearIdeaAge" class="reset-filter"></i>
                </h4>
                <div class="btn-group-vue dropdown customer-select" id="idea-age-select">
                    <div class="menu-overlay-vue" v-if="showDropdownIdeaAge" @click.stop="toggleMenuIdeaAge"></div>
                    <li @click="toggleMenuIdeaAge()" class="dropdown-toggle-vue" v-if="selectedOptionIdeaAgeId">
                        {{selectedOptionNameIdeaAgeData}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuIdeaAge()" class="dropdown-toggle-vue" v-if="selectedOptionNameIdeaAge && !selectedOptionIdeaAgeId">
                        {{selectedOptionNameIdeaAge}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuIdeaAge()" class="dropdown-toggle-vue" v-if="!selectedOptionNameIdeaAge && !selectedOptionIdeaAgeId">
                        {{ideas.choose_age_of_ideas}}
                        <span class="caret-menu"></span>
                    </li>
                    <ul class="dropdown-menu-vue" v-if="showDropdownIdeaAge">
                        <li v-for="(ideaAge, index) in ideas.idea_ages">
                            <a href="javascript:void(0)"
                               v-on:click="updateOptionIdeaAge(ideaAge)"
                               @click="changeSelectIdeaAge(`idea_age=${ideaAges[index]}`)">
                                {{ideaAge}}
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
        </section>
        <section id="departments" class="item mg-top-10 sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.department}}
                    <i @click="clearCheckboxFilter('department_id[]')" class="reset-filter"></i>
                </li>
                <li v-for="(itemDepartament, index) in filters.departmentsList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="department_id[]"
                               :value="`${itemDepartament.id}`"
                               @change="changeHandler"
                               v-bind:checked="isDepartmentChecked(itemDepartament.id)"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-1">{{itemDepartament.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="competenc" class="item sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.core_competency}}
                    <i @click="clearCheckboxFilter('core_competency_id[]')" class="reset-filter"></i>
                </li>
                <li v-for="(itemCompetenc, index) in filters.coreCompetenciesList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="core_competency_id[]"
                               :value="`${itemCompetenc.id}`"
                               @change="changeHandler"
                               v-bind:checked="isCoreCompetencyChecked(itemCompetenc.id)"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-2">{{itemCompetenc.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="operational" class="item sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.operational_goal}}
                    <i @click="clearCheckboxFilter('operational_goal_id[]')" class="reset-filter"></i>
                </li>
                <li v-for="(itemOperational, index) in filters.operationalGoalsList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="operational_goal_id[]"
                               :value="`${itemOperational.id}`"
                               @change="changeHandler"
                               v-bind:checked="isOperationalGoalChecked(itemOperational.id)"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-3">{{itemOperational.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="type" class="item sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.type}}
                    <i @click="clearCheckboxFilter('type_id[]')" class="reset-filter"></i>
                </li>
                <li v-for="(itemType, index) in filters.typesList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="type_id[]"
                               :value="`${itemType.id}`"
                               @change="changeHandler"
                               v-bind:checked="isTypeChecked(itemType.id)"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-4">{{itemType.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section v-if="filters.tagsList && Object.keys(filters.tagsList).length" id="tag" class="item bottom-20 sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.tag}}
                    <i @click="clearCheckboxFilter('tag_id[]')" class="reset-filter"></i>
                </li>
                <li v-for="(itemTag, index) in filters.tagsList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="tag_id[]"
                               :value="`${itemTag.id}`"
                               @change="changeHandler"
                               v-bind:checked="isTagChecked(itemTag.id)"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-5">{{itemTag.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
    </form>
</template>

<script>
    export default {
        name: "MainFilterBlock",
        props: {
            filters: Object,
            users: [Object, Array],
            activeStatusId: {
                type: String,
                default: ''
            },
            ideas: Object
        },
        data() {
            return {
                active: 'active',
                selectUser: '',
                selectUserDepartment: '',
                selectIdeaAge: '',
                selectExecutor: '',
                searchIdea: '',
                datepickerDates: '',
                inputChecked: '',
                query: {
                    limit: this.$route.query.limit || 15,
                    count: 0,
                    statusId: this.$route.query.statusId || 'active',
                    orderDir: this.$route.query.orderDir || 'new',
                    page: this.$route.query.page || 1,
                },
                url: (window.location.pathname === '/') ? '/get-idea/all' : '/get-idea' + pathUrl,
                resetParam: {
                    limit: 15,
                    statusId: '',
                    selected: ''
                },
                selectedOption: {
                    name: ''
                },
                selectedOptionUserDepartment: {
                    name: ''
                },
                selectedOptionIdeaAge: {
                    name: ''
                },
                selectedOptionExecutor: {
                    name: ''
                },
                selectedOptionName: '',
                selectedOptionNameUserDepartment: '',
                selectedOptionNameIdeaAge: '',
                selectedOptionNameExecutor: '',
                showDropdown: false,
                showDropdownUserDepartment: false,
                showDropdownIdeaAge: false,
                showDropdownExecutor: false,
                ideaAges: [45, 90],
                selectedOptionUserId: this.$route.query.user_id || '',
                selectedOptionUserDepartmentId: this.$route.query.user_department_id || '',
                selectedOptionExecutorId: this.$route.query.executor_id || '',
                selectedOptionIdeaAgeId: this.$route.query.idea_age || '',
                checkedDepartmentIds: this.getDepartmentIds() || '',
                checkedCoreCompetencyIds: this.getCoreCompetencyIds() || '',
                checkedOperationalGoalIds: this.getOperationalGoalIds() || '',
                checkedTypeIds: this.getTypeIds() || '',
                checkedTagIds: this.getTagIds() || '',
                checkedIsAnonymous: this.$route.query.is_anonymous || '',
                checkedIsLiked: this.$route.query.is_liked || '',
                pageSearch: 1,
                pageDatepicker: 1,
                previousUrl: '',
            }
        },
        computed: {
            selectedOptionNameUserData: function() {
                if (this.selectedOptionUserId) {
                    for (var index in this.users) {
                        if (this.users[index].id == this.selectedOptionUserId) {
                            return this.users[index].name + ' ' + this.users[index].last_name;
                        }
                    }
                }
            },
            selectedOptionNameUserDepartmentData: function() {
                if (this.selectedOptionUserDepartmentId) {
                    for (var index in this.filters.departmentsList) {
                        if (this.filters.departmentsList[index].id == this.selectedOptionUserDepartmentId) {
                            return this.filters.departmentsList[index].name;
                        }
                    }
                }
            },
            selectedOptionNameExecutorData: function() {
                if (this.selectedOptionExecutorId) {
                    for (var index in this.filters.executorsList) {
                        if (this.filters.executorsList[index].id == this.selectedOptionExecutorId) {
                            return this.filters.executorsList[index].name;
                        }
                    }
                }
            },
            selectedOptionNameIdeaAgeData: function() {
                if (this.selectedOptionIdeaAgeId) {
                    for (var index in this.ideaAges) {
                        if (this.ideaAges[index] == this.selectedOptionIdeaAgeId) {
                            for (var indexProps in this.ideas.idea_ages) {
                                if (index == indexProps) {
                                    return this.ideas.idea_ages[indexProps];
                                }
                            }
                        }
                    }
                }
            },
        },
        watch: {
            selectedOptionNameUserData: function () {
                if (this.selectedOptionNameUserData) {
                    this.selectedOptionName = this.selectedOptionNameUserData;
                    this.changeSelect('user_id=' + this.selectedOptionUserId);
                }
            },
            selectedOptionNameUserDepartmentData: function () {
                if (this.selectedOptionNameUserDepartmentData) {
                    this.selectedOptionNameUserDepartment = this.selectedOptionNameUserDepartmentData;
                    this.changeSelectUserDepartment('user_department_id=' + this.selectedOptionUserDepartmentId);
                }
            },
            selectedOptionNameExecutorData: function () {
                if (this.selectedOptionNameExecutorData) {
                    this.selectedOptionNameExecutor = this.selectedOptionNameExecutorData;
                    this.changeSelectExecutor('executor_id=' + this.selectedOptionExecutorId);
                }
            },
            selectedOptionNameIdeaAgeData: function () {
                if (this.selectedOptionNameIdeaAgeData) {
                    this.selectedOptionNameIdeaAge = this.selectedOptionNameIdeaAgeData;
                    this.changeSelectIdeaAge('idea_age=' + this.selectedOptionIdeaAgeId);
                }
            },
        },
        mounted() {
            this.activeStatusId = this.$refs.activeStatusId.value;
            this.selectedOption = this.users;
            this.selectedOptionUserDepartment = this.filters.departmentsList;
            this.selectedOptionIdeaAge = this.ideaAges;
            this.selectedOptionExecutor = this.filters.executorsList;

            this.$root.$on('checkStatusIdAndOrderDir', (res) => {
                this.query.statusId = res.statusId;
                this.query.orderDir = res.orderDir;
                this.query.limit = res.limit;
                this.query.page = res.page;
                this.post();
            });
        },
        updated: function () {
            this.$nextTick(function () {
                if (this.$refs.searchIdeaVuejs.getAttribute('pageSearch') == 0 ||
                    this.$refs.datepickerDates.getAttribute('pageDatepicker') == 0) {
                    this.$refs.searchIdeaVuejs.setAttribute('pageSearch', 1);
                    this.$refs.datepickerDates.setAttribute('pageDatepicker', 1);
                    if (this.pageSearch != 1) {
                        this.query.page = this.pageSearch;
                    } else if (this.pageDatepicker != 1) {
                        this.query.page = this.pageDatepicker;
                    }
                }
                this.changeHandler(0);
            });
        },
        methods: {
            getUrlSearch() {
                return this.$route.query.search_idea || '';
            },
            getUrlDates() {
                return this.$route.query.datepicker_dates || '';
            },
            getDepartmentIds() {
                for (var index in this.$route.query) {
                    if (index == 'department_id[]') {
                        return this.$route.query[index];
                    }
                }
            },
            isDepartmentChecked(itemDepartamentId) {
                for (var index in this.checkedDepartmentIds) {
                    if (itemDepartamentId == this.checkedDepartmentIds[index]) {
                        return 'checked';
                    }
                }
            },
            getCoreCompetencyIds() {
                for (var index in this.$route.query) {
                    if (index == 'core_competency_id[]') {
                        return this.$route.query[index];
                    }
                }
            },
            isCoreCompetencyChecked(itemCoreCompetencyId) {
                for (var index in this.checkedCoreCompetencyIds) {
                    if (itemCoreCompetencyId == this.checkedCoreCompetencyIds[index]) {
                        return 'checked';
                    }
                }
            },
            getOperationalGoalIds() {
                for (var index in this.$route.query) {
                    if (index == 'operational_goal_id[]') {
                        return this.$route.query[index];
                    }
                }
            },
            isOperationalGoalChecked(itemOperationalGoalId) {
                for (var index in this.checkedOperationalGoalIds) {
                    if (itemOperationalGoalId == this.checkedOperationalGoalIds[index]) {
                        return 'checked';
                    }
                }
            },
            getTypeIds() {
                for (var index in this.$route.query) {
                    if (index == 'type_id[]') {
                        return this.$route.query[index];
                    }
                }
            },
            isTypeChecked(itemTypeId) {
                for (var index in this.checkedTypeIds) {
                    if (itemTypeId == this.checkedTypeIds[index]) {
                        return 'checked';
                    }
                }
            },
            getTagIds() {
                for (var index in this.$route.query) {
                    if (index == 'tag_id[]') {
                        if (Array.isArray(this.$route.query[index])) {
                            return this.$route.query[index];
                        } else {
                            return this.$route.query[index].split(',');
                        }
                    }
                }
            },
            isTagChecked(itemTagId) {
                for (var index in this.checkedTagIds) {
                    if (itemTagId == this.checkedTagIds[index]) {
                        return 'checked';
                    }
                }
            },
            isAnonymousChecked() {
                if (this.checkedIsAnonymous) {
                    return 'checked';
                }
            },
            isLikedChecked() {
                if (this.checkedIsLiked) {
                    return 'checked';
                }
            },
            clearDepartment() {
                this.selectedOptionUserDepartmentId = '';
                this.updateOptionUserDepartment('');
                this.changeSelectUserDepartment('');
            },
            clearSubmitter() {
                this.selectedOptionUserId = '';
                this.updateOption('');
                this.changeSelect('');
            },
            clearExecutor() {
                this.selectedOptionExecutorId = '';
                this.updateOptionExecutor('');
                this.changeSelectExecutor('');
            },
            clearIdeaAge() {
                this.selectedOptionIdeaAgeId = '';
                this.updateOptionIdeaAge('');
                this.changeSelectIdeaAge('');
            },
            clearCheckboxFilter(checkboxName) {
                let selector = 'input[name="' + checkboxName +'"]';
                let checkboxes = document.querySelectorAll(selector);
                checkboxes.forEach(function (checkbox) {
                    if(checkbox.checked) {
                        checkbox.checked = false;
                    }
                });
                this.changeHandler();
            },
            updateOption(option) {
                this.query.page = 1;
                this.selectedOptionName = option;
                this.showDropdown = false;
                this.$emit('updateOption', this.selectedOption);
            },
            updateOptionUserDepartment(option) {
                this.query.page = 1;
                this.selectedOptionNameUserDepartment = option;
                this.showDropdownUserDepartment = false;
                this.$emit('updateOptionUserDepartment', this.selectedOptionUserDepartment);
            },
            updateOptionIdeaAge(option) {
                this.query.page = 1;
                this.selectedOptionNameIdeaAge = option;
                this.showDropdownIdeaAge = false;
                this.$emit('updateOptionIdeaAge', this.selectedOptionIdeaAge);
            },
            updateOptionExecutor(option) {
                this.query.page = 1;
                this.selectedOptionNameExecutor = option;
                this.showDropdownExecutor = false;
                this.$emit('updateOptionExecutor', this.selectedOptionExecutor);
            },
            toggleMenu () {
                this.selectedOptionUserId = '';
                this.showDropdown = !this.showDropdown;
                this.removedClass();
            },
            toggleMenuUserDepartment () {
                this.selectedOptionUserId = '';
                this.selectedOptionUserDepartmentId = '';
                this.showDropdownUserDepartment = !this.showDropdownUserDepartment;
                this.removedClassUserDepartment();
            },
            toggleMenuIdeaAge () {
                this.selectedOptionIdeaAgeId = '';
                this.showDropdownIdeaAge = !this.showDropdownIdeaAge;
                this.removedClassIdeaAge();
            },
            toggleMenuExecutor () {
                this.selectedOptionExecutorId = '';
                this.showDropdownExecutor = !this.showDropdownExecutor;
                this.removedClassExecutor();
            },
            post() {
                const params = {
                    ...this.query
                };

                if (this.selectIdeaAge) {
                    let ideaStatuses = document.getElementById('idea-status').childNodes;
                    ideaStatuses.forEach(function (el, i) {
                        if (i == 0) {
                            el.classList.add('active');
                        } else {
                            el.classList.remove('active');
                        }
                    });
                }
                let urlParams;
                if (this.selectUser && !this.inputChecked) {
                    urlParams = this.selectUser;
                } else if (this.selectUserDepartment && !this.inputChecked) {
                    urlParams = this.selectUserDepartment;
                } else if (this.selectIdeaAge && !this.inputChecked) {
                    urlParams = this.selectIdeaAge;
                } else if (this.selectExecutor && !this.inputChecked) {
                    urlParams = this.selectExecutor;
                } else if (this.searchIdea && !this.inputChecked) {
                    urlParams = this.searchIdea;
                } else if (this.datepickerDates && !this.inputChecked) {
                    urlParams = this.datepickerDates;
                } else {
                    urlParams = this.inputChecked;
                }

                let url = '';
                for (let index in params) {
                    if (!(index == 'count')) {
                        url += '&' + index + '=' + params[index];
                    }
                }
                var currentUrl = '?' + urlParams + url;
                if (this.previousUrl != currentUrl) {
                    this.$root.$emit('preloaderPage', true);

                    this.$router.push(currentUrl).catch(err => {});
                    axios.get(this.url + '?' + urlParams, {params: params})
                        .then((res) => {
                            this.$root.$emit('resultFilter', res);
                        });
                    this.previousUrl = currentUrl;
                }
            },
            changeHandler(page = 1) {
                let serialize = this.checkBoxStatus();
                this.inputChecked = serialize.substr(1);
                if (this.selectUser) {
                    this.inputChecked = this.inputChecked + '&' +this.selectUser
                }
                if (this.selectUserDepartment) {
                    this.inputChecked = this.inputChecked + '&' + this.selectUserDepartment
                }
                if (this.selectIdeaAge) {
                    this.inputChecked = this.inputChecked + '&' +this.selectIdeaAge
                }
                if (this.selectExecutor) {
                    this.inputChecked = this.inputChecked + '&' + this.selectExecutor;
                }
                if (this.searchIdea) {
                    this.inputChecked = this.inputChecked + '&' + this.searchIdea;
                }
                if (this.datepickerDates) {
                    this.inputChecked = this.inputChecked + '&' + this.datepickerDates;
                }

                if (page) {
                    this.query.page = page;
                }
                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });

                this.post();

            },
            changeSelect (val) {
                if (this.inputChecked) {
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)user_id=(\d+)/gm, '');
                }

                if (val === '') {
                    this.selectUser = '';
                } else {
                    this.selectUser = val;
                    this.inputChecked = this.inputChecked + '&' + this.selectUser;
                }

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeSelectUserDepartment (val) {
                let department = val.replace('user_department_id=', '');
                this.$root.$emit('changeUserSelect', {data: department});

                if (!this.selectedOptionUserId) {
                    this.selectedOptionName = '';
                    if (this.inputChecked) {
                        //remove from inputChecked string user_id parameter
                        this.inputChecked = this.inputChecked.replace(/(\&|\?)user_id=(\d+)/gm, '');
                    }
                }

                if (this.inputChecked) {
                    //remove from inputChecked string user_department_id parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)user_department_id=(\d+)/gm, '');
                }

                if (val === '') {
                    this.selectUserDepartment = '';
                    this.selectUser = '';
                } else {
                    this.selectUserDepartment = val;
                    this.inputChecked = this.inputChecked + '&' + this.selectUserDepartment;
                }

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeSelectIdeaAge (val) {
                this.query.statusId = this.activeStatusId;

                if (this.inputChecked) {
                    //remove from inputChecked string idea_age parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)idea_age=(\d+)/gm, '');
                }

                if (val === '') {
                    this.selectIdeaAge = '';
                } else {
                    this.selectIdeaAge = val;
                    this.inputChecked = this.inputChecked + '&' + this.selectIdeaAge;
                }

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeSelectExecutor (val) {
                if (this.inputChecked) {
                    //remove from inputChecked string executor_id parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)executor_id=(\d+)/gm, '');
                }

                if (val === '') {
                    this.selectExecutor = '';
                } else {
                    this.selectExecutor = val;
                    this.inputChecked = this.inputChecked + '&' + this.selectExecutor;
                }

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeSearchIdea () {
                let val = 'search_idea=' + this.$refs.searchIdeaVuejs.value;

                if (this.inputChecked) {
                    //remove from inputChecked string search_idea parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)search_idea=([а-яА-Яa-zA-Z0-9ёЁ\s]*)/gmu, '');
                }

                this.searchIdea = val;
                this.inputChecked = this.inputChecked + '&' + this.searchIdea;

                this.pageSearch = this.query.page;
                this.query.page = 1;

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeDatepickerDates () {
                let val = 'datepicker_dates=' + this.$refs.datepickerDates.value;

                if (this.inputChecked) {
                    //remove from inputChecked string datepicker_dates parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)datepicker_dates=([\d\-\,]+)/gm, '');
                }

                this.datepickerDates = val;
                this.inputChecked = this.inputChecked + '&' + this.datepickerDates;

                this.pageDatepicker = this.query.page;
                this.query.page = 1;

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            clearResult () {
                this.post();
            },
            removeChecked () {
                let uncheck = document.getElementsByTagName('input');

                for (let i=0; i < uncheck.length; i++) {

                    if (uncheck[i].type == 'checkbox') {
                        uncheck[i].checked = false;
                    }
                }

                let ideaStatuses = document.getElementById('idea-status').childNodes;
                ideaStatuses.forEach(function (el) {
                    el.classList.remove('active');
                });
                this.query.statusId = '';
                this.query.orderDir = 'new';
                this.query.limit = 15;
                this.query.page = 1;
                this.pageSearch = 1;
                this.pageDatepicker = 1;
                this.removedClass();
                this.removedClassUserDepartment();
                this.removedClassIdeaAge();
                this.removedClassExecutor();
                this.removedSearchIdea();
                this.removedDatepickerDates();
                this.selectedOptionName = '';
                this.selectedOptionNameUserDepartment = '';
                this.selectedOptionNameIdeaAge = '';
                this.selectedOptionNameExecutor = '';
                this.selectUser = '';
                this.selectUserDepartment = '';
                this.selectIdeaAge = '';
                this.selectExecutor = '';
                this.searchIdea = '';
                this.datepickerDates = '';
                this.$root.$emit('changeUserSelect', {data: ''});
                this.$root.$emit('resultChecked', {data: '', orderResult: 'removed'});
                this.$root.$emit('resetAllFilterParams', this.resetParam);
                this.inputChecked = '';
                this.selectedOptionUserId = '';
                this.selectedOptionUserDepartmentId = '';
                this.selectedOptionExecutorId = '';
                this.selectedOptionIdeaAgeId = '';
                this.clearResult();
            },
            checkBoxStatus() {
                let serialize = '';
                let checkboxAll = document.querySelectorAll('input[type=checkbox]');

                let checkboxArray = Array.from(checkboxAll);

                for (let i = 0; i < checkboxArray.length; ++i) {
                    if (checkboxArray[i].type === 'checkbox' && checkboxArray[i].checked) {
                        serialize += '&' + checkboxArray[i].name + '=' + checkboxArray[i].value;
                    }
                }
                return serialize;
            },
            removedClass() {
                let userMenu = document.getElementById('customer-select');
                userMenu.classList.remove('open');
            },
            removedClassUserDepartment() {
                let userDepartmentMenu = document.getElementById('user-department-select');
                userDepartmentMenu.classList.remove('open');
            },
            removedClassIdeaAge() {
                let userMenu = document.getElementById('idea-age-select');
                userMenu.classList.remove('open');
            },
            removedClassExecutor() {
                let executorMenu = document.getElementById('executor-select');
                executorMenu.classList.remove('open');
            },
            removedSearchIdea() {
                document.getElementById('search-idea').value = '';
                this.$refs.searchIdeaVuejs.value = '';
            },
            removedDatepickerDates() {
                this.$refs.datepickerDates.value = '';
            }
        },
    }
</script>
