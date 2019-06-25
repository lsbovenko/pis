<template>
    <div class="left-sidebar sameblock">
        <form action="">
        <input type="hidden" :value="activeStatusId" ref="activeStatusId">
        <input type="hidden" ref="searchIdeaVuejs" id="search-idea-vuejs" @click="changeSearchIdea()">
        <input type="hidden" ref="datepickerDates" id="datepicker-dates" @click="changeDatepickerDates()">
            <section class="item mg-right-15">
                <ul class="last-changes-list without-list-style">
                    <li class="first">
                        Диапазон дат
                        <span class="drop" @click="removeChecked" id="reset-filters">Сбросить</span>
                    </li>
                </ul>
                <div style="margin-bottom: 20px;" id="datepicker"></div>

                <ul class="last-changes-list without-list-style">
                    <li class="first">Отдел автора</li>
                </ul>
                <div class="btn-group-vue dropdown customer-select" id="user-department-select">
                    <div class="menu-overlay-vue" v-if="showDropdownUserDepartment" @click.stop="toggleMenuUserDepartment"></div>
                    <li @click="toggleMenuUserDepartment()" class="dropdown-toggle-vue" v-if="selectedOptionNameUserDepartment !== ''">
                        {{selectedOptionNameUserDepartment}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuUserDepartment()" class="dropdown-toggle-vue" v-if="selectedOptionNameUserDepartment === ''">
                        {{placeholderTextUserDepartment}}
                        <span class="caret-menu"></span>
                    </li>
                    <ul class="dropdown-menu-vue" v-if="showDropdownUserDepartment">
                        <li v-for="(itemDepartament, index) in filters.departmentsList">
                            <a href="javascript:void(0)"
                               v-on:click="updateOptionUserDepartment(itemDepartament)"
                               @click="changeSelectUserDepartment(`user_department_id=${index}`)">
                                {{itemDepartament}}
                            </a>
                        </li>
                    </ul>
                </div>

                <ul class="last-changes-list without-list-style">
                    <li class="first">Автор</li>
                </ul>

                <div class="btn-group-vue dropdown customer-select" id="customer-select">
                    <div class="menu-overlay-vue" v-if="showDropdown" @click.stop="toggleMenu"></div>
                    <li @click="toggleMenu()" class="dropdown-toggle-vue" v-if="selectedOptionName !== '' ">
                        {{ selectedOptionName }}
                        <span class="caret"></span>
                    </li>

                    <li @click="toggleMenu()" class="dropdown-toggle-vue" v-if="selectedOptionName === ''">
                        {{placeholderText}}
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

                <ul class="last-changes-list without-list-style">
                    <li class="first">Возраст идей</li>
                </ul>
                <div class="btn-group-vue dropdown customer-select" id="idea-age-select">
                    <div class="menu-overlay-vue" v-if="showDropdownIdeaAge" @click.stop="toggleMenuIdeaAge"></div>
                    <li @click="toggleMenuIdeaAge()" class="dropdown-toggle-vue" v-if="selectedOptionNameIdeaAge !== ''">
                        {{selectedOptionNameIdeaAge}}
                        <span class="caret"></span>
                    </li>
                    <li @click="toggleMenuIdeaAge()" class="dropdown-toggle-vue" v-if="selectedOptionNameIdeaAge === ''">
                        {{placeholderTextIdeaAge}}
                        <span class="caret-menu"></span>
                    </li>
                    <ul class="dropdown-menu-vue" v-if="showDropdownIdeaAge">
                        <li v-for="ideaAge in ideaAges">
                            <a href="javascript:void(0)"
                               v-on:click="updateOptionIdeaAge(ideaAge.name)"
                               @click="changeSelectIdeaAge(`idea_age=${ideaAge.value}`)">
                                {{ideaAge.name}}
                            </a>
                        </li>
                    </ul>
                </div>
            </section>
            <section id="departments" class="item mg-top-10">
                <ul class="without-list-style">
                    <li class="first">Отдел</li>
                    <li v-for="(itemDepartament, index) in filters.departmentsList">
                        <label class="inbtn">
                            <input type="checkbox"
                                   name="department_id[]"
                                   :value="`${index}`"
                                   @change="changeHandler($event)"
                            >
                            <span class="inbtn__indicator"></span>
                            <span class="data" id="data-1">{{ itemDepartament }}</span>
                        </label>
                    </li>
                </ul>
            </section>
            <section id="competenc" class="item">
                <ul class="without-list-style">
                    <li class="first">Основная компетенция</li>
                    <li v-for="(itemCompetenc, index) in filters.coreCompetenciesList">
                        <label class="inbtn">
                            <input type="checkbox"
                                   name="core_competency_id[]"
                                   :value="`${index}`"
                                   @change="changeHandler($event)"
                            >
                            <span class="inbtn__indicator"></span>
                            <span class="data" id="data-2">{{ itemCompetenc }}</span>
                        </label>
                    </li>
                </ul>
            </section>
            <section id="operational" class="item">
                <ul class="without-list-style">
                    <li class="first">Операционная цель</li>
                    <li v-for="(itemOperational, index) in filters.operationalGoalsList">
                        <label class="inbtn">
                            <input type="checkbox"
                                   name="operational_goal_id[]"
                                   :value="`${index}`"
                                   @change="changeHandler"
                            >
                            <span class="inbtn__indicator"></span>
                            <span class="data" id="data-3">{{ itemOperational }}</span>
                        </label>
                    </li>
                </ul>
            </section>
            <section id="type" class="item">
                <ul class="without-list-style">
                    <li class="first">Тип</li>
                    <li v-for="(itemType, index) in filters.typesList">
                        <label class="inbtn">
                            <input type="checkbox"
                                   name="type_id[]"
                                   :value="`${index}`"
                                   @change="changeHandler"
                            >
                            <span class="inbtn__indicator"></span>
                            <span class="data" id="data-4">{{ itemType }}</span>
                        </label>
                    </li>
                </ul>
            </section>
            <section v-if="filters.tagsList && Object.keys(filters.tagsList).length" id="tag" class="item bottom-20">
                <ul class="without-list-style">
                    <li class="first">Тэг</li>
                    <li v-for="(itemTag, index) in filters.tagsList">
                        <label class="inbtn">
                            <input type="checkbox"
                                   name="tag_id[]"
                                   :value="`${index}`"
                                   @change="changeHandler"
                            >
                            <span class="inbtn__indicator"></span>
                            <span class="data" id="data-5">{{ itemTag }}</span>
                        </label>
                    </li>
                </ul>
            </section>
        </form>
    </div>
</template>

<script>
    export default {
        name: "MainFilterBlock",
        props: ['filters', 'users', 'activeStatusId'],
        data() {
            return {
                active: 'active',
                selectUser: '',
                selectUserDepartment: '',
                selectIdeaAge: '',
                searchIdea: '',
                datepickerDates: '',
                inputChecked: '',
                query: {
                    limit: 15,
                    page: 1,
                    count: 0,
                    statusId: '',
                    orderDir: 'desc',
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
                selectedOptionName: '',
                selectedOptionNameUserDepartment: '',
                selectedOptionNameIdeaAge: '',
                showDropdown: false,
                showDropdownUserDepartment: false,
                showDropdownIdeaAge: false,
                placeholderText: 'Выбрать автора',
                placeholderTextUserDepartment: 'Выбрать отдел',
                placeholderTextIdeaAge: 'Выбрать возраст идей',
                activeStatusId: '',
                ideaAges: [
                  { name: 'Добавленные >45 дней назад', value: 45 },
                  { name: 'Добавленные >90 дней назад', value: 90 }
                ]
            }
        },
        mounted() {
            this.activeStatusId = this.$refs.activeStatusId.value;
            this.selectedOption = this.users;
            this.selectedOptionUserDepartment = this.filters.departmentsList;
            this.selectedOptionIdeaAge = this.ideaAges;
            if (this.placeholder)
            {
                this.placeholderText = this.placeholder;
            }

            this.$root.$on('checkOrderDir', (res) => {
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
                if (this.searchIdea) {
                    this.inputChecked = this.inputChecked + '&' + this.searchIdea;
                }
                if (this.datepickerDates) {
                    this.inputChecked = this.inputChecked + '&' + this.datepickerDates;
                }

                this.$root.$emit('resultChecked', {data: this.inputChecked, statusId: this.query.statusId});

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

                this.$root.$emit('resultChecked', {data: this.inputChecked, statusId: this.query.statusId});
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

                this.$root.$emit('resultChecked', {data: this.inputChecked, statusId: this.query.statusId});
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

                this.$root.$emit('resultChecked', {data: this.inputChecked, statusId: this.query.statusId});
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

                this.$root.$emit('resultChecked', {data: this.inputChecked, statusId: this.query.statusId});
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

                this.$root.$emit('resultChecked', {data: this.inputChecked, statusId: this.query.statusId});
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
                this.query.orderDir = 'desc';
                this.removedClass();
                this.removedClassUserDepartment();
                this.removedClassIdeaAge();
                this.removedSearchIdea();
                this.removedDatepickerDates();
                this.selectedOptionName = '';
                this.selectedOptionNameUserDepartment = '';
                this.selectedOptionNameIdeaAge = '';
                this.selectUser = '';
                this.selectUserDepartment = '';
                this.selectIdeaAge = '';
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