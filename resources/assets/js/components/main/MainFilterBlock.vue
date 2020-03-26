<template>
    <form action="">
        <input type="hidden" :value="activeStatusId" ref="activeStatusId">
        <input type="hidden" ref="searchIdeaVuejs" id="search-idea-vuejs" @click="changeSearchIdea()">
        <input type="hidden" ref="datepickerDates" id="datepicker-dates" @click="changeDatepickerDates()">
        <section class="item mg-right-12">
            <div id="datepicker"></div>
            <div @click="removeChecked" id="reset-filters" class="reset-btn">
                <i>×</i>
                <span>{{ideas.clear}}</span>
            </div>

            <section class="item inbtn sidebar-section">
                <label class="filter_checkbox">
                    <input type="checkbox" name="is_anonymous" :value="1" @change="changeHandler">
                    <span class="inbtn__indicator"></span>
                    <span class="first">{{ideas.anonymous}}</span>
                </label>
                <label class="filter_checkbox">
                    <input type="checkbox" name="is_liked" :value="1" @change="changeHandler">
                    <span class="inbtn__indicator"></span>
                    <span class="first">{{ideas.liked}}</span>
                </label>
            </section>

            <section class="sidebar-section">
                <h4 class="block-subtitle">{{ideas.department_of_the_author}}</h4>
                <div class="btn-group-vue dropdown customer-select" id="user-department-select">
                    <div class="menu-overlay-vue" v-if="showDropdownUserDepartment" @click.stop="toggleMenuUserDepartment"></div>
                    <li @click="toggleMenuUserDepartment()" class="dropdown-toggle-vue" v-if="selectedOptionNameUserDepartment !== ''">
                        {{selectedOptionNameUserDepartment}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuUserDepartment()" class="dropdown-toggle-vue" v-if="selectedOptionNameUserDepartment === ''">
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
                <h4 class="block-subtitle">{{ideas.author}}</h4>
                <div class="btn-group-vue dropdown customer-select" id="customer-select">
                    <div class="menu-overlay-vue" v-if="showDropdown" @click.stop="toggleMenu"></div>
                    <li @click="toggleMenu()" class="dropdown-toggle-vue" v-if="selectedOptionName !== '' ">
                        {{ selectedOptionName }}
                        <span class="caret"></span>
                    </li>

                    <li @click="toggleMenu()" class="dropdown-toggle-vue" v-if="selectedOptionName === ''">
                        {{ideas.choose_author}}
                        <span class="caret-menu"></span>
                    </li>

                    <ul class="dropdown-menu-vue" v-if="showDropdown">
                        <li v-for="user in users">
                            <a href="javascript:void(0)"
                               v-on:click="updateOption(user.name + ' ' + user.last_name)"
                               @click="changeSelect(`user_id[]=${user.id}`)">
                                {{user.name}} {{user.last_name}}
                            </a>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="sidebar-section">
                <h4 class="block-subtitle">{{ideas.executor}}</h4>
                <div class="btn-group-vue dropdown customer-select" id="executor-select">
                    <div class="menu-overlay-vue" v-if="showDropdownExecutor" @click.stop="toggleMenuExecutor"></div>
                    <li @click="toggleMenuExecutor()" class="dropdown-toggle-vue" v-if="selectedOptionNameExecutor !== ''">
                        {{selectedOptionNameExecutor}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuExecutor()" class="dropdown-toggle-vue" v-if="selectedOptionNameExecutor === ''">
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
                <h4 class="block-subtitle">{{ideas.age_of_ideas}}</h4>
                <div class="btn-group-vue dropdown customer-select" id="idea-age-select">
                    <div class="menu-overlay-vue" v-if="showDropdownIdeaAge" @click.stop="toggleMenuIdeaAge"></div>
                    <li @click="toggleMenuIdeaAge()" class="dropdown-toggle-vue" v-if="selectedOptionNameIdeaAge !== ''">
                        {{selectedOptionNameIdeaAge}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuIdeaAge()" class="dropdown-toggle-vue" v-if="selectedOptionNameIdeaAge === ''">
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
                <li class="first">{{ideas.department}}</li>
                <li v-for="(itemDepartament, index) in filters.departmentsList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="department_id[]"
                               :value="`${itemDepartament.id}`"
                               @change="changeHandler($event)"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-1">{{itemDepartament.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="competenc" class="item sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.core_competency}}</li>
                <li v-for="(itemCompetenc, index) in filters.coreCompetenciesList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="core_competency_id[]"
                               :value="`${itemCompetenc.id}`"
                               @change="changeHandler($event)"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-2">{{itemCompetenc.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="operational" class="item sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.operational_goal}}</li>
                <li v-for="(itemOperational, index) in filters.operationalGoalsList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="operational_goal_id[]"
                               :value="`${itemOperational.id}`"
                               @change="changeHandler"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-3">{{itemOperational.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section id="type" class="item sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.type}}</li>
                <li v-for="(itemType, index) in filters.typesList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="type_id[]"
                               :value="`${itemType.id}`"
                               @change="changeHandler"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-4">{{itemType.name}}</span>
                    </label>
                </li>
            </ul>
        </section>
        <section v-if="filters.tagsList && Object.keys(filters.tagsList).length" id="tag" class="item bottom-20 sidebar-section">
            <ul class="without-list-style">
                <li class="first">{{ideas.tag}}</li>
                <li v-for="(itemTag, index) in filters.tagsList">
                    <label class="inbtn">
                        <input type="checkbox"
                               name="tag_id[]"
                               :value="`${itemTag.id}`"
                               @change="changeHandler"
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
                    limit: 15,
                    page: 1,
                    count: 0,
                    statusId: '',
                    orderDir: 'new',
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
                ideaAges: [45, 90]
            }
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
            });
        },
        methods: {
            updateOption(option) {
                this.selectedOptionName = option;
                this.showDropdown = false;
                this.$emit('updateOption', this.selectedOption);
            },
            updateOptionUserDepartment(option) {
                this.selectedOptionNameUserDepartment = option;
                this.showDropdownUserDepartment = false;
                this.$emit('updateOptionUserDepartment', this.selectedOptionUserDepartment);
            },
            updateOptionIdeaAge(option) {
                this.selectedOptionNameIdeaAge = option;
                this.showDropdownIdeaAge = false;
                this.$emit('updateOptionIdeaAge', this.selectedOptionIdeaAge);
            },
            updateOptionExecutor(option) {
                this.selectedOptionNameExecutor = option;
                this.showDropdownExecutor = false;
                this.$emit('updateOptionExecutor', this.selectedOptionExecutor);
            },
            toggleMenu () {
                this.showDropdown = !this.showDropdown;
                this.removedClass();
            },
            toggleMenuUserDepartment () {
                this.showDropdownUserDepartment = !this.showDropdownUserDepartment;
                this.removedClassUserDepartment();
            },
            toggleMenuIdeaAge () {
                this.showDropdownIdeaAge = !this.showDropdownIdeaAge;
                this.removedClassIdeaAge();
            },
            toggleMenuExecutor () {
                this.showDropdownExecutor = !this.showDropdownExecutor;
                this.removedClassExecutor();
            },
            post() {
                this.$root.$emit('preloaderPage', true);
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

                axios.get(this.url + '?' + urlParams, { params: params })
                    .then( (res) => {
                        this.$root.$emit('resultFilter', res);
                    });
            },
            changeHandler (e) {
                let serialize = this.checkBoxStatus(e);
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

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });

                if (e.target.checked){
                    this.post();
                } else {
                    this.clearResult();
                }

            },
            changeSelect (val) {
                if (val === 'undefined') {
                    this.selectUser = '';
                    this.clearResult();
                    return false;
                }

                if (this.inputChecked) {
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)user_id\[\]=(\d+)/gm, '');
                }

                this.selectUser = val;
                this.inputChecked = this.inputChecked + '&' + this.selectUser;

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeSelectUserDepartment (val) {
                if (val === 'undefined') {
                    this.selectUserDepartment = '';
                    this.clearResult();
                    return false;
                }

                let department = val.replace('user_department_id=', '');
                this.$root.$emit('changeUserSelect', {data: department});

                this.selectedOptionName = '';
                if (this.inputChecked) {
                    //remove from inputChecked string user_id parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)user_id\[\]=(\d+)/gm, '');
                }

                if (this.inputChecked) {
                    //remove from inputChecked string user_department_id parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)user_department_id=(\d+)/gm, '');
                }

                this.selectUserDepartment = val;
                this.inputChecked = this.inputChecked + '&' + this.selectUserDepartment;

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeSelectIdeaAge (val) {
                if (val === 'undefined') {
                    this.selectIdeaAge = '';
                    this.clearResult();
                    return false;
                }

                this.query.statusId = this.activeStatusId;

                if (this.inputChecked) {
                    //remove from inputChecked string idea_age parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)idea_age=(\d+)/gm, '');
                }

                this.selectIdeaAge = val;
                this.inputChecked = this.inputChecked + '&' + this.selectIdeaAge;

                this.$root.$emit('resultChecked', {
                    data: this.inputChecked,
                    statusId: this.query.statusId,
                    orderDir: this.query.orderDir
                });
                this.post();
            },
            changeSelectExecutor (val) {
                if (val === 'undefined') {
                    this.selectExecutor = '';
                    this.clearResult();
                    return false;
                }

                if (this.inputChecked) {
                    //remove from inputChecked string executor_id parameter
                    this.inputChecked = this.inputChecked.replace(/(\&|\?)executor_id=(\d+)/gm, '');
                }

                this.selectExecutor = val;
                this.inputChecked = this.inputChecked + '&' + this.selectExecutor;

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

                this.$root.$emit('resultChecked', {data:
                    this.inputChecked,
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
                this.clearResult();
            },
            checkBoxStatus (e) {
                let serialize = '';
                let checkboxAll = e.target.form.querySelectorAll('input[type=checkbox]');

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
