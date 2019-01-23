<template>
    <div class="left-sidebar sameblock">
        <form action="">
            <section class="item mg-right-15">
                <ul class="last-changes-list">
                    <li class="first">Автор</li>
                </ul>
                <div class="dropdown customer-select">
                    <button class="btn btn-default dropdown-toggle home" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <em> Выбрать автора </em>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li class="active" @click="changeSelect(); active != active"><a class="pointer">Выбрать автора </a></li>
                        <li @click="changeSelect(`user_id[]=${user.id}`); active != active" v-for="user in users" ><a class="pointer">{{user.name}} {{user.last_name}} ({{user.number}})</a></li>
                    </ul>
                </div>
            </section>
            <section id="departments" class="item">
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
            <section id="type" class="item">
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
                selected:undefined,
                checkedNames: [],
                inputChecked: String,
                query: {
                    limit: 15,
                    page: 1,
                    count: 0,
                }
            }
        },
        methods: {
            post() {
                this.$root.$emit('preloaderPage', true);
                const params = {
                    ...this.query
                };

                axios.get('/get-idea/all/?'+this.inputChecked, {params: params})
                    .then( (res) => {
                        this.$root.$emit('resultFilter', res);
                    });
            },
            changeHandler (e) {
                let serialize = this.checkBoxStatus(e);
                this.inputChecked = serialize.substr(1);
                this.$root.$emit('resultChecked', this.inputChecked);

                if (e.target.checked){
                    this.post();
                } else {
                    this.clearResult();
                }

            },
            changeSelect (val) {
                if (val === 'undefined') {
                    this.inputChecked = '';
                    this.clearResult();
                    return false;
                } else {
                    this.inputChecked = val;
                }

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
                this.selected = undefined;
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
            }
        },
    }
</script>