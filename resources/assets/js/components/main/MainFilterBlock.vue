<template>
    <div class="left-sidebar sameblock">
        <form action="">
            <section class="item mg-right-15">
                <ul class="last-changes-list">
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
            </section>
            <section id="departments" class="item mg-top-10">
                <ul>
                    <li class="first">
                        Отдел
                        <span class="drop" @click="removeChecked">Сбросить</span>
                    </li>
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
                <ul>
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
                <ul>
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
            <section id="strategic" class="item">
                <ul>
                    <li class="first">Стратегическая задача</li>
                    <li v-for="(itemStrategic, index) in filters.strategicObjectivesList">
                        <label class="inbtn">
                            <input type="checkbox"
                                   name="strategic_objective_id[]"
                                   :value="`${index}`"
                                   @change="changeHandler"
                            >
                            <span class="inbtn__indicator"></span>
                            <span class="data" id="data-4">{{ itemStrategic }}</span>
                        </label>
                    </li>
                </ul>
            </section>
            <section id="type" class="item bottom-20">
                <ul>
                    <li class="first">Тип</li>
                    <li v-for="(itemType, index) in filters.typesList">
                        <label class="inbtn">
                            <input type="checkbox"
                                   name="type_id[]"
                                   :value="`${index}`"
                                   @change="changeHandler"
                            >
                            <span class="inbtn__indicator"></span>
                            <span class="data" id="data-5">{{ itemType }}</span>
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
        props: ['filters', 'users'],
        data() {
            return {
                active: 'active',
                selectUser: '',
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
                selectedOptionName: '',
                showDropdown: false,
                placeholderText: 'Выбрать автора',
            }
        },
        mounted() {
            this.selectedOption = this.users;
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
            toggleMenu () {
                this.showDropdown = !this.showDropdown;
                this.removedClass();
            },
            post() {
                this.$root.$emit('preloaderPage', true);
                const params = {
                    ...this.query
                };

                let urlParams = (this.selectUser && !this.inputChecked) ? this.selectUser : this.inputChecked;

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

                this.$root.$emit('resultChecked', {data: this.inputChecked});

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

                this.$root.$emit('resultChecked', {data: this.inputChecked});
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

                this.query.orderDir = 'desc';
                this.removedClass();
                this.selectedOptionName = '';
                this.selectUser = '';
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
            }
        },
    }
</script>