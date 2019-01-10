<template>
    <div class="left-sidebar sameblock">
        <section id="departments" class="item">
            <ul>
                <li class="first">
                    Отдел
                    <span class="drop">Сбросить</span>
                </li>
                <li v-for="(itemDepartament, index) in filters.departmentsList">
                    <label class="inbtn">
                        <input type="checkbox"
                               :value="`department_id[]=${index}`"
                               @change="changeHandler"
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
                               :value="`core_competency_id[]=${index}`"
                               @change="changeHandler"
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
                               :value="`operational_goal_id[]=${index}`"
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
                               :value="`strategic_objective_id[]=${index}`"
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
                               :value="`type_id[]=${index}`"
                               @change="changeHandler"
                        >
                        <span class="inbtn__indicator"></span>
                        <span class="data" id="data-5">{{ itemType }}</span>
                    </label>
                </li>
            </ul>
        </section>
    </div>
</template>

<script>
    export default {
        name: "MainFilterBlock",
        props: ['filters'],
        data() {
            return {

            }
        },
        methods: {
            changeHandler (e) {
                if (e.target.checked){
                    this.$root.$emit('input', e.target.value)
                }

            }

        },
    }
</script>